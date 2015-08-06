<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_roles_cadastro.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pulsar Admin - Regras</title>
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
				class="icon-home"></i>Dashboard</a> <a href="roles.php">Regras</a>
			<a href="#" class="current">Cadastro</a>
		</div>
		<form id="usuarios_cadastro" method="post" class="form-horizontal formOnclick">
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
											Nome: <input name="name" type="text" placeholder="Nome" value="<?php echo ($isNew?"":$rowUsers['nome'])?>" />
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
							<h5>Regras de Acesso</h5>
						</div>
						<div class="widget-content nopadding">
<!-- 							<form action="#" method="post" class="form-horizontal"> -->
									<div class="control-group">
										<div class="controls clearfix">
											<div class="span1">
												<label>Status</label>
											</div>

											<div class="span4">
												<label class="radio inline"> <input type="radio" name="status" id="inlineCheckbox1" value="A" <?php echo ($isNew?"checked":($rowUsers['status']!="D"?"checked":""))?> /> Válido </label> 
												<label class="radio inline"> <input type="radio" name="status" id="inlineCheckbox2" value="D" <?php echo ($isNew?"":($rowUsers['status']=="D"?"checked":""))?> /> Excluído </label>
											</div>
										</div>
									</div>
<?php 
foreach ($menu->menu->getChild() as $submenu) {
	$noSpaceSubmenu =  str_replace(" ", "", $submenu->name);
?>									
									<div class="control-group">
										<div class="controls clearfix">
											<div class="span3">
												<label><?php echo $submenu->name?></label>
											</div>

											<div class="span4">
												<label class="radio inline"> <input type="radio" name="<?php echo $noSpaceSubmenu?>" value="1" <?php echo ($isNew?"":($rowUsers[$noSpaceSubmenu]=="1"?"checked":""))?> /> Editar </label>
												<label class="radio inline"> <input type="radio" name="<?php echo $noSpaceSubmenu?>" value="0" <?php echo ($isNew?"":($rowUsers[$noSpaceSubmenu]=="0"?"checked":""))?> /> Ver </label>
												<label class="radio inline"> <input type="radio" name="<?php echo $noSpaceSubmenu?>" value="-1" <?php echo ($isNew?"checked":($rowUsers[$noSpaceSubmenu]=="-1"?"checked":""))?> /> Nada </label> 
											</div>
										</div>
									</div>
<?php 
} 
?>									
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
						<a class="btn btn-secundary" href="roles.php">Voltar</a>&nbsp;
						<a class="btn btn-primary submitOnclick">Salvar</a>&nbsp;
						<a class="btn btn-danger confirmOnclick" href="roles.php?excluirUser=<?php echo $isEdit?>">Excluir</a>
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
