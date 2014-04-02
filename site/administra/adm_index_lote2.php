<?php require_once('Connections/pulsar.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "administra.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
$colname_login = "0";
if (isset($_SESSION['MM_Username'])) {
  $colname_login = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_login = sprintf("SELECT * FROM usuarios WHERE login like '%s'", $colname_login);
$login = mysql_query($query_login, $pulsar) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);
$totalRows_login = mysql_num_rows($login);

?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$query_lote = "";

mysql_select_db($database_pulsar, $pulsar);

if (!($_GET['tema']=="0")) {
	$query_lote = sprintf("
	SELECT DISTINCT 
	  Fotos.Id_Foto,
	  Fotos.tombo,
	  Fotos.id_autor,
	  Fotos.data_foto,
	  Fotos.cidade,
	  Fotos.id_estado,
	  Fotos.id_pais,
	  Fotos.orientacao,
	  Fotos.assunto_principal,
	  fotografos.Nome_Fotografo,
	  Fotos_extra.extra,
	  Estados.Sigla,
	  paises.nome
	FROM
	  Fotos
	  LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
	  LEFT OUTER JOIN fotografos ON (Fotos.id_autor = fotografos.id_fotografo)
	  LEFT OUTER JOIN Estados ON (Fotos.id_estado = Estados.id_estado)
	  LEFT OUTER JOIN paises ON (Fotos.id_pais = paises.id_pais)
	  LEFT OUTER JOIN rel_fotos_temas ON (Fotos.Id_Foto = rel_fotos_temas.id_foto)
	  LEFT OUTER JOIN `super_temas` ON (rel_fotos_temas.id_tema = `super_temas`.Id)
	WHERE `rel_fotos_temas`.id_tema = %s
	", $_GET['tema']);
}		
if (!($_GET['palavra1']=="")) {
	if ($query_lote == "") {
		$query_lote = sprintf("
		SELECT DISTINCT 
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.id_autor,
		  Fotos.data_foto,
		  Fotos.cidade,
		  Fotos.id_estado,
		  Fotos.id_pais,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  fotografos.Nome_Fotografo,
		  Fotos_extra.extra,
		  Estados.Sigla,
		  paises.nome
		FROM
		  Fotos
		  LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		  LEFT OUTER JOIN fotografos ON (Fotos.id_autor = fotografos.id_fotografo)
		  LEFT OUTER JOIN Estados ON (Fotos.id_estado = Estados.id_estado)
		  LEFT OUTER JOIN paises ON (Fotos.id_pais = paises.id_pais)
        where
          Fotos.Id_Foto in (select id_foto from rel_fotos_pal_ch left outer join pal_chave on (rel_fotos_pal_ch.id_palavra_chave = pal_chave.Id) where pal_chave like '%s') 
		", $_GET['palavra1']);
	} else {
			$query_lote .= sprintf("
        and Fotos.Id_Foto in (select id_foto from rel_fotos_pal_ch left outer join pal_chave on (rel_fotos_pal_ch.id_palavra_chave = pal_chave.Id) where pal_chave like '%s') 
		", $_GET['palavra1']);
	}
}
if (!($_GET['palavra2']=="")) {
			$query_lote .= sprintf("
        and Fotos.Id_Foto in (select id_foto from rel_fotos_pal_ch left outer join pal_chave on (rel_fotos_pal_ch.id_palavra_chave = pal_chave.Id) where pal_chave like '%s') 
		", $_GET['palavra2']);
}

if (!($_GET['palavra3']=="")) {
			$query_lote .= sprintf("
        and Fotos.Id_Foto in (select id_foto from rel_fotos_pal_ch left outer join pal_chave on (rel_fotos_pal_ch.id_palavra_chave = pal_chave.Id) where pal_chave like '%s') 
		", $_GET['palavra3']);
}

if (!($_GET['autor']=="0")) {
	if ($query_lote == "") {
		$query_lote = sprintf("
		SELECT DISTINCT 
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.id_autor,
		  Fotos.data_foto,
		  Fotos.cidade,
		  Fotos.id_estado,
		  Fotos.id_pais,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  fotografos.Nome_Fotografo,
		  Fotos_extra.extra,
		  Estados.Sigla,
		  paises.nome
		FROM
		  Fotos
		  LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		  LEFT OUTER JOIN fotografos ON (Fotos.id_autor = fotografos.id_fotografo)
		  LEFT OUTER JOIN Estados ON (Fotos.id_estado = Estados.id_estado)
		  LEFT OUTER JOIN paises ON (Fotos.id_pais = paises.id_pais)
		WHERE id_autor = %s
	", $_GET['autor']);
	} else {
			$query_lote .= sprintf("
		AND id_autor = %s
	", $_GET['autor']);
	}
}
if (!($_GET['assunto']=="")) {
	if ($query_lote == "") {
		$query_lote = sprintf("
		SELECT DISTINCT 
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.id_autor,
		  Fotos.data_foto,
		  Fotos.cidade,
		  Fotos.id_estado,
		  Fotos.id_pais,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  fotografos.Nome_Fotografo,
		  Fotos_extra.extra,
		  Estados.Sigla,
		  paises.nome
		FROM
		  Fotos
		  LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		  LEFT OUTER JOIN fotografos ON (Fotos.id_autor = fotografos.id_fotografo)
		  LEFT OUTER JOIN Estados ON (Fotos.id_estado = Estados.id_estado)
		  LEFT OUTER JOIN paises ON (Fotos.id_pais = paises.id_pais)
		WHERE
		  assunto_principal LIKE '%s'
		", $_GET['assunto']);
	} else {
			$query_lote .= sprintf("
		  AND assunto_principal LIKE '%s'
		", $_GET['assunto']);
	}
}

if (!($_GET['assuntoextra']=="")) {
	if ($query_lote == "") {
		$query_lote = sprintf("
		SELECT DISTINCT 
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.id_autor,
		  Fotos.data_foto,
		  Fotos.cidade,
		  Fotos.id_estado,
		  Fotos.id_pais,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  fotografos.Nome_Fotografo,
		  Fotos_extra.extra,
		  Estados.Sigla,
		  paises.nome
		FROM
		  Fotos
		  LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		  LEFT OUTER JOIN fotografos ON (Fotos.id_autor = fotografos.id_fotografo)
		  LEFT OUTER JOIN Estados ON (Fotos.id_estado = Estados.id_estado)
		  LEFT OUTER JOIN paises ON (Fotos.id_pais = paises.id_pais)
		WHERE
		  extra LIKE '%s'
		", $_GET['assuntoextra']);
	} else {
			$query_lote .= sprintf("
		  AND extra LIKE '%s'
		", $_GET['assuntoextra']);
	}
}

if (!($_GET['cidade']=="")) {
	if ($query_lote == "") {
		$query_lote = sprintf("
		SELECT DISTINCT 
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.id_autor,
		  Fotos.data_foto,
		  Fotos.cidade,
		  Fotos.id_estado,
		  Fotos.id_pais,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  fotografos.Nome_Fotografo,
		  Fotos_extra.extra,
		  Estados.Sigla,
		  paises.nome
		FROM
		  Fotos
		  LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		  LEFT OUTER JOIN fotografos ON (Fotos.id_autor = fotografos.id_fotografo)
		  LEFT OUTER JOIN Estados ON (Fotos.id_estado = Estados.id_estado)
		  LEFT OUTER JOIN paises ON (Fotos.id_pais = paises.id_pais)
		WHERE
		  cidade LIKE '%s'
		", $_GET['cidade']);
	} else {
			$query_lote .= sprintf("
		  AND cidade LIKE '%s'
		", $_GET['cidade']);
	}
}
if (!($_GET['estado']=="")) {
	if ($query_lote == "") {
		$query_lote = sprintf("
		SELECT DISTINCT 
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.id_autor,
		  Fotos.data_foto,
		  Fotos.cidade,
		  Fotos.id_estado,
		  Fotos.id_pais,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  fotografos.Nome_Fotografo,
		  Fotos_extra.extra,
		  Estados.Sigla,
		  paises.nome
		FROM
		  Fotos
		  LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		  LEFT OUTER JOIN fotografos ON (Fotos.id_autor = fotografos.id_fotografo)
		  LEFT OUTER JOIN Estados ON (Fotos.id_estado = Estados.id_estado)
		  LEFT OUTER JOIN paises ON (Fotos.id_pais = paises.id_pais)
		WHERE
		  Fotos.id_estado = %s
		", $_GET['estado']);
	} else {
			$query_lote .= sprintf("
		  AND Fotos.id_estado = %s
		", $_GET['estado']);
	}
}
if (!($_GET['pais']=="")) {
	if ($query_lote == "") {
		$query_lote = sprintf("
		SELECT DISTINCT 
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.id_autor,
		  Fotos.data_foto,
		  Fotos.cidade,
		  Fotos.id_estado,
		  Fotos.id_pais,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  fotografos.Nome_Fotografo,
		  Fotos_extra.extra,
		  Estados.Sigla,
		  paises.nome
		FROM
		  Fotos
		  LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		  LEFT OUTER JOIN fotografos ON (Fotos.id_autor = fotografos.id_fotografo)
		  LEFT OUTER JOIN Estados ON (Fotos.id_estado = Estados.id_estado)
		  LEFT OUTER JOIN paises ON (Fotos.id_pais = paises.id_pais)
		WHERE
		  Fotos.id_pais like '%s'
		", $_GET['pais']);
	} else {
			$query_lote .= sprintf("
		  AND Fotos.id_pais like '%s'
		", $_GET['pais']);
	}
}
$query_lote .= sprintf(" ORDER BY tombo ASC");

if($siteDebug) {
	echo "<br><br>".$query_lote."<br><br>";
}

$lote = mysql_query($query_lote, $pulsar) or die(mysql_error());
$row_lote = mysql_fetch_assoc($lote);
$totalRows_lote = mysql_num_rows($lote);
?>
<head>
<title>Indexa&ccedil;&atilde;o por Lote</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12pt;
	font-weight: bold;
}
.style6 {
	font-size: 10pt;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style7 {
	font-size: 7pt;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style8 {
	font-size: 10pt;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
#Layer1 {
	position:absolute;
	left:484px;
	top:168px;
	width:114px;
	height:24px;
	z-index:1;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>
<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
  <tr>
    <td class="style1">pulsarimagens.com.br<br>
      indexa&ccedil;&atilde;o por lote</td>
    <td class="style1"><div align="right">
        <input name="Button" type="button" onClick="MM_goToURL('parent','adm_index_lote.php');return document.MM_returnValue" value="Novo Lote">
      </div></td>
  </tr>
</table>
<p class="style6">Total de fotos encontradas: <?php echo $totalRows_lote; ?></p>
<form name="form1" method="post" action="">
  <table width="550" border="1">
    <tr>
      <td width="80" class="style8">INCLUIR</td>
      <td><div align="center">
          <input name="button" type="button" id="button" onClick="MM_openBrWindow('adm_index_lote_tema.php','','width=680,height=140,top=400,left=250')" value="Inclui TEMA">
        </div></td>
      <td><div align="center">
          <input type="button" name="button2" id="button2" onClick="MM_openBrWindow('adm_index_lote_desc.php','','width=680,height=140,top=400,left=250')" value="Inclui PAL. CHAVE">
        </div></td>
      <td><div align="center"></div></td>
      <td><div align="center"></div></td>
    </tr>
    <tr>
      <td width="80" class="style8">EXCLUIR</td>
      <td><div align="center">
          <input type="button" name="button3" id="button3" onClick="MM_openBrWindow('adm_index_lote_tema_ex.php','','width=680,height=140,top=400,left=250')" value="Exclui TEMA">
        </div></td>
      <td><div align="center">
          <input type="button" name="button4" id="button4" onClick="MM_openBrWindow('adm_index_lote_desc_ex.php','','width=680,height=140,top=400,left=250')" value="Exclui PAL. CHAVE">
        </div></td>
      <td><div align="center"></div></td>
      <td><div align="center"></div></td>
    </tr>
    <tr>
      <td width="80" class="style8">ALTERAR</td>
      <td><div align="center">
          <input type="button" name="button5" id="button5" onClick="MM_openBrWindow('adm_index_lote_autor.php','','width=680,height=140,top=400,left=250')" value="Altera AUTOR">
        </div></td>
      <td><div align="center">
          <input type="button" name="button6" id="button6" onClick="MM_openBrWindow('adm_index_lote_data.php','','width=680,height=140,top=400,left=250')" value="Altera DATA">
        </div></td>
      <td><div align="center">
          <input type="button" name="button7" id="button7" onClick="MM_openBrWindow('adm_index_lote_local.php','','width=680,height=140,top=400,left=250')" value="Altera LOCAL">
        </div></td>
      <td><div align="center">
          <input type="button" name="button8" id="button8" onClick="MM_openBrWindow('adm_index_lote_extra.php','','width=680,height=140,top=400,left=250')" value="Altera EXTRA">
        </div></td>
    </tr>
  </table>
</form>
<form name="form3" method="post" action="">
  <?php do { 
$query_temas = sprintf("SELECT Fotos.tombo, super_temas.Tema_total as Tema, super_temas.Id FROM super_temas INNER JOIN rel_fotos_temas ON (super_temas.Id=rel_fotos_temas.id_tema) INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) WHERE (Fotos.tombo = '%s')", $row_lote['tombo']);
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);

$query_palavras = sprintf("SELECT  DISTINCT  pal_chave.Pal_Chave,   pal_chave.Id FROM  rel_fotos_pal_ch  INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE   (Fotos.tombo LIKE '%s')", $row_lote['tombo']);
$palavras = mysql_query($query_palavras, $pulsar) or die(mysql_error());
$row_palavras = mysql_fetch_assoc($palavras);
$totalRows_palavras = mysql_num_rows($palavras);

?>
    <table width="550" border="1">
      <tr>
        <td width="20" rowspan="5" class="style6"><input name="vai" value="<?php echo $row_lote['tombo']; ?>" type="checkbox" id="vai" checked></td>
        <td width="150" rowspan="4" class="style6"><div align="center"><img src="<? echo $homeurl;?>/bancoImagens/<?php echo $row_lote['tombo']; ?>p.jpg"></div></td>
        <td class="style6">Assunto Principal: <?php echo $row_lote['assunto_principal']; ?></td>
      </tr>
      <tr>
		<td class="style6">Assunto Extra: <?php echo $row_lote['extra']; ?></td>
	  </tr>
      <tr>
        <td class="style6">Autor: <?php echo $row_lote['Nome_Fotografo']; ?></td>
      </tr>
      <tr>
        <td class="style6">Data:
          <?php if (strlen($row_lote['data_foto']) == 4) {
			echo $row_lote['data_foto'];
		} elseif (strlen($row_lote['data_foto']) == 6) {
			echo substr($row_lote['data_foto'],4,2).'/'.substr($row_lote['data_foto'],0,4);
		} elseif (strlen($row_lote['data_foto']) == 8) {
			echo substr($row_lote['data_foto'],6,2).'/'.substr($row_lote['data_foto'],4,2).'/'.substr($row_lote['data_foto'],0,4);
		} ?></td>
      </tr>
      <tr>
        <td width="150" class="style6">Tombo: <?php echo $row_lote['tombo']; ?></td>
        <td class="style6">Local: <?php echo $row_lote['cidade']; ?>, <?php echo $row_lote['Sigla']; ?> - <?php echo $row_lote['nome']; ?></td>
      </tr>
      <tr class="style7">
    	<td colspan="3">
        <strong>Temas:</strong><br />
        <?php do { ?>
        <?php echo $row_temas['Tema']; ?><br>
        <?php } while ($row_temas = mysql_fetch_assoc($temas)); ?>
        </td>
    </tr>
    <tr class="style7">
    	<td colspan="3">
        <strong>Palavras-chave:</strong><br />
        <?php do { ?><?php echo $row_palavras['Pal_Chave']; ?> | <?php } while ($row_palavras = mysql_fetch_assoc($palavras)); ?>
        </td>
    </tr>
    </table>
    <br />
    <?php } while ($row_lote = mysql_fetch_assoc($lote));?>
</form>
<form name="form2" method="post" action="">
  <table width="550" border="1">
    <tr>
      <td width="80" class="style8">INCLUIR</td>
      <td><div align="center">
          <input name="button" type="button" id="button" onClick="MM_openBrWindow('adm_index_lote_tema.php','','width=680,height=140,top=400,left=250')" value="Inclui TEMA">
        </div></td>
      <td><div align="center">
          <input type="button" name="button2" id="button2" onClick="MM_openBrWindow('adm_index_lote_desc.php','','width=680,height=140,top=400,left=250')" value="Inclui PAL. CHAVE">
        </div></td>
      <td><div align="center"></div></td>
    </tr>
    <tr>
      <td width="80" class="style8">EXCLUIR</td>
      <td><div align="center">
          <input type="button" name="button3" id="button3" onClick="MM_openBrWindow('adm_index_lote_tema_ex.php','','width=680,height=140,top=400,left=250')" value="Exclui TEMA">
        </div></td>
      <td><div align="center">
          <input type="button" name="button4" id="button4" onClick="MM_openBrWindow('adm_index_lote_desc_ex.php','','width=680,height=140,top=400,left=250')" value="Exclui PAL. CHAVE">
        </div></td>
      <td><div align="center"></div></td>
    </tr>
    <tr>
      <td width="80" class="style8">ALTERAR</td>
      <td><div align="center">
          <input type="button" name="button5" id="button5" onClick="MM_openBrWindow('adm_index_lote_autor.php','','width=680,height=140,top=400,left=250')" value="Altera AUTOR">
        </div></td>
      <td><div align="center">
          <input type="button" name="button6" id="button6" onClick="MM_openBrWindow('adm_index_lote_data.php','','width=680,height=140,top=400,left=250')" value="Altera DATA">
        </div></td>
      <td><div align="center">
          <input type="button" name="button7" id="button7" onClick="MM_openBrWindow('adm_index_lote_local.php','','width=680,height=140,top=400,left=250')" value="Altera LOCAL">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html><?php
mysql_free_result($lote);
?>
