<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_precos_usos.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Usos</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Usos</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Administrativo</a>
        <a href="administrativo_precos.php">Preço</a>
        <a href="#" class="current">Usos</a>
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
		  <div class="span9">
            <a class="btn btn-success" href="administrativo_precos_usos.php">Tipo</a>
            <a class="btn btn-success" href="administrativo_precos_usos.php?tabela=USO_SUBTIPO&campo=subtipo">Utilização</a>
            <a class="btn btn-success" href="administrativo_precos_usos.php?tabela=uso_formato&campo=formato">Formato</a>
            <a class="btn btn-success" href="administrativo_precos_usos.php?tabela=uso_distribuicao&campo=distribuicao">Distribuição</a>
            <a class="btn btn-success" href="administrativo_precos_usos.php?tabela=USO_DESC&campo=descricao">Tamanho</a>
            <a class="btn btn-success" href="administrativo_precos_usos.php?tabela=uso_periodicidade&campo=periodicidade">Periodicidade</a>
            <a class="btn btn-success" href="administrativo_precos_usos.php?tabela=uso_descricao&campo=descricao">Descrição</a>
          </div>
        </div>
      </div>
          
      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span12">
            <a class="btn btn-secundary" href="administrativo_precos.php">Voltar</a>
          </div>

          </div><br />
        	<div class="row-fluid">
        		<form onsubmit="return valida();" id="formTipo" action='administrativo_precos_usos.php?<?php if (isset($_GET["edita"]) && $_GET["edita"] != "" ) { ?>gravaedita=<?php echo $_GET["edita"] ?><?php } else { ?>inclui=true<?php } ?>' enctype="" method="get">
        		
					<div class="span12">
						<div class="widget-box-form">
							<div class="widget-title">
								<span class="icon"><i class="icon-remove"></i> </span>
								<h5>Incluir <?php echo $campo?></h5>
							</div>
							<div class="widget-content nopadding">
								<div class="control-group">
									<div class="controls clearfix">
										<div class="span5">
											<input type="text" id="txttipo_br" placeholder="<?php echo $campo?>" name="txttipo_br" maxlength="200" size="50" <?php if (isset($_GET["edita"]) && $_GET["edita"] != "" ) { ?>value='<?php echo $row_objId[$campo."_br"]; } ?>' />	        									
										</div>
					`					<div class="span5">
											<input type="text" id="txttipo_en" placeholder="<?php echo $campo." en"?>" name="txttipo_en" maxlength="200" size="50" <?php if (isset($_GET["edita"]) && $_GET["edita"] != "" ) { ?>value='<?php echo $row_objId[$campo."_en"]; } ?>' />	        									
										</div>
	
									</div>
	        			          <div class="form-actions2">
				                    <div class="controls clearfix">
				                      <button type="submit" class="btn btn-primary"><?php if (isset($_GET["edita"]) && $_GET["edita"] != "" ) { echo "Alterar Tipo"; } else { echo "Gravar $campo"; }?></button>
			                          <input type="hidden" name="tabela" value="<?php echo $tabela?>"/>
									  <input type="hidden" name="campo" value="<?php echo $campo?>"/>
<?php if (isset($_GET["edita"]) && $_GET["edita"] != "" ) { ?>
								  	  <input type="hidden" name="gravaedita" value="<?php echo $_GET["edita"] ?>"/>
<?php } else { ?>
									  <input type="hidden" name="inclui" value="true"/>
<?php } ?>
				                      
				                    </div>
				                  </div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
        <div class="row-fluid">
          <div class="span12">
            
                <table class="table table-bordered table-striped with-check">
                  <thead>
                    <tr>
                      <th><input type="checkbox" /></th>
                      <th>Tipos incluídos</th>
                      <th>Tipos incluídos (en)</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
<?php while ($row_obj = mysql_fetch_array($obj)) { ?>
                      <tr>
                        <td><input type="checkbox" /></td>
                        <td><?php echo $row_obj[$campo."_br"]?></td>
                        <td><?php echo $row_obj[$campo."_en"]?></td>
                        <td width="200">
                          <a class="btn btn-primary" href="administrativo_precos_usos.php?tabela=<?php echo $tabela?>&campo=<?php echo $campo?>&edita=<?php echo $row_obj["Id"]?>">Editar</a>&nbsp;<a class="btn btn-danger" href="administrativo_precos_usos.php?tabela=<?php echo $tabela?>&campo=<?php echo $campo?>&deleta=<?php echo $row_obj["Id"]?>" onclick="return confirma_exluir_uso();">Excluir</a>
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
