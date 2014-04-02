<?php
	include_once('Connections/pulsar.php');
	include("tool_auth.php");
	
	/// configuração paypal conta vendedor
	define('PWD_PAYPAL','LHQQN75JQP8JN7M2');
	define('USER_PAYPAL','saulo_api1.pulsarimagens.com.br');
	define('SIGNATURE_PAYPAL','AFcWxV21C7fd0v3bYYYRCpSSRl31AwRR42uND6pSn5Y6fPKcGS-rA1VX');
	
	// insira a pagina de retorno após pagamento paypal
	//segue o exemplo: paginaERRO.php?check=false
	define('RETORNO_PAYPAL_TRUE','../retornoERRO.php?check=true');
	define('RETORNO_PAYPAL_FALSE','../retornoERRO.php?check=false');
	define('RETORNO_PAYPAL_CANCEL','../retornoERRO.php?check=cancel');
	
	
	//////////PAGSEGURO
	/// configuração pagseguro para validar vendedor
	define('TOKEN', 'DA02880FB3764F229DE3F39CD0218ECD');
	define('EMAIL', 'saulo@pulsarimagens.com.br');
	
	include('ecommerce/pagseguro/PagSeguroLibrary.php');
	include('ecommerce/crud.php');
	include('ecommerce/pedido.class.php');
	include('ecommerce/paypal.class.php');
	//include('Connections/pulsar.php');
	//include_once('functions.php');

	if(empty($_SESSION['produto'])){
		header('Location: carrinho.php');
		}
	
	// cria uma instancia do objeto pedido
	$pedido =  new Pedido();
	
	// gera um codigo para o pedido
	if(empty($_SESSION['existPedido'])){
		$_SESSION['existPedido'] = date("m").date("His").rand(1,999);
	} else{
		$_SESSION['existPedido'] = $_SESSION['existPedido'];
	}

	//echo $_SESSION['existPedido'].'<br><br>';
	// $_SESSION['existPedido'] ;
	$crud = new Crud();
	/// formato br
	setlocale(LC_MONETARY, 'pt_BR');
	
	/// instancia do objeto pagseguro
	$objetopagseguro = new PagSeguroPaymentRequest();
	///Moeda
	$objetopagseguro->setCurrency('BRL');
	
	//////////////////
	$totalgeral 	= 0;
	$arrayPayPal 	= 0;
	$content 		= null;
	$nvp 			= null;
	
	/*if (isset($_SESSION['produto'])){
		$_SESSION['aux'] = $_SESSION['produto'];
	} else {
		$_SESSION['aux'] = $_SESSION['aux'];
	}*/
	
	foreach($_SESSION['produto'] as $id => $quantidade){
		
		$crud->tabela = 'Fotos';
		$campTabela = "Fotos.Id_Foto,
					  Fotos.tombo,
					  Fotos.id_autor,
					  fotografos.Nome_Fotografo,
					  Fotos.data_foto,
					  Fotos.cidade,
					  Estados.Sigla,
					  Fotos.orientacao,
					  Fotos.dim_a,
					  Fotos.dim_b,
					  Fotos.direito_img,
					  Fotos.assunto_principal,
					  paises.nome AS pais
					  ";
		
		$id = substr($id,9);
		$produto = $crud->readJoinCarrinho($campTabela,'Fotos.tombo ="'.$id.'"');
		//print_r($produto);
		$idproduto = $produto[0]['tombo'];
		$nomeproduto = $produto[0]['assunto_principal'];
		$vlunitario = $_SESSION['produto'.$id]['valor'];
		$subtotal =  $vlunitario;
		$totalgeral += $subtotal;

		// gera o array dos itens do pedido e grava na tabela de itens do pedido
		$itens= array('cod_pedido' => $_SESSION['existPedido'], 
						'id_produto' => $id, 
						'produto' => $nomeproduto, 
						'quantidade' => 1, 
						'valor' => $vlunitario);
		$pedido->tabela = 'itenspedido';
		
		
		//se estiver fazio faz o cadastro, evitando refresh na tela e gerando novo pedido
		if(isset($_GET['tipopag'])){
			$pedido->gravaItenPedido($itens);
		}
		/////////////////////////////////////////////


		/////monta a lista de pedidos para o paypal
		$nvp['L_PAYMENTREQUEST_0_NAME'.$arrayPayPal] = 'imagem';
		$nvp['L_PAYMENTREQUEST_0_DESC'.$arrayPayPal] = $nomeproduto;
		$nvp['L_PAYMENTREQUEST_0_QTY'.$arrayPayPal] = $quantidade;
		$nvp['L_PAYMENTREQUEST_0_AMT'.$arrayPayPal] = $vlunitario;
		$arrayPayPal +=1;
		
		//if(isset($_GET['ck']))
			/////monta a lista de pedidos para o pagseguro
			$objetopagseguro->addItem($idproduto, $nomeproduto, '1', $vlunitario);
			/////////////////////////////////////////////////////////////
		
		$content .= '
		<tbody>
			<tr>
			  <td>
				<div class="imagem">
				  <img src="http://www.pulsarimagens.com.br/bancoImagens/'.$id.'.jpg" width="120" />
				</div>
				<div class="descricao">
				  <ul>
					<li class="autor"><span class="label">Autor:</span> '.$produto[0]['Nome_Fotografo'].'</li>
					<li class="codigo"><span class="label">C&oacute;digo:</span> '.$id.'</li>
					<li class="uso"><span class="label">Descrição:</span> '.$nomeproduto.'</li>
				  </ul>
				</div>
			  </td>
			  <td class="acoes">
				<div class="calculo-preco">
				  <div class="preco">R$ '.number_format($vlunitario,2,',','.').'</div>
				</div>
			  </td>
			</tr>
		 </tbody>
		';
 }
 		$contentTotal = '
		<tfoot>
			<tr>
			  <td colspan="2" class="total">Total: R$ '.number_format($totalgeral,2,',','.').'</td>
			</tr>
		</tfoot>
		
		';
		
		//se estiver fazio faz o cadastro, evitando refresh na tela e gerando novo pedido
		if(isset($_GET['tipopag'])){
			////gravo o pedido
			$pedido->tabela = 'pedidos';
			$dt = date("d/m/Y H:i:s");
			$pedido->gravaPedido(array("cpf" => $_SESSION['user']['cpf_cnpj'], "cod_pedido" => $_SESSION['existPedido'], "valorpedido" => $totalgeral, "data" => $dt,"statustransacao" => "Aguardando pagamento"));
			/////////////////
		}


/// configurar dados do cliente para pagseguro
$objetopagseguro->setSender($_SESSION['user']['nome'], $_SESSION['user']['email']);

// Configuração de frete
$objetopagseguro->setShippingType('3'); // 1 - pac, 2 - sedex, 3 - outros;

// Codigo do pedido
$objetopagseguro->setReference($_SESSION['existPedido']);

// defini credenciais do logista ou vendedor ou dono do site....
$credenciais =  new PagSeguroAccountCredentials(EMAIL, TOKEN);  

//Criando o código de requisição de pagamento e obtendo a URL da página do pagamento no PagSeguro 
$url = $objetopagseguro->register($credenciais); 

$_SESSION['urlPagSeguro'] = $url;

/*/// dados do cliente
echo '
	<td><b>Nome:</b></td>
	<td>'.$_SESSION['user']['nome'].'</td>
	</tr>
	<tr>
	<td><b>Cpf:</b></td>
	<td>'.$_SESSION['user']['cpf_cnpj'].'</td>
	</tr>
	<tr><td><b>E-mail:</b></td>
	<td>'.$_SESSION['user']['email'].'</td></tr>
	<tr>
';*/



//// gera riquisição PayPal
$PWD = PWD_PAYPAL;
$USER = USER_PAYPAL;
$SIGNATURE = SIGNATURE_PAYPAL;
$nvp['PAYMENTREQUEST_0_ITEMAMT']=$totalgeral;
$nvp['PAYMENTREQUEST_0_AMT']=$totalgeral;
$nvp['PAYMENTREQUEST_0_CURRENCYCODE']='BRL';
$nvp['PAYMENTREQUEST_0_PAYMENTACTION']='Sale';
$nvp['PAYMENTREQUEST_0_INVNUM']= $_SESSION['existPedido'];
$nvp['LOCALECODE']='pt_BR';
$nvp['RETURNURL']='http://localhost/pulsar/html/br/ecommerce/retornoPaypal.php';
$nvp['CANCELURL']='http://localhost/pulsar/html/br/retornoERRO.php?check=cancel';
$nvp['METHOD']='SetExpressCheckout';
$nvp['VERSION']='91.0';
$nvp['PWD']=$PWD;
$nvp['USER']=$USER;
$nvp['SIGNATURE']=$SIGNATURE;

$linkPaypal = new paypalClass();
$_SESSION['urlPaypal'] = $linkPaypal->Link($nvp);
//echo $_SESSION['urlPaypal'];
//echo '<pre>';
//print_r($nvp);

if(isset($_GET['tipopag'])){
	unset($_SESSION['produto']);
	unset($_SESSION['existPedido']);
	echo'<script>';
	if($_GET['tipopag'] == 'pay')
	
		echo 'document.location = "'.$_SESSION['urlPaypal'].'"';
	
	if($_GET['tipopag'] == 'pag')
		echo 'document.location = "'.$_SESSION['urlPagSeguro'].'"';
	}
	echo'</script>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="style.css" rel="stylesheet" type="text/css" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="js/easyTooltip.js"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>
<script src="js/carrinho.js" type="text/javascript"></script>
<script type="text/javascript" src="js/sitewite.js"></script>

<?php include("scripts.php"); ?>
</head>
<body>
<?php include("part_topbar.php") ?>
<div class="main size960">
      <div class="carrinho-page">

<table class="carrinho-lista">
<?php print $content; ?>
<?php print $contentTotal;?>

</table>
<hr />
<h1 style="font-size:16px; font-weight:bold; margin:30px 0">Formas de pagamento</h1>
<style type="text/css">
	a.pagseguro{
		background:url(images/botao_pagseguro.gif) no-repeat center center; 
		display:block; 
		padding:32px 0; 
		width:205px; 
		text-align:center; 
		text-indent: -9999px;
		float:left;
		margin-right:20px;}
	a.paypal{
		background:url(images/botao_paypal.png) no-repeat center center; 
		display:block; 
		padding:32px 0; 
		width:205px; 
		text-align:center; 
		text-indent: -9999px;float:left}
</style>
<a href="carrinho-concluido.php?tipopag=pag" class="pagseguro">Pagar com Pagseguro</a>
<a href="carrinho-concluido.php?tipopag=pay"  class="paypal">Pagar com Paypal</a>
<div class="clear"></div>
</div>
</div>
<?php include("part_footer.php") ?>
</body>
</html>
<?php

//unset($_SESSION['produto']);
?>