<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MOVIMENTO/CONTRATO/NOVO .::SIG - SISTEMA DE INFORMAÇÕES GERENCIAIS PULSAR IMAGENS::.</title>
<link href="atributos/global.css" type="text/css" rel="stylesheet" media="screen" />
<link href="atributos/tablecloth.css" type="text/css" rel="stylesheet" media="screen" />
<LINK href="css/style.css" type=text/css rel=STYLESHEET />
<style>
textarea { 
  width: 1050px; 
  height: 30px; 
}

#progreso { 
  background: url(textarea.png) no-repeat; 
  background-position: -1000px 0px; 
  width: 1000px; 
  height: 15px; 
  text-align: center; 
  color: #000000; 
  font-size: 10pt; 
  font-family: Arial; 
  text-transform: uppercase; 
} 

#border{
	border-style:solid;
	border-width:thin;
	border-color:#999999;
	padding:5px 5px 5px 5px;
	font-family:Georgia, Times New Roman, Times, serif
	}
</style>
<SCRIPT src="js/geral.js" type=text/javascript></SCRIPT>
<script>
var max=251; 
var ancho=300;
function progreso_tecla(obj) { 
  var progreso = document.getElementById("progreso");   
  if (obj.value.length < max) { 
progreso.style.backgroundColor = "#006400";     
progreso.style.backgroundImage = "url(textarea.png)";     
progreso.style.color = "#FFFFFF"; 
var pos = ancho-parseInt((ancho*parseInt(obj.value.length))/251); 
progreso.style.backgroundPosition = "-"+pos+"px 0px"; 
  } else { 
progreso.style.backgroundColor = "#FF0000";     
progreso.style.backgroundImage = "url()";     
progreso.style.color = "#FFFFFF"; 
  }  
  progreso.innerHTML = "("+obj.value.length+" / "+max+")"; 
} 
function valida_cromo()
{
	// criei uma variavel auxiliar que se encarrega de receber o status da
	// validação
	var passou = true;
	
	if (document.form_send.id_uso.value=='')
	{
		alert('Informe o uso do cromo.');
		document.form_send.id_uso.focus();
		passou = false;
		return false;
	}
	
	if (document.form_send['qcodigo[]'].value=='')
	{
		alert('Informe o código do cromo.');
		document.form_send['qcodigo[]'].focus();
		passou = false;
		return false;
	}
	
	// se a var passou n estiver recebendo false
	// então realiza o submit do form
	if (passou != false)
	{
		document.form_send.exec.value = "cromo";
		document.form_send.ENCTYPE = "";
		document.form_send.action="tool_contrato_gravar.php";
		document.form_send.method="post";
	}
	
	return true;
}

function grava_cromo()
{
	// criei uma variavel auxiliar que se encarrega de receber o status da
	// validação
	var passou = true;
	
	if (document.form_send.id_uso.value=='')
	{
		alert('Informe o uso do cromo.');
		document.form_send.id_uso.focus();
		passou = false;// se der erro, a var passou recebe false
		return false;
	}
	
	if (document.form_send.qassunto.value=='')
	{
		alert('Informe o assunto do cromo.');
		document.form_send.qassunto.focus();
		passou = false;
		return false;
	}
	
	if (document.form_send.qautor.value=='')
	{
		alert('Informe o autor do cromo.');
		document.form_send.qautor.focus();
		passou = false;
		return false;
	}
	
	// se a var passou n estiver recebendo false
	// então realiza o submit do form
	if (passou != false)
	{
		document.form_send.exec.value = "cromo";
		document.form_send.action="tool_contrato_gravar.php";
		document.form_send.ENCTYPE = "";
		document.form_send.method="post";
	}
	
	return true;
}

function valida_saida(){
	$(window).unbind('beforeunload');

	document.form_send.exec.value = "finaliza";
	document.form_send.action="tool_contrato_gravar.php";
	document.form_send.ENCTYPE = "";
	document.form_send.method="post";
//	document.form_send.target="_blank";
	document.form_send.submit();
}

function atualiza_valor_cromo(){
	$(window).unbind('beforeunload');
	
	document.form_send.exec.value = "atualiza_valor";
	document.form_send.action="tool_contrato_gravar.php";
	document.form_send.ENCTYPE = "";
	document.form_send.method="post";
	document.form_send.submit();
}

</script>
<?php include('scripts.php')?>
<?php if(!$print) include("part_top.php")?>
</head>

<body>
<?php 
//resgatando parâmetros passados pela ulr
$novo = isset($_GET['novo'])?true:false;
$copy = isset($_GET['copy'])?true:false;
$delete = isset($_GET['delete'])?true:false;

$arr_indios = get_tribos();
$has_indios = false;
$has_normal = false;
$is_indios = false;
$is_video = false;
$has_video = false;
$has_foto = false;

