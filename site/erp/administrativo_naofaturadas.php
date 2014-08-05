<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_naofaturadas.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Licenças</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Licenças</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Administrativo</a>
        <a href="#" class="current">Licenças</a>
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
     	<form class="form-inline" method="post">
      		<div class="row-fluid">
		          <div class="span5">
					<div class="input-append calendar">
	                   Cliente <select class="span12" name="id_cliente" data-placeholder="Escolha um cliente">
							<option value="">Escolha um cliente</option>
<?php 	while($row_empresas = mysql_fetch_assoc($empresas)) { ?>
							<option value="<?php echo $row_empresas['ID']?>" <?php echo ($row_empresas['ID']==$id_cliente?"selected":"")?>><?php echo $row_empresas['RAZAO']." / ".$row_empresas['FANTASIA']?></option>
<?php 	} ?>
    	  				</select>		          
					</div>      			  
      			  </div>
		          <div class="span2">
					<div class="input-append calendar">
				    	De <input data-format="dd/MM/yyyy" type="text" name="de" class="input-small" placeholder="Data Inicial" value="<?php echo $de?>" maxlength="10" onKeyPress="return txtBoxFormat(this, '99/99/9999', event);"/>
				    	<span class="add-on">
				      		<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      		</i>
				    	</span>
				  	</div>
		          </div>
		          <div class="span2">
					<div class="input-append calendar">
				    	Até <input data-format="dd/MM/yyyy" type="text" name="ate" class="input-small" placeholder="Data Final" value="<?php echo $ate?>" maxlength="10" onKeyPress="return txtBoxFormat(this, '99/99/9999', event);"/>
				    	<span class="add-on">
				      		<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      		</i>
				    	</span>
				  	</div>
		          </div>
          		  <div class="span2">
		              LR: <input class="input-small" name="lr" type="text" placeholder="No. da LR" value="<?php echo $lr?>" maxlength="10"/>
		          </div>
<!-- 	    		  <div class="span2"> -->
<!--		              <input name="baixados" type="checkbox" <?php echo ($show_baixados?"checked":"")?>/> Mostra baixados -->
<!-- 		          </div> -->
		          <div class="span1">
<!-- 		              Cliente: <input class="input-large" name="cliente" type="text" placeholder="Nome fantasia ou Razão social" value="<?php echo $cliente?>"/> -->
		              <button type="submit" name="action" value="enviar" class="btn btn-primary">Consultar</button>
		          </div>
		        </div>
	          </div>
<?php if($totalTotal > 0) {?>		        
			<div class="row-fluid">
	          <div class="span12">
	            <table class="table table-bordered table-striped">
	              <thead>
	                <tr>
	                  <th>Cromo</th>
	                  <th>Data</th>
	                  <th>Nome</th>
	                  <th>Empresa</th>
	                  <th>Uso</th>
	                  <th>LR</th>
	                  <th>Data LR</th>
	                </tr>
	              </thead>
	              <tbody>
<?php 
	                while($rowTotal = mysql_fetch_array($objTotal)) {
						$codigo_tmp = $rowTotal["arquivo"];
						$codigo_arr = explode(".",$codigo_tmp);
						$codigo = $codigo_arr[0];
						$id_uso = $rowTotal["uso"];
						$dataStart = $rowTotal["data_hora"];
												
						$sql = "SELECT
						CROMOS.ID_CONTRATO, CROMOS.CODIGO, CROMOS.ID_USO, CROMOS.finalizado, CONTRATOS.ID, CONTRATOS.DATA
						FROM CROMOS
						LEFT JOIN CONTRATOS ON CONTRATOS.ID = CROMOS.ID_CONTRATO
						WHERE CODIGO LIKE '$codigo' AND ID_USO = '$id_uso' AND DATA > '$dataStart' AND DATA < '$dataStart' + INTERVAL 2 MONTH";
						$rs = mysql_query($sql, $sig) or die(mysql_error());
						$row = mysql_fetch_array($rs);
						$total = mysql_num_rows($rs);
						if($total > 0) continue; 
?>
	                  <tr>
	                    <td><a href="relatorio_download.php?periodo=<?php echo date("m/Y",strtotime($rowTotal["data_hora"]))?>&id_login=<?php echo str_pad($rowTotal["id_login"],20,"0",STR_PAD_LEFT)?>&tipo=fotos"><?php echo $rowTotal["arquivo"]?></a></td>
	                    <td><?php echo date("d/m/Y",strtotime($rowTotal["data_hora"]))?></td>
	                    <td><?php echo $rowTotal["nome"]?></td>
	                    <td><?php echo $rowTotal["empresa"]?></td>
	                    <td><?php echo $rowTotal["uso"]?></td>
	                    <td><?php echo $row["ID"]?></td>
	                    <td><?php echo ($total>0?date("d/m/Y",strtotime($row["DATA"])):"")?></td>
	                  </tr>
	                <?php } ?>
	              </tbody>
	            </table>
	          </div>
	        </div>
<?php } ?>
	        <br />

		</form>
	        
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
