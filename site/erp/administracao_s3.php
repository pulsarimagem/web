<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_administracao_s3.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pulsar Admin - Indexação > Imagens</title>
<meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
<body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
		<div id="content-header">
			<h1>Imagens</h1>
		</div>
		<div id="breadcrumb">
			<a href="index.php" title="Go to Home" class="tip-bottom"><i
				class="icon-home"></i>Pulsar Admin - Administração S3</a> <a href="#" class="current">Administração</a>
		</div>
		<div class="container-fluid">
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
			<div class="row-fluid">
				<div class="span12">
					<div class="widget-box-form">
						<div class="widget-title">
							<span class="icon"><i class="icon-align-justify"></i></span>
							<h5>Formulário</h5>
						</div>
						<div class="widget-content nopadding">
							<form method="get" class="form-horizontal">

								<div class="control-group">
									<label class="control-label">Tombo</label>
									<div class="controls clearfix">
										<div class="span3">
											<input type="text" name="tombo" class="input-large" value="<?php echo ($toLoad?$colname_dados_foto:"");?>" placeholder="Codigo " />
										</div>
										<div class="span4">
											<button type="submit" name="action" value="excluir" class="btn btn-primary">Excluir</button>
										</div>
									</div>
								</div>
							</form>
							<form method="get" class="form-horizontal">

								<div class="control-group">
									<label class="control-label">Multiplos Tombos</label>
									<div class="controls clearfix">
										<div class="span3">
											<input type="text" name="prefix" class="input-large" value="<?php echo (isset($_GET['prefix'])?$_GET['prefix']:"");?>" placeholder="Prefixo" />
											<input type="text" name="inicio" class="input-large" value="<?php echo (isset($_GET['inicio'])?$_GET['inicio']:"");?>" placeholder="Inicio" />
											<input type="text" name="fim" class="input-large" value="<?php echo (isset($_GET['fim'])?$_GET['fim']:"");?>" placeholder="Fim" />
										</div>
										<div class="span4">
											<button type="submit" name="action" value="multi" class="btn btn-primary">Excluir</button>
										</div>
									</div>
								</div>
							</form>			
						</div>
					</div>
				</div>
			</div>


        <?php include('page_bottom.php'); ?>
      </div>
	</div>
	<!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