if($novo) { 
	$id_cliente	= $_GET['id_cliente'];	
	$strSQL = "INSERT INTO CONTRATOS (ID_CLIENTE, DATA, ID_CONTRATO_DESC) values ($id_cliente,NOW(),7)";
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$strSQL = "SELECT MAX(ID) as ID FROM CONTRATOS";
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_assoc($objRS);
	$id_contrato = $row_objRS['ID'];
}
else if($copy) { 
	$strSQL = "SELECT ID, ID_CLIENTE, ID_CONTATO, ID_CONTRATO_DESC, DESCRICAO FROM CONTRATOS ORDER BY ID DESC LIMIT 1";
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_assoc($objRS);
	$strSQL = "INSERT INTO CONTRATOS (ID_CLIENTE, DATA, ID_CONTATO, ID_CONTRATO_DESC, DESCRICAO) values (".$row_objRS['ID_CLIENTE'].",NOW(),".$row_objRS['ID_CONTATO'].",".$row_objRS['ID_CONTRATO_DESC'].",'".$row_objRS['DESCRICAO']."')";
	$strSQL = str_replace("''","Null",$strSQL);
	$strSQL = str_replace(",,",",0,",$strSQL);
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$strSQL = "SELECT MAX(ID) as ID FROM CONTRATOS";
	$objRS = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_assoc($objRS);
	$id_contrato = $row_objRS['ID'];
}
else {
	$id_contrato	= $_GET['id_contrato'];
}
$total = 0;
//excluindo um cromo do contrato
If (isset($_GET['trash'])) {
	$strSQL = "DELETE FROM CROMOS WHERE ID=".$_GET['trash'];
	$objRS6 = mysql_query($strSQL, $sig) or die(mysql_error());
}

if (isset($_POST['editaCromo']) && $_POST['editaCromo'] == "sim") {
	$_GET['editaCromo'] = "sim";
}

/*
If(isset($_GET['salvaDesCont']) && $_GET['salvaDesCont'] == "sim" && !$print) {
	
	$strSQL     = "UPDATE CONTRATOS SET DESCRICAO = '" . $_POST['descricao'] . "' , ID_CONTRATO_DESC = " . $_POST['contrato_desc'] . ", ID_CONTATO = " . $_POST['qcontato'] . " WHERE ID =" . $id_contrato;
	$objUpdt	= mysql_query($strSQL, $sig) or die(mysql_error());
	

	$strSQL 	= "SELECT BAIXADO FROM CONTRATOS WHERE ID=".$id_contrato;
	$objRS		= mysql_query($strSQL, $sig) or die(mysql_error());
	$baixado	= $objRS['baixado'];
	
	if ($baixado != "N") {
		if($_POST['nota'] == "0") {
			$strSQL      = "UPDATE CONTRATOS SET NOTA_FISCAL = NULL , DATA_PAGTO = NULL, BAIXADO = 'N' WHERE ID =" . $id_contrato;
		} else {
			$strSQL      = "UPDATE CONTRATOS SET NOTA_FISCAL = '" . $_POST['nota'] . "' , DATA_PAGTO = '" . $_POST['data_nota'] . "' WHERE ID =" . $id_contrato;
		}
		$objUpdt = mysql_query($strSQL, $sig) or die(mysql_error());
	}

}
//else {
*/
//consultando informações do cliente
$strSQL 		= "SELECT ID_CLIENTE, ID_CONTATO,ID_CONTRATO_DESC, DESCRICAO, DATA, BAIXADO, FINALIZADO, NOTA_FISCAL, DATA_PAGTO FROM CONTRATOS WHERE ID=".$id_contrato;
$objRS	= mysql_query($strSQL, $sig) or die(mysql_error());
$row_objRS = mysql_fetch_assoc($objRS);
$id_cliente	= $row_objRS['ID_CLIENTE'];
$id_contato	= $row_objRS['ID_CONTATO'];
$descricao	= $row_objRS['DESCRICAO'];
$contratoDesc = $row_objRS['ID_CONTRATO_DESC'];
$data		= $row_objRS['DATA'];

$finalizado		= $row_objRS['FINALIZADO'];
$baixado		= $row_objRS['BAIXADO'];
$nota		= $row_objRS['NOTA_FISCAL'];
$data_nota 	= $row_objRS['DATA_PAGTO'];

$isBaixado = $baixado == "S"?true:false;
$isFinalizado = $finalizado == "S"?true:false;

if(!$isFinalizado) {
?>
<script>
	$(window).bind('beforeunload', function() { 
		return 'Contrato ainda não finalizado!!!';
	});
</script>
<?php 
}

$is_indios = isIndio($contratoDesc, $sig);
$is_video = isContratoVideo($contratoDesc, $sig);

if ($contratoDesc != 0) {
    $strSQLDESC = "SELECT b.Id, ID_CONTRATO_DESC, titulo, padrao, assinatura, tipo  FROM CONTRATOS a, CONTRATOS_DESC b WHERE a.ID_CONTRATO_DESC = b.Id and a.Id = " . $id_contrato;
}
else {
    $strSQLDESC = "SELECT Id, titulo, padrao, assinatura  FROM CONTRATOS_DESC WHERE padrao = true";
}   
$objContrDesc =  mysql_query($strSQLDESC, $sig) or die(mysql_error());
$row_objContrDesc = mysql_fetch_assoc($objContrDesc); 

