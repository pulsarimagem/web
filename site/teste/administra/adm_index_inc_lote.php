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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$tombos = array();
if($_GET['Submit'] == "Consultar" || isset($_GET['copiar'])) {
	$prefix = strtoupper($_GET['tombo_prefix']);
	$inicio = $_GET['tombo_inicio'];
	$final = $_GET['tombo_final'];

	if($inicio < 10)
		$zeros = "00";
	else if($inicio < 100)
		$zeros = "0";
	else
		$zeros = "";

	$first = $prefix.$zeros.$inicio;
	
	do {
		if($inicio < 10)
			$zeros = "00";
		else if($inicio < 100)
			$zeros = "0";
		else
			$zeros = "";
			
		$tombos[] = $prefix.$zeros.$inicio;
		$inicio++;
	} while($inicio <= $final);
//print_r($tombos);
//echo "<br>".$first."<br>";
}

// INSERIR NA TABELA FOTO
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	
	include('../toolkit/inc_IPTC4.php');
	
			
	foreach ($tombos as $tombo) {

		$pop_file = $thumbpop."/".$tombo."p.jpg";
		$thumb_file = $thumbpop."/".$tombo.".jpg";
//		$pop_file = '/var/www/www.pulsarimagens.com.br/bancoImagens/'.$tombo."p.jpg";
//		$thumb_file = '/var/www/www.pulsarimagens.com.br/bancoImagens/'.$tombo.".jpg";
		
		
		if(file_exists($pop_file) && file_exists($thumb_file)) {

if($siteDebug) {
	echo $pop_file." exists<br>";
	echo $thumb_file." exists<br>";
}		

			$orientacao = 'H';
			$width = 0;
			$height = 0;
			
			$file = "/var/fotos_alta/".$tombo.".jpg";
			
			if (!file_exists($file)) {				// check se o arquivo existe com extensao jpg e JPG
				$file = "/var/fotos_alta/".$tombo.".JPG";
			}
			
			if (file_exists($file)) {				// se existir, abre e imprime a resolucao
				$getimgsize = getimagesize($file);
			
				if ($getimgsize) {
					list($width, $height, $type, $attr) = $getimgsize; 
			                
					if($height > $width) {
						$orientacao = 'V';
					}
				}
			}

  			$direito_img = $_POST['dir_img'];
			
		  $insertSQL = sprintf("INSERT INTO Fotos (tombo, id_autor, data_foto, cidade, id_estado, id_pais, orientacao, assunto_principal, dim_a, dim_b, direito_img, extra) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			               GetSQLValueString($tombo, "text"),
			               GetSQLValueString($_POST['autor'], "int"),
			               GetSQLValueString($_POST['data'], "text"),
			               GetSQLValueString($_POST['cidade'], "text"),
			               GetSQLValueString($_POST['estado'], "int"),
			               GetSQLValueString($_POST['pais'], "text"),
                           GetSQLValueString($orientacao, "text"),
                           GetSQLValueString($_POST['assunto_principal'], "text"),
                           GetSQLValueString($width, "int"),
	                       GetSQLValueString($height, "int"),
	                       GetSQLValueString($direito_img, "int"),
	                       GetSQLValueString($_POST['extra'], "text"));
                           			               			               
	
		  mysql_select_db($database_pulsar, $pulsar);
		  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	
		  $Ultimo_Id = mysql_insert_id();
		  
		  if($_POST['extra'] != "") {
			  $insertextraSQL = sprintf("INSERT INTO Fotos_extra (tombo, extra) VALUES (%s, %s)",
				               GetSQLValueString($tombo, "text"),
				               GetSQLValueString($_POST['extra'], "text"));
		
			  mysql_select_db($database_pulsar, $pulsar);
			  $Result2 = mysql_query($insertextraSQL, $pulsar) or die(mysql_error());
		  }
		  
		  
		  
		// INSERIR OS TEMAS
	
		  $Array_t = explode(",",$_POST["todos_temas"]);
	
		  $insertSQLt = "INSERT INTO rel_fotos_temas (id_foto,id_tema) VALUES ($Ultimo_Id,".implode("),($Ultimo_Id,",$Array_t).")";
		//  echo $insertSQLt;
		  mysql_select_db($database_pulsar, $pulsar);
		  $Result2 = mysql_query($insertSQLt, $pulsar) or die(mysql_error());
	
		// INSERIR AS PALAVRAS-CHAVES  
	
		  $Array_d = explode(",",$_POST["todos_descritores"]);
	
		  $insertSQLp = "INSERT INTO rel_fotos_pal_ch (id_foto,id_palavra_chave) VALUES ($Ultimo_Id,".implode("),($Ultimo_Id,",$Array_d).")";
		//  echo $insertSQLp;
		  mysql_select_db($database_pulsar, $pulsar);
		  $Result3 = mysql_query($insertSQLp, $pulsar) or die(mysql_error());
		  
			// Insere o IPTC no arquivo
	//		$tombo = $_POST['tombo'];
			$path = $thumbpop;
			$dest_file = $path."/".$tombo.".jpg";
			coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
			$dest_file = $path."/".$tombo."p.jpg";
			coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
			
			cleanFotos_tmp($tombo,$pulsar);
			cleanTombos_toindex($tombo,$pulsar);
				
		}	
		else {
if($siteDebug) {
	if(!file_exists($pop_file))
		echo $pop_file." not exists...<br>";
	if(!file_exists($thumb_file))
		echo $thumb_file." not exists...<br>";    
}
		}
	}
	
  $insertGoTo = "adm_index_inc_lote.php";
