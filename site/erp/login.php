<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_login.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin</title>
    <meta charset="iso-8859-1"/>
    <?php include('includes_header.php'); ?>
  </head>
  <body>

		<?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Login</h1>
      </div>
      <div id="breadcrumb">
        <a href="#" title="Go to Home" class="tip-bottom current"><i class="icon-user"></i>Login</a>
      </div>
      <div class="container-fluid">
        
        <div class="row-fluid">
          <div class="span12">
            <div class="widget-box">
							<div class="widget-title">
								<span class="icon">
									<i class="icon-align-justify"></i>									
								</span>
								<h5>Formulário de login</h5>
							</div>
							<div class="widget-content nopadding">
								<form form name="form1" method="post" action="login.php" class="form-horizontal">
									<div class="control-group">
										<label class="control-label">Login</label>
										<div class="controls span4">
											<input name="login" type="text" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Senha</label>
										<div class="controls span4">
											<input name="senha" type="password" />
										</div>
									</div>
									<div class="form-actions">
										<button name="action" type="submit" class="btn btn-primary">Login</button>
									</div>
								</form>
							</div>
						</div>
          </div>
        </div>
       
        
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>
    
  </body>
</html>