$strSQL 		= "SELECT CNPJ, FANTASIA, RAZAO, ENDERECO, BAIRRO, CEP, CIDADE, ESTADO, TELEFONE, OBS, desc_valor, desc_porcento FROM CLIENTES WHERE ID=".$id_cliente; 
$objRS1	= mysql_query($strSQL, $sig) or die(mysql_error());
$row_objRS1 = mysql_fetch_assoc($objRS1);
$cnpj		= $row_objRS1['CNPJ'];
$fantasia	= $row_objRS1['FANTASIA'];
$razao		= $row_objRS1['RAZAO'];
$endereco	= $row_objRS1['ENDERECO'];
$cep		= $row_objRS1['CEP'];
$cidade		= $row_objRS1['CIDADE'];
$estado		= $row_objRS1['ESTADO'];
$telefone	= $row_objRS1['TELEFONE'];
$obs		= $row_objRS1['OBS'];

$contato	= "N/A";
If ($id_contato != "") {
$strSQL 		= "SELECT ID, CONTATO FROM CONTATOS WHERE ID_CLIENTE='".$id_cliente."' AND ID=".$id_contato;
$objRS4 	= mysql_query($strSQL, $sig) or die(mysql_error());
$row_objRS4 = mysql_fetch_assoc($objRS4);

	if ($row_objRS4) {
		$contato	= $row_objRS4['CONTATO'];
		$id_contato = $row_objRS4['ID'];
	}
	else {
		$contato	= "N/A";
	}
}
$strSQL 		= "SELECT ID, ID_USO FROM CROMOS WHERE ID_CONTRATO=".$id_contrato." ORDER BY ID DESC LIMIT 1"; 
$objUso	= mysql_query($strSQL, $sig) or die(mysql_error());
if($row_objUso = mysql_fetch_assoc($objUso)) {
	$id_uso = $row_objUso['ID_USO']; 
}

$tipo_contrato = 'F';
if ($contratoDesc != 0) {
	$tipo_contrato = $row_objContrDesc['tipo'];
}

$sqlTipo = "select Id, tipo_br as tipo from USO_TIPO where Id in (select id_tipo from USO) order by tipo";
//$sqlTipo = "select Id, tipo from USO_TIPO where Id in (select id_tipo from USO) order by tipo";
$objTipo = mysql_query($sqlTipo, $sig) or die(mysql_error());


$strSQL = "SELECT ID, ID_CONTRATO, ID_USO, CODIGO, ASSUNTO, AUTOR, VALOR, DESCONTO, reuso FROM CROMOS WHERE ID_CONTRATO=".$id_contrato;
$objRS5 = mysql_query($strSQL, $sig) or die(mysql_error());

$sqlContratosDescs = "select Id, titulo,padrao, assinatura from CONTRATOS_DESC where status = true order by titulo ";
$objContrDescs = mysql_query($sqlContratosDescs, $sig) or die(mysql_error());


$sql 		= "SELECT ID, CONTATO FROM CONTATOS WHERE ID_CLIENTE = " . $id_cliente . " ORDER BY CONTATO";
$rs1 	= mysql_query($sql, $sig) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
if ($row_rs1) { 
	$qcontato = "<select name=\"qcontato\">";
	//qcontato = qcontato + "<option>-- selecione --</option>"
	do { 
	    if ($row_rs1['ID'] == $id_contato) {
		    $qcontato = $qcontato . "<option selected value=".$row_rs1['ID'].">".$row_rs1['CONTATO']."</option>";
	    }
	    else {
		    $qcontato = $qcontato . "<option value=".$row_rs1['ID'].">".$row_rs1['CONTATO']."</option>";
	    }
	} while ($row_rs1 = mysql_fetch_assoc($rs1));
}
else {
	$qcontato = "<input type=\"hidden\" name=\"qcontato\" value=\"0\" />";
}

?>
<form name="form_send" id="form_send" <?php If (isset($_GET['editaCromo']) && $_GET['editaCromo'] == "sim") { if ( !isset($_GET['cromo_nao_cadastrado'])) { ?>onsubmit="return valida_cromo();"<?php } else { ?>onsubmit="return grava_cromo();"<?php } } else { ?> action="tool_contrato_gravar.php" method="post" <?php } ?> />
<input type="hidden" name="id_contrato" value="<?php echo $id_contrato?>" />
<input type="hidden" name="exec" value="" />

<!--  <form name="atualiza" method="post" id="frm_editaContrato" action="consulta_contrato_visualiza.php?salvaDesCont=sim&id_contrato=<?php echo  $id_contrato ?>">-->
<!--visualizando informações do contrato-->
<table width="95%">
	<tr>
		<tr>
			<th colspan="4"><center><font face="Times New Roman">Consulta de Contratos</font></center></th>
		</tr>
			
		<tr></tr>
		
		<tr>
			<td id="border" colspan="4"><center><font face="Times New Roman" color="#000000"><b>CONTRATO Nº <?php echo  $id_contrato ?>&nbsp;-&nbsp;EMISSÃO: <?php echo  formatdate($data) ?></b></font></center></td>
		</tr>
