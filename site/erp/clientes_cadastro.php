<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_clientes_cadastro.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pulsar Admin - Usuários</title>
<meta charset="iso-8859-1" />
<?php include('includes_header.php'); ?>
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
		<form id="cliente_cadastro" method="post" class="form-horizontal formOnclick">
			<div class="container-fluid">
				<div class="row-fluid">
<?php if(isset($msg) && $msg != "") { ?>
            <div class="alert alert-success">
              <?php echo $msg?>
              <a href="#" data-dismiss="alert" class="close">×</a>
            </div>
<?php } ?>       
<?php if(isset($error) && $error != "") { ?>
            <div class="alert alert-error">
              <?php echo $error?>
              <a href="#" data-dismiss="alert" class="close">×</a>
            </div>
<?php } ?>     					
					<div class="span12">
						<div class="widget-box-form">
							<div class="widget-title">
								<span class="icon"><i class="icon-remove"></i> </span>
								<h5>Dados Cadastrais</h5>
							</div>
							<div class="widget-content nopadding">
				              <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span5">
			                        Razão <input type="text" placeholder="Razão Social" name="razao" value="<?php echo ($isNew?"":$rowUsers['RAZAO'])?>" />
			                      </div>
			                      <div class="span4">
			                        Fantasia <input type="text" placeholder="Nome Fantasia" name="fantasia" value="<?php echo ($isNew?"":$rowUsers['FANTASIA'])?>" />
			                      </div>
			                      <div class="span3">
			                        CNPJ <input type="text" placeholder="CNPJ" name="cnpj" value="<?php echo ($isNew?"":$rowUsers['CNPJ'])?>" />
			                      </div>
			                    </div>
			                  </div>
			 	             <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span4">
			                        I.E. <input type="text" placeholder="Inscrição" name="inscricao" value="<?php echo ($isNew?"":$rowUsers['INSCRICAO'])?>" />
			                      </div>
			                      <div class="span4">
			                        Telefone <input type="text" placeholder="Telefone " name="telefone" value="<?php echo ($isNew?"":$rowUsers['TELEFONE'])?>" />
			                      </div>
			                      <div class="span3">
			                        Fax <input type="text" placeholder="Fax " name="fax" value="<?php echo ($isNew?"":$rowUsers['FAX'])?>" />
			                      </div>
			                    </div>
			                  </div>
			 	             <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span6">
			                        Endereço <input type="text" placeholder="Endereço" name="endereco" value="<?php echo ($isNew?"":$rowUsers['ENDERECO'])?>" />
			                      </div>
			                      <div class="span3">
			                        Bairro <input type="text" placeholder="Bairro" name="bairro" value="<?php echo ($isNew?"":$rowUsers['BAIRRO'])?>" />
			                      </div>
			                      <div class="span3">
			                        CEP <input type="text" placeholder="CEP " name="cep" value="<?php echo ($isNew?"":$rowUsers['CEP'])?>" />
			                      </div>
			                    </div>
			                  </div>
			 	             <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span5">
			                        Cidade <input type="text" placeholder="Cidade" name="cidade" value="<?php echo ($isNew?"":$rowUsers['CIDADE'])?>" />
			                      </div>
			                      <div class="span5">
			                        Estado <select data-placeholder="Estado" name="estado">
			                          <option value=""></option>
<?php 
	$sql = "SELECT ID, SIGLA FROM ESTADOS";
	$result = mysql_query($sql, $sig);
?>
										<option value=""></option>
<?php while ($row = mysql_fetch_array($result)) { ?>
										<option value="<?php echo $row["SIGLA"]?>" <?php if (!$isNew && ($rowUsers["ESTADO"] == $row["SIGLA"])) echo "selected=\"selected\"" ?>><?php echo $row["SIGLA"] ?></option>
<?php } ?>                          
			                        </select>
			                      </div>
