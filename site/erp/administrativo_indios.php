<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_indios.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Indios</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Indios</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Administrativo</a>
        <a href="#" class="current">Indios</a>
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
		        <div class="span7">
		            <a class="btn btn-success novoIndioBtn">Novo</a>
		          </div>
					<form class="form-inline" method="get">
		          <div class="span5">
		              <input class="input-large " name="busca" type="text" placeholder="Nome da Tribo" value="<?php echo $tribo?>"/>
		              <button type="submit" class="btn btn-primary">Buscar</button>
		              <a class="btn btn-info" href="administrativo_indios.php">Limpar</a>
	          	  </div>
				</form>	          	
	          </div>
	        <br />
		<form class="form-inline" method="get">	        
      		<div class="row-fluid novoIndio" <?php if(!$atualizar) { ?> style="display:none" <?php } ?>>
		        <div class="span4">
		            Nome: <input name="tribo" type="text" placeholder="Nome de Tribo" value="<?php echo ($atualizar?$rowSingle['tribo']:"")?>" />
		        </div>
		        <div class="span4">
		            Sinonimos: <input name="sinonimos" type="text" placeholder="Outros Nomes" value="<?php echo ($atualizar?$rowSingle['sinonimos']:"")?>" />
		        </div>
		        <div class="span4">
<?php if($atualizar) { ?>		        
		            <input name="id" type="hidden" value="<?php echo $rowSingle['id'] ?>"/>
		            <input name="action" type="hidden" value="atualizar"/>
		            <button class="btn btn-info" type="submit" name="action" value="atualizar">Atualizar</button>
<?php } else { ?>		        
		            <input name="action" type="hidden" value="salvar"/>
					<button class="btn btn-info" type="submit" name="action" value="salvar">Salvar</button>
<?php } ?>		            
		         </div>
			</div>	     
		</form>      
		<form class="form-inline" method="get">
	        <div class="row-fluid">
	          <div class="span12">
	            <table class="table table-bordered table-striped">
	              <thead>
	                <tr>
	                  <th>Nome</th>
	                  <th>Sinonimos</th>
	                  <th>Ações</th>
	                </tr>
	              </thead>
	              <tbody>
	                <?php while($rowTotal = mysql_fetch_array($objTotal)) { ?>
	                  <tr>
	                    <td><a href="administrativo_indios.php?action=carregar&id=<?php echo $rowTotal["id"]?>"><?php echo $rowTotal["tribo"]?></a></td>
	                    <td><?php echo $rowTotal["sinonimos"]?></td>
	                    <td class="baixaShow_<?php echo $rowTotal["id"]?> baixaShow">
	                      <a class="btn btn-primary" href="administrativo_indios.php?action=carregar&id=<?php echo $rowTotal["id"]?>">Editar</a>
	                      <a class="btn btn-danger" href="administrativo_indios.php?action=excluir&id=<?php echo $rowTotal["id"]?>">Excluir</a>
	                    </td>
	                  </tr>
	                <?php } ?>
	              </tbody>
	            </table>
	          </div>
	        </div>
	
         </form>
	        
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>