<?php
if ($baixado != "N") {
	if (isset($_GET['editaDesCont']) && $_GET['editaDesCont'] == "sim") { 
?>
		<tr>
			<td id="border" colspan="4"><center><font face="Times New Roman" color="#000000"><b>NOTA Nº <input type="text" name="nota" size="25" value="<?php echo  $nota ?>">&nbsp;-&nbsp;DATA PAGAMENTO: <input type="text" name="data_nota" maxlength="10" onKeyPress="return txtBoxFormat(this, '99/99/9999', event);" value="<?php echo  $data_nota ?>"></b></font></center></td>
		</tr>
<?php	
	}
	else {
?>
		<tr>
			<td id="border" colspan="4"><center><font face="Times New Roman" color="#000000"><b>NOTA Nº <?php echo  $nota ?>&nbsp;-&nbsp;DATA PAGAMENTO: <?php echo  $data_nota ?></b></font></center></td>
			<input type="hidden" name="nota" value="<?php echo  $nota ?>">
			<input type="hidden" name="data_nota" value="<?php echo  $data_nota ?>">
		</tr>
<?php 
	} 
} 
?>		
		<tr></tr>
		
		 	 
	
	<tr>
		<td width="10%" id="border">Cliente:</td>
		<td id="border" class="tooltipme" title='<?php echo $obs?>'><?php echo  $fantasia ?>&nbsp;</td>
		<td width="5%" id="border">Contato:</td>
		<td width="20%" id="border">
		<?php If (isset($_GET['editaDesCont']) && $_GET['editaDesCont'] == "sim" && !$isFinalizado) { ?>
		    <?php echo  $qcontato ?>
		<?php } Else { ?>
		    <?php echo  $contato ?>
		    <input name="qcontato" type="hidden" value="<?php echo $id_contato?>"/>
		<?php } ?>
		
		&nbsp;</td>
	</tr>
	
	<tr>
		<td id="border">Razão Social:</td>
		<td id="border"><?php echo  $razao ?>&nbsp;</td>
		<td id="border">CNPJ:</td>
		<td id="border"><?php echo  $cnpj ?>&nbsp;</td>
	</tr>
	
	<tr>
		<td id="border">Endereço:</td>
		<td colspan="3" id="border"><?php echo  $endereco ?> - <?php echo  $cep ?> - <?php echo  $cidade ?> - <?php echo  $estado ?> | <?php echo  $telefone ?>&nbsp;</td>
	</tr>
	
	<tr>
	    <td  id="border">Contrato</td>
	    <?php If (isset($_GET['editaDesCont']) && $_GET['editaDesCont'] == "sim") { // && !$isFinalizado) { ?>
	        <td colspan="3" id="border">
	        <select id="tipo_contrato" name="contrato_desc">
	            <?php while ($row_objContrDescs = mysql_fetch_assoc($objContrDescs)) { ?>
                    <option <?php if ($row_objContrDesc['Id'] == $row_objContrDescs['Id']) echo "selected"; ?> value='<?php echo  $row_objContrDescs['Id'] ?>'><?php echo  $row_objContrDescs['titulo'] ?> - P:<?php If (ord($row_objContrDescs['padrao']) == 1 || ord($row_objContrDescs['padrao']) == 49) echo "Sim"; else echo "Não"; ?> | A:<?php If (ord($row_objContrDescs['assinatura']) == 1 || ord($row_objContrDescs['assinatura']) == 49) echo "Sim"; else echo "Não"; ?> </option>	            
	            <?php } ?>
	        </select>
	    </td>
	    <?php } Else { ?>
	        <td colspan="3" id="border"> 
    	      <?php echo  $row_objContrDesc['titulo'] ?> - Padrão: <?php If (ord($row_objContrDesc['padrao']) == 1 || ord($row_objContrDesc['padrao']) == 49) echo "Sim"; else echo "Não"; ?> | Assinatura Digital:  <?php If (ord($row_objContrDesc['assinatura']) == 1 || ord($row_objContrDesc['assinatura']) == 49) echo "Sim"; else echo "Não"; ?>
    	      <input name="contrato_desc" type="hidden" value="<?php echo $row_objContrDesc['Id']?>"/>
	        </td>	    
	    <?php } ?>
	</tr>
	
	<tr>
		<td id="border">Descrição:</td>
		<td id="border" colspan="3">
		<?php If (isset($_GET['editaDesCont']) && $_GET['editaDesCont'] == "sim") { ?>
		    	                         
		    	                         <textarea name="descricao" onkeyup="progreso_tecla(this)"><?php echo  $descricao ?></textarea><div id="progreso">(0 / 250)</div>
		    	                          </td></tr>
	                                    <tr>
	                                        <td id="border" colspan="4" style="text-align:right;">
<!-- 	                                        <a style="color:#333;vertical-align:middle;" href="consulta_contrato_visualiza.php?editaCromo=sim&id_contrato=<?php echo  $id_contrato ?>"><img src="images/incluirCromo.jpg" border="0" alt="Editar" /></a> -->
	                                        <input type="hidden" name="editaCromo" value="nao" id="input_editaCromo"/>
	                                        <input type="hidden" name="salvaDesCont" value="sim" id="input_salvaDes"/>
		<?php if(!$novo && !$copy) { ?>
											<a style="color:#333;vertical-align:middle;" id="btn_editaCromo"><img src="images/incluirCromo.jpg" border="0" alt="Editar" class="unbind_unload"/></a>
	                                        <input type="submit" value="Salvar Alterações" id="enviaAtualiza" class="unbind_unload"/>
		<?php } ?>	                                        
	                                        </td>
	                                     
	                                    </tr>
	    <?php  } Else If (isset($_GET['editaCromo']) && $_GET['editaCromo'] == "sim") { ?>
		    	                         <?php echo  $descricao ?>
		    	                          </td></tr>
	                                        <tr>
	                                            <td colspan="4" style="text-align:right;"><a style="color:#333;vertical-align:middle;" href="consulta_contrato_visualiza.php?editaDesCont=sim&id_contrato=<?php echo  $id_contrato ?>"><img src="images/editarContrato.jpg" border="0" alt="Editar" class="unbind_unload"/></a>
												</td>
	                                        </tr>
	 	<?php } else { ?>
		    	                         <?php echo  $descricao ?>
		    	                          </td></tr>
	                                        <tr>
<?php if(!$print || (!$novo && !$copy)) { ?>	                                        
	                                            <td colspan="4" style="text-align:right;"><a style="color:#333;vertical-align:middle;" href="consulta_contrato_visualiza.php?editaDesCont=sim&id_contrato=<?php echo  $id_contrato ?>"><img src="images/editarContrato.jpg" border="0" alt="Editar" class="unbind_unload"/></a>
												<a style="color:#333;vertical-align:middle;" href="consulta_contrato_visualiza.php?editaCromo=sim&id_contrato=<?php echo  $id_contrato ?>"><img src="images/incluirCromo.jpg" border="0" alt="Editar" class="unbind_unload"/></a></td>
<?php } ?>	                                        
											</tr>
		<?php }?>
	
