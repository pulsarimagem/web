<?php 
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
?>
