<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_clientes_cadastro.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pulsar Admin - Usuários</title>
<meta charset="iso-8859-1" />
<?php include('includes_header.php'); ?>
<script type="text/JavaScript">
jQuery(document).ready(function() {
	$('.fixo').hide();
	$('.editavel').show();
});
</script>
</head>
<body>

	<?php include('page_top.php'); ?>

	<?php include('sidebar.php'); ?>

	<div id="content">
		<div id="content-header">
			<h1>Cadastro</h1>
		</div>
		<div id="breadcrumb">
			<a href="index.php" title="Go to Home" class="tip-bottom"><i
				class="icon-home"></i>Dashboard</a> <a href="clientes.php">Clientes</a>
			<a href="#" class="current">Cadastro</a>
		</div>
<!-- 		<form id="cliente_cadastro" method="post" class="form-horizontal formOnclick"> -->
			<div class="container-fluid">
<form name="cliente" action="tool_cliente_gravar.php" method="post">
	<table width="90%">
		<tr>
			<td colspan="5"><a href="javascript:history.back();"><b>Clique aqui</b></a> para voltar para a página anterior. <a href="<?php echo $_SESSION['menu_url']?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
		</tr>
		<tr>
			<th colspan="6"><center><b>Consulta de clientes</b></center></th>
		</tr>
		<tr></tr>
		<tr>
			<td colspan="6"><center><b><?php echo $isNew?"Novo Cliente":$rowUsers["FANTASIA"] ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/edit.gif" class="editBtn" border="0" alt="editar cadastro" />&nbsp;<a href="#?id=<?php echo $isNew?"":$rowUsers["ID"]?>"><img src="images/del.gif" border="0"  alt="excluir cadastro" /></a></center></td></tr>
		<tr></tr>
		<tr>
			<td width="15%"><p align="right">Razão Social:</p></td>
			<td colspan="3" class="fixo"><?php echo $rowUsers["RAZAO"] ?>&nbsp;</td>
			<td colspan="3" class="editavel"><input name="razao" type="text" size="70" value="<?php echo $isNew?"":$rowUsers["RAZAO"] ?>"/>&nbsp;</td>
			<td width="10%"><p align="right">CNPJ:</p></td>
			<td class="fixo"><?php echo $rowUsers["CNPJ"] ?>&nbsp;</td>
			<td class="editavel"><input name="cnpj" type="text" size="18" value="<?php echo $isNew?"":$rowUsers["CNPJ"] ?>" onKeyPress="return txtBoxFormat(this,'99.999.999/9999-99', event);"/>&nbsp;</td>
		</tr>
		<tr>
			<td ><p align="right">Nome Fantasia:</p></td>
			<td colspan="3" class="fixo"><?php echo $rowUsers["FANTASIA"] ?>&nbsp;</td>
			<td colspan="3" class="editavel"><input name="fantasia" type="text" size="70" value="<?php echo $isNew?"":$rowUsers["FANTASIA"] ?>"/>&nbsp;</td>
			<td ><p align="right">I.E.:</p></td>
			<td class="fixo"><?php echo $rowUsers["INSCRICAO"] ?>&nbsp;</td>
			<td class="editavel"><input name="inscricao" type="text" size="18" maxlength="15" value="<?php echo $isNew?"":$rowUsers["INSCRICAO"] ?>" onKeyPress="return txtBoxFormat(this,'999.999.999-999', event);"/>&nbsp;</td>
		</tr>
		<tr>
			<td ><p align="right">Endereço:</p></td>
			<td colspan="3" class="fixo"><?php echo  $rowUsers["ENDERECO"] ?>&nbsp;</td>
			<td colspan="3" class="editavel"><input name="endereco" type="text" size="70" value="<?php echo  $isNew?"":$rowUsers["ENDERECO"] ?>"/>&nbsp;</td>
			<td ><p align="right">Bairro:</p></td>
			<td class="fixo"><?php echo $rowUsers["BAIRRO"] ?>&nbsp;</td>
			<td class="editavel"><input name="bairro" type="text" size="18" value="<?php echo $isNew?"":$rowUsers["BAIRRO"] ?>"/>&nbsp;</td>
		</tr>  
		<tr>
			<td ><p align="right">CEP:</p></td>
			<td class="fixo"><?php echo $rowUsers["CEP"] ?>&nbsp;</td>
			<td class="editavel"><input type="text" name="cep" maxlength="9" size="10" onKeyPress="return txtBoxFormat(this,'99999-999', event);" value="<?php echo $isNew?"":$rowUsers["CEP"] ?>"/>&nbsp;</td>
			<td width="10%"><p align="right">Cidade:</p></td>
			<td class="fixo"><?php echo $rowUsers["CIDADE"] ?>&nbsp;</td>
			<td class="editavel"><input type="text" name="cidade" size="18" value="<?php echo $isNew?"":$rowUsers["CIDADE"] ?>"/>&nbsp;</td>
			<td ><p align="right">Estado:</p></td>
			<td class="fixo"><?php echo $rowUsers["ESTADO"] ?>&nbsp;</td>
			<td class="editavel">
			
				<select name="estado">