</table>
<!-- </form> -->
<?php If (isset($_GET['editaCromo']) && $_GET['editaCromo'] == "sim" && !$isBaixado) { ?>
<!-- <form name="form_send" <?php if ( !isset($_GET['cromo_nao_cadastrado'])) { ?>onsubmit="return valida_cromo();"<?php } else { ?>onsubmit="return grava_cromo();"<?php } ?> /> -->
<input type="hidden" name="id" value="<?php echo $id_cliente?>" />
<input type="hidden" id="cromo_nao_cadastrado" name="cromo_nao_cadastrado" value="<?php if ( isset($_GET['cromo_nao_cadastrado']) && $_GET['cromo_nao_cadastrado'] == "s") echo "s"; else echo "n"; ?>" />

<table>
	<tr>
		<td id="border">Uso:</td>
		<td id="border">
			<select name="id_uso" id="id_uso">
				<option> -- selecione -- </option>
			<?php while ($row_objTipo = mysql_fetch_assoc($objTipo)) { ?>
				    <optgroup label='<?php echo $row_objTipo['tipo'] ?>'>
				    <?php
				        $strSub = "select distinct subtipo_br as subtipo, sub.Id from USO_SUBTIPO as sub, USO as uso where uso.id_utilizacao = sub.Id and uso.id_tipo = " . $row_objTipo['Id'] ." AND uso.contrato like '$tipo_contrato'";
//				    	$strSub = "select distinct subtipo, sub.Id from USO_SUBTIPO as sub, USO as uso where uso.id_subtipo = sub.Id and uso.id_tipo = " . $row_objTipo['Id'] ." AND uso.contrato like '$tipo_contrato'";
				        $objSub = mysql_query($strSub, $sig) or die(mysql_error());
				        
				        while ($row_objSub = mysql_fetch_assoc($objSub)) {
				    ?>
				        <optgroup label="<?php echo $row_objSub['subtipo'] ?>">
				        
				        <?php
				        
				        $strDesc = "select uso.Id, uso_formato.formato_br as formato, uso_distribuicao.distribuicao_br as distribuicao, uso_periodicidade.periodicidade_br as periodicidade, descr.descricao_br as descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor 
									from USO as uso 
									left join USO_DESC as descr on uso.id_tamanho = descr.Id
									left join uso_formato on uso.id_formato = uso_formato.id
									left join uso_distribuicao on uso.id_distribuicao = uso_distribuicao.id 
									left join uso_periodicidade on uso.id_periodicidade = uso_periodicidade.id  
									where uso.id_utilizacao = " . $row_objSub['Id']." AND uso.id_tipo = " . $row_objTipo['Id'] ." AND uso.contrato like '$tipo_contrato'";
//				        echo $strDesc;
//				        $strDesc = "select uso.Id, descr.descricao_br as descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor from USO_DESC as descr, USO as uso where uso.id_tamanho = descr.Id and uso.id_utilizacao = " . $row_objSub['Id']." AND uso.contrato like '$tipo_contrato'";
//				        $strDesc = "select uso.Id, descr.descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor from USO_DESC as descr, USO as uso where uso.id_descricao = descr.Id and uso.id_subtipo = " . $row_objSub['Id']." AND uso.contrato like '$tipo_contrato'";
				        $objDesc =  mysql_query($strDesc, $sig) or die(mysql_error());
				        
				        	while ($row_objDesc = mysql_fetch_assoc($objDesc)) {
				        
				        ?>
				            <option <?php if ( isset($id_uso) && $row_objDesc['Id'] == $id_uso) echo"selected"; ?> value="<?php echo $row_objDesc['Id']?>"><?php echo $row_objDesc['Id']." - "?><?php echo $row_objDesc['formato']." ".$row_objDesc['distribuicao']." ".$row_objDesc['periodicidade']." ".$row_objDesc['descricao'] ?> (R$ <?php echo $row_objDesc['valor']?>)</option>
				        <?php } ?>
				        </optgroup>
				    <?php } ?>
				    </optgroup>
				<?php } ?>
			</select>
		</td>
				
		<?php if ( isset($_GET['cromo_nao_cadastrado']) && $_GET['cromo_nao_cadastrado'] == "s") { ?>
				<td id="border">Assunto:</td>
				<td id="border"><input type="text" name="qassunto" size="70" /></td>
				<td id="border">Autor:</td>
				<td id="border"><input type="text" name="qautor" size="5" /></td>
				<td><input type="submit" value="Enviar >>" class="unbind_unload<?php echo isset($id_uso)?"":" cromo_submit" ?>"/></td>
			</tr>
			
			<script type="text/javascript">
				document.form.qassunto.focus();
			</script>	
					
		<?php 
		} Else { 
			//Response.Cookies("cromo_nao_cadastrado") = "n";
		?>
			
			<td id="border">Código:</td>
			<td id="border"><input class="gimefocus" type="text" name="qcodigo[]" size="10"/></td>
			<td><input type="submit" value="Enviar >>" class="unbind_unload<?php echo isset($id_uso)?"":" cromo_submit" ?>"/></td>
			<td><a id="btn_cromoNaoCad" title="Clique para inserir um cromo não cadastrado no contrato." class="unbind_unload">| Cromo não cadastrado |</a></td></tr>		
			</table>
			
			<h3><center><font color="#FF0000"><?php if(isset($_GET['mens'])) echo $_GET['mens'] ?></font></center></h3>
			
		<?php }  ?>
<?php } ?>



