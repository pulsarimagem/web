<?php 
include("create_menu.php");
include("create_menu_video.php");

if(!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	//  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
	
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
}
// Read a file and display its content chunk by chunk
function readfile_chunked($filename, $retbytes = TRUE) {
	$buffer = '';
	$cnt =0;
	// $handle = fopen($filename, 'rb');
	$handle = fopen($filename, 'rb');
	if ($handle === false) {
		return false;
	}
	while (!feof($handle)) {
		$buffer = fread($handle, 1048576);
		echo $buffer;
		ob_flush();
		flush();
		if ($retbytes) {
			$cnt += strlen($buffer);
		}
	}
	$status = fclose($handle);
	if ($retbytes && $status) {
		return $cnt; // return num. bytes delivered like readfile() does.
	}
	return $status;
}

/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$overwrite = false) {
  //if the zip file already exists and overwrite is false, return false
  if(file_exists($destination) && !$overwrite) { return false; }
  //vars
  $valid_files = array();
  //if files were passed in...
  if(is_array($files)) {
    //cycle through each file
    foreach($files as $file) {
      //make sure the file exists
      if(file_exists($file)) {
        $valid_files[] = $file;
      }
    }
  }
  //if we have good files...
  if(count($valid_files)) {
    //create the archive
    $zip = new ZipArchive();
    if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
      return false;
    }
    //add the files
    foreach($valid_files as $file) {
      $localname = end( explode( "/", $file ) ); 
      $zip->addFile($file,$localname);
    }
    //debug
    //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
    
    //close the zip -- done!
    $zip->close();
    
    //check to make sure the file exists
    return file_exists($destination);
  }
  else
  {
    return false;
  }
}

function filter($data) {
	$data = trim(strip_tags($data));

	if (get_magic_quotes_gpc())
		$data = stripslashes($data);

	$data = mysql_real_escape_string($data);

	return $data;
}

function filter_arr($data) {
	foreach($data as $key => $value) {
		$value = trim(strip_tags($value));
	
		if (get_magic_quotes_gpc())
			$value = stripslashes($value);
	
		$value = mysql_real_escape_string($value);
		$data[$key] = $value;
	}
	return $data;
}

session_start();

$logged = false;
if (isset($_SESSION['MM_Username'])) {
	$colname_login = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
	mysql_select_db($database_pulsar, $pulsar);
	$query_top_login = sprintf("SELECT id_cadastro, nome, email, download, empresa, login, senha FROM cadastro WHERE login like '%s'", $colname_login);
	$top_login = mysql_query($query_top_login, $pulsar) or die(mysql_error());
	$row_top_login = mysql_fetch_assoc($top_login);
	$totalRows_top_login = mysql_num_rows($top_login);
	if($totalRows_top_login > 0)
		$logged = true;
}

if(!isset($lingua)) {
	$lingua = "br";
	$lingua = isset($_POST['lingua'])?$_POST['lingua']:$lingua;
	$lingua = isset($_SESSION['lingua'])?$_SESSION['lingua']:$lingua;
}
else {
	$_SESSION['lingua'] = $lingua;
}
include_once("language_$lingua.php");

//if(substr($_SERVER['REQUEST_URI'],-9) != "login.php") {
//echo "xxxxx<br>";
	
	if(isset($_SESSION['this_uri'])) {
		$_SESSION['last_uri'] = $_SESSION['this_uri'];
	//	echo $_SESSION['last_uri'];
	}
	$_SESSION['this_uri'] = $_SERVER['REQUEST_URI'];
//}
/*
echo "****".$_SERVER['REQUEST_URI']."<br><br>";
echo "****".$_SESSION['this_uri']."<br><br>";
echo "****".$_SESSION['last_uri']."<br><br>";
*/
if(!isset($isAdministra)) {
	foreach($_POST as $key => $value) {
		if(is_array($value)){
			$_POST[$key] = filter_arr($value);
		} else {
			$_POST[$key] = filter($value);
		}
	}
	foreach($_GET as $key => $value) {
		if(is_array($value)){
			$_GET[$key] = filter_arr($value);
		} else {
			$_GET[$key] = filter($value);
		}
	}
}
//  Alteracoes Zoca para pegar resolusao original das fotos
					
function check_int($i) { // Verifica se o tombo eh numerico
	// return 0 if not int and return 1 if $i is int
	if (ereg ( "^[0-9]+[.]?[0-9]*$", $i, $p )) {
		return 1;
	} else {
		return 0;
	} // end if
}// end check_int 

function isVideo($codigo) {
	$x;
	if ( preg_match( "/^[A-Za-z]+[0-9]+/", $codigo,$x)) {
		return 1;
	} else {
		return 0;
	} // end if
}

function delQuote($text) {
	return str_replace("\"", "", $text);
}

function addQuote($text) {
	return str_replace("'", "\'", $text);
}

function translate_idestado ($id_estado, $pulsar) {
	$sql = "SELECT Estado FROM Estados WHERE id_estado = $id_estado";
	$result = mysql_query($sql, $pulsar);
	$row = mysql_fetch_array($result);
	return $row['Estado'];
}
function translate_idtema ($id_tema, $pulsar, $lingua = "br") {
	$idioma = "";
	if($lingua != "br")
		$idioma = "_en";
	$sql = "SELECT Tema$idioma FROM temas WHERE Id = $id_tema";
	$result = mysql_query($sql, $pulsar);
	$row = mysql_fetch_array($result);	
	return $row['Tema'.$idioma];
}
function translate_idautor ($id_autor, $pulsar) {
	$sql = "SELECT Nome_Fotografo FROM fotografos WHERE id_fotografo = $id_autor";
	$result = mysql_query($sql, $pulsar);
	$row = mysql_fetch_array($result);
	return $row['Nome_Fotografo'];	
}

