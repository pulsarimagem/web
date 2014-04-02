<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CLIENTES/CONSULTA .::SIG - SISTEMA DE INFORMAÇÕES GERENCIAIS PULSAR IMAGENS::.</title>
<link href="atributos/global.css" type="text/css" rel="stylesheet" media="screen" />
<link href="atributos/tablecloth.css" type="text/css" rel="stylesheet" media="screen" />
<LINK href="css/style.css" type=text/css rel=STYLESHEET />
<?php include("scripts.php"); ?>
<?php
Function StrData($Str) {
	$qano = year($str);
	$qmes = month($str);
	$qdia = day($str);
	if (len($qdia)==1) { 
		$qdia = "0".$qdia;
	}
	if (len($qmes)==1) { 
		$qmes = "0".$qmes;
	}
	
    $StrData == $qdia."/".$qmes."/".$qano;
}
?>
<style>
#border{
	border-style:solid;
	border-width:thin;
	border-color:#999999;
	padding:5px 5px 5px 5px;
	font-family:Georgia, Times New Roman, Times, serif(
	}
</style>
<?php include("part_top.php")?>
</head>
<body>
<?php
//requisitando parâmetros enviados pelo form via método get
$isNovo =  isset($_GET['novo'])?true:false;
if(!$isNovo) {
	$id = $_GET['id_cliente'];
//	consultando dinfromacoes do cliente
	$sql = "SELECT ID, CNPJ, RAZAO, FANTASIA, INSCRICAO, ENDERECO, BAIRRO, CEP, CIDADE, ESTADO, TELEFONE, FAX, ENDERECO_COB, BAIRRO_COB, CEP_COB, CIDADE_COB, ESTADO_COB, DESDE, OBS, desc_valor, desc_porcento FROM CLIENTES WHERE ID = ".$id;  
	$objRS	= mysql_query($sql, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_assoc($objRS);
}
else {
?>
<script type="text/JavaScript">
jQuery(document).ready(function() {
	$('.fixo').hide();
	$('.editavel').show();
});
</script>
<?php 
}
?>
<!--mensagem-->
<h4><font color="#000000"><?php echo $_GET['mens'] ?></font></h4>
<!--visualizando retorno da consulta-->
<form name="cliente" action="tool_cliente_gravar.php" method="post">
	<table width="90%">
		<tr>
			<td colspan="5"><a href="javascript:history.back();"><b>Clique aqui</b></a> para voltar para a página anterior. <a href="<?php echo $_SESSION['menu_url']?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
		</tr>
		<tr>
			<th colspan="6"><center><font face="Times New Roman"><b>Consulta de clientes</b></font></center></th>
		</tr>
		<tr></tr>
		<tr>
			<td id="border" colspan="6"><center><font face="Times New Roman" color="#000000"><b><?php echo $isNovo?"Novo Cliente":$row_objRS["FANTASIA"] ?></b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/edit.gif" class="editBtn" border="0" alt="editar cadastro" />&nbsp;<a href="#?id=<?php echo $isNovo?"":$row_objRS["ID"]?>"><img src="images/del.gif" border="0"  alt="excluir cadastro" /></a></center></td></tr>
		<tr></tr>
		<tr>
			<td id="border" width="15%"><p align="right">Razão Social:</p></td>
			<td id="border" colspan="3" class="fixo"><?php echo $row_objRS["RAZAO"] ?>&nbsp;</td>
			<td id="border" colspan="3" class="editavel"><input name="razao" type="text" size="70" value="<?php echo $isNovo?"":$row_objRS["RAZAO"] ?>"/>&nbsp;</td>
			<td id="border" width="10%"><p align="right">CNPJ:</p></td>
			<td id="border" class="fixo"><?php echo $row_objRS["CNPJ"] ?>&nbsp;</td>
			<td id="border" class="editavel"><input name="cnpj" type="text" size="18" value="<?php echo $isNovo?"":$row_objRS["CNPJ"] ?>" onKeyPress="return txtBoxFormat(this,'99.999.999/9999-99', event);"/>&nbsp;</td>
		</tr>
		<tr>
			<td id="border"><p align="right">Nome Fantasia:</p></td>
			<td id="border" colspan="3" class="fixo"><?php echo $row_objRS["FANTASIA"] ?>&nbsp;</td>
			<td id="border" colspan="3" class="editavel"><input name="fantasia" type="text" size="70" value="<?php echo $isNovo?"":$row_objRS["FANTASIA"] ?>"/>&nbsp;</td>
			<td id="border"><p align="right">I.E.:</p></td>
			<td id="border" class="fixo"><?php echo $row_objRS["INSCRICAO"] ?>&nbsp;</td>
			<td id="border" class="editavel"><input name="inscricao" type="text" size="18" maxlength="15" value="<?php echo $isNovo?"":$row_objRS["INSCRICAO"] ?>" onKeyPress="return txtBoxFormat(this,'999.999.999-999', event);"/>&nbsp;</td>
		</tr>
		<tr>
			<td id="border"><p align="right">Endereço:</p></td>
			<td id="border" colspan="3" class="fixo"><?php echo  $row_objRS["ENDERECO"] ?>&nbsp;</td>
			<td id="border" colspan="3" class="editavel"><input name="endereco" type="text" size="70" value="<?php echo  $isNovo?"":$row_objRS["ENDERECO"] ?>"/>&nbsp;</td>
			<td id="border"><p align="right">Bairro:</p></td>
			<td id="border" class="fixo"><?php echo $row_objRS["BAIRRO"] ?>&nbsp;</td>
			<td id="border" class="editavel"><input name="bairro" type="text" size="18" value="<?php echo $isNovo?"":$row_objRS["BAIRRO"] ?>"/>&nbsp;</td>
		</tr>  
		<tr>
			<td id="border"><p align="right">CEP:</p></td>
			<td id="border" class="fixo"><?php echo $row_objRS["CEP"] ?>&nbsp;</td>
			<td id="border" class="editavel"><input type="text" name="cep" maxlength="9" size="10" onKeyPress="return txtBoxFormat(this,'99999-999', event);" value="<?php echo $isNovo?"":$row_objRS["CEP"] ?>"/>&nbsp;</td>
			<td id="border" width="10%"><p align="right">Cidade:</p></td>
			<td id="border" class="fixo"><?php echo $row_objRS["CIDADE"] ?>&nbsp;</td>
			<td id="border" class="editavel"><input type="text" name="cidade" size="18" value="<?php echo $isNovo?"":$row_objRS["CIDADE"] ?>"/>&nbsp;</td>
			<td id="border"><p align="right">Estado:</p></td>
			<td id="border" class="fixo"><?php echo $row_objRS["ESTADO"] ?>&nbsp;</td>
			<td id="border" class="editavel">
			
				<select name="estado">
<?php 
	$sql = "SELECT ID, SIGLA FROM ESTADOS";
	$result = mysql_query($sql, $sig);
?>
					<option value=""></option>
<?php while ($row = mysql_fetch_array($result)) { ?>
					<option value="<?php echo $row["SIGLA"]?>" <?php if (!$isNovo && ($row_objRS["ESTADO"] == $row["SIGLA"])) echo "selected=\"selected\"" ?>><?php echo $row["SIGLA"] ?></option>
<?php } ?>
				</select>
			</td>
		</tr>
	    <tr>
			<td id="border"><p align="right">Telefone:</p></td>
			<td id="border" class="fixo"><?php echo $row_objRS["TELEFONE"] ?>&nbsp;</td>
			<td id="border" class="editavel"><input type="text" size="15" name="telefone" maxlength="13" onKeyPress="return txtBoxFormat(this, '(99)9999-9999', event);" value="<?php echo $isNovo?"":$row_objRS["TELEFONE"] ?>"/>&nbsp;</td>
			<td id="border"><p align="right">Fax:</p></td>
			<td id="border" class="fixo"><?php echo $row_objRS["FAX"] ?>&nbsp;</td>
			<td id="border" class="editavel"><input type="text" size="15" name="fax" maxlength="13" onKeyPress="return txtBoxFormat(this, '(99)9999-9999', event);" value="<?php echo $isNovo?"":$row_objRS["FAX"] ?>"/>&nbsp;</td>
			<td id="border"><p align="right">Desde:</p></td>
			<td id="border" class="fixo"><?php echo $row_objRS["DESDE"] ?>&nbsp;</td>
			<td id="border" class="editavel"><input type="text" name="desde" maxlength="10" onKeyPress="return txtBoxFormat(this, '99/99/9999', event);" value="<?php echo $isNovo?"":$row_objRS["DESDE"] ?>"/>&nbsp;</td>
		</tr>
		<tr>
			<td id="border"><p align="right">Desconto Valor: </p></td>
			<td id="border">
				<span class="fixo">R$ <?php echo replacedot($row_objRS["desc_valor"]) ?></span>
				<span class="editavel">R$ <input name="desc_valor" type="text" value="<?php echo $isNovo?"":replacedot($row_objRS["desc_valor"]) ?>" size="10"/></span>
			</td>
			<td id="border" colspan="3"><p align="right">Desconto Porcento: </p></td>
			<td id="border">
				<span class="fixo"><?php echo replacedot($row_objRS["desc_porcento"]*100) ?>%</span>
				<span class="editavel"><input name="desc_porcento" type="text" value="<?php echo $isNovo?"":replacedot($row_objRS["desc_porcento"]*100) ?>" size="10"/>%</span>
			</td>
		</tr>
		<tr>
			<td id="border"><p align="right">Comentários:</p></td>
			<td id="border" colspan="5" class="fixo"><TEXTAREA NAME="obs" ROWS="7" COLS="82" readonly="readonly"><?php echo $row_objRS["OBS"] ?></TEXTAREA></td>
			<td id="border" colspan="5" class="editavel"><TEXTAREA NAME="obs" ROWS="7" COLS="82"><?php echo $isNovo?"":$row_objRS["OBS"] ?></TEXTAREA></td>
		</tr>
	</table>
	<table width="90%">			
		<tr>
			<td colspan="6"><b>Endereço de cobrança</b></td>
		</tr>
		<?php
		if (!$isNovo && ($row_objRS["ENDERECO_COB"] != "")) {
		?>
			<tr class="fixo">
				<td id="border"><p align="right" width="15%">Endereço:</p></td>
				<td id="border" colspan="3"><?php echo $row_objRS["ENDERECO_COB"] ?>&nbsp;</td>
				<td id="border" width="10%"><p align="right">Bairro:</p></td>
				<td id="border"><?php echo $row_objRS["BAIRRO_COB"] ?>&nbsp;</td>
			</tr>
			<tr class="fixo">
				<td id="border"><p align="right">CEP:</p></td>
				<td id="border"><?php echo $row_objRS["CEP_COB"] ?>&nbsp;</td>
				<td id="border" width="10%"><p align="right">Cidade:</p></td>
				<td id="border"><?php echo $row_objRS["CIDADE_COB"] ?>&nbsp;</td>
				<td id="border"><p align="right">Estado:</p></td>
				<td id="border"><?php echo $row_objRS["ESTADO_COB"] ?>&nbsp;</td>
			</tr>
		<?php
		} else {
		?>
			<tr class="fixo">
				<td id="border" colspan="6">Endereço de cobrança não cadastrado...</td>
			</tr>
		<?php
		}
		?>
			<tr class="editavel">
				<td id="border"><p align="right" width="15%">Endereço:</p></td>
				<td id="border" colspan="3"><input type="text" name="endereco_cob" size="70" value="<?php echo $isNovo?"":$row_objRS["ENDERECO_COB"] ?>"/>&nbsp;</td>
				<td id="border" width="10%"><p align="right">Bairro:</p></td>
				<td id="border"><input type="text" name="bairro_cob" size="18" value="<?php echo $isNovo?"":$row_objRS["BAIRRO_COB"] ?>"/>&nbsp;</td>
			</tr>
			<tr class="editavel">
				<td id="border"><p align="right">CEP:</p></td>
				<td id="border"><input type="text" name="cep_cob" maxlength="9" size="10" onKeyPress="return txtBoxFormat(this,'99999-999', event);" value="<?php echo $isNovo?"":$row_objRS["CEP_COB"] ?>"/>&nbsp;</td>
				<td id="border" width="10%"><p align="right">Cidade:</p></td>
				<td id="border"><input type="text" name="cidade_cob" size="18" value="<?php echo $isNovo?"":$row_objRS["CIDADE_COB"] ?>"/>&nbsp;</td>
				<td id="border"><p align="right">Estado:</p></td>
				<td id="border">
					<select name="estado_cob">
						<option value=""></option>
	<?php 
		$sql = "SELECT ID, SIGLA FROM ESTADOS";
		$result = mysql_query($sql, $sig);
	?>
						<option value=""></option>
	<?php while ($row = mysql_fetch_array($result)) { ?>
						<option value="<?php echo $row["SIGLA"]?>" <?php if (!$isNovo && ($row_objRS["ESTADO_COB"] == $row["SIGLA"])) echo "selected=\"selected\"" ?>><?php echo $row["SIGLA"] ?></option>
	<?php } ?>
					</select>
				</td>
			</tr>
</table>
<!-- visualizando contatos cadastrados -->	
	<table width="90%">
	    <tr>
			<td colspan="6"><b>Contatos</b></td>
		</tr>			
		<?php
		if(!$isNovo) {
			$sql = "SELECT * FROM CONTATOS WHERE ID_CLIENTE = $id ORDER BY CONTATO";
			$objRS2	= mysql_query($sql, $sig) or die(mysql_error());
			$totalRows_objRS2 = mysql_num_rows($objRS2);
		}
		else
			$totalRows_objRS2 = 0;
		
		if ($totalRows_objRS2 == 0) {
		?>
			<tr><td id="border" colspan="6">Nenhum contato cadastrado...</td></tr>
		<?php
		} else {
		?>
			<tr>
				<td id="border" width="20%"><center><font face="Times New Roman" color="#000000"><b>NOME</b></font></center></td>
				<td id="border" width="15%"><center><font face="Times New Roman" color="#000000"><b>DEPARTAMENTO</b></font></center></td>
				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>%</b></font></center></td>
				<td id="border" width="25%"><center><font face="Times New Roman" color="#000000"><b>E-MAIL</b></font></center></td>
				<td id="border" width="20%"><center><font face="Times New Roman" color="#000000"><b>TELEFONE</b></font></center></td>
				<td id="border" width="5%"><center><font face="Times New Roman" color="#000000"><b>RAMAL</b></font></center></td>
			</tr>	
			<?php
			while ($row_objRS2 = mysql_fetch_assoc($objRS2)) {
			?>
				<tr>
					<td id="border" class="fixo"><?php echo $row_objRS2["CONTATO"] ?>&nbsp;</td>
					<td id="border" class="editavel"><input size="25" type="text" name="contato<?php echo $row_objRS2['ID']?>" value="<?php echo $row_objRS2["CONTATO"] ?>"/>&nbsp;</td>
					<td id="border" class="fixo"><?php echo $row_objRS2["DPT"] ?>&nbsp;</td>
					<td id="border" class="editavel"><input size="15" type="text" name="dpt<?php echo $row_objRS2['ID']?>" value="<?php echo $row_objRS2["DPT"] ?>"/>&nbsp;</td>
					<td id="border" class="fixo"><?php echo $row_objRS2["COMISSAO"] ?>&nbsp;</td>
					<td id="border" class="editavel"><input size="5" type="text" name="comissao<?php echo $row_objRS2['ID']?>" value="<?php echo $row_objRS2["COMISSAO"] ?>" maxlength="2" onkeypress='return SomenteNumero(event)'/>&nbsp;</td>
					<td id="border" class="fixo"><?php echo $row_objRS2["EMAIL"] ?>&nbsp;</td>
					<td id="border" class="editavel"><input type="text" name="email<?php echo $row_objRS2['ID']?>" size="25" value="<?php echo $row_objRS2["EMAIL"] ?>"/>&nbsp;</td>
					<td id="border" class="fixo"><?php echo $row_objRS2["TEL_CONTATO"] ?>&nbsp;</td>
					<td id="border" class="editavel"><input size="15" type="text" name="tel_contato<?php echo $row_objRS2['ID']?>" maxlength="13" onKeyPress="return txtBoxFormat(this, '(99)9999-9999', event);" value="<?php echo $row_objRS2["TEL_CONTATO"] ?>"/>&nbsp;</td>
					<td id="border" class="fixo"><?php echo $row_objRS2["RAMAL"] ?>&nbsp;</td>
					<td id="border" class="editavel"><input size="5" type="text" name="ramal<?php echo $row_objRS2['ID']?>" value="<?php echo $row_objRS2["RAMAL"] ?>" maxlength="4" onkeypress='return SomenteNumero(event)'/>&nbsp;</td>
					<td class="editavel"><a href="tool_cliente_gravar.php?action=excluir_contato&id_contato=<?php echo $row_objRS2['ID']?>&id=<?php echo $id?>"><img src="images/del.gif" style="cursor:hand" title="excluir contato" border="0"></a></td>
				</tr>
		<?php	
			}
		}		
		?>    
</table>

	<table width="90%" class="editavel">
		<tr><td colspan="6"><b>Novo contato</b></td></tr>			
	    <tr>
			<td id="border" width="20%"><center><font face="Times New Roman" color="#000000"><b>NOME</b></font></center></td>
			<td id="border" width="15%"><center><font face="Times New Roman" color="#000000"><b>DEPTO.</b></font></center></td>
			<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>%</b></font></center></td>
			<td id="border" width="25%"><center><font face="Times New Roman" color="#000000"><b>E-MAIL</b></font></center></td>
			<td id="border" width="15%"><center><font face="Times New Roman" color="#000000"><b>TELEFONE</b></font></center></td>
			<td id="border" width="5%" ><center><font face="Times New Roman" color="#000000"><b>RAMAL</b></font></center></td>
		</tr>
		<tr>
			<td id="border"><input size="25" type="text" name="contato" maxlength="30"/></td>
			<td id="border"><input size="15" type="text" name="dpt" maxlength="25"/></td>
			<td id="border"><input size="5" type="text" name="comissao" maxlength="2" onkeypress='return SomenteNumero(event)'/></td>
			<td id="border"><input type="text" name="email" size="30" maxlength="100"/></td>
			<td id="border"><input size="15" type="text" name="tel_contato" maxlength="13" onKeyPress="return txtBoxFormat(this, '(99)9999-9999', event);"/></td>
			<td id="border"><input size="5" type="text" name="ramal" maxlength="4" onkeypress='return SomenteNumero(event)'/></td>
		</tr>
	</table>
<?php if($isNovo) { ?>
	<input name="novo" type="hidden" value="<?php echo $isNovo?>"/> 
<?php } else { ?>	
	<input name="id" type="hidden" value="<?php echo $id?>"/> 
<?php } ?>	
	<input name="action" type="submit" class="editavel" value="Enviar" style="display: none;"/> 
	<a href="<?php echo $_SESSION['menu_url']?>"><b>Clique aqui</b></a> para realizar nova consulta.
	
</form>
</body>
</html>

<?php //'Fechar e eliminar todos os objetos recordset e objeto de conexao?>