<table width="95%">
	<tr>
		<td id="border" width="5%"><center><font face="Times New Roman" color="#000000"><b>CÓDIGO</b></font></center></td>
		<td id="border" width="45%"><center><font face="Times New Roman" color="#000000"><b>ASSUNTO</b></font></center></td>
		<td id="border" width="15%"><center><font face="Times New Roman" color="#000000"><b>AUTOR</b></font></center></td>
		<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>VALOR</b></font></center></td>
		<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>DESCONTO</b></font></center></td>
		<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>TOTAL</b></font></center></td>
		<td id="border" width="5%"><center><font face="Times New Roman" color="#000000"><b>REUSO</b></font></center></td>
		<td id="border" width="5%"><center><font face="Times New Roman" color="#000000"><b>INDIO</b></font></center></td>
	</tr>
	
	<?php
	$contador = 0;
	While ($row_objRS5 = mysql_fetch_assoc($objRS5)) { 
		$id_uso=$row_objRS5['ID_USO'];
		
		$strSQL = "select uso.Id, USO_TIPO.tipo_br as tipo, USO_SUBTIPO.subtipo_br as subtipo, uso_formato.formato_br as formato, uso_distribuicao.distribuicao_br as distribuicao, uso_periodicidade.periodicidade_br as periodicidade, descr.descricao_br as descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor
									from USO as uso
									left join USO_TIPO on uso.id_tipo = USO_TIPO.Id
									left join USO_SUBTIPO on uso.id_utilizacao = USO_SUBTIPO.Id
									left join USO_DESC as descr on uso.id_tamanho = descr.Id
									left join uso_formato on uso.id_formato = uso_formato.id
									left join uso_distribuicao on uso.id_distribuicao = uso_distribuicao.id
									left join uso_periodicidade on uso.id_periodicidade = uso_periodicidade.id
									where uso.Id = ".$id_uso." AND uso.contrato like '$tipo_contrato'";
		
//		$strSQL 		= "SELECT a.valor, b.tipo_br as tipo, c.subtipo_br as subtipo, d.descricao_br as descricao FROM USO a, USO_TIPO b, USO_SUBTIPO c, USO_DESC d where a.id_tipo = b.Id and a.id_utilizacao = c.Id and a.id_tamanho = d.Id and a.Id = ".$id_uso;
//		$strSQL 		= "SELECT a.valor, b.tipo, c.subtipo, d.descricao FROM USO a, USO_TIPO b, USO_SUBTIPO c, USO_DESC d where a.id_tipo = b.Id and a.id_subtipo = c.Id and a.id_descricao = d.Id and a.Id = ".$id_uso;
		$objRS6 	= mysql_query($strSQL, $sig) or die(mysql_error());
		$row_objRS6 = mysql_fetch_assoc($objRS6);
		$uso			= "uso: ".mb_strtolower($row_objRS6['tipo'])." / ".mb_strtolower($row_objRS6['subtipo'])." / ".mb_strtolower($row_objRS6['formato'])." / ".mb_strtolower($row_objRS6['distribuicao'])." / ".mb_strtolower($row_objRS6['periodicidade'])." / ".mb_strtolower($row_objRS6['descricao']);
		
		//deteccao se o cromo eh de indio
//		echo $row_objRS5['ASSUNTO']."<br>";
		foreach($arr_indios as $tribo => $total_tribo) {
//			echo "|$tribo|";
			if(stristr($row_objRS5['ASSUNTO'],$tribo)!==false) {
				$has_indios = true;
			}
		}
		if(!$has_indios) {
			$has_normal = true;
		}
		
		if(isVideo($row_objRS5['CODIGO'])) {
			$has_video = true;
		} else {
			$has_foto = true;	
		}

//echo $row_objRS5['ASSUNTO'].$has_indios?" =indio":"=normal"."<br>";
		
//print_r($has_normal)
//		echo "<br>";
		
	?>	
		<input type="hidden" name="id<?php echo  $contador?>" value="<?php echo  $row_objRS5['ID'] ?>" />
		
		<tr>
			<td id="border"><?php echo $row_objRS5['CODIGO']?>&nbsp;</td>
			<td id="border"><?php echo mb_strtoupper($row_objRS5['ASSUNTO'])?><br /><?php echo $uso?>&nbsp;</td>
			<td id="border"><?php echo $row_objRS5['AUTOR']?>&nbsp;</td>
<?php If (isset($_GET['editaCromo']) && $_GET['editaCromo'] == "sim" && !$isBaixado) { ?>
			<td id="border">R$ <input type="text" name="valor<?php echo $contador?>" id="valor<?php echo $contador?>" value="<?php echo $row_objRS5['VALOR']?>" size="7" maxlength="9"/></td>
			<td id="border">R$ <input type="text" name="desconto<?php echo $contador?>" id="desconto<?php echo $contador?>" value="<?php echo $row_objRS5['DESCONTO']?>" size="7" maxlength="9"/></td>
			<?php $valor_final=fixnumber($row_objRS5['VALOR'])-fixnumber($row_objRS5['DESCONTO'])?>
			<td id="border">R$ <input type="text" name="valor_final<?php echo $contador?>" value="<?php echo formatnumber($valor_final)?>" size="7" readonly=""/></td>
			<td id="border"><input type="checkbox" name="reuso[]" value="<?php echo $row_objRS5['ID']?>" id="chk_<?php echo $contador?>" class="reuso unbind_unload" <?php echo ((int)$row_objRS5['reuso']%10)>=1?"checked":""?>/></td>
			<td id="border"><input type="checkbox" name="indio[]" value="<?php echo $row_objRS5['ID']?>" id="chkIndio_<?php echo $contador?>" class="chkIndio unbind_unload" <?php echo ((int)$row_objRS5['reuso']/10)>=1?"checked":""?>/></td>
			<td><center><a href="consulta_contrato_visualiza.php?editaCromo=sim&id_contrato=<?php echo $row_objRS5['ID_CONTRATO']?>&trash=<?php echo $row_objRS5['ID']?>"><img src="images/del.gif" border="0" alt="excluir cromo do contrato" class="unbind_unload"/></a></center></td>
<?php } else { ?>
			<td id="border">R$ <?php echo $row_objRS5['VALOR']?>&nbsp;</td>
			<td id="border">R$ <?php echo $row_objRS5['DESCONTO']?>&nbsp;</td>
			<?php $valor_final=fixnumber($row_objRS5['VALOR'])-fixnumber($row_objRS5['DESCONTO'])?>
			<td id="border">R$ <?php echo formatnumber($valor_final)?>&nbsp;</td>
			<td id="border"><input type="checkbox" name="reuso[]" value="<?php echo $row_objRS5['ID']?>" id="chk_<?php echo $contador?>" class="reuso" <?php echo ((int)$row_objRS5['reuso']%10)>=1?"checked":""?> disabled/></td>
			<td id="border"><input type="checkbox" name="indio[]" value="<?php echo $row_objRS5['ID']?>" id="chkIndio_<?php echo $contador?>" class="chkIndio" <?php echo ((int)$row_objRS5['reuso']/10)>=1?"checked":""?> disabled/></td>
<?php 	if(isset($_GET['editaCromo']) && $_GET['editaCromo'] == "sim" && $isBaixado) {?>
			<td><center><a href="consulta_contrato_visualiza.php?editaCromo=sim&id_contrato=<?php echo $row_objRS5['ID_CONTRATO']?>&trash=<?php echo $row_objRS5['ID']?>"><img src="images/del.gif" border="0" alt="excluir cromo do contrato" class="unbind_unload confirm_del"/></a></center></td>
<?php 	} ?>			
<?php } ?>			
		</tr>			
	
	<?php
		$total += $valor_final;
		$contador=$contador+1;
	}
	?>
	<input type="hidden" name="contador" value="<?php echo $contador?>" />	
	
	<tr>
		<td colspan="2">&nbsp;</td>
		<td colspan="2" id="border">Total de cromos:&nbsp;&nbsp;&nbsp;<b><?php echo $contador?></b></td>
		<td id="border"><p align="right">Valor Total:</p></td>
		<td id="border"><b>R$ <?php echo FormatNumber($total,2)?></b></td>
		<input type="hidden" value="<?php echo FormatNumber($total,2)?>" name="valor_total"/>
		<?php If (isset($_GET['editaCromo']) && $_GET['editaCromo'] == "sim" && !$isBaixado) { ?>
				<td><center><input type="button" value="+" onClick="atualiza_valor_cromo();" alt="Clique para atualizar o valor do cromo." class="unbind_unload"></center></td>
		<?php } ?>					
	</tr>
