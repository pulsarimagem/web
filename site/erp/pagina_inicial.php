<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_pagina_inicial.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Pagina Inicial</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Pagina Inicial</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Administrativo</a>
        <a href="#" class="current">Preços</a>
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
          <div class="span12">
            <form class="form-inline" method="post">
              <label>Incluir: </label>
              <input type="text" class="input-small" placeholder="Código" name="tombo"/>
              <button type="submit" class="btn btn-primary" name="action" value="Incluir">Enviar</button>
            </form>
          </div>
        </div>
        <hr />
            
        <div class="row-fluid">
          <div class="span12">

            <table class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th><input type="checkbox" /></th>
			      <th>Código</th>
                  <th>Preview</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
<?php while ($row_fotos_home = mysql_fetch_assoc($fotos_home)) {?>
                  <tr>
                    <td><input type="checkbox" /></td>
		            <td><?php echo $row_fotos_home['tombo']; ?></td>
		        	<td>        	
		        		<div style="width: 150px; height: 47px; overflow: hidden">
	        				<img src="<?php echo "http://www.pulsarimagens.com.br/" //$homeurl; ?>bancoImagens/<?php echo $row_fotos_home['tombo']; ?>p.jpg" title="" style="margin:-27px 0px -27px 0px" onclick="document.location.href='http://www.pulsarimagens.com.br/images/home/<?php echo $row_fotos_home['tombo']; ?>.jpg'"/> 
        				</div>
        			</td>
                    <td>
                      <a class="btn btn-danger confirmOnclick" href="pagina_inicial.php?delete=<?php echo $row_fotos_home['id_foto']; ?>">Excluir</a>
                    </td>
                  </tr>
<?php } ?>
              </tbody>
            </table>
<!-- 
            <div class="pagination pagination-right">
              <ul>
                <li class="disabled"><a href="#">«</a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">»</a></li>
              </ul>
            </div>
 -->
          </div>
        </div>


        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
