<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Pagina Inicial</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
<!--         <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
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
          <div class="span12">
            <form class="form-inline" method="post">
              <label>Incluir: </label>
              <input type="text" class="input-small" placeholder="Código" name="tombo"/>
              <button type="submit" class="btn btn-primary" name="action" value="Incluir">Enviar</button>
            </form>
          </div>
        </div>
        <hr />
<div class="well">
  <div class="input-append date calendar">
    <input data-format="dd/MM/yyyy hh:mm:ss" type="text"></input>
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>
        <div class="row-fluid">
          <div class="span12">


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