<!-- 			                      <div class="span2"> -->
<!-- 			                        <select data-placeholder="País" name="pais"> -->
<!-- 			                          <option value=""></option> -->
<!-- 			                          <option>First option</option> -->
<!-- 			                          <option>Second option</option> -->
<!-- 			                          <option>Third option</option> -->
<!-- 			                          <option>Fourth option</option> -->
<!-- 			                          <option>Fifth option</option> -->
<!-- 			                          <option>Sixth option</option> -->
<!-- 			                          <option>Seventh option</option> -->
<!-- 			                          <option>Eighth option</option> -->
<!-- 			                        </select> -->
<!-- 			                      </div> -->
			                    </div>
			                  </div>
							  <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span4">
			                        Desde <input type="text" placeholder="Desde" name="desde" value="<?php echo ($isNew?"":$rowUsers['DESDE'])?>" />
			                      </div>
			                      <div class="span4">
			                        Desc R$ <input type="text" placeholder="Desconto R$" name="desc_valor" value="<?php echo ($isNew?"":$rowUsers['desc_valor'])?>" />
			                      </div>
			                      <div class="span4">
			                        Desc % <input type="text" placeholder="Desconto %" name="desc_porcento" value="<?php echo ($isNew?"":$rowUsers['desc_porcento'])?>" />
			                      </div>
			                    </div>
			                  </div>
			                  <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span12">
			                        Comentários <textarea rows="6" class="span12" placeholder="Comentários" name="obs"><?php echo ($isNew?"":$rowUsers['OBS'])?></textarea> 
			                      </div>
			                    </div>
			                  </div>
							</div>
						</div>
					</div>
				</div>

			<div class="row-fluid">
				<div class="span12">
					<div class="widget-box-form">
						<div class="widget-title">
							<span class="icon"><i class="icon-remove"></i> </span>
							<h5>Endereço Cobrança</h5>
						</div>
						<div class="widget-content nopadding">
							<div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span6">
			                        Endereço <input type="text" placeholder="Endereço" name="endereco_cob" value="<?php echo ($isNew?"":$rowUsers['ENDERECO_COB'])?>" />
			                      </div>
			                      <div class="span3">
			                        Bairro <input type="text" placeholder="Bairro" name="bairro_cob" value="<?php echo ($isNew?"":$rowUsers['BAIRRO_COB'])?>" />
			                      </div>
			                      <div class="span3">
			                        CEP <input type="text" placeholder="CEP " name="cep_cob" value="<?php echo ($isNew?"":$rowUsers['CEP_COB'])?>" />
			                      </div>
			                    </div>
							</div>
							  <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span5">
			                        Cidade <input type="text" placeholder="Cidade" name="cidade_cob" value="<?php echo ($isNew?"":$rowUsers['CIDADE_COB'])?>" />
			                      </div>
			                      <div class="span5">
			                        Estado <select data-placeholder="Estado" name="estado_cob">
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
			                      </div>
<!-- 			                      <div class="span2"> -->
<!-- 			                        <select data-placeholder="País" name="pais_cob"> -->
<!-- 			                          <option value=""></option> -->
<!-- 			                          <option>First option</option> -->
<!-- 			                          <option>Second option</option> -->
<!-- 			                          <option>Third option</option> -->
<!-- 			                          <option>Fourth option</option> -->
<!-- 			                          <option>Fifth option</option> -->
<!-- 			                          <option>Sixth option</option> -->
<!-- 			                          <option>Seventh option</option> -->
<!-- 			                          <option>Eighth option</option> -->
<!-- 			                        </select> -->
			                      </div>
			                    </div>
			                  </div>
			               </div>
						</div>
					</div>
				</div>
				
				<div class="row-fluid">
					<div class="span12">				
<!-- 						<form method="post"> -->
<?php 
if(!$isNew) {
	$sql = "SELECT * FROM CONTATOS WHERE ID_CLIENTE = $isEdit ORDER BY CONTATO";
	$objRS2	= mysql_query($sql, $sig) or die(mysql_error());
	$totalRows_objRS2 = mysql_num_rows($objRS2);
}
else
	$totalRows_objRS2 = 0;
