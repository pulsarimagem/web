<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_envio.php"); ?>
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
        <a href="#" class="current">Formulário Envio</a>
      </div>
      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span12">
          <form class="form-inline" method="post">
	  <input type="button" class="btn btn-success" id="btnFtpCopy" name="Submit6" value="Formulário arquivo de Alta">
	  <input type="button" class="btn btn-primary" id="btnFtpVideo" name="Submit7" value="Formulário Videos">
		</form>
      </div>
	</div>

        <div id="ftpCopy" class="row-fluid" style="display:none">
    	<div class="span12">
<h1>Fotos</h1>
    	
    	
<form id="form1" name="form1" method="post">
  <table>
	<tr>
  	<td><span class="style14">Usuário:</span></td>
	<td>
  <select name="id_login" data-placeholder="usuario">
	          	<option value="">-- Escolha o Usuário --</option>
<?php while ($row_diretorios = mysql_fetch_assoc($diretorios)) { ?>
			    <option value="<?php echo $row_diretorios['id_login']?>"<?php if (isset($idLogin) && !(strcmp($row_diretorios['id_login'], $idLogin))) {echo "selected=\"selected\"";} ?>><?php echo $row_diretorios['nome']?>/<?php echo $row_diretorios['empresa']?></option>
<?php } mysql_data_seek($diretorios, 0);?>
  			  </select>	
  </td>
  </tr>
    <tr>
      <td><span class="style14">Codigo:</span></td>
      <td><input name="tombo" type="text" id="tombo" size="60" /></td>
    </tr>
    <tr>
      <td><span class="style14">Observa&ccedil;&otilde;es: </span></td>
      <td><input name="observacoes" type="text" id="observacoes" size="60" /></td>
    </tr>
    <tr>
    
                        <label>* Título do livro/projeto:</label>
	                    <input id="titulo" name="titulo" type="text" class="titulo<?php if($titulo_error) echo " error"?>" value="<?php echo $titulo?>" size="" />

<?php 
$MMColParam_dados_foto = "12SDM000";
$sufix = "F";
include("part_form_uso.php");?>
    <tr>
      <td colspan="2"><div align="center" class="style14">
        <input type="submit" name="Submit" value="Gravar" />
        <input type="hidden" name="action" value="copiarFoto" /> 
      </div></td>
    </tr>
  </table>
</form>    	
    	
        </div>
        </div>

        <div id="ftpVideo" class="row-fluid" style="display:none">
    	<div class="span12">
<h1>Video</h1>
<form id="form1" name="form1" method="post">
  <table>
  	<tr>
  	<td><span class="style14">Usuário:</span></td>
	<td>
  <select name="id_login" data-placeholder="usuario">
	          	<option value="">-- Escolha o Usuário --</option>
<?php while ($row_diretorios = mysql_fetch_assoc($diretorios)) { ?>
			    <option value="<?php echo $row_diretorios['id_login']?>"<?php if (isset($idLogin) && !(strcmp($row_diretorios['id_login'], $idLogin))) {echo "selected=\"selected\"";} ?>><?php echo $row_diretorios['nome']?>/<?php echo $row_diretorios['empresa']?></option>
<?php } mysql_data_seek($diretorios, 0);?>
  			  </select>	
  </td>
  </tr>
    <tr>
      <td><span class="style14">Codigo:</span></td>
      <td><input name="tombo" type="text" id="tombo" size="60" /></td>
    </tr>
    <tr>
      <td><span class="style14">Observa&ccedil;&otilde;es: </span></td>
      <td><input name="observacoes" type="text" id="observacoes" size="60" /></td>
    </tr>
    <tr>
    
                        <label>* Título do livro/projeto:</label>
	                    <input id="titulo" name="titulo" type="text" class="titulo<?php if($titulo_error) echo " error"?>" value="<?php echo $titulo?>" size="" />

<?php 
$MMColParam_dados_foto = "SDM120000";
$sufix = "V";
include("part_form_uso.php");?>
    <tr>
      <td colspan="2"><div align="center" class="style14">
        <input type="submit" name="Submit" value="Gravar" />
        <input type="hidden" name="action" value="copiarVideo" /> 
      </div></td>
    </tr>
  </table>
</form>    	
</div>
</div>    	
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
