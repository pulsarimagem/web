<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_relatorio_download.php"); ?>
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
      		  <div class="span4"> Período do Download: 
              <select class="span5 do_submit" name="periodo" data-placeholder="periodo do download">
	          	<option value="TODOS">- Todos -</option>
              
<?php while ($row_periodo = mysql_fetch_assoc($periodo)) { ?>
				<option value="<?php echo $row_periodo['mes_ano']; ?>"<?php if (isset($_GET['periodo']) && !(strcmp($row_periodo['mes_ano'], $_GET['periodo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_periodo['mes_ano']?></option>
<?php } ?>
  			  </select>	
	          </div>
            <div class="span4">
              <select class="span10 do_submit" name="id_login" data-placeholder="usuario">
	          	<option value="TODOS">-- Todos os Usuários --</option>
<?php while ($row_diretorios = mysql_fetch_assoc($diretorios)) { ?>
			    <option value="<?php echo $row_diretorios['id_cadastro']?>"<?php if (isset($_GET['id_login']) && !(strcmp($row_diretorios['id_cadastro'], $_GET['id_login']))) {$limite = $row_diretorios['limite']; echo "selected=\"selected\"";} ?>><?php echo $row_diretorios['nome']?> / <?php echo $row_diretorios['empresa']?></option>
<?php }?>
  			  </select>	
            </div>
      		  <div class="span4"> Tipo de Relatorio: 
              <select class="span5 do_submit" name="tipo" data-placeholder="tipo de relatorio">
	          	<option value="fotos" <?php echo ($relTipo=="fotos"?"selected":"")?>>Fotos</option>
               	<option value="videos" <?php echo ($relTipo=="videos"?"selected":"")?>>Videos</option>
               	<option value="layout" <?php echo ($relTipo=="layout"?"selected":"")?>>Layout</option>
  			  </select>	
	          </div>
          </div>
      	  <div class="row-fluid">
            <div class="span2">
              <button type="submit" class="btn btn-primary do_button">Consultar</button>
            </div>
          </div>
      		
        </form>
        <br />
        <div class="row-fluid">
          <div class="span12">


<?php
if (! (isset($_GET['id_login']) or isset($_GET['periodo']))  || ($colname_arquivos == "-1")) { ?>
<span>Mês Atual: </span>
<table class="table table-bordered table-striped">
<thead>
  <tr class="style5">
    <th>Nome</th>
    <th>Empresa</th>
    <th><div align="center">Downloads</div></th>
    <th><div align="center">Faturados</div></th>
  </tr>
  </thead>
  <tbody>
<?php	   do { ?>
  <tr>
    <td><?php echo $row_tabela1['nome']; ?>&nbsp;</td>
    <td><?php echo $row_tabela1['empresa']; ?>&nbsp;</td>
    <td><div align="center"><?php echo $row_tabela1['total']; ?>&nbsp;</div></td>
    <td><div align="center"><?php echo $row_tabela1['faturados']; ?>&nbsp;</div></td>
  </tr>
<?php } while ($row_tabela1 = mysql_fetch_assoc($tabela1));  ?>
  <tr>
    <td colspan="2">Total:</td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>
  </tbody>
</table>
<br />
<span class="style5">Mês Anterior: </span>
<table class="table table-bordered table-striped">
<thead>
  <tr class="style5">
    <th>Nome</th>
    <th>Empresa</th>
    <th><div align="center">Downloads</div></th>
    <th><div align="center">Faturados</div></th>
  </tr>
  </thead>
  <tbody>
<?php	   do { ?>
  <tr>
    <td><?php echo $row_tabela2['nome']; ?>&nbsp;</td>
    <td><?php echo $row_tabela2['empresa']; ?>&nbsp;</td>
    <td><div align="center"><?php echo $row_tabela2['total']; ?>&nbsp;</div></td>
    <td><div align="center"><?php echo $row_tabela2['faturados']; ?></div></td>
  </tr>
<?php } while ($row_tabela2 = mysql_fetch_assoc($tabela2));  ?>
  <tr>
    <td colspan="2">Total:</td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>
  </tbody>
</table>
<?php } ?>




  <?php if (isset($_GET['id_login']) && $_GET['id_login']!= "TODOS") { ?>
<form name="altera" method="post" >
<span class="style5">Limite diário:
<input name="limite" type="text" id="limite" value="<?php echo $limite; ?>" size="5" maxlength="3"> 
</span>
<input type="submit" name="alterar" id="alterar" value="Alterar">
<input type="hidden" name="id_login" value="<?php echo $_GET['id_login']; ?>">
<input type="hidden" name="alterando" value="1">
<br>
</form>
<?php
if ($totalRows_arquivos > 0) { // Show if recordset not empty ?>
    <span class="style5">Arquivos retirados:</span><br>
    <br>
    <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><div align="center">Tombo</div></th>
        <th><div align="center">Data Retirada </div></th>
        <th><div align="center">Usu&aacute;rio </div></th>
        <th><div align="center">IP</div></th>
      </tr>
      </thead>
      <tbody>
      <?php
	  
 	  $mes = makeDateTime($row_arquivos['data_hora'], 'm/Y');
	  $contador = 0;

	   do {
	   if ($mes != makeDateTime($row_arquivos['data_hora'], 'm/Y')) {
	
		  ?>
        <tr>
            <td colspan="4"><div align="left"><a href="relatorio_download_detalhado.php?id_login=<?php echo $colname_arquivos ;?>&data=<?php echo $mes; ?>&tipo=<?php echo $relTipo?>">Total de downloads do m&ecirc;s <?php echo $mes; ?>: <?php echo $contador;?></a></div></td>
         </tr>
	   <?php
	   
  	 	  $mes = makeDateTime($row_arquivos['data_hora'], 'm/Y');

		  $contador = 0;
	   }	   
	   ?>
      <tr>
        <td><div align="center"><?php echo $row_arquivos['arquivo']; ?></div></td>
        <td><div align="center"><?php echo makeDateTime($row_arquivos['data_hora'], 'd/m/y'); ?>-<?php echo makeDateTime($row_arquivos['data_hora'], 'H:i:s'); ?></div></td>
        <td><div align="center"><?php echo $row_arquivos['usuario']; ?></div></td>
        <form name="delete" action="adm_ftp2.php" method="post" >
		<td><div align="center"><?php echo $row_arquivos['ip']; ?></div>
        <input name="id_login" type="hidden" id="id_login" value="<?php echo $_GET['id_login']; ?>"></td></form>
      </tr>
        <?php 	   $contador = $contador + 1;
} while ($row_arquivos = mysql_fetch_assoc($arquivos)); ?>
      <tr>
         <td colspan="4"><div align="left"><a href="relatorio_download_detalhado.php?id_login=<?php echo $_GET['id_login'];?>&data=<?php echo $mes; ?>&tipo=<?php echo $relTipo?>">Total de downloads do m&ecirc;s <?php echo $mes; ?>: <?php echo $contador;?></a></div></td>
      </tr>
      </tbody>
</table>
<?php } else { ?>
	<span>Sem arquivos retirados!!! </span><?php }; ?>
	<br>
	<br>
<?php } else if (isset($_GET['periodo']) ) { ?>
<br>
<?php
if ($totalRows_arquivos > 0) { // Show if recordset not empty ?>
    <span>Arquivos retirados:</span><br>
    <br>
    <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><div align="center">Tombo</div></th>
        <th><div align="center">Data Retirada </div></th>
        <th><div align="center">Usuário</div></th>
        <th><div align="center">Empresa</div></th>
        <th>&nbsp;</th>
      </tr>
      </thead>
      <tbody>
      <?php
	  
 	  $mes = makeDateTime($row_arquivos['data_hora'], 'm/Y');
	  $contador = 0;

	   do {
	   if ($mes != makeDateTime($row_arquivos['data_hora'], 'm/Y')) {
	
		  ?>
        <tr>
            <td colspan="4"><div align="left"><a href="relatorio_download_detalhado.php?id_login=<?php echo $colname_arquivos ;?>&data=<?php echo $mes; ?>&tipo=<?php echo $relTipo?>">Total de downloads do m&ecirc;s <?php echo $mes; ?>: <?php echo $contador;?></a></div></td>
         </tr>
	   <?php
	   
  	 	  $mes = makeDateTime($row_arquivos['data_hora'], 'm/Y');

		  $contador = 0;
	   }	   
	   ?>
      <tr>
        <td><div align="center"><?php echo $row_arquivos['arquivo']; ?></div></td>
        <td><div align="center"><?php echo makeDateTime($row_arquivos['data_hora'], 'd/m/y'); ?>-<?php echo makeDateTime($row_arquivos['data_hora'], 'H:i:s'); ?></div></td>
        <td><div align="center"><?php echo $row_arquivos['usuario']; ?></div></td>
        <td><div align="center"><?php echo $row_arquivos['empresa']; ?></div></td>
		<td>
		    <form name="delete" action="adm_ftp2.php" method="post" >
	        	<input name="id_login" type="hidden" id="id_login" value="<?php echo $_GET['id_login']; ?>">
        	</form>        
        </td>
      </tr>
        <?php 	   $contador = $contador + 1;
} while ($row_arquivos = mysql_fetch_assoc($arquivos)); ?>
      <tr>
         <td colspan="5"><div align="left"><a href="relatorio_download_detalhado.php?id_login=<?php echo $colname_arquivos ;?>&data=<?php echo $mes; ?>&tipo=<?php echo $relTipo?>">Total de downloads do m&ecirc;s <?php echo $mes; ?>: <?php echo $contador;?></a></div></td>
      </tr>
      </tbody>
</table>
<?php } else { ?>
	<span class="style7">Sem arquivos retirados!!! </span><?php }; ?>
	<br>
	<br>
<?php }; ?>





          
<!--             
              <thead>
                <tr>
                  <th><input type="checkbox" /></th>
                  <th>Pesquisas</th>
                  <th>Ocorrências</th>
                  <th>PC/PA</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php //for ($i = 0; $i < 20; $i++): ?>
                  <tr>
                    <td><input type="checkbox" /></td>
                    <td>zoca</td>
                    <td>Zoca LTDA</td>
                    <td></td>
                  </tr>
                <?php //endfor; ?>
              </tbody>
            </table>

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

          </div>
        </div>

 -->
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