<?php if(!$print) { ?>
	<tr>
		<td colspan="6"><a href="<?php echo isset($_SESSION['menu_url'])?$_SESSION['menu_url']:"menu.php"?>"><b>Clique aqui</b></a> para nova consulta. <a href="consulta_contrato_print.asp?id_contrato=<?php echo $id_contrato?>" title="Clique para reimprimir este contrato."><b>&nbsp;</b></a></td>								
	</tr>
<?php } ?>
</table>


<?php If (isset($_GET['editaCromo']) && $_GET['editaCromo'] == "sim") { ?>
				<input type="button" value="Finalizar >>" onClick="valida_saida();"/>
<?php } ?>
<?php If ($delete) { ?>
				<input type="hidden" name="delete" value="true" />
<?php } ?>
</form>	

<?php 
If (isset($_GET['deleteCont']) && $_GET['deleteCont'] == "sim") {
	$strSQL      = "DELETE FROM CONTRATOS WHERE ID =" . $id_contrato;
	$objRS_delete 	= mysql_query($strSQL, $sig) or die(mysql_error());
?>
#### CONTRATO DELETADO!!! #####

<?php } else { ?>
<center>
		    <form name="form_imp" action="contrato_print.php" target="_blank" method="get">
<?php If ($delete) { ?>
				<a style="color:Red;background-color:Yellow;vertical-align:middle;" onclick="javascript:return confirm('Confirma exclusão do contrato?')" href="consulta_contrato_visualiza.php?deleteCont=sim&id_contrato=<?php echo $id_contrato ?>">### DELETAR ESTE CONTRATO ###</a>				
<?php } if(!$print) { ?>
				<input type="hidden" name="id_contrato" value="<?php echo  $id_contrato ?>"   />
				<input value="Imprimir" style="border:1px solid #333;background-color:#FFF;color:#333;font-weight:bold;background-image:url(images/print.png);background-repeat:no-repeat;padding:2px 2px 2px 10px;background-position:left center;" type="submit"/>
<?php } ?>
			</form>
</center>
<?php } ?>
<?php if((!$is_indios && $has_indios)&&!(isset($_GET['editaDesCont']) && $_GET['editaDesCont'] == "sim")) { ?>
<script>alert("Contrato normal contendo fotos de indio!");</script>
<?php } ?>
<?php if(($is_indios && $has_normal)&&!(isset($_GET['editaDesCont']) && $_GET['editaDesCont'] == "sim")) { ?>
<script>alert("Contrato indio sem fotos de indio!");</script>
<?php } ?>
<?php if(($is_video && $has_foto)&&!(isset($_GET['editaDesCont']) && $_GET['editaDesCont'] == "sim")) { ?>
<script>alert("Contrato de video contendo foto!");</script>
<?php } ?>
<?php if((!$is_video && $has_video)&&!(isset($_GET['editaDesCont']) && $_GET['editaDesCont'] == "sim")) { ?>
<script>alert("Contrato de foto contendo video!");</script>
<?php } ?>
<?php 
/*
if($is_indios) {
	echo "is_indios!";
} else {
	echo "not is_indios!";
}
if($has_indios) {
	echo "has_indios!";
} else {
	echo "not has_indios!";
}*/
?>
</body>
</html>
<?php //fechar e eliminar todos os objetos record set e os objetos de conexão?>
<?php //} ?>