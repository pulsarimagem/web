<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php
$retirar = array(".jpg",".JPG");		
function makeStamp($theString) {
  if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})", $theString, $strReg)) {
    $theStamp = mktime($strReg[4],$strReg[5],$strReg[6],$strReg[2],$strReg[3],$strReg[1]);
  } else if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})", $theString, $strReg)) {
    $theStamp = mktime(0,0,0,$strReg[2],$strReg[3],$strReg[1]);
  } else if (ereg("([0-9]{2}):([0-9]{2}):([0-9]{2})", $theString, $strReg)) {
    $theStamp = mktime($strReg[1],$strReg[2],$strReg[3],0,0,0);
  }
  return $theStamp;
}

function makeDateTime($theString, $theFormat) {
  $theDate=date($theFormat, makeStamp($theString));
  return $theDate;
} 
$colname_arquivos = "-1";
if (isset($_GET['id_login'])) {
  $colname_arquivos = (get_magic_quotes_gpc()) ? $_GET['id_login'] : addslashes($_GET['id_login']);
  $data = $_GET['data'];
  $data2 = substr($data,5,2).substr($data,0,2);
}

$tribos = implode('|', array_keys(get_tribos()));

mysql_select_db($database_pulsar, $pulsar);
$query_arquivos = sprintf("SELECT 
  `log_download2`.id_log,
  `log_download2`.arquivo,
  `log_download2`.data_hora,
  `log_download2`.ip,
  `log_download2`.id_login,
  `log_download2`.usuario,
  `log_download2`.circulacao,
  `log_download2`.tiragem,
  `log_download2`.projeto,
  `log_download2`.formato,
  `log_download2`.obs,
  `log_download2`.uso,
  `log_download2`.faturado,
  `fotografos`.Nome_Fotografo,
  `Fotos`.assunto_principal,
  (`Fotos`.assunto_principal regexp '($tribos)') as indio,
	$database_sig.USO_DESC.descricao_br as tamanho_desc, 
	$database_sig.USO_SUBTIPO.subtipo_br as uso_desc	
FROM
  `Fotos`

INNER JOIN `fotografos` ON (`Fotos`.id_autor = `fotografos`.id_fotografo)
  RIGHT OUTER JOIN `log_download2` ON (`Fotos`.tombo = SUBSTRING_INDEX(`log_download2`.arquivo, '.', 1)) 

		LEFT JOIN $database_sig.USO_SUBTIPO ON (log_download2.uso = $database_sig.USO_SUBTIPO.Id)
		LEFT JOIN $database_sig.USO ON (log_download2.formato = $database_sig.USO.Id)
		LEFT JOIN $database_sig.USO_DESC ON ($database_sig.USO.id_descricao = $database_sig.USO_DESC.Id)
		
WHERE id_login = '%s' and EXTRACT(YEAR_MONTH FROM data_hora) like '20%s'
GROUP BY arquivo, EXTRACT(DAY FROM data_hora), projeto
ORDER BY faturado, projeto, indio, data_hora DESC 
 ", $colname_arquivos,$data2);
$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
$row_arquivos = mysql_fetch_assoc($arquivos);
$totalRows_arquivos = mysql_num_rows($arquivos);


mysql_select_db($database_pulsar, $pulsar);
$query_cliente = sprintf("SELECT * FROM cadastro WHERE id_cadastro = '%s'", $colname_arquivos);
$cliente = mysql_query($query_cliente, $pulsar) or die(mysql_error());
$row_cliente = mysql_fetch_assoc($cliente);
$totalRows_cliente = mysql_num_rows($cliente);

mysql_select_db($database_sig, $sig);

$row_uso = translate_iduso($row_arquivos['uso'], "br", $sig);

$where_query = "";
if(isset($row_cliente['id_cliente_sig']) && ($row_cliente['id_cliente_sig'] != "")) {
	$where_query = "WHERE ID = ".$row_cliente['id_cliente_sig'];
}
$query_empresas = sprintf("SELECT ID, RAZAO, FANTASIA FROM CLIENTES $where_query ORDER BY RAZAO");
$empresas = mysql_query($query_empresas, $sig) or die(mysql_error());
$totalRows_empresas = mysql_num_rows($empresas);
//$row_empresas = mysql_fetch_assoc($empresas);

if(isset($row_cliente['id_cliente_sig']) && ($row_cliente['id_cliente_sig'] != "")) {
	mysql_select_db($database_sig, $sig);
	$where_query = "";
	$where_query = "WHERE ID_CLIENTE = ".$row_cliente['id_cliente_sig'];
	$query_contato = sprintf("SELECT ID, CONTATO FROM CONTATOS $where_query ORDER BY CONTATO");
	$contato = mysql_query($query_contato, $sig) or die(mysql_error());
	$totalRows_contato = mysql_num_rows($contato);
//	$row_contato = mysql_fetch_assoc($contato);
}



if (isset($_GET['faturar_todas'])) {
	mysql_select_db($database_pulsar, $pulsar);
	do {
		$query_faturar = "UPDATE log_download2 SET faturado=".'1'." WHERE arquivo = '".$row_arquivos['arquivo']."' AND EXTRACT(DAY FROM data_hora) = EXTRACT(DAY FROM '".$row_arquivos['data_hora']."') AND projeto LIKE '".$row_arquivos['projeto']."' AND id_login = ".$row_arquivos['id_login'];
		$faturar = mysql_query($query_faturar, $pulsar) or die(mysql_error());
	} while ($row_arquivos = mysql_fetch_assoc($arquivos));
	$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
	$row_arquivos = mysql_fetch_assoc($arquivos);
	$totalRows_arquivos = mysql_num_rows($arquivos);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Relat�rio de Download</title>
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
<?php include("scripts.php"); ?>
<script type="text/javascript">                                         
$(document).ready(function() {
	$("input:checkbox").click(function() {
//		alert(this.value+' '+this.checked);
		$.get("adm_down_fat.php", { id_log: this.value, marca: this.checked } );
//		$.get("adm_down_fat.php", { tombo: this.value, marca: this.checked } );

	});
});


</script> 
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#BCBFAE" class="style1 style4"><div align="center"><img src="images/header_03.gif" width="225" height="61" id="logo" /></div></td>
  </tr>
</table>
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
      <td class="style1 style4"><div align="left"><strong>Cliente SIG:</strong></div></td>
<?php 
if (isset($row_cliente['id_cliente_sig']) && ($row_cliente['id_cliente_sig'] != "")) { 
	$row_empresas = mysql_fetch_assoc($empresas);
?>
      <td class="style4 style1"><div align="left"><?php echo $row_empresas['RAZAO']." / ".$row_empresas['FANTASIA']?> <input type="button" value="Alterar" id="btn_change"/></div></td>
<?php 
} 
else { 
?>      
      <td class="style4 style1"><div align="left"><select name="cliente_sig" id="combobox">
		<option></option>
<?php while($row_empresas = mysql_fetch_assoc($empresas)) { ?>
		<option value="<?php echo $row_empresas['ID']?>"><?php echo $row_empresas['RAZAO']." / ".$row_empresas['FANTASIA']?></option>
<?php } ?>
      </select></div></td>
<?php 
}
?>      
    </tr>
    <tr>
      <td class="style1 style4"><div align="left"><strong>Contato SIG:</strong></div></td>
<?php 
if (isset($row_cliente['id_cliente_sig']) && ($row_cliente['id_cliente_sig'] != "")) { 
?>
      <td class="style4 style1"><div align="left"><select name="contato_sig" id="contato">
<?php while($row_contato = mysql_fetch_assoc($contato)) { ?>
		<option value="<?php echo $row_contato['ID']?>" <?php if ($row_contato['ID'] == $row_cliente['id_contato_sig']) echo "selected"?>><?php echo $row_contato['CONTATO']?></option>
<?php } ?>
<?php 
} 
else { 
?>      
      <td class="style4 style1"><div align="left"><select name="contato_sig" id="contato">
		<option>Escolha o Cliente Primeiro</option>
<?php /* while($row_contatos = mysql_fetch_assoc($contatos)) { ?>
		<option value="<?php echo $row_empresas['ID']?>"><?php echo $row_empresas['CONTATO']?></option>
<?php } */ ?>
      </select></div></td>
<?php 
}
?>      
    </tr>
    <tr>
      <td class="style1 style4"><div align="left"><strong>Total de Downloads:</strong></div></td>
      <td class="style4 style1"><div align="left"><?php echo $totalRows_arquivos; ?>&nbsp;</div></td>
    </tr>
    </table>
  <br />
  
  <form name="fatura_tudo" method="get" action="adm_down_misc.php">
  	<input name="faturar_todas" type="submit" value="Faturar Todas"/>
  	<input name="id_login" type="hidden" value="<?php echo $colname_arquivos;?>"/>
  	<input name="data" type="hidden" value="<?php echo $data;?>"/>
  </form>
  
  <form name="imprimir_rel" method="get" action="adm_down_misc_print.php">
  	<input name="imprimir" type="submit" value="Gerar vers�o para impress�o"/>
  	<input name="id_login" type="hidden" value="<?php echo $colname_arquivos;?>"/>
  	<input name="data" type="hidden" value="<?php echo $data;?>"/>
  </form>

  <form method="post" action="../sig/tool_contrato_gravar.php">  
  <?php
  $divisor = false;
  $divisor2 = false;
  $new_group = false;

  $group_cnt = 0;
  $this_download = $row_arquivos;
  $last_download = $row_arquivos;
  
do {

  $row_uso = translate_iduso($row_arquivos['uso'], "br", $sig);

  if ($divisor2 == false) {
    if($row_arquivos['faturado']==0) {
	  $divisor2 = true;
	  echo "<br><br><h2> Imagem(ns) N&atilde;o Faturada(s) </h2><br><br>";
	}
  }
  if ($divisor == false) {
    if($row_arquivos['faturado']==1) {
	  $divisor = true;
	  echo "<br><br><h2> Imagem(ns) J&aacute; Faturada(s) </h2><br><br>";
	}
  }
?>
<?php 
$last_download = $this_download;
$this_download = $row_arquivos;
//echo $this_download['projeto']." - ".$last_download['projeto']."<br>";
if(($this_download['projeto'] != $last_download['projeto'])||($this_download['indio'] != $last_download['indio'])) {
	echo "$group_cnt foto(s).".($last_download['indio']=="1"?" Tipo Indio.":"");
	$group_cnt = 0;
?>
    <input class="gerarLR" name="action" type="submit" value="Gerar LR"/>
    <input name="exec" type="hidden" value="cromo"/>  
    <input name="descricao" type="hidden" value="<?php echo $last_download['projeto']; ?>"/>  
    <input name="id_uso" type="hidden" value="<?php echo $last_download['formato']//"6";//$row_arquivos['id_uso']; ?>"/>
    <input name="id" class="id_cliente_sig" type="hidden" value="<?php echo $row_cliente['id_cliente_sig'];//$row_arquivos['id_uso']; ?>"/>
    <input name="qcontato" class="id_contato_sig" type="hidden" value="<?php echo $row_cliente['id_contato_sig'];//$row_arquivos['id_uso']; ?>"/>
    <input name="contrato_desc" type="hidden" value="<?php echo ($last_download['indio']=="1"?"9":"7")?>"/>
    <input name="data" type="hidden" value="<?php echo $last_download['data_hora']; ?>"/>
</form>

<form method="post" action="../sig/tool_contrato_gravar.php">
<?php } ?>
    <table width="600" border="1" cellspacing="0">
      <tr>
        <td width="150" rowspan="9" valign="top" class="style1 style4"><img src="http://www.pulsarimagens.com.br/bancoImagens/<?php
		 echo str_replace($retirar,"",$row_arquivos['arquivo']); ?>p.jpg" /></td>
        <td colspan="2" class="style1 style4"><div align="left">Assunto: <?php echo $row_arquivos['assunto_principal']; ?></div></td>
      </tr>
      <tr>
        <td class="style1 style4"><div align="left">C&oacute;digo: <?php echo str_replace(".jpg","",$row_arquivos['arquivo']); ?></div></td>
        <td class="style1 style4"><div align="left">Autor: <?php echo $row_arquivos['Nome_Fotografo']; ?></div></td>
      </tr>
      <tr>
        <td class="style1 style4"><div align="left">Data do Download: <?php echo makeDateTime($row_arquivos['data_hora'], 'd/m/y'); ?></div></td>
        <td class="style1 style4"><div align="left">IP: <?php echo $row_arquivos['ip']; ?></div></td>
      </tr>
      <tr>
        <td colspan="2" class="style1 style4"><div align="left">Usu&aacute;rio: <?php echo $row_arquivos['usuario']; ?></div>          <div align="left"></div></td>
      </tr>
      <tr>
        <td class="style1 style4"><div align="left">Circula&ccedil;&atilde;o: <?php echo $row_arquivos['circulacao']; ?></div></td>
        <td class="style1 style4"><div align="left">Tiragem: <?php echo $row_arquivos['tiragem']; ?></div></td>
      </tr>
      <tr>
        <td class="style1 style4"><div align="left">T&iacute;tulo: <?php echo $row_arquivos['projeto']; ?></div></td>
<?php if(is_numeric($row_arquivos['uso'])) { ?>
<!--          <td class="style1 style4"><div align="left">Tamanho: <?php echo $row_arquivos['tamanho_desc']; ?></div></td> -->
          <td class="style1 style4"><div align="left">Tamanho: <?php echo $row_uso['tamanho']; ?></div></td>
<?php } else { ?>                             
        <td class="style1 style4"><div align="left">Tamanho: <?php echo $row_arquivos['formato']; ?></div></td>
<?php } ?>        
      </tr>
      <tr>
<?php if(is_numeric($row_arquivos['uso'])) { ?>
<!--         <td colspan="2" class="style1 style4"><div align="left">Uso: <?php echo $row_arquivos['uso_desc']; ?></div></td> -->
		<td colspan="2" class="style1 style4"><div align="left">Uso: <?php echo $row_uso['tipo']." | ".$row_uso['utilizacao']; ?></div></td>
<?php } else { ?>
        <td colspan="2" class="style1 style4"><div align="left">Uso: <?php echo $row_arquivos['uso']; ?></div></td>
<?php } ?>
              </tr>
      <tr>
        <td colspan="2" class="style1 style4"><div align="left">Obs: <?php echo $row_arquivos['obs']; ?></div></td>
      </tr>
      <tr>
        <td colspan="2" class="style1 style4"><div align="left">Faturado:
            <input type="checkbox" id="faturado" value="<?php echo $row_arquivos['id_log']; ?>" <?php if ($row_arquivos['faturado']==1) { ?> checked="checked" <?php } ?>/>
		</div></td>
      </tr>
    </table>
    <input name="qcodigo[]" type="hidden" value="<?php echo str_ireplace(".jpg","",$row_arquivos['arquivo']); ?>"/>
    <input name="uso_<?php echo str_ireplace(".jpg","",$row_arquivos['arquivo'])?>" type="hidden" value="<?php echo $row_arquivos['uso'] ?>"/>
    
<?php
	$group_cnt ++;
} while ($row_arquivos = mysql_fetch_assoc($arquivos));
echo "$group_cnt foto(s).".($this_download['indio']=="1"?" Tipo Indio.":"");
$group_cnt = 0;
?>
    <input class="gerarLR" name="action" type="submit" value="Gerar LR"/>
    <input name="exec" type="hidden" value="cromo"/>  
    <input name="descricao" type="hidden" value="<?php echo $this_download['projeto']; ?>"/>  
    <input name="id_uso" type="hidden" value="<?php echo $this_download['formato']//"6";//$row_arquivos['id_uso']; ?>"/>
    <input name="id" class="id_cliente_sig" type="hidden" value="<?php echo $row_cliente['id_cliente_sig'];//$row_arquivos['id_uso']; ?>"/>
    <input name="qcontato" class="id_contato_sig" type="hidden" value="<?php echo $row_cliente['id_contato_sig'];//$row_arquivos['id_uso']; ?>"/>
    <input name="contrato_desc" type="hidden" value="<?php echo ($this_download['indio']=="1"?"9":"7")?>"/>
    <input name="data" type="hidden" value="<?php echo $this_download['data_hora']; ?>"/>
</form>
</div>
</body>
</html>
<?php
mysql_free_result($cliente);

mysql_free_result($arquivos);
?>