<?php 
	$sql = "SELECT ID, SIGLA FROM ESTADOS";
	$result = mysql_query($sql, $sig);
?>
					<option value=""></option>
<?php while ($row = mysql_fetch_array($result)) { ?>
					<option value="<?php echo $row["SIGLA"]?>" <?php if (!$isNew && ($rowUsers["ESTADO"] == $row["SIGLA"])) echo "selected=\"selected\"" ?>><?php echo $row["SIGLA"] ?></option>
<?php } ?>
				</select>
			</td>
		</tr>
	    <tr>
			<td ><p align="right">Telefone:</p></td>
			<td class="fixo"><?php echo $rowUsers["TELEFONE"] ?>&nbsp;</td>
			<td class="editavel"><input type="text" size="15" name="telefone" maxlength="13" onKeyPress="return txtBoxFormat(this, '(99)9999-9999', event);" value="<?php echo $isNew?"":$rowUsers["TELEFONE"] ?>"/>&nbsp;</td>
			<td ><p align="right">Fax:</p></td>
			<td class="fixo"><?php echo $rowUsers["FAX"] ?>&nbsp;</td>
			<td class="editavel"><input type="text" size="15" name="fax" maxlength="13" onKeyPress="return txtBoxFormat(this, '(99)9999-9999', event);" value="<?php echo $isNew?"":$rowUsers["FAX"] ?>"/>&nbsp;</td>
			<td ><p align="right">Desde:</p></td>
			<td class="fixo"><?php echo $rowUsers["DESDE"] ?>&nbsp;</td>
			<td class="editavel"><input type="text" name="desde" maxlength="10" onKeyPress="return txtBoxFormat(this, '99/99/9999', event);" value="<?php echo $isNew?"":$rowUsers["DESDE"] ?>"/>&nbsp;</td>
		</tr>
		<tr>
			<td ><p align="right">Desconto Valor: </p></td>
			<td >
				<span class="fixo">R$ <?php echo replacedot($rowUsers["desc_valor"]) ?></span>
				<span class="editavel">R$ <input name="desc_valor" type="text" value="<?php echo $isNew?"":replacedot($rowUsers["desc_valor"]) ?>" size="10"/></span>
			</td>
			<td colspan="3"><p align="right">Desconto Porcento: </p></td>
			<td >
				<span class="fixo"><?php echo replacedot($rowUsers["desc_porcento"]*100) ?>%</span>
				<span class="editavel"><input name="desc_porcento" type="text" value="<?php echo $isNew?"":replacedot($rowUsers["desc_porcento"]*100) ?>" size="10"/>%</span>
			</td>
		</tr>
		<tr>
			<td ><p align="right">Comentários:</p></td>
			<td colspan="5" class="fixo"><TEXTAREA NAME="obs" ROWS="7" COLS="82" readonly="readonly"><?php echo $rowUsers["OBS"] ?></TEXTAREA></td>
			<td colspan="5" class="editavel"><TEXTAREA NAME="obs" ROWS="7" COLS="82"><?php echo $isNew?"":$rowUsers["OBS"] ?></TEXTAREA></td>
		</tr>
	</table>
	<table width="90%">			
		<tr>
			<td colspan="6"><b>Endereço de cobrança</b></td>
		</tr>
		<?php
		if (!$isNew && ($rowUsers["ENDERECO_COB"] != "")) {
		?>
			<tr class="fixo">
				<td ><p align="right" width="15%">Endereço:</p></td>
				<td colspan="3"><?php echo $rowUsers["ENDERECO_COB"] ?>&nbsp;</td>
				<td width="10%"><p align="right">Bairro:</p></td>
				<td ><?php echo $rowUsers["BAIRRO_COB"] ?>&nbsp;</td>
			</tr>
			<tr class="fixo">
				<td ><p align="right">CEP:</p></td>
				<td ><?php echo $rowUsers["CEP_COB"] ?>&nbsp;</td>
				<td width="10%"><p align="right">Cidade:</p></td>
				<td ><?php echo $rowUsers["CIDADE_COB"] ?>&nbsp;</td>
				<td ><p align="right">Estado:</p></td>
				<td ><?php echo $rowUsers["ESTADO_COB"] ?>&nbsp;</td>
			</tr>
		<?php
		} else {
		?>
			<tr class="fixo">
				<td colspan="6">Endereço de cobrança não cadastrado...</td>
			</tr>
		<?php
		}
		?>
			<tr class="editavel">
				<td ><p align="right" width="15%">Endereço:</p></td>
				<td colspan="3"><input type="text" name="endereco_cob" size="70" value="<?php echo $isNew?"":$rowUsers["ENDERECO_COB"] ?>"/>&nbsp;</td>
				<td width="10%"><p align="right">Bairro:</p></td>
				<td ><input type="text" name="bairro_cob" size="18" value="<?php echo $isNew?"":$rowUsers["BAIRRO_COB"] ?>"/>&nbsp;</td>
			</tr>
			<tr class="editavel">
				<td ><p align="right">CEP:</p></td>
				<td ><input type="text" name="cep_cob" maxlength="9" size="10" onKeyPress="return txtBoxFormat(this,'99999-999', event);" value="<?php echo $isNew?"":$rowUsers["CEP_COB"] ?>"/>&nbsp;</td>
				<td width="10%"><p align="right">Cidade:</p></td>
				<td ><input type="text" name="cidade_cob" size="18" value="<?php echo $isNew?"":$rowUsers["CIDADE_COB"] ?>"/>&nbsp;</td>
				<td ><p align="right">Estado:</p></td>
				<td >
					<select name="estado_cob">
						<option value=""></option>
	<?php 
		$sql = "SELECT ID, SIGLA FROM ESTADOS";
		$result = mysql_query($sql, $sig);
	?>
						<option value=""></option>
	<?php while ($row = mysql_fetch_array($result)) { ?>
						<option value="<?php echo $row["SIGLA"]?>" <?php if (!$isNew && ($rowUsers["ESTADO_COB"] == $row["SIGLA"])) echo "selected=\"selected\"" ?>><?php echo $row["SIGLA"] ?></option>
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
		if(!$isNew) {
			$sql = "SELECT * FROM CONTATOS WHERE ID_CLIENTE = $isEdit ORDER BY CONTATO";
			$objRS2	= mysql_query($sql, $sig) or die(mysql_error());
			$totalRows_objRS2 = mysql_num_rows($objRS2);
		}
		else
			$totalRows_objRS2 = 0;
		
		if ($totalRows_objRS2 == 0) {
		?>
			<tr><td colspan="6">Nenhum contato cadastrado...</td></tr>
		<?php
		} else {
		?>
			<tr>
				<td width="20%"><center><font face="Times New Roman" color="#000000"><b>NOME</b></font></center></td>
				<td width="15%"><center><font face="Times New Roman" color="#000000"><b>DEPARTAMENTO</b></font></center></td>
				<td width="10%"><center><font face="Times New Roman" color="#000000"><b>%</b></font></center></td>
				<td width="25%"><center><font face="Times New Roman" color="#000000"><b>E-MAIL</b></font></center></td>
				<td width="20%"><center><font face="Times New Roman" color="#000000"><b>TELEFONE</b></font></center></td>
				<td width="5%"><center><font face="Times New Roman" color="#000000"><b>RAMAL</b></font></center></td>
			</tr>	
			<?php
			while ($rowUsers2 = mysql_fetch_assoc($objRS2)) {
			?>
				<tr>
					<td class="fixo"><?php echo $rowUsers2["CONTATO"] ?>&nbsp;</td>
					<td class="editavel"><input size="25" type="text" name="contato<?php echo $rowUsers2['ID']?>" value="<?php echo $rowUsers2["CONTATO"] ?>"/>&nbsp;</td>
					<td class="fixo"><?php echo $rowUsers2["DPT"] ?>&nbsp;</td>
					<td class="editavel"><input size="15" type="text" name="dpt<?php echo $rowUsers2['ID']?>" value="<?php echo $rowUsers2["DPT"] ?>"/>&nbsp;</td>
					<td class="fixo"><?php echo $rowUsers2["COMISSAO"] ?>&nbsp;</td>
					<td class="editavel"><input size="5" type="text" name="comissao<?php echo $rowUsers2['ID']?>" value="<?php echo $rowUsers2["COMISSAO"] ?>" maxlength="2" onkeypress='return SomenteNumero(event)'/>&nbsp;</td>
					<td class="fixo"><?php echo $rowUsers2["EMAIL"] ?>&nbsp;</td>
					<td class="editavel"><input type="text" name="email<?php echo $rowUsers2['ID']?>" size="25" value="<?php echo $rowUsers2["EMAIL"] ?>"/>&nbsp;</td>
					<td class="fixo"><?php echo $rowUsers2["TEL_CONTATO"] ?>&nbsp;</td>
					<td class="editavel"><input size="15" type="text" name="tel_contato<?php echo $rowUsers2['ID']?>" maxlength="13" onKeyPress="return txtBoxFormat(this, '(99)9999-9999', event);" value="<?php echo $rowUsers2["TEL_CONTATO"] ?>"/>&nbsp;</td>
					<td class="fixo"><?php echo $rowUsers2["RAMAL"] ?>&nbsp;</td>
					<td class="editavel"><input size="5" type="text" name="ramal<?php echo $rowUsers2['ID']?>" value="<?php echo $rowUsers2["RAMAL"] ?>" maxlength="4" onkeypress='return SomenteNumero(event)'/>&nbsp;</td>
					<td class="editavel"><a href="tool_cliente_gravar.php?action=excluir_contato&id_contato=<?php echo $rowUsers2['ID']?>&id=<?php echo $isEdit?>"><img src="images/del.gif" style="cursor:hand" title="excluir contato" border="0"></a></td>
				</tr>
		<?php	
			}
		}		
		?>    
</table>

	<table width="90%" class="editavel">
		<tr><td colspan="6"><b>Novo contato</b></td></tr>			
	    <tr>
			<td width="20%"><center><font face="Times New Roman" color="#000000"><b>NOME</b></font></center></td>
			<td width="15%"><center><font face="Times New Roman" color="#000000"><b>DEPTO.</b></font></center></td>
			<td width="10%"><center><font face="Times New Roman" color="#000000"><b>%</b></font></center></td>
			<td width="25%"><center><font face="Times New Roman" color="#000000"><b>E-MAIL</b></font></center></td>
			<td width="15%"><center><font face="Times New Roman" color="#000000"><b>TELEFONE</b></font></center></td>
			<td width="5%" ><center><font face="Times New Roman" color="#000000"><b>RAMAL</b></font></center></td>
		</tr>
		<tr>
			<td ><input size="25" type="text" name="contato" maxlength="30"/></td>
			<td ><input size="15" type="text" name="dpt" maxlength="25"/></td>
			<td ><input size="5" type="text" name="comissao" maxlength="2" onkeypress='return SomenteNumero(event)'/></td>
			<td ><input type="text" name="email" size="30" maxlength="100"/></td>
			<td ><input size="15" type="text" name="tel_contato" maxlength="13" onKeyPress="return txtBoxFormat(this, '(99)9999-9999', event);"/></td>
			<td ><input size="5" type="text" name="ramal" maxlength="4" onkeypress='return SomenteNumero(event)'/></td>
		</tr>
	</table>
<?php if($isNew) { ?>
	<input name="novo" type="hidden" value="<?php echo $isNew?>"/> 
<?php } else { ?>	
	<input name="id" type="hidden" value="<?php echo $isEdit?>"/> 
<?php } ?>	
	<input name="action" type="submit" class="editavel" value="Enviar" style="display: none;"/> 
	<a href="<?php echo $_SESSION['menu_url']?>"><b>Clique aqui</b></a> para realizar nova consulta.
	
</form>
				<?php include('page_bottom.php'); ?>
			</div>
<!-- 		</form> -->
	</div>
	<!-- END #content -->
	
	<?php include('includes_footer.php'); ?>

</body>
</html>
