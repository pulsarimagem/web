<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_precos.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Preçoos</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Preços</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Administrativo</a>
        <a href="#" class="current">Preços</a>
      </div>
      <div class="container-fluid">
        
        <div class="row-fluid">
          <div class="span10">
            <form class="form-inline">
              <label>Imposto (Alíquota): </label>
              <input type="text" class="input-small" /> % valor total
              <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
          </div>
          <div class="span2">
            <a class="btn btn-primary" href="administrativo_precos_usos.php">Adicionar uso</a>
          </div>
        </div>
        <hr />
        <div class="row-fluid">
          <form id="frmPreco" action="administrativo_precos.php?<?php If ( isset($_GET["edita"]) ) { ?>gravaedita=<?php echo $_GET["edita"] ?><?php } else { ?>inclui=true<?php } ?>" enctype="" method="post">
            <div class="span3">
              <label>Contrato</label>
              <select name="contrato" data-placeholder="Contrato">
            	<option <?php If ( $idEditaContrato == "F") echo "selected=\"selected\"";?> value='F'>Foto</option>
            	<option <?php If ( $idEditaContrato == "V") echo "selected=\"selected\"";?> value='V'>Video</option>
              </select>
            </div>
            <div class="span3">
              <label>Tipo</label>
              <select name="ddltipo" data-placeholder="Tipo">
                <option value=""></option>
	            <?php while ($row_objTipo = mysql_fetch_array($objTipo)) {?>
	                <?php If ( $idEditaTipo == $row_objTipo["Id"] ) { ?>
	                    <option selected="selected" value='<?php echo $row_objTipo["Id"] ?>'><?php echo $row_objTipo["tipo"] ?></option>
	                <?php } else { ?>
	                    <option value='<?php echo $row_objTipo["Id"] ?>'><?php echo $row_objTipo["tipo"] ?></option>
	                <?php } ?>
	            <?php } ?>
              </select>
            </div>
            <div class="span3">
              <label>Utilização</label>
              <select name="ddlutilizacao" data-placeholder="Utilização">
            	<option value='0'>Nenhum</option>
            <?php while ($row_objUtilizacao = mysql_fetch_array($objUtilizacao)) { ?>
                <?php If ( $idEditaUtilizacao == $row_objUtilizacao["Id"] ) { ?>
                    <option selected="selected" value='<?php echo $row_objUtilizacao["Id"] ?>'><?php echo $row_objUtilizacao["subtipo"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $row_objUtilizacao["Id"] ?>'><?php echo $row_objUtilizacao["subtipo"] ?></option>
                <?php } ?>
            <?php } ?>
              </select>
            </div>
            <div class="span3">
              <label>Formato</label>
              <select name="ddlformato" data-placeholder="Formato">
           		<option value='0'>Nenhum</option>
            <?php while ($rowFormato = mysql_fetch_array($formato)) {?>
                <?php If ( $idEditaFormato == $rowFormato["id"] ) { ?>
                    <option selected="selected" value='<?php echo $rowFormato["id"] ?>'><?php echo $rowFormato["formato"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $rowFormato["id"] ?>'><?php echo $rowFormato["formato"] ?></option>
                <?php } ?>
            <?php } ?>
              </select>
            </div>
            <div class="span3">
              <label>Distribuição</label>
              <select name="ddldistribuicao" data-placeholder="Distribuição">
           		<option value='0'>Nenhum</option>
        	<?php while ($rowDistribuicao = mysql_fetch_array($distribuicao)) {?>
            	<?php If ( $idEditaDistribuicao == $rowDistribuicao["id"] ) { ?>
                    <option selected="selected" value='<?php echo $rowDistribuicao["id"] ?>'><?php echo $rowDistribuicao["distribuicao"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $rowDistribuicao["id"] ?>'><?php echo $rowDistribuicao["distribuicao"] ?></option>
                <?php } ?>
            <?php } ?>
              </select>
            </div>
            <div class="span3">
              <label>Periodicidade</label>
              <select name="ddlperiodicidade" data-placeholder="Periodicidade">
           		<option value='0'>Nenhum</option>
        	<?php while ($rowPeriodicidade = mysql_fetch_array($periodicidade)) {?>
                <?php If ( $idEditaPeriodicidade == $rowPeriodicidade["id"] ) { ?>
                    <option selected="selected" value='<?php echo $rowPeriodicidade["id"] ?>'><?php echo $rowPeriodicidade["periodicidade"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $rowPeriodicidade["id"] ?>'><?php echo $rowPeriodicidade["periodicidade"] ?></option>
                <?php } ?>
            <?php } ?>
              </select>
            </div>
            <div class="span3">
              <label>Tamanho</label>
              <select name="ddltamanho" data-placeholder="Tamanho">
           		<option value='0'>Nenhum</option>
        	<?php while ($row_objTamanho = mysql_fetch_array($objTamanho)) {?>
                <?php If ( $idEditaTamanho == $row_objTamanho["Id"] ) { ?>
                    <option selected="selected" value='<?php echo $row_objTamanho["Id"] ?>'><?php echo $row_objTamanho["descricao"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $row_objTamanho["Id"] ?>'><?php echo $row_objTamanho["descricao"] ?></option>
                <?php } ?>
            <?php } ?>
              </select>
            </div>
            
            <div class="span3">
              <label class="control-label">Valor</label>
<!--               <input type="text" class="input-small" /> -->
		   <?php If (isset($_GET["edita"]) ) { ?>
                <input type="text" name="txtvalor" id="txtvalor" class="input-small" value='<?php echo $row_objEdita["valor"] ?>' size="15" onKeyPress="return (soNums(event,','));" />
            <?php } else { ?>
                <input type="text" name="txtvalor" id="txtvalor" class="input-small" size="15" onKeyPress="return (soNums(event,','));" />
            <?php } ?>
              <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
            
            <div class="span3">
              <label>Descrição</label>
              <select name="ddldescricao" data-placeholder="Descrição">
           		<option value='0'>Nenhum</option>
        	<?php while ($rowDescricao = mysql_fetch_array($descricao)) {?>
                <?php If ( $idEditaDescricao == $rowDescricao["id"] ) { ?>
                    <option selected="selected" value='<?php echo $rowDescricao["id"] ?>'><?php echo $rowDescricao["descricao"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $rowDescricao["id"] ?>'><?php echo $rowDescricao["descricao"] ?></option>
                <?php } ?>
            <?php } ?>
              </select>
            </div>

          </form>
        </div>
        <br />
        <div class="row-fluid">
          <div class="span12">

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
			      <th>Tipo Contrato</th>
                  <th>Tipo do Projeto</th>
                  <th>Utilização</th>
                  <th>Formato</th>  
                  <th>Distribuição</th>
                  <th>Periodicidade</th>
                  <th>Tamanho</th>
                  <th>Valor</th>
                  <th>Descrição</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
<?php while ($row_objTotal = mysql_fetch_array($objTotal)) {?>
                  <tr>
		            <td><?php echo $row_objTotal["contrato"]=="V"?"Video":"Foto" ?></td>
		        	<td><?php echo $row_objTotal["tipo"] ?></td>
		            <td><?php echo $row_objTotal["utilizacao"] ?></td>
		            <td><?php echo $row_objTotal["formato"] ?></td>
		            <td><?php echo $row_objTotal["distribuicao"] ?></td>
		            <td><?php echo $row_objTotal["periodicidade"] ?></td>
		            <td><?php echo $row_objTotal["tamanho"] ?></td>
		            <?php If ( $row_objTotal["valor"] != "0" ) { ?>
		                <td><?php echo formatcurrency($row_objTotal["valor"]) ?></td>
		            <?php } else { ?>
		                <td>N/D</td>
		            <?php } ?>
		            <td><?php echo $row_objTotal["descricao"] ?></td>
                    <td>
                      <a class="btn btn-primary" href="administrativo_precos.php?edita=<?php echo $row_objTotal["Id"] ?>">Editar</a>
                      <a class="btn btn-danger" href="administrativo_precos.php?delete=<?php echo $row_objTotal["Id"] ?>" onclick="return confirma_exluir_uso();">Excluir</a>
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
