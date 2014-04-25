<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_ftp_criar.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Relatórios</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Relatórios</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Site</a>
        <a href="#" class="current">FTP</a>
      </div>
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
<?php if(!$isCriarTmp) { ?> 
          <form class="form-inline">
            <div class="span5">
              <select class="span10" name="id_login" data-placeholder="usuario">
	          	<option value="">-- Escolha o Usuário --</option>
<?php while ($row_diretorios = mysql_fetch_assoc($diretorios)) { ?>
			    <option value="<?php echo $row_diretorios['id_cadastro']?>"<?php if (isset($idLogin) && !(strcmp($row_diretorios['id_cadastro'], $idLogin))) {echo "selected=\"selected\"";} ?>><?php echo $row_diretorios['nome']?>/<?php echo $row_diretorios['empresa']?></option>
<?php }?>
  			  </select>	
            </div>
            <div class="span1">
              <button type="submit" class="btn btn-success">Criar</button>
            </div>
            <div class="span2">
              <a class="btn btn-primary" href="ftp_criar.php?createtmp=true">Criar Temporário</a>
            </div>
            <div class="span2">
              <a class="btn btn-warning" href="ftp.php">Voltar</a>
            </div>
            
          </form>
<?php } else { ?>
          <form class="form-inline">
            <div class="span4">
              Login <input name="tmp_login" type="text" placeholder="Login Temporário" value="<?php echo (isset($_GET['tmp_login'])?$_GET['tmp_login']:"")?>"/>
            </div>
            <div class="span4">
              Senha <input name="senha" type="text" placeholder="Senha" value="<?php echo (isset($_GET['senha'])?$_GET['senha']:"")?>"/>
            </div>
            <div class="span4">
              E-mail<input name="email" type="text" placeholder="E-mail" value="<?php echo (isset($_GET['email'])?$_GET['email']:"")?>"/>
            </div>
            <div class="span1">
              <input name="createtmp" type="hidden" value="true"/>
              <button type="submit" class="btn btn-success">Criar</button>
            </div>
	        <div class="span2">
              <a class="btn btn-warning" href="ftp.php">Voltar</a>
            </div>
          </form>
<?php } ?>          
        </div>
        <br />
	  
</div>
</form>
</div>



        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
