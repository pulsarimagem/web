<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_temas_descritores.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Temas e Descritores</title>
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
        <a href="#">Administrativo</a>
        <a href="#" class="current">Relatórios</a>
      </div>
      <div class="container-fluid">

        <div class="row-fluid">
          <form class="form-inline">
            <div class="span7">
              <select class="span11 do_submit" name="id" data-placeholder="Tema">
	          	<option></option>
<?php while ($row_temas = mysql_fetch_assoc($temas)) { ?>
				<option value="<?php echo $row_temas['Id']?>" <?php if($id == $row_temas['Id']) echo "selected"?>><?php echo $row_temas['Tema_total']?></option>
<?php }?>
  			  </select>
            </div>
            <div class="span2">
            	<input class="input-small" name="porcento" type="text" placeholder="Corte" value="<?php echo $porcento?>"/> %	
            </div>
            <div class="span3">
              <button type="submit" class="btn btn-primary do_button">Enviar</button>
            </div>
          </form>
        </div>
        <br />
        <div class="row-fluid">
          <div class="span12">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Palavra-Chave</th>
                <th>Quantidade</th>
                <th>Porcentagem</th>
            </tr>
            </thead>
            <tbody>		
<?php while($rowTemas = mysql_fetch_array($rsTemas)) { ?>
			
					<tr>
						<td><?php echo $rowTemas["palavra"]?></td>
						<td><?php echo $rowTemas["qty"]?></td>
						<td><?php echo ($rowTemas["porcento"]*100)?> %</td>
					</tr>
		
<?php } ?>
			</tbody>
<!-- 			<tr> -->
<!--				<td colspan="2">Foram localizados (<b><?php echo $x;?></b>) registros com esta consulta.</td>
				<td id="border"><b>R$ <?php echo formatnumber($nf_tot);?></b></td>
				<td id="border"><b>R$ <?php echo formatnumber($imp_tot);?></b></td>
 				<td>&nbsp;</td> -->
<!-- 				<td id="border"><b>R$ <?php echo formatnumber($com_comp_tot);?></b></td>
				<td id="border"><b>R$ <?php echo FormatNumber($com_aut_tot);?></b></td>
 			</tr> -->
		</table>
		</div>

        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