if($totalRows_objRS2 > 0) {
?>						
						
              <table class="table table-bordered table-striped">
                  <tbody>
                      <tr>
                      	  <th colspan="7">Contatos</th>
                      </tr>
                      <tr>
                      	  <th>Nome</th>
                          <th>Departamento</th>
                          <th>%</th>
                          <th>E-mail</th>
                          <th>Telefone</th>
                          <th>Ramal</th>
                          <th>Ação</th>
                      </tr>
<?php While ($row_objRS2 = mysql_fetch_assoc($objRS2)) { ?>           
                      <tr>
						<td><input size="25" type="text" name="contato<?php echo $row_objRS2['ID']?>" value="<?php echo $row_objRS2["CONTATO"] ?>"/>&nbsp;</td>
						<td><input size="15" type="text" name="dpt<?php echo $row_objRS2['ID']?>" value="<?php echo $row_objRS2["DPT"] ?>"/>&nbsp;</td>
						<td><input size="5" type="text" name="comissao<?php echo $row_objRS2['ID']?>" value="<?php echo $row_objRS2["COMISSAO"] ?>" maxlength="2" onkeypress='return SomenteNumero(event)'/>&nbsp;</td>
						<td><input type="text" name="email<?php echo $row_objRS2['ID']?>" size="25" value="<?php echo $row_objRS2["EMAIL"] ?>"/>&nbsp;</td>
						<td><input size="15" type="text" name="tel_contato<?php echo $row_objRS2['ID']?>" maxlength="13" onKeyPress="return txtBoxFormat(this, '(99)9999-9999', event);" value="<?php echo $row_objRS2["TEL_CONTATO"] ?>"/>&nbsp;</td>
						<td><input size="5" type="text" name="ramal<?php echo $row_objRS2['ID']?>" value="<?php echo $row_objRS2["RAMAL"] ?>" maxlength="4" onkeypress='return SomenteNumero(event)'/>&nbsp;</td>
						<td><a class="btn btn-danger confirmOnclick" href="clientes_cadastro.php?delContato=<?php echo $row_objRS2['ID']?>&idUser=<?php echo $isEdit?>">Excluir</a>
                      </tr>
<?php } ?>
                  </tbody>
              </table>
<?php } ?>              
              <table class="table table-bordered table-striped">
                  <tbody>
                      <tr>
                      	  <th colspan="7">Novo Contato</th>
                      </tr>
                      <tr>
                      	  <th>Nome</th>
                          <th>Departamento</th>
                          <th>%</th>
                          <th>E-mail</th>
                          <th>Telefone</th>
                          <th>Ramal</th>
                          <th>Ação</th>
                      </tr>
                      <tr>
						<td><input size="25" type="text" name="contato" />&nbsp;</td>
						<td><input size="15" type="text" name="dpt" />&nbsp;</td>
						<td><input size="5" type="text" name="comissao" maxlength="2" onkeypress='return SomenteNumero(event)'/>&nbsp;</td>
						<td><input type="text" name="email" size="25" />&nbsp;</td>
						<td><input size="15" type="text" name="tel_contato" maxlength="13" onKeyPress="return txtBoxFormat(this, '(99)9999-9999', event);" />&nbsp;</td>
						<td><input size="5" type="text" name="ramal"  maxlength="4" onkeypress='return SomenteNumero(event)'/>&nbsp;</td>
						<td>
							<input class="btn btn-primary" type="submit" name="incluirContato" value="Incluir">
							<input name="idUser" type="hidden" value="<?php echo $isEdit?>"/> 
						</td>
                      </tr>
                  </tbody>
              </table>              
<!--               </form> -->
			</div>
			</div>	
				
				<div class="row-fluid">
					<div class="span9"></div>
					<div class="span3">
						<a class="btn btn-secundary" href="clientes.php">Voltar</a>&nbsp;
						<a class="btn btn-primary submitOnclick">Salvar</a>&nbsp;
<?php if ($isNew) { ?>					
						<input name="saveUser" type="hidden" value="true" />
<?php } else { ?>						
						<input name="updateUser" type="hidden" value="<?php echo $isEdit?>" />
<?php if($rowUsers['STATUS']=='A') { ?>
						<a class="btn btn-danger confirmOnclick" href="clientes_cadastro.php?delUser=<?php echo $isEdit?>">Excluir</a>
<?php } else { ?>									
						<a class="btn btn-success" href="clientes_cadastro.php?addUser=<?php echo $isEdit?>">Ativar</a>
<?php } ?>						
<?php } ?>									
					</div>
				</div>
				<?php include('page_bottom.php'); ?>
			</div>
		</form>
	</div>
	<!-- END #content -->
	
	<?php include('includes_footer.php'); ?>

</body>
</html>