function translate_iduso ($id_uso, $idioma, $sig) {
	$sql = "select uso.Id, USO_TIPO.tipo_$idioma as tipo, USO_SUBTIPO.subtipo_$idioma as utilizacao, uso_formato.formato_$idioma as formato, uso_distribuicao.distribuicao_$idioma as distribuicao, uso_periodicidade.periodicidade_$idioma as periodicidade, descr.descricao_$idioma as tamanho, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor
			from USO as uso
			left join USO_TIPO on uso.id_tipo = USO_TIPO.Id
			left join USO_SUBTIPO on uso.id_utilizacao = USO_SUBTIPO.Id
			left join USO_DESC as descr on uso.id_tamanho = descr.Id
			left join uso_formato on uso.id_formato = uso_formato.id
			left join uso_distribuicao on uso.id_distribuicao = uso_distribuicao.id
			left join uso_periodicidade on uso.id_periodicidade = uso_periodicidade.id
			where uso.Id = $id_uso";
	$result = mysql_query($sql, $sig) or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	$uso = "";
	if($row['tipo']!= "")
		$uso .= $row['tipo'];
	if($row['utilizacao']!= "")
		$uso .= " - ".$row['utilizacao'];
	if($row['formato']!= "")
		$uso .= " - ".$row['formato'];
	if($row['distribuicao']!= "")
		$uso .= " - ".$row['distribuicao'];
	if($row['periodicidade']!= "")
		$uso .= " - ".$row['periodicidade'];
	if($row['tamanho']!= "")
		$uso .= " - ".$row['tamanho'];
			
	return $uso;
}

function translate_idusoTamanho ($id_uso, $idioma, $sig) {
	$sql = "select uso.Id, USO_TIPO.tipo_$idioma as tipo, USO_SUBTIPO.subtipo_$idioma as utilizacao, uso_formato.formato_$idioma as formato, uso_distribuicao.distribuicao_$idioma as distribuicao, uso_periodicidade.periodicidade_$idioma as periodicidade, descr.descricao_$idioma as tamanho, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor
	from USO as uso
	left join USO_TIPO on uso.id_tipo = USO_TIPO.Id
	left join USO_SUBTIPO on uso.id_utilizacao = USO_SUBTIPO.Id
	left join USO_DESC as descr on uso.id_tamanho = descr.Id
	left join uso_formato on uso.id_formato = uso_formato.id
	left join uso_distribuicao on uso.id_distribuicao = uso_distribuicao.id
	left join uso_periodicidade on uso.id_periodicidade = uso_periodicidade.id
	where uso.Id = $id_uso";
	$result = mysql_query($sql, $sig) or die(mysql_error());
	$row = mysql_fetch_array($result);

	$uso = "";
	if($row['tamanho']!= "")
		$uso .= $row['tamanho'];
		
	return $uso;
}

function convertPounds($reais) {
	$pounds = ceil(($reais - ($reais*0.3))*0.66);  
	return $pounds.".00";
}

function translateText($palavra, $idioma = "pt") {
	$return = array();
	if($palavra != '' && $idioma != ''){
		$palavra = preg_replace("/[¿‡¬‚ƒ‰√„¡·]/","a", $palavra);
		$palavra = preg_replace("/[»Ë ÍÀÎ…È]/","e", $palavra);
		$palavra = preg_replace("/[ÃÏŒÓœÔÕÌ]/","i", $palavra);
		$palavra = preg_replace("/[“Ú‘Ù÷ˆ’ı”Û]/","o", $palavra);
		$palavra = preg_replace("/[Ÿ˘€˚‹¸⁄˙]/","u", $palavra);
		$palavra = preg_replace("/[«Á]/","c", $palavra);
		$palavra = preg_replace("/[—Ò]/","n", $palavra);
		
//		$palavra = utf8_decode($palavra);
//		echo "http://translate.google.com/translate_a/t?client=p&text=".utf8_encode(urlencode($palavra))."&hl=en&sl=".$idioma."&tl=en&ie=ISO-8859-1&oe=ISO-8859-1&multires=1&otf=1&ssel=0&tsel=0&sc=1";
		
		$data2 = file_get_contents("http://translate.google.com/translate_a/t?client=p&text=".urlencode(utf8_encode($palavra))."&hl=".$idioma."&sl=".$idioma."&tl=en&ie=ISO-8859-1&oe=ISO-8859-1&multires=1&otf=1&ssel=0&tsel=0&sc=1");
//		echo $data2;
		$dados = json_decode(utf8_encode($data2));

		if(false) {
			echo "Array google translator: ";
			print_r($dados);
			echo "<br>";
			echo "<br>";
		}

		//			$return[] = $data[1];
		if($dados->sentences[0]->trans == "") {
			$return= $palavra;
		}
		else {
			$return= utf8_decode($dados->sentences[0]->trans);
		}
		return $return;
	}
	return $palavra;
}



?>
