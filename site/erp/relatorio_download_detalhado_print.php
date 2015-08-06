<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_relatorio_download_detalhado_print.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Relatórios Download Detalhado</title>
    <meta charset="iso-8859-1" />
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style4 {font-size: 12px}
.style5 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
<script type="text/javascript" src="./js/jquery.js"></script> 
<script type="text/javascript">                                         
$(document).ready(function() {
	$("input:checkbox").click(function() {
//		alert(this.value+' '+this.checked);
		$.get("tool_ajax_fatura.php", { tombo: this.value, marca: this.checked } );
//		$.get("adm_down_fat.php", { tombo: this.value, marca: this.checked } );

	});
});


</script> 
</head>

<body>
<div align="center"><br />
  <table width="600" border="1" cellspacing="0">
    <tr>
      <td colspan="2" class="style4 style1"><div align="center" class="style5">RELAT&Oacute;RIO MENSAL DE DOWNLOAD DE IMAGENS</div></td>
    </tr>
    <tr>
      <td class="style1 style4"><div align="left"><strong>M&ecirc;s/Ano: </strong></div></td>
      <td class="style4 style1"><div align="left"><?php echo $data; ?>&nbsp;</div></td>
    </tr>
    <tr>
      <td class="style1 style4"><div align="left"><strong>Cliente:</strong></div></td>
      <td class="style4 style1"><div align="left"><?php echo $row_cliente['nome']; ?> / <?php echo $row_cliente['empresa']; ?>&nbsp;</div></td>
    </tr>
    <tr>
      <td class="style1 style4"><div align="left"><strong>Total de Downloads:</strong></div></td>
      <td class="style4 style1"><div align="left"><?php echo $totalRows_arquivos; ?>&nbsp;</div></td>
    </tr>
  </table>
  <br />
  
<?php
do {
	if($row_arquivos['faturado']==0) {
		if($relTipo != "layout") {
			if(is_numeric($row_arquivos['uso'])) {
				mysql_select_db($database_sig, $sig);
				$row_uso = translate_iduso_array($row_arquivos['uso'], "br", $sig);
			}
		}
?>
  <br><form>
    <table width="600" border="2" cellspacing="0">
      <tr>
        <td class="style1 style4"><b>C&oacute;digo: <?php echo strtoupper(str_replace(".jpg","",$row_arquivos['arquivo'])); ?></b></td>
        <td class="style1 style4">Data: <?php $data = explode(" ",$row_arquivos['data_hora']); echo date("d/m/Y", strtotime($data[0]));?></td>
      </tr>

      <tr>
        <td colspan="2" class="style1 style4">Assunto: <?php echo $row_arquivos['assunto_principal']; ?></td>
      </tr>
      
      <tr>
        <td colspan="2" class="style1 style4">T&iacute;tulo: <?php echo $row_arquivos['projeto']; ?></td>
      </tr>
<?php if($relTipo != "layout") { ?>      
      <tr>
<?php 	if(is_numeric($row_arquivos['uso'])) { ?>
<!--          <td width="422" class="style1 style4">Uso: <?php echo $row_arquivos['uso_desc']; ?></td>-->
		<td width="422" class="style1 style4">Uso: <?php echo $row_uso['tipo']." | ".$row_uso['utilizacao']; ?></td>
<?php 	} else { ?>
        <td width="422" class="style1 style4">Uso: <?php echo $row_arquivos['uso']; ?></td>
<?php 	} ?>
<?php 	if(is_numeric($row_arquivos['uso'])) { ?>
        <td width="168" class="style1 style4">Tamanho: <?php echo $row_uso['tamanho']; ?></td>
<?php 	} else { ?>                             
        <td width="168" class="style1 style4">Tamanho: <?php echo $row_arquivos['formato']; ?></td>
<?php 	} ?>        
      </tr>
<?php } ?>      
      <tr>
<?php if($row_arquivos['obs'] != "") { ?>      
        <td colspan="2" class="style1 style4">Obs: <?php echo str_replace(array("\\r\\n", "\\r", "\\n"), "<br />", $row_arquivos['obs']); ?></td>
<?php } ?>        
      </tr>
    </table>
    </form>
<?php
	}
} while ($row_arquivos = mysql_fetch_assoc($arquivos));
?>
</div>
</body>
</html>