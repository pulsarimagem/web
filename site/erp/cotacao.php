<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_cotacao.php"); ?>
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
          <div class="span12">
<?php if($isHist) { ?>
<a href="cotacao.php"><strong>Voltar para cota&ccedil;&otilde;es</strong></a><br>
<br>
<span>Organizar por:</span>
  <select name="organizar" onChange="MM_jumpMenu('parent',this,0)">
    <option value="cotacao.php?action=historico&ordem=data_hora%20DESC" <?php if (!(strcmp("data_hora DESC", $_GET['ordem']))) {echo "selected=\"selected\"";} ?>>Data de recebimento</option>
    <option value="cotacao.php?action=historico&ordem=nome" <?php if (!(strcmp("nome", $_GET['ordem']))) {echo "selected=\"selected\"";} ?>>Cliente</option>
    <option value="cotacao.php?action=historico&ordem=empresa" <?php if (!(strcmp("empresa", $_GET['ordem']))) {echo "selected=\"selected\"";} ?>>Empresa</option>
    <option value="cotacao.php?action=historico&ordem=data_hora_atendida%20DESC" <?php if (!(strcmp("data_hora_atendida DESC", $_GET['ordem']))) {echo "selected=\"selected\"";} ?>>Data de resposta</option>
  </select>
<br>
<br>
<table class="table table-bordered table-striped">
  <tr>
    <td><div align="center">Data de recebimento</div></td>
    <td>Cliente</td>
    <td>Empresa</td>
    <td><div align="center">Data de resposta </div></td>
  </tr>
  <?php if ($totalRows_atendidas > 0) { // Show if recordset not empty ?>
  <?php do { ?>
  <tr>
    <td><div align="center"><?php echo makeDateTime($row_atendidas['data_hora'], 'd/m/Y'); ?><br>
        <?php echo makeDateTime($row_atendidas['data_hora'], 'H:i:s'); ?> </div></td>
    <td><a href="cotacao.php?action=show&id_cotacao=<?php echo $row_atendidas['id_cotacao2']; ?>" target="_blank"><strong><?php echo $row_atendidas['nome']; ?></strong></a></td>
    <td><?php echo $row_atendidas['empresa']; ?>&nbsp;</td>
    <td><div align="center"><?php echo makeDateTime($row_atendidas['data_hora_atendida'], 'd/m/Y'); ?><br>
      <?php echo makeDateTime($row_atendidas['data_hora_atendida'], 'H:i:s'); ?>    </div></td>
  </tr>
  <?php } while ($row_atendidas = mysql_fetch_assoc($atendidas)); ?>
  <?php } // Show if recordset not empty ?>
</table>

<?php } else if(!$isShow) { ?>          
<span>Pendentes</span>
<p><a href="cotacao.php?action=historico" class="btn btn-primary">Ver Historico</a></p>
<?php if($totalRows_pendentes>0) { // Show if recordset not empty ?>
<table class="table table-bordered table-striped with-check">
<thead>
  <tr class="style5">
  	<th><input type="checkbox" /></th>
    <th>Data</th>
    <th>Cliente</th>
    <th>Empresa</th>
    <th>Cromos</th>
  </tr>
  </thead>
  <tbody>
  
<?php do { ?>
  <tr>
  	<td>
  		<input name="checkbox" type="checkbox" onClick="MM_callJS('document.form<?php echo $row_pendentes['id_cotacao2']; ?>.submit();')" value="checkbox">
		<input name="id_cotacao2" type="hidden" id="id_cotacao2" value="<?php echo $row_pendentes['id_cotacao2']; ?>"> 
		<input name="MM_Update" type="hidden" id="MM_Update" value="True"> 	
  	</td>
    <td>
    	<div align="center"><?php echo makeDateTime($row_pendentes['data_hora'], 'd-m-Y'); ?><br>
          <?php echo makeDateTime($row_pendentes['data_hora'], 'H:i:s'); ?> </div>
    </td>
    <td><strong><a href="cotacao.php?action=show&id_cotacao=<?php echo $row_pendentes['id_cotacao2']; ?>"><?php echo $row_pendentes['nome']; ?></a></strong></td>
    <td><?php echo $row_pendentes['empresa']; ?>&nbsp;</td>
    <td><div align="center"><?php echo $row_pendentes['total_cromos']; ?></div></td>
  </tr>
<?php } while ($row_pendentes = mysql_fetch_assoc($pendentes));  ?>
<?php } // Show if recordset not empty ?>
<?php } else if($isShow) {?>


<TABLE class="table table-bordered table-striped">
  <TBODY>
  <TR>
    <TD>Cliente:</TD>
    <TD><?php echo $row_cliente['nome']; ?></TD>
  </TR>
  <TR>
    <TD>Empresa:</TD>
    <TD><?php echo $row_cliente['empresa']; ?>&nbsp;</TD>
  </TR>
  <TR>
    <TD>Email:</TD>
    <TD><?php echo $row_cliente['email']; ?></TD>
  </TR>
  <TR>
    <TD>Telefone:</TD>
    <TD><?php echo $row_cliente['telefone']; ?></TD>
  </TR>
  <TR>
    <TD>Cidade:</TD>
    <TD><?php echo $row_cliente['cidade']; ?></TD>
  </TR>
  <TR>
    <TD>Estado:</TD>
    <TD><?php echo $row_cliente['estado']; ?></TD>
  </TR>
  <TR>
    <TD>Distribui&ccedil;&atilde;o:</TD>
    <TD><p><?php echo $row_cliente['distribuicao']; ?></p>      </TD>
  </TR>
  <TR>
    <TD>Descri&ccedil;&atilde;o do uso :</TD>
    <TD><?php echo $row_cliente['descricao_uso']; ?></TD>
  </TR>
<?php if($isAtendida) { ?>  
    <tr>
    <td><span>Atendida por: </span></td>
    <td><span><?php echo $row_cliente['atendida']; ?> em <?php echo $row_cliente['data_hora']; ?></span></td>
  </tr>
  <tr>
    <td><span>Mensagem:</span></td>
    <td><span><?php echo $row_cliente['mensagem']; ?>&nbsp;</span></td>
  </tr>
<?php } ?>  
  </TBODY></TABLE>
<BR>
<TABLE class="table table-bordered table-striped">
  <TBODY>
  <TR>
    <TD>
      <DIV align=center><STRONG>Foto</STRONG></DIV></TD>
    <TD>
      <DIV align=center><STRONG>Pasta</STRONG></DIV></TD>
    </TR>
  <?php do { ?>
  <TR>
      <TD><div align="center"><?php echo $row_fotos['tombo']; ?><br>
          <IMG src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $row_fotos['tombo']; ?>p.jpg" 
      align=middle></div></TD>
      <TD><div align="center"><?php echo $row_fotos['nome_pasta']; ?>&nbsp;</div></TD>
  </TR>
  <?php } while ($row_fotos = mysql_fetch_assoc($fotos)); ?>
  </TBODY></TABLE>
<br/>
<?php if(!$isAtendida) { ?>
<span>Responder:</span>
<form name="form1" method="post" action="cotacao.php">
<table class="table table-bordered table-striped">
  <tr>
    <td>Responder para:</td>
    <td><input name="responder" type="text" id="responder" placeholder="digite o e-mail para resposta" size="30">
    @pulsarimagens.com.br
      <input name="to" type="hidden" id="to" value="<?php echo $row_cliente['email']; ?>">
      <input name="id_cotacao2" type="hidden" id="id_cotacao2" value="<?php echo $idCotacao ?>">
</td>
  </tr>
  <tr>
    <td>Assunto da mensagem:</td>
    <td><input name="subject" type="text" id="subject" size="30">
    </td>
  </tr>
  <tr>
    <td>Mensagem:</td>
    <td><?php
include("./fckeditor/fckeditor.php");

$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath = './fckeditor/';
$oFCKeditor->Value = '
		<br><br>
      <font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="1">Pulsar Imagens<br>
        </font> <font face="Verdana, Arial, Helvetica, sans-serif" color="#999999" size="1">www.pulsarimagens.com.br<br>
      pulsar@pulsarimagens.com.br</font></td></tr>
		';
$oFCKeditor->Create() ;
	?>
  <tr>
    <td colspan="2"><div align="center">      
      <p><br>
          <input type="submit" name="Submit" value="Enviar">    
          <input type="hidden" name="action" value="send"> 
          <br>
          <br>
      </p>
    </div></td>
  </tr>
</table>
</form>
<?php } ?>

<?php } ?>
<!--   <tr> -->
<!--     <td colspan="3">Total:</td> -->
<!--     <td><div align="center"></div></td> -->
<!--     <td><div align="center"></div></td> -->
<!--   </tr> -->
  </tbody>
</table>
<br />

        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
