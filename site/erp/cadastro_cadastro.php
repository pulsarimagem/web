<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_cadastro_cadastro.php"); ?>
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
				class="icon-home"></i>Dashboard</a> <a href="cadastro.php">Cadastro</a>
			<a href="#" class="current">Cadastro</a>
		</div>
		<form id="cliente_cadastro" method="post" class="form-horizontal formOnclick">
			<div class="container-fluid">
				<div class="row-fluid">
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
			                        <input type="text" placeholder="Login" name="login" value="<?php echo ($isNew?"":$rowUsers['login'])?>" />
			                      </div>
			                      <div class="span4">
			                        <input type="text" placeholder="Nome" name="nome" value="<?php echo ($isNew?"":$rowUsers['nome'])?>" />
			                      </div>
			                      <div class="span3">
			                        <input type="text" placeholder="Empresa" name="empresa" value="<?php echo ($isNew?"":$rowUsers['empresa'])?>" />
			                      </div>
			                    </div>
			                  </div>
			 	             <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span4">
			                        <input type="text" placeholder="E-mail" name="email" value="<?php echo ($isNew?"":$rowUsers['email'])?>" />
			                      </div>
			                      <div class="span3">
			                        <input type="text" placeholder="Cargo " name="cargo" value="<?php echo ($isNew?"":$rowUsers['cargo'])?>" />
			                      </div>
			                      <div class="span5">
			                        <input type="text" placeholder="Telefone " name="telefone" value="<?php echo ($isNew?"":$rowUsers['telefone'])?>" />
			                      </div>
			                    </div>
			                  </div>
			 	             <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span3">
			                        <input type="text" placeholder="CPF/CNPJ" name="cpf_cnpj" value="<?php echo ($isNew?"":$rowUsers['cpf_cnpj'])?>" />
			                      </div>
			                    <div class="span7">
			                        <input type="text" placeholder="Endereço" name="endereco" value="<?php echo ($isNew?"":$rowUsers['endereco'])?>" />
			                      </div>
			                      <div class="span2">
			                        <input type="text" placeholder="CEP " name="cep" value="<?php echo ($isNew?"":$rowUsers['cep'])?>" />
			                      </div>
			                    </div>
			                  </div>
			 	             <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span3">
			                        <input type="text" placeholder="Cidade" name="cidade" value="<?php echo ($isNew?"":$rowUsers['cidade'])?>" />
			                      </div>
			                      <div class="span3">
			                        <select data-placeholder="Estado" name="estado">
			                          <option value=""></option>
<?php while ($row_estados = mysql_fetch_assoc($estados)) { ?>
								        <option value="<?php echo $row_estados['Sigla']?>"<?php if (!(strcmp($row_estados['Sigla'], $rowUsers['estado']))) {echo "selected=\"selected\"";} ?>><?php echo $row_estados['Estado']?></option>
<?php } ?>                          
			                        </select>
			                      </div>
			                      <div class="span2">
			                        <select data-placeholder="País" name="pais">
			                          <option value=""></option>
<?php while ($row_paises = mysql_fetch_assoc($paises)) { ?>			                          
        								<option value="<?php echo $row_paises['id_pais']?>"<?php if (!(strcmp($row_paises['id_pais'], $rowUsers['pais']))) {echo "selected=\"selected\"";} ?>><?php echo $row_paises['nome']?></option>
<?php } ?>
			                        </select>
			                      </div>
			                    </div>
			                  </div>
							  <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span7">
			                        <input type="text" placeholder="Data Cadastro" name="data_cadastro" value="<?php echo ($isNew?"":makeDateTime($rowUsers['data_cadastro'], 'd/m/Y'))?>" />
			                      </div>
			                      <div class="span3">
								      <select data-placeholder="Tipo Cadastro" name="tipo">
							          	<option value=""></option>
								      	<option value="F" <?php if (!(strcmp("F", $rowUsers['tipo']))) {echo "selected=\"selected\"";} ?>>Pessoa F&iacute;sica</option>
								        <option value="J" <?php if (!(strcmp("J", $rowUsers['tipo']))) {echo "selected=\"selected\"";} ?>>Pessoa Jur&iacute;dica</option>
								      </select>
			                    </div>
			                  </div>
							</div>
			 	            <div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span4">
			                        <input type="text" placeholder="Limite Download" name="limite" value="<?php echo ($isNew?"":$rowUsers['limite'])?>" />
			                      </div>
			                      <div class="span3">
								      <select data-placeholder="Cliente SIG" name="download">
							          	<option value="">Nenhuma</option>
								      	<option value="SV" <?php if (!(strcmp("SV", $rowUsers['download']))) {echo "selected=\"selected\"";} ?>>Videos+Fotos+Layout</option>
								        <option value="LV" <?php if (!(strcmp("LV", $rowUsers['download']))) {echo "selected=\"selected\"";} ?>>Videos+Layout</option>
							          	<option value="S" <?php if (!(strcmp("S", $rowUsers['download']))) {echo "selected=\"selected\"";} ?>>Fotos+Layout</option>
								        <option value="L" <?php if (!(strcmp("L", $rowUsers['download']))) {echo "selected=\"selected\"";} ?>>Layout</option>
								        <option value="V" <?php if (!(strcmp("L", $rowUsers['download']))) {echo "selected=\"selected\"";} ?>>Videos</option>
								      </select>
			                      </div>
			                    </div>
			                </div>							
							<div class="control-group">
			                    <div class="controls clearfix">
			                      <div class="span7">
								      <select class="span10" data-placeholder="Cliente SIG"  name="id_cliente_sig">
							          	<option value=""></option>
<?php while($row_empresas = mysql_fetch_assoc($empresas)) { ?>
										<option value="<?php echo $row_empresas['ID']?>" <?php echo ((!(strcmp($row_empresas['ID'], $rowUsers['id_cliente_sig'])))?"selected":"")?>><?php echo $row_empresas['RAZAO']." / ".$row_empresas['FANTASIA']?></option>
<?php } ?>
								      </select>
			                      </div>
			                      <div class="span5">
								      <select class="span10" data-placeholder="Contato SIG"  name="id_contato_sig">
							          	<option value=""></option>
<?php while($row_contatos = mysql_fetch_assoc($contatos)) { ?>
										<option value="<?php echo $row_contatos['ID']?>" <?php echo ((!(strcmp($row_contatos['ID'], $rowUsers['id_contato_sig'])))?"selected":"")?>><?php echo $row_contatos['CONTATO']?></option>
<?php } ?>
								      </select>
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
						<a class="btn btn-secundary" href="cadastro.php">Voltar</a>&nbsp;
						<a class="btn btn-primary submitOnclick">Salvar</a>&nbsp;
						<a class="btn btn-danger confirmOnclick" href="cadastro_cadastro.php?delUser=<?php echo $isEdit?>">Excluir</a>
					</div>
				</div>
				<?php include('page_bottom.php'); ?>
			</div>
			</div>
		</form>
	</div>
	<!-- END #content -->
	
	<?php include('includes_footer.php'); ?>

</body>
</html>
