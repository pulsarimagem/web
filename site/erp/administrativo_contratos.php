<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_contratos.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Contratos</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Contratos</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Administrativo</a>
        <a href="#" class="current">Contratos</a>
      </div>
      <div class="container-fluid">
      	<div class="row-fluid">
<?php if(isset($msg) && $msg != "") { ?>
            <div class="alert alert-success">
              <?php echo $msg?>
              <a href="#" data-dismiss="alert" class="close">×</a>
            </div>
<?php } ?>              	
			<div class="span4">
		    	<a class="btn btn-success showNovoContrato" <?php if($editar) {?> href="administrativo_contratos.php" <?php } ?>>Novo</a>
		    </div>
	    </div>
	  </div>
      <div class="container-fluid novoContrato" <?php if(!$editar) { ?> style="display:none;" <?php } ?>>
     	<form class="form-inline" method="post">
      		<div class="row-fluid novoContrato">
		        <div class="span7">
		            Titulo <input type="text" name="txtTitulo" placeholder="Titulo" size="50" value='<?php echo ($editar?$row_objId['titulo']:"") ?>' />
		        </div>
		    </div>
      		<div class="row-fluid novoContrato">
		        <div>
		    		<textarea name="FCKeditor1" id="FCKeditor1"><?php echo ($editar?$valor=$row_objId['condicoes']:$valor="")?></textarea>
		         </div>
		    </div>
		    <div class="row-fluid novoContrato">
		        <div class="span2">
		        	Padrão:
	                <input type="radio" name="padrao" <?php if ($editar && (ord($row_objId['padrao']) == 0 || ord($row_objId['padrao']) == 48)) { echo "checked"; } ?> value="0"/>Não
	                <input type="radio" name="padrao" <?php if ($editar && (ord($row_objId['padrao']) == 1 || ord($row_objId['padrao']) == 49)) { echo "checked"; } else if(!$editar) { echo "checked";}?> value="1"/>Sim
		        </div>
		        <div class="span3">
		        	Assinatura Digital:
	                <input type="radio" name="assinatura" <?php if ($editar && (ord($row_objId['assinatura']) == 0 || ord($row_objId['assinatura']) == 48)) { echo "checked"; } ?> value="0"/>Não
	                <input type="radio" name="assinatura" <?php if ($editar && (ord($row_objId['assinatura']) == 1 || ord($row_objId['assinatura']) == 49)) { echo "checked"; } else if(!$editar) { echo "checked";}?> value="1"/>Sim
		        </div>
		        <div class="span2">
		        	Indio:
	                <input type="radio" name="indio" <?php if ($editar && (ord($row_objId['indio']) == 0 || ord($row_objId['indio']) == 48)) { echo "checked"; } else if(!$editar) { echo "checked";}?> value="0"/>Não
	                <input type="radio" name="indio" <?php if ($editar && (ord($row_objId['indio']) == 1 || ord($row_objId['indio']) == 49)) { echo "checked"; } ?> value="1"/>Sim
		        </div>
		        <div class="span2">
		        	Tipo:
	                <input type="radio" name="tipo" <?php if ($editar && ($row_objId['tipo'] == "F")) { echo "checked"; } else if(!$editar) { echo "checked";}?> value="F"/>Foto
	                <input type="radio" name="tipo" <?php if ($editar && ($row_objId['tipo'] == "V")) { echo "checked"; } ?> value="V"/>Video
		        </div>
		        <div class="span2">
		        	Habilitado:
	                <input type="radio" name="status" <?php if ($editar && (ord($row_objId['status']) == 0 || ord($row_objId['status']) == 48)) { echo "checked"; } ?> value="0"/>Não
	                <input type="radio" name="status" <?php if ($editar && (ord($row_objId['status']) == 1 || ord($row_objId['status']) == 49)) { echo "checked"; } else if(!$editar) { echo "checked";}?> value="1"/>Sim
		        </div>
		    </div>
      		<div class="row-fluid novoContrato">
		        <div class="span7">
					Clientes: 
					<select class="span12" name="clientes[]" multiple data-placeholder=" - - - - - Escolha os Clientes - - - - - ">
