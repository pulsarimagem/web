<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_fotos_sem_index.php"); ?>
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
        <a href="#" class="current">Fotos Sem Indexação</a>
      </div>
      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span12">

<a class="btn btn-primary" href='fotos_sem_index.php?show=1'>Fotos sem thumb</a>
<a class="btn btn-primary" href='fotos_sem_index.php?show=2'>Thumb sem fotos</a>
<a class="btn btn-primary" href='fotos_sem_index.php?show=3'>Fotos sem db</a>
       
<?php if($show==1) { ?>
<table class="table-bordered">
  <thead>
  <tr>
    <th>Fotos sem Thumb: <?php echo count($fotos_sem_thumb);?></th>
  </tr>
  </thead>
  <tbody>
<?php foreach ($fotos_sem_thumb as $value) { ?>  <tr>
    <td><?php echo "$value"; ?>&nbsp;</td>
  </tr>
<?php } ?>
</tbody>
</table>
<br>
<?php } ?>
<?php if($show==2) { ?>
<table class="table-bordered">
  <thead>
  <tr>
    <th>Thumb sem Fotos: <?php echo count($thumb_sem_fotos);?></th>
  </tr>
  </thead>
  <tbody>
<?php foreach ($thumb_sem_fotos as $value) { ?>  <tr>
    <td><?php echo "$value"; ?>&nbsp;</td>
  </tr>
<?php } ?>
</tbody>
</table>
<br>
<?php }?>
<?php if($show==3) { ?>
<table class="table-bordered">
  <thead>
  <tr>
    <th>Fotos sem Indexa&ccedil;&atilde;o: <?php echo count($fotos_sem_db);?></th>
  </tr>
  </thead>
  <tbody>
<?php foreach ($fotos_sem_db as $value) { ?>  <tr>
    <td><?php echo "$value"; ?>&nbsp;</td>
  </tr>
<?php } ?>
</tbody>
</table>
<?php }?>
</div>
</div>
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
