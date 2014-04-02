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
function coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar) {
	
	if ($siteDebug) {
		echo "<strong>tombo: </strong>".$tombo."<br><br>";
	}
	
mysql_select_db ( $database_pulsar, $pulsar );
$query_dados_foto = sprintf ( "
SELECT 
	Fotos.Id_Foto,
	Fotos.tombo,
	Fotos.id_autor,
	Fotos.data_foto,
	Fotos.cidade,
	Fotos.id_estado,
	Fotos.id_pais,
	Fotos.orientacao,
	Fotos.assunto_principal,
	fotografos.nome_fotografo,
	Estados.Sigla as estado,
	paises.nome as pais
FROM
	Fotos
	LEFT OUTER JOIN fotografos ON (Fotos.id_autor = fotografos.id_fotografo)
	LEFT OUTER JOIN Estados ON (Fotos.id_estado = Estados.id_estado)
	LEFT OUTER JOIN paises ON (Fotos.id_pais = paises.id_pais)
WHERE
	tombo like '%s'
", $tombo );
$dados_foto = mysql_query ( $query_dados_foto, $pulsar ) or die ( mysql_error () );
$row_dados_foto = mysql_fetch_assoc ( $dados_foto );
$totalRows_dados_foto = mysql_num_rows ( $dados_foto );

$query_palavras = sprintf ( "
SELECT  DISTINCT
	pal_chave.Pal_Chave,
	pal_chave.Id 
FROM
	rel_fotos_pal_ch  
	INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto) 
	INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) 
WHERE   
	(Fotos.tombo LIKE '%s') 
ORDER BY
	Pal_Chave
", $tombo );
$palavras = mysql_query ( $query_palavras, $pulsar ) or die ( mysql_error () );
$row_palavras = mysql_fetch_assoc ( $palavras );
$totalRows_palavras = mysql_num_rows ( $palavras );

$palavras_chave_arry = array ( );
$pc_index = 0;
do {
	$palavras_chave_arry [$pc_index] = $row_palavras ['Pal_Chave'];
	$pc_index ++;
} while ( $row_palavras = mysql_fetch_assoc ( $palavras ) );

$local = $row_dados_foto['cidade']; 
if (($row_dados_foto['estado'] <> '') AND ( ( is_null($row_dados_foto['pais'])) OR ($row_dados_foto['pais'] == 'Brasil'))) { 
	if ($row_dados_foto['cidade'] <> '') {
		$local .= " - ";
	};
	$local .= $row_dados_foto['estado']; 
}
if ((!is_null($row_dados_foto['pais'])) and ($row_dados_foto['pais']!='Brasil')) { 
	$local .= "  ".$row_dados_foto['pais']; 
}

$data = "0000:00:00 00:00:00";
if (strlen($row_dados_foto['data_foto']) == 4) {
	$data = $row_dados_foto['data_foto'].":00:00 00:00:00";
} elseif (strlen($row_dados_foto['data_foto']) == 6) {
	$data = substr($row_dados_foto['data_foto'],0,4).":".substr($row_dados_foto['data_foto'],4,2).":00 00:00:00";
} elseif (strlen($row_dados_foto['data_foto']) == 8) {
	$data = substr($row_dados_foto['data_foto'],0,4).':'.substr($row_dados_foto['data_foto'],4,2).':'.substr($row_dados_foto['data_foto'],6,2)." 00:00:00";
}	

$data2 = "";
if (strlen($row_dados_foto['data_foto']) == 4) {
	$data2 = $row_dados_foto['data_foto'];
} elseif (strlen($row_dados_foto['data_foto']) == 6) {
	$data2 = substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
} elseif (strlen($row_dados_foto['data_foto']) == 8) {
	$data2 = substr($row_dados_foto['data_foto'],6,2).'/'.substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
}	


$IPTCtitle = $row_dados_foto ['assunto_principal'];
$IPTCcreator = $row_dados_foto ['nome_fotografo']; 
$IPTCbylinetitle = $tombo;
$IPTCdescription = $row_dados_foto ['assunto_principal'];
$IPTClocation = $local;
$IPTCcity = $row_dados_foto['cidade'];
$IPTCstate = $row_dados_foto['estado'];
$IPTCcountry = $row_dados_foto['pais'];
$IPTCdatecreated = $data;
$IPTCdatecreated2 = $data2;
$IPTCkeywords = implode(",",$palavras_chave_arry);
$IPTCcopyright = "Pulsar Imagens - http://www.pulsarimagens.com.br";

/*
 Document title => Title, Author => Creator, Author title => By-line Title; 
 Description => Description; Keywords => Subject; Copyright => Rights
 
exiftool <tombo>.jpg -All=;
exiftool <tombo>.jpg -Title="Titulo Foto" -Creator="Criador" -"By-line Title"="Subtitulo" -Description="Descricao" -Subject="Palavra1;Palavra2" -Rights="Copyright Pulsar Imagens"
 -Copyright="Copyright Pulsar Imagens"
 */

	if ($siteDebug) {
		echo "<strong>dest_file: </strong>".$dest_file."<br>";
		echo "Title: ".$IPTCtitle."<br>";
		echo "Creator: ".$IPTCcreator."<br>";
		echo "Bylinetitle: ".$IPTCbylinetitle."<br>";
		echo "Description: ".$IPTCdescription."<br>";
		echo "Location: ".$IPTClocation."<br>";
		echo "DateCreated: ".$IPTCdatecreated."<br>";
		echo "DateCreated2: ".$IPTCdatecreated2."<br>";
		echo "Keywords: ".$IPTCkeywords."<br>";
		echo "Copyright: ".$IPTCcopyright."<br><br>";
	}
	$command_clean = "exiftool ".$dest_file." -overwrite_original -All=";
	
	$command_set = "exiftool ".$dest_file." -overwrite_original -L -Title=\"".$IPTCtitle."\" -Creator=\"".$IPTCcreator."\" -\"By-lineTitle\"=\"".$IPTCbylinetitle."\" -Description=\"".$IPTCdescription." Local: ".$IPTClocation." Data: ".$IPTCdatecreated2."\" -Location=\"".$IPTClocation."\" -XMP:City=\"".$IPTCcity."\" -XMP:State=\"".$IPTCstate."\" -XMP:Country=\"".$IPTCcountry."\" -CreateDate=\"".$IPTCdatecreated."\" -Subject=\"".$IPTCkeywords."\" -Rights=\"".$IPTCcopyright."\" -Copyright=\"".$IPTCcopyright."\" -\"CopyrightFlag\"=true -CopyrightNotice=\"".$IPTCcopyright."\"";
	
	if ($siteDebug) {
		echo $command_clean."<br>";
		echo $command_set."<br>";
	}
	shell_exec($command_clean);
	shell_exec($command_set);
}	



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Indexa&ccedil;&atilde;o</title>
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
.style6 {font-size: 10pt; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style8 {font-size: 10pt; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
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

function atualizar(tela,valor) {

	var combo = document.form2.tema;
	//alert(combo.options.length);
	combo.options[combo.options.length]=new Option(tela, valor);

}

function atualizar2(tela,valor) {

	var combo = document.form2.descritor;
	//alert(combo.options.length);
	combo.options[combo.options.length]=new Option(tela, valor);

}

<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
function confirmSubmit()
{
var agree=confirm("Confirma exclus�o?");
if (agree)
	document.form2.submit();
else
	return false ;
}
function confirmSubmit2()
{
var agree=confirm("Confirma exclus�o do cromo?");
if (agree)
	document.form3.submit();
else
	return false ;
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function fix_data() {
if (document.form2.data_tela.value.length == 4) {
	document.form2.data.value = document.form2.data_tela.value;
	}
if (document.form2.data_tela.value.length == 7) {
	document.form2.data.value = document.form2.data_tela.value.substring(3,7)+document.form2.data_tela.value.substring(0,2);
	}
if (document.form2.data_tela.value.length == 10) {
	document.form2.data.value = document.form2.data_tela.value.substring(6,10)+document.form2.data_tela.value.substring(3,5)+document.form2.data_tela.value.substring(0,2);
	}

}
function fix_data2() {
if (document.form4.data_tela.value.length == 4) {
	document.form4.data.value = document.form4.data_tela.value;
	}
if (document.form4.data_tela.value.length == 7) {
	document.form4.data.value = document.form4.data_tela.value.substring(3,7)+document.form4.data_tela.value.substring(0,2);
	}
if (document.form4.data_tela.value.length == 10) {
	document.form4.data.value = document.form4.data_tela.value.substring(6,10)+document.form4.data_tela.value.substring(3,5)+document.form4.data_tela.value.substring(0,2);
	}

}
//-->
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td class="style1">pulsarimagens.com.br<br>
         indexa&ccedil;&atilde;o</td>
     <td class="style1"><div align="right">
       <input name="Button" type="button" onClick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" value="Menu Principal">
     </div></td>
   </tr>
</table>

<?php 
$path = "/var/www/www2.pulsarimagens.com.br/temp";
$thumbs = 0;
$pops = 0;
$count = 0;

if ($handle = opendir($path)) {
    echo "Directory handle: $handle\n";
    echo "Files:\n";

    $timeBefore = microtime(true);
	
    /* This is the correct way to loop over the directory. */
    while (false !== ($file = readdir($handle))) {
        $dest_file = $path."/".$file;
        $thisFileType = strtolower(substr($file,-5));
        
		if (strlen($file) > 5) {
			if ($thisFileType == "p.jpg") {
        		echo "$file\n";
				$tombo = substr($file,0,-5);
				$pops++;
				$count++;
				coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
			} else {
        		echo "$file\n";
				$tombo = substr($file,0,-4);
				$thumbs++;
				$count++;
				coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
			}
		}
    }
	echo "<br>\nThumbs: $thumbs   Pops: $pops    Total: $count<br>\n";
	$timeAfter = microtime(true);
	$diff = $timeAfter - $timeBefore;
	echo "<strong>delay: </strong>".$diff."</strong><br>";
}


?>

</body>
</html>
<?php
mysql_free_result($login);

?>