<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_profissionais_cadastro.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pulsar Admin - Profissionais</title>
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
				class="icon-home"></i>Dashboard</a> <a href="profissionais.php">Profissionais</a>
			<a href="#" class="current">Cadastro</a>
		</div>
		<form id="profissionais_cadastro" method="post" class="form-horizontal formOnclick">
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
			                        <input type="text" placeholder="Nome" name="nome" value="<?php echo ($isNew?"":$rowUsers['NOME'])?>" />
			                      </div>
			                      <div class="span7">
			                        <input type="text" placeholder="Nome completo" name="nome_completo" value="<?php echo ($isNew?"":$rowUsers['NOME_COMPLETO'])?>" />
			                      </div>
			                    </div>
			                  </div>
			 	             <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span4">
			                        <input type="text" placeholder="CPF" name="cpf" value="<?php echo ($isNew?"":$rowUsers['CPF'])?>" />
			                      </div>
			                      <div class="span5">
			                        <input type="text" placeholder="CNPJ " name="cnpj" value="<?php echo ($isNew?"":$rowUsers['CNPJ'])?>" />
			                      </div>
			                      <div class="span3">
			                        <input type="text" placeholder="ZIP Code " name="zip" value="<?php echo ($isNew?"":$rowUsers['ZIPCODE'])?>" />
			                      </div>
			                    </div>
			                  </div>
			 	             <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span4">
			                        <input type="text" placeholder="Comissão" name="com" value="<?php echo ($isNew?"":$rowUsers['COMISSAO'])?>" />
			                      </div>
			                      <div class="span4">
			                        <input type="text" placeholder="Telefone " name="tel" value="<?php echo ($isNew?"":$rowUsers['TELEFONE'])?>" />
			                      </div>
			                      <div class="span4">
			                        <input type="text" placeholder="Celular" name="cel" value="<?php echo ($isNew?"":$rowUsers['CELULAR'])?>" />
			                      </div>
			                    </div>
			                  </div>
			 	             <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span7">
			                        <input type="text" placeholder="Endereço" name="edc" value="<?php echo ($isNew?"":$rowUsers['ENDERECO'])?>" />
			                      </div>
			                      <div class="span3">
			                        <input type="text" placeholder="Bairro" name="bairro" value="<?php echo ($isNew?"":$rowUsers['BAIRRO'])?>" />
			                      </div>
			                      <div class="span2">
			                        <input type="text" placeholder="CEP " name="cep" value="<?php echo ($isNew?"":$rowUsers['CEP'])?>" />
			                      </div>
			                    </div>
			                  </div>
			 	             <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span3">
			                        <input type="text" placeholder="Cidade" name="cid" value="<?php echo ($isNew?"":$rowUsers['CIDADE'])?>" />
			                      </div>
			                      <div class="span3">
			                        <select data-placeholder="Estado" name="est">
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
			                      <div class="span2">
			                        <select data-placeholder="País" name="pais">
			                          <option value=""></option>
			                          <option>First option</option>
			                          <option>Second option</option>
			                          <option>Third option</option>
			                          <option>Fourth option</option>
			                          <option>Fifth option</option>
			                          <option>Sixth option</option>
			                          <option>Seventh option</option>
			                          <option>Eighth option</option>
			                        </select>
			                      </div>
			                    </div>
			                  </div>
							  <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span7">
			                        <select class="span12" data-placeholder="Banco" name="bco">
			                          <option value=""></option>
<?php
			$sql = "SELECT ID, NUMERO, NOME FROM TA_BANCOS ORDER BY NOME ";
			$result = mysql_query($sql, $sig);

			while ($row = mysql_fetch_array($result)) { ?>
									  <option value="<?php echo  $row["NUMERO"] ?> <?php echo  $row["NOME"] ?>" <?php If (!$isNew && ($rowUsers["BANCO"]==$row["NUMERO"]." ".$row["NOME"])) { ?> selected="selected" <?php } ?>><?php echo  $row["NUMERO"] ?> <?php echo  $row["NOME"] ?></option>
<?php
			}
?>
			                        </select>
			                      </div>
			                      <div class="span3">
			                        <input type="text" placeholder="Agencia" name="ag" value="<?php echo ($isNew?"":$rowUsers['AGENCIA'])?>" />
			                      </div>
			                      <div class="span2">
			                        <input type="text" placeholder="Conta" name="cc" value="<?php echo ($isNew?"":$rowUsers['CONTA'])?>" />
			                      </div>
			                    </div>
			                  </div>
			                  <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span12">
			                        <input type="text" placeholder="Comentários" name="obs" value="<?php echo ($isNew?"":$rowUsers['OBS'])?>" />
			                      </div>
			                    </div>
			                  </div>
							</div>
						</div>
						
						<div class="widget-box-form">
							<div class="widget-title">
								<span class="icon"><i class="icon-remove"></i> </span>
								<h5>Informações acesso</h5>
							</div>
							<div class="widget-content nopadding">
				              <div class="control-group">
			                    <div class="controls clearfix">
								  <div class="span6">
			                        <input type="text" placeholder="E-mail " name="email" value="<?php echo ($isNew?"":$rowUsers['EMAIL'])?>" />
			                      </div>
			                      <div class="span2">
			                        <input type="text" placeholder="Sigla" name="sigla" value="<?php echo ($isNew?"":$rowUsers['SIGLA'])?>" />
			                      </div>
			                      <div class="span4">
			                        <input type="text" placeholder="Senha" name="senha" value="<?php echo ($isNew?"":$rowUsers['senha'])?>" />
			                      </div>
			                    </div>
			                  </div>
							</div>
						</div>
					</div>
				</div>

				<div class="row-fluid">
					<div class="span9"></div>
					<div class="span3">
<?php if ($isNew) { ?>					
						<input name="saveUser" type="hidden" value="true" />
<?php } else { ?>						
						<input name="updateUser" type="hidden" value="<?php echo $isEdit?>" />
<?php } ?>						
						<a class="btn btn-secundary" href="profissionais.php">Voltar</a>&nbsp;
						<a class="btn btn-primary submitOnclick">Salvar</a>&nbsp;
						<a class="btn btn-danger confirmOnclick" href="profissionais_cadastro.php?delUser=<?php echo $isEdit?>">Excluir</a>
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
