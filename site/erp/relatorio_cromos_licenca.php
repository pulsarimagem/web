<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_relatorio_cromos_licenca.php")?>
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
        <a href="#" class="current">Relatórios</a>
      </div>
      <div class="container-fluid">
       <form class="form-inline">
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
		    <div class="span4">
              Código: <input class="input-small" name="codigo" type="text" placeholder="Código" value="<?php echo $codigo?>"/>
            </div>
            <div class="span2">
              <button type="submit" class="btn btn-primary">Consultar</button>
            </div>
         </div>
       </form>
       <div class="row-fluid">
          <div class="span12">      
       
<?php
if ($objTotal == 0 && $codigo!="") {
?>
<table class="table table-bordered table-striped">
	<tr>
		<th colspan="2"><center>Consulta de cromos vendidos</center></th>
	</tr>
	<tr></tr>
	<tr>
		<td colspan="2">Nenhum registro encontrado com as informações digitadas</td>
	</tr>
	<tr>
		<td>Código:</td>
		<td><b>&nbsp;<?php echo $codigo?></b></td>
	</tr>
</table>
<?php } else if ($codigo!="") { ?>
<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th colspan="6"><center><b>Consulta de cromos vendidos</b></center></th>
	</tr>
	
	<tr></tr>
	<tr>
		<th><center><b>CONTRATO</b></center></th>
		<th><center><b>EMISSÃO</b></center></th>
		<th><center><b>CLIENTE</b></center></th>
		<th><center><b>DESCRIÇÃO</b></center></th>
	</tr>
	</thead>
	<tbody>	
<?php WHILE ($row_objRs = mysql_fetch_assoc($objRs)) { ?>
	<tr>
		<td><center><a href="administrativo_licencas_nova.php?id_contrato=<?php echo $row_objRs["ID_CONTRATO"]?>" title="Visualizar Contrato"><b><?php echo $row_objRs["ID_CONTRATO"]?></b></a></center></td>
		<td><center><?php echo formatdate($row_objRs["DATA"])?></center>&nbsp;</td>
		<td><?php echo $row_objRs["FANTASIA"]?>&nbsp;</td>
		<td><center><textarea cols="60" rows="2" readonly="readonly"><?php echo $row_objRs["DESCRICAO"]?></textarea></center></td>
	</tr>
<?php } ?>
	<tr>
		<td colspan="4">Foram localizados <b><?php echo $objTotal?></b> registros com esta consulta. </td>
	</tr>	
	</tbody>
</table>
<?php } ?>
			</div>
		</div>
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>

