<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_usuarios_cadastro.php"); ?>
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
				class="icon-home"></i>Dashboard</a> <a href="usuarios.php">Usuários</a>
			<a href="#" class="current">Cadastro</a>
		</div>
		<form id="usuarios_cadastro" method="post" class="form-horizontal formOnclick">
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
											<input name="name" type="text" placeholder="Nome" value="<?php echo ($isNew?"":$rowUsers['nome'])?>" />
										</div>
										<div class="span5">
											<!--                         <input type="text" placeholder="e-mail " /> -->
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
							<h5>Informações de Acesso</h5>
						</div>
						<div class="widget-content nopadding">
<!-- 							<form action="#" method="post" class="form-horizontal"> -->
								<div class="control-group">
									<div class="controls clearfix">
										<div class="span4">
											<input name="user" type="text" placeholder="Login "	value="<?php echo ($isNew?"":$rowUsers['usuario'])?>" />
										</div>
										<div class="span4">
											<!--                         <input type="text" placeholder="ftp " /> -->
										</div>
									</div>
								</div>
								<div class="control-group">
									<div class="controls clearfix">
										<div class="span4">
											<input name="password" type="text" placeholder="Senha " />
										</div>
										<div class="span4">
											<input name="passAgain" type="text" placeholder="Confirmação Senha " />
										</div>
									</div>


									<div class="control-group">

										<div class="controls clearfix">
											<div class="span1">
												<label>Status</label>
											</div>

											<div class="span4">
												<label class="radio inline"> <input type="radio" name="status" id="inlineCheckbox1" value="A" <?php echo ($isNew?"":($rowUsers['status']!="D"?"checked":""))?> /> Válido </label> 
												<label class="radio inline"> <input type="radio" name="status" id="inlineCheckbox2" value="D" <?php echo ($isNew?"":($rowUsers['status']=="D"?"checked":""))?> /> Excluído </label>
											</div>
										</div>
									</div>
									<div class="control-group">

										<div class="controls clearfix">
											<div class="span1">
												<label>Regra Acesso</label>
											</div>

											<div class="span4">
<?php while($rowRoles = mysql_fetch_array($rsRoles)) { ?>
												<label class="radio inline"> <input type="radio" name="role" value="<?php echo $rowRoles['id']?>" <?php echo ($isNew?"":($rowUsers['role']==$rowRoles['nome']?"checked":""))?> /> <?php echo $rowRoles['nome']?></label> 
<?php } ?>											
											</div>
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
						<a class="btn btn-secundary" href="usuarios.php">Voltar</a>&nbsp;
						<a class="btn btn-primary submitOnclick">Salvar</a>&nbsp;
						<a class="btn btn-danger confirmOnclick" href="usuarios_cadastro.php?delUser=<?php echo $isEdit?>">Excluir</a>
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