<?php while($row_empresas = mysql_fetch_assoc($empresas)) { ?>
						<option value="<?php echo $row_empresas['ID']?>" <?php echo (array_search($row_empresas['ID'], $clientes_arr)!==false?"selected":"")?>><?php echo $row_empresas['RAZAO']." / ".$row_empresas['FANTASIA']?></option>
<?php } ?>
					</select>
   		        </div>
		        <div class="span3">
      				<input type="hidden" name="id" value="<?php echo ($editar?$id:"0")?>"/>
		        	<button class="btn btn-info <?php echo ($editar&&$row_objId['num_contratos']>0?"block_edit":"")?>" type="submit" name="action" value="<?php echo ($editar?"gravar":"incluir")?>">Gravar</button>
		        </div>
			</div>	  
		</form>
	</div>
	<div class="container-fluid">
			      
	        <div class="row-fluid">
	          <div class="span12">
	            <table class="table table-bordered table-striped with-check">
	              <thead>
	                <tr>
			            <th>Título</th>
			            <th>Padrão</th>
			            <th>Assinatura Digital</th>
			            <th>Tipo</th>
			            <th>Indio</th>
			            <th>Habilitado</th>
			            <th>Número de LRs</th>
			            <th>Ações</th>
	                </tr>
	              </thead>
	              <tbody>
	                <?php while($rowTotal = mysql_fetch_array($objTotal)) { ?>
	                  <tr>
		                <td><a href="administrativo_contratos.php?editar=true&id_contrato=<?php echo $rowTotal["Id"]?>"><?php echo $rowTotal['titulo'] ?></a></td>
		                <td><?php if (ord($rowTotal['padrao']) == 0 || ord($rowTotal['padrao']) == 48) { echo "Não"; } else { echo "Sim"; } ?></td>
		                <td><?php if (ord($rowTotal['assinatura']) == 0 || ord($rowTotal['assinatura']) == 48) { echo "Não"; } else { echo "Sim"; } ?></td>                
		                <td><?php echo $rowTotal['tipo'] == "V"?"Video":"Foto"; ?></td>
		                <td><?php if (ord($rowTotal['indio']) == 0 || ord($rowTotal['indio']) == 48) { echo "Não"; } else { echo "Sim"; } ?></td>
		                <td><?php if (ord($rowTotal['status']) == 0 || ord($rowTotal['status']) == 48) { echo "Não"; } else { echo "Sim"; } ?></td>                
		                <td><?php echo $rowTotal['num_contratos']?></td>                
   	                    <td>
	                      <a class="btn btn-primary" href="administrativo_contratos.php?editar=true&id_contrato=<?php echo $rowTotal["Id"]?>">Editar</a>
	                      <a class="btn btn-danger" href="administrativo_contratos.php?excluir=true&id_contrato=<?php echo $rowTotal["Id"]?>">Excluir</a>
	                    </td>
	                  </tr>
	                <?php } ?>
	              </tbody>
	            </table>
<!-- 	            <div class="pagination pagination-right"> -->
<!-- 	              <ul> -->
<!-- 	                <li class="disabled"><a href="#">«</a></li> -->
<!-- 	                <li class="active"><a href="#">1</a></li> -->
<!-- 	                <li><a href="#">2</a></li> -->
<!-- 	                <li><a href="#">3</a></li> -->
<!-- 	                <li><a href="#">4</a></li> -->
<!-- 	                <li><a href="#">5</a></li> -->
<!-- 	                <li><a href="#">»</a></li> -->
<!-- 	              </ul> -->
<!-- 	            </div> -->
	
	          </div>
	        </div>
	
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
