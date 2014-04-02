<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_index_sem_foto.php"); ?>
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
        <a href="#" class="current">Indexação sem Foto Alta</a>
      </div>
      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span12">

<table class="table table-bordered table-striped">
  <thead>
  <tr>	
    <th>Indexa&ccedil;&atilde;o sem Fotos Alta: <?php echo count($db_sem_altas);?></th>
  </tr>
  </thead>
  <tbody>
<?php foreach ($db_sem_altas as $value) { ?>  <tr>
    <td><?php echo "$value"; ?>&nbsp;</td>
  </tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