//  if (isset($_SERVER['QUERY_STRING'])) {
//    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
//    $insertGoTo .= $_SERVER['QUERY_STRING'];
//  }

  header(sprintf("Location: %s", $insertGoTo));

}

$colname_dados_foto = "0";
if (isset($_GET['copiar'])) {
  $colname_dados_foto = (get_magic_quotes_gpc()) ? $_GET['copiar'] : addslashes($_GET['copiar']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_dados_foto = sprintf("SELECT * FROM Fotos WHERE tombo = '%s'", $colname_dados_foto);
$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
$row_dados_foto = mysql_fetch_assoc($dados_foto);
$totalRows_dados_foto = mysql_num_rows($dados_foto);

mysql_select_db($database_pulsar, $pulsar);
$query_fotografos = "SELECT * FROM fotografos ORDER BY Nome_Fotografo ASC";
$fotografos = mysql_query($query_fotografos, $pulsar) or die(mysql_error());
$row_fotografos = mysql_fetch_assoc($fotografos);
$totalRows_fotografos = mysql_num_rows($fotografos);

mysql_select_db($database_pulsar, $pulsar);
$query_estado = "SELECT * FROM Estados ORDER BY Estado ASC";
$estado = mysql_query($query_estado, $pulsar) or die(mysql_error());
$row_estado = mysql_fetch_assoc($estado);
$totalRows_estado = mysql_num_rows($estado);

mysql_select_db($database_pulsar, $pulsar);
$query_pais = "SELECT * FROM paises ORDER BY nome ASC";
$pais = mysql_query($query_pais, $pulsar) or die(mysql_error());
$row_pais = mysql_fetch_assoc($pais);
$totalRows_pais = mysql_num_rows($pais);

mysql_select_db($database_pulsar, $pulsar);
$query_descritore = sprintf("SELECT    Fotos.tombo,   pal_chave.Id,   pal_chave.Pal_Chave,  rel_fotos_pal_ch.id_rel FROM  rel_fotos_pal_ch  INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE   (Fotos.tombo = '%s') ORDER BY pal_chave.Pal_Chave",$row_dados_foto['tombo']);
$descritore = mysql_query($query_descritore, $pulsar) or die(mysql_error());
$row_descritore = mysql_fetch_assoc($descritore);
$totalRows_descritore = mysql_num_rows($descritore);

mysql_select_db($database_pulsar, $pulsar);
$query_temas = sprintf("SELECT   Fotos.tombo,  super_temas.Tema_total,  super_temas.Id,  rel_fotos_temas.id_rel FROM Fotos INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) INNER JOIN super_temas ON (rel_fotos_temas.id_tema=super_temas.Id) WHERE   (Fotos.tombo = '%s') ORDER BY  super_temas.Tema_total",$row_dados_foto['tombo']);
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);

//Foto extra
mysql_select_db($database_pulsar, $pulsar);
$query_extra_foto = sprintf("SELECT * FROM Fotos_extra WHERE tombo = '%s'", $row_dados_foto['tombo']);
$extra_foto = mysql_query($query_extra_foto, $pulsar) or die(mysql_error());
$row_extra_foto = mysql_fetch_assoc($extra_foto);
$totalRows_extra_foto = mysql_num_rows($extra_foto);

// Deteccao de fotografo
$inicial = strtoupper(ereg_replace("[^A-Za-z]","", $tombos[0]));
mysql_select_db($database_pulsar, $pulsar);
$query_ini_fotografo = sprintf("SELECT * FROM fotografos WHERE Iniciais_Fotografo = '%s'", $inicial);
$ini_fotografo = mysql_query($query_ini_fotografo, $pulsar) or die(mysql_error());
$row_ini_fotografo = mysql_fetch_assoc($ini_fotografo);
$totalRows_ini_fotografo = mysql_num_rows($ini_fotografo);



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
	font-size: 10pt;
	font-weight: bold;
}
.style6 {font-size: 10pt; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style8 {font-size: 10pt; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
-->
</style>
<script language="JavaScript" type="text/JavaScript">

function atualizar(tela,valor) {

//	alert(tela + ' - ' + valor);

	var combo = document.form2.tema;
	//alert(combo.options.length);
	combo.options[combo.options.length]=new Option(tela, valor);

}

function atualizar2(tela,valor) {

//	alert(tela + ' - ' + valor);

	var combo = document.form2.descritor;
	//alert(combo.options.length);
	combo.options[combo.options.length]=new Option(tela, valor);

}

function removeMe() {
	var boxLength = document.form2.descritor.length;
	arrSelected = new Array();
	var count = 0;
	for (i = 0; i < boxLength; i++) {
		if (document.form2.descritor.options[i].selected) {
			arrSelected[count] = document.form2.descritor.options[i].value;
		}
		count++;
	}
	var x;
	for (i = 0; i < boxLength; i++) {
		for (x = 0; x < arrSelected.length; x++) {
			if (document.form2.descritor.options[i].value == arrSelected[x]) {
				document.form2.descritor.options[i] = null;
			}
		}
	}
}
function excluir(indice) {

alert(indice);
//	document.form2.descritor.remove(indice);
}

function excluir2(indice) {

	document.form2.tema.remove(indice);

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
if (document.form2.data_tela.value.length == 0) {
	document.form2.data.value = document.form2.data_tela.value;
	}
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
function copiarDados() {

MM_openBrWindow('adm_index_inc_lote_copiar.php?tombo_prefix='+document.form2.tombo_prefix.value+'&tombo_inicio='+document.form2.tombo_inicio.value+'&tombo_final='+document.form2.tombo_final.value,'','width=380,height=30');

//alert(document.form2.tombo.value);

}

function grava() {

multi_select = document.form2.tema;
todos_t = "";
todos_t += multi_select.options[0].value;
for(x=1;x<multi_select.length;x++){

  todos_t += ",";
  todos_t += multi_select.options[x].value;

}

document.form2.todos_temas.value = todos_t;

multi_select = document.form2.descritor;
todos_d = "";
todos_d += multi_select.options[0].value;
for(x=1;x<multi_select.length;x++){

  todos_d += ",";
  todos_d += multi_select.options[x].value;

}

document.form2.todos_descritores.value = todos_d;

document.form2.submit();

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
<form action="adm_index_inc_lote.php" method="get" name="form1" class="style2">
   Tombo Prefixo: 
   <input name="tombo_prefix" type="text" id="tombo_prefix" value="<?php if (isset($_GET['tombo_prefix'])) { echo $_GET['tombo_prefix']; }?>"><br>
   Tombo Inicio: 
   <input name="tombo_inicio" type="text" id="tombo_inicio" value="<?php if (isset($_GET['tombo_inicio'])) { echo $_GET['tombo_inicio']; }?>"><br>
   Tombo Fim: 
   <input name="tombo_final" type="text" id="tombo_final" value="<?php if (isset($_GET['tombo_final'])) { echo $_GET['tombo_final']; }?>"><br>
   <input type="submit" name="Submit" value="Consultar">
</form>
<?php if (isset($_GET['tombo_prefix']) && isset($_GET['tombo_inicio']) && isset($_GET['tombo_final'])) {?>
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST">
  <span class="style2">Nova Indexa&ccedil;&atilde;o<br>
  </span><br>
  <table width="600" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="style2"><div align="center">
      <?php foreach($tombos as $tombo) {
		if(!file_exists($fotosalta.$tombo.".jpg") && !file_exists($fotosalta.$tombo.".JPG")) {
			?>
			<script>
			alert('Tombo <?php echo $tombo?> n�o presente no <?php echo $fotosalta?>');
			</script>
			<?php 
		}
      ?>
      <img src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $tombo; ?>p.jpg" align="middle" onclick="MM_openBrWindow('http://www.pulsarimagens.com.br/bancoImagens/<?php echo $tombo; ?>.jpg','','resizable=yes,width=550,height=550')">
      <?php }?>
      <br>
          <br>
      <input type="button" name="botao" value="Extra IPTC" align="middle" onclick="MM_openBrWindow('<?php echo $homeurl ?>toolkit/Example.php?jpeg_fname=<?php echo $first; ?>','','scrollbars=yes,resizable=yes,width=600,height=800')"><br>
      </div></td>
		      <td class="style2">	<IFRAME ID=IFrame1 FRAMEBORDER=0 SCROLLING=YES SRC="iptc.php?foto=<?php echo $first; ?>"></IFRAME>
</td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td class="style2">Tombo:</td>
            <td class="style2"><label class="style6">
              <input name="tombo2" type="text" id="tombo2" value="<?php echo implode(",",$tombos); ?>"><script>document.form2.tombo2.disabled=true;</script><input name="tombo" type="hidden" id="tombo" value="<?php echo $first; ?>"><input name="tombo_prefix" type="hidden" id="tombo_prefix" value="<?php echo $_GET['tombo_prefix']; ?>"><input name="tombo_inicio" type="hidden" id="tombo_inicio" value="<?php echo $_GET['tombo_inicio']; ?>"><input name="tombo_final" type="hidden" id="tombo_final" value="<?php echo $_GET['tombo_final']; ?>">
              <input type="button" name="Submit2" value="Copiar dados de..." onClick="copiarDados()">
              </label></td>
          </tr>
          <tr>
            <td width="150" class="style2">Assunto Principal: </td>
            <td class="style2"><input name="assunto_principal" type="text" id="assunto_principal" value="<?php echo $row_dados_foto['assunto_principal']; ?>" size="70" maxlength="100"></td>
          </tr>
        <tr>
          <td width="150" class="style2">Informa&ccedil;&atilde;o Adicional: </td>
          <td class="style2"><input name="extra" type="text" id="extra" value="<?php echo $row_extra_foto['extra']; ?>" size="70">
            <input name="Id_Foto" type="hidden" id="Id_Foto" value="<?php echo $row_dados_foto['Id_Foto']; ?>"></td>
        </tr>
        <tr>
          <td width="150" class="style2">Uso de Imagem: </td>
<!--           <td class="style2"><input name="dir_img" type="checkbox" id="dir_img" value="<?php echo $row_dados_foto['direito_img']; ?>"></td> -->
          <td class="style6"><input name="dir_img" type="radio" id="dir_img" value="0" <?php echo ($row_dados_foto['direito_img'] != 1 && $row_dados_foto['direito_img'] != 2 ? "checked":"");?>>Nenhum
          <input name="dir_img" type="radio" id="dir_img" value="1" <?php echo ($row_dados_foto['direito_img'] == 1 ? "checked":"");?>>Uso Autorizado 
          <input name="dir_img" type="radio" id="dir_img" value="2" <?php echo ($row_dados_foto['direito_img'] == 2 ? "checked":"");?>>Autorizado+Acr�scimo de 100%</td>
        </tr>
          <tr>
            <td width="150" class="style2">Autor:</td>
            <td class="style2"><select name="autor" id="autor" disabled="disabled">
                <?php
do {  
?>
                <option value="<?php echo $row_fotografos['id_fotografo']?>"<?php if (false && !(strcmp($row_fotografos['id_fotografo'], $row_dados_foto['id_autor']))) {echo "SELECTED";} else if (!(strcmp($row_fotografos['Iniciais_Fotografo'], $row_ini_fotografo['Iniciais_Fotografo']))) {echo "SELECTED";} ?>><?php echo $row_fotografos['Nome_Fotografo']?></option>
                <?php
} while ($row_fotografos = mysql_fetch_assoc($fotografos));
  $rows = mysql_num_rows($fotografos);
  if($rows > 0) {
      mysql_data_seek($fotografos, 0);
	  $row_fotografos = mysql_fetch_assoc($fotografos);
  }
?>
              </select>
				<input name="autor" type="hidden" id="autor" value="<?php echo $row_ini_fotografo['id_fotografo']; ?>"/>
              </td>
          </tr>
          <tr>
            <td width="150" class="style2">Data:</td>
            <td class="style2"><input name="data_tela" type="text" id="data_tela" onBlur="MM_callJS('fix_data()')" value="<?php if (strlen($row_dados_foto['data_foto']) == 4) {
			echo $row_dados_foto['data_foto'];
		} elseif (strlen($row_dados_foto['data_foto']) == 6) {
			echo substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
		} elseif (strlen($row_dados_foto['data_foto']) == 8) {
			echo substr($row_dados_foto['data_foto'],6,2).'/'.substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
		} ?>">
              <input name="data" type="hidden" id="data" value="<?php echo $row_dados_foto['data_foto']; ?>"></td>
          </tr>
          <tr>
            <td width="150" class="style2">Cidade:</td>
            <td class="style2"><input name="cidade" type="text" id="cidade" value="<?php echo $row_dados_foto['cidade']; ?>" size="70"></td>
          </tr>
          <tr>
            <td width="150" class="style2">Estado:</td>
            <td class="style2"><select name="estado" id="estado">
                <option value="" <?php if (!(strcmp("", $row_dados_foto['id_estado']))) {echo "SELECTED";} ?>>---
                em branco ---</option>
                <?php
do {  
?>
                <option value="<?php echo $row_estado['id_estado']?>"<?php if (!(strcmp($row_estado['id_estado'], $row_dados_foto['id_estado']))) {echo "SELECTED";} ?>><?php echo $row_estado['Estado']?></option>
                <?php
} while ($row_estado = mysql_fetch_assoc($estado));
  $rows = mysql_num_rows($estado);
  if($rows > 0) {
      mysql_data_seek($estado, 0);
	  $row_estado = mysql_fetch_assoc($estado);
  }
?>
              </select></td>
          </tr>
          <tr>
            <td width="150" class="style2">Pa&iacute;s:</td>
            <td class="style2"><select name="pais" id="pais">
                <option value="">---
                em branco ---</option>
                <?php
do {  
?>
                <option value="<?php echo $row_pais['id_pais']?>"<?php if (!(strcmp($row_pais['id_pais'], $row_dados_foto['id_pais']))) {echo "SELECTED";} ?><?php if ( (!(strcmp("", $row_dados_foto['id_pais']))) and (!(strcmp($row_pais['id_pais'], "BR"))) ) {echo "SELECTED";} ?>><?php echo $row_pais['nome']?></option>
                <?php
} while ($row_pais = mysql_fetch_assoc($pais));
  $rows = mysql_num_rows($pais);
  if($rows > 0) {
      mysql_data_seek($pais, 0);
	  $row_pais = mysql_fetch_assoc($pais);
  }
?>
              </select></td>
          </tr>
          <tr>
            <td width="150" class="style2">Orienta&ccedil;&atilde;o:</td>
            <td class="style2"><select name="orientacao" id="orientacao">
                <option value="H" <?php if (!(strcmp("H", $row_dados_foto['orientacao']))) {echo "SELECTED";} ?>>Horizontal</option>
                <option value="V" <?php if (!(strcmp("V", $row_dados_foto['orientacao']))) {echo "SELECTED";} ?>>Vertical</option>
              </select></td>
          </tr>
          <tr>
            <td width="150" class="style2">Temas:</td>
            <td class="style2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td rowspan="2"><select name="tema" size="5" id="tema">
                      <?php
					  if ( $totalRows_temas > 0 ) {
do {  
?>
                      <option value="<?php echo $row_temas['Id']?>"><?php echo $row_temas['Tema_total']?></option>
                      <?php
} while ($row_temas = mysql_fetch_assoc($temas));
  $rows = mysql_num_rows($temas);
  if($rows > 0) {
      mysql_data_seek($temas, 0);
	  $row_temas = mysql_fetch_assoc($temas);
  }
}
?>
                    </select></td>
                  <td valign="bottom"><?php if ($row_login['index_alt']==1) {?>
                    <input name="Button" type="button" onClick="MM_openBrWindow('adm_index_tema2.php?Id_Foto=<?php echo $row_dados_foto['Id_Foto']; ?>&tombo=<?php echo $row_dados_foto['tombo']; ?>','','width=680,height=140,top=400,left=250')" value="Incluir Tema">
                  <?php } ?></td>
                </tr>
                <tr>
                  <td valign="top"><?php if ($row_login['index_alt']==1) {?>
                    <input type="button" name="Button" onClick="excluir2(document.form2.tema.selectedIndex)" value="Excluir Tema">
                    <?php } ?>                  </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td class="style2">Descritores:</td>
            <td class="style2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td rowspan="2"><select name="descritor" size="5" multiple id="descritor">
                      <?php
				if ($totalRows_descritore > 0) {
do {  
?>
                      <option value="<?php echo $row_descritore['Id']?>"><?php echo $row_descritore['Pal_Chave']?></option>
                      <?php
} while ($row_descritore = mysql_fetch_assoc($descritore));
  $rows = mysql_num_rows($descritore);
  if($rows > 0) {
      mysql_data_seek($descritore, 0);
	  $row_descritore = mysql_fetch_assoc($descritore);
  }
}
?>
                    </select></td>
                  <td valign="bottom"><?php if ($row_login['index_alt']==1) {?>
                    <input name="Button" type="button" onClick="MM_openBrWindow('adm_index_desc2.php?Id_Foto=<?php echo $row_dados_foto['Id_Foto']; ?>&tombo=<?php echo $row_dados_foto['tombo']; ?>','','scrollbars=yes,width=470,height=80,top=500,left=250')" value="Incluir Descritor">
                  <?php } ?></td>
                </tr>
                <tr>
                  <td valign="top"><?php if ($row_login['index_alt']==1) {?>
                    <input type="button" name="Button" onClick="removeMe();" value="Excluir Descritor">
                  <?php } ?></td>
                </tr>
              </table></td>
          </tr>
          <?php if ($row_login['index_alt']==1) {?>
          <tr>
            <td colspan="2" class="style6"><div align="center"><br>
                <input name="todos_temas" type="hidden" id="todos_temas">
                <input name="todos_descritores" type="hidden" id="todos_descritores">
                <input type="button" name="Button" value="Gravar" onClick="grava();">
              </div></td>
          </tr>
          <?php } ?>
        </table></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>
<?php }?>
</body>
</html>
<?php
mysql_free_result($dados_foto);

mysql_free_result($fotografos);

mysql_free_result($estado);

mysql_free_result($pais);

mysql_free_result($descritore);

mysql_free_result($temas);

mysql_free_result($login);

mysql_free_result($extra_foto);

?>
