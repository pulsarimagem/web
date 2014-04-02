<?php
//////////PAGSEGURO
/// configuração pagseguro para validar vendedor
define('TOKEN', 'DA02880FB3764F229DE3F39CD0218ECD');
define('EMAIL', 'saulo@pulsarimagens.com.br');

//segue o exemplo : paginaERRO.php?check=false
define('RETORNO_PAGSERUGO','../retornoERRO.php?check=check');

require_once("log.class.php");
require_once("pedido.class.php");
require_once('pagseguro.class.php');

if (count($_POST) > 0) {
	
	// POST recebido, indica que é a requisição do NPI.
	$npi = new PagSeguroNpi();
	$result = $npi->notificationPost();
	
	$transacaoID = isset($_POST['TransacaoID']) ? $_POST['TransacaoID'] : '';
	$name = 'resultado.txt';
	$text = var_export($result, true);
	$file = fopen($name, 'a');
	fwrite($file, $text);
	fclose($file);
	if ($result == "VERIFICADO") {
		//O post foi validado pelo PagSeguro.
		// mudo o status da transação
		$statusTransacao = new Pedido();
		$statusTransacao->tabela = 'pedidos';
		$statusTransacao->atualizaTransacao(array('statustransacao' => $_POST['StatusTransacao'], 'data' => $_POST['DataTransacao'], 'Tipopagamento' => $_POST['TipoPagamento']), 'cod_pedido='.$_POST['Referencia']);
		if($_POST['StatusTransacao'] == 'Completo'){
			
			}
	
	} else if ($result == "FALSO") {
		//O post não foi validado pelo PagSeguro.
		$statusTransacao = new Pedido();
		$statusTransacao->tabela = 'logpagseguro';
		$statusTransacao->atualizaTransacao(array('status' => $result, 'desclog' =>'O post não foi validado pelo PagSeguro.','data' => $_POST['DataTransacao']));
		
	} else {
		// 'Erro na integração com o PagSeguro.';
		$statusTransacao = new Pedido();
		$statusTransacao->tabela = 'logpagseguro';
		$statusTransacao->atualizaTransacao(array('status' => $result, 'desclog' =>'Erro na integração com o PagSeguro.', 'data' => $_POST['DataTransacao']));
		$name = 'FALSO.txt';
		$text = var_export($result, true);
		$file = fopen($name, 'a');
		fwrite($file, $text);
		fclose($file);
	}
	
} else {

	// POST não recebido, indica que a requisição é o retorno do Checkout PagSeguro.
	// No término do checkout o usuário é redirecionado para este bloco.
	header('Location: '.RETORNO_PAGSERUGO);
}


?>
