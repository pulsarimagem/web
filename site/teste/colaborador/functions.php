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

function isIndio($tipo_contrato, $sig) {
	$query = "SELECT indio FROM CONTRATOS_DESC WHERE Id = $tipo_contrato";
	$result = mysql_query($query, $sig) or die(mysql_error());
	$totalRows = mysql_num_rows($result);


	if($totalRows > 0) {
		$row = mysql_fetch_assoc($result);
		if(ord($row['indio']) == 0 || ord($row['indio']) == 48)
			return false;
		else if(ord($row['indio']) == 1 || ord($row['indio']) == 49)
			return true;
	}
	return false;
}

function isIndioOld($tipo_contrato) {
	if($tipo_contrato == "5" || $tipo_contrato == "9" || $tipo_contrato == "12" || $tipo_contrato == "13" || $tipo_contrato == "15" || $tipo_contrato == "19" || $tipo_contrato == "20" || $tipo_contrato == "23" || $tipo_contrato == "24" || $tipo_contrato == "27" || $tipo_contrato == "28" || $tipo_contrato == "30" || $tipo_contrato == "32" || $tipo_contrato == "34" || $tipo_contrato == "36" || $tipo_contrato == "38")
		return true;
	return false;
}

function formatnumber($number) {
//	setlocale(LC_MONETARY, 'pt_BR');
//	$numStr = money_format($format, $number);
//	$locale = localeconv();
//	$numStr = $locale['currency_symbol'].number_format($number, 2, $locale['decimal_point'], $locale['thousands_sep']);
	$numStr = number_format($number, 2, ",", ".");
	return $numStr;
}

function isVideo($codigo) {
	$x;
	if ( preg_match( "/^[A-Za-z]+[0-9]+/", $codigo,$x)) {
		return 1;
	} else {
		return 0;
	} // end if
}

function fixnumber($number) {
	$number = str_replace(".","",$number);
	$number = str_replace(",",".",$number);
	return $number;
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

//ini_set('session.gc_maxlifetime', 5);
//ini_set('session.gc_probability',1);
//ini_set('session.gc_divisor',1);

session_start();

$logged = false;
if (isset($_SESSION['MM_Username_Fotografo'])) {
	$colname_login = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username_Fotografo'] : addslashes($_SESSION['MM_Username_Fotografo']);
	mysql_select_db($database_pulsar, $pulsar);
	$query_top_login = sprintf("SELECT * FROM fotografos WHERE Iniciais_fotografo like '%s'", $colname_login);
	$top_login = mysql_query($query_top_login, $pulsar) or die(mysql_error());
	$row_top_login = mysql_fetch_assoc($top_login);
	$row_login = $row_top_login;
	$totalRows_top_login = mysql_num_rows($top_login);
	if($totalRows_top_login > 0)
		$logged = true;
}

	
if(isset($_SESSION['this_uri'])) {
	$_SESSION['last_uri'] = $_SESSION['this_uri'];
}
$_SESSION['this_uri'] = $_SERVER['REQUEST_URI'];

?>
<?php 
/**
 * Unaccent a string 
 *
 * An example string like ÀØeÿ?????? will be translated to AOeyIOzoBY. 
 * More complete than :
 *
 *  strtr(
 *      (string)$str,
 *      "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
 *      "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"
 *  );
 *
 * @author http://www.evaisse.net/2008/php-translit-remove-accent-unaccent-21001
 * @param $str input string
 * @param $utf8 if null, function will detect input string encoding
 * @return string input string without accent
 */
function removeAccents($str, $utf8 = true) {
    $str = (string) $str;
    if (is_null($utf8)) {
        if (!function_exists('mb_detect_encoding')) {
            $utf8 = (strtolower(mb_detect_encoding($str)) == 'utf-8');
        } else {
            $length = strlen($str);
            $utf8 = true;
 
            for ($i = 0; $i < $length; $i++) {
                $c = ord($str[$i]);
 
                if ($c < 0x80) $n = 0; // 0bbbbbbb
                elseif (($c & 0xE0) == 0xC0) $n = 1; // 110bbbbb
                elseif (($c & 0xF0) == 0xE0) $n = 2; // 1110bbbb
                elseif (($c & 0xF8) == 0xF0) $n = 3; // 11110bbb
                elseif (($c & 0xFC) == 0xF8) $n = 4; // 111110bb
                elseif (($c & 0xFE) == 0xFC) $n = 5; // 1111110b
                else return false; // Does not match any model
 
                for ($j = 0; $j < $n; $j++) { // n bytes matching 10bbbbbb follow ?
                    if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80)) {
                        $utf8 = false;
                        break;
                    }
                }
            }
        }
    }
 
    if (!$utf8) {
        $str = utf8_encode($str);
    }
 
    $transliteration = array(
        '?' => 'I', 'Ö' => 'O', 'Œ' => 'O', 'Ü' => 'U', 'ä' => 'a', 'æ' => 'a',
        '?' => 'i', 'ö' => 'o', 'œ' => 'o', 'ü' => 'u', 'ß' => 's', '?' => 's',
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
        'Æ' => 'A', 'A' => 'A', 'A' => 'A', 'A' => 'A', 'Ç' => 'C', 'C' => 'C',
        'C' => 'C', 'C' => 'C', 'C' => 'C', 'D' => 'D', 'Ð' => 'D', 'È' => 'E',
        'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'E' => 'E', 'E' => 'E', 'E' => 'E',
        'E' => 'E', 'E' => 'E', 'G' => 'G', 'G' => 'G', 'G' => 'G', 'G' => 'G',
        'H' => 'H', 'H' => 'H', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'I' => 'I', 'I' => 'I', 'I' => 'I', 'I' => 'I', 'I' => 'I', 'J' => 'J',
        'K' => 'K', 'L' => 'K', 'L' => 'K', 'L' => 'K', '?' => 'K', 'L' => 'L',
        'Ñ' => 'N', 'N' => 'N', 'N' => 'N', 'N' => 'N', '?' => 'N', 'Ò' => 'O',
        'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ø' => 'O', 'O' => 'O', 'O' => 'O',
        'O' => 'O', 'R' => 'R', 'R' => 'R', 'R' => 'R', 'S' => 'S', 'S' => 'S',
        'S' => 'S', '?' => 'S', 'Š' => 'S', 'T' => 'T', 'T' => 'T', 'T' => 'T',
        '?' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'U' => 'U', 'U' => 'U',
        'U' => 'U', 'U' => 'U', 'U' => 'U', 'U' => 'U', 'W' => 'W', 'Y' => 'Y',
        'Ÿ' => 'Y', 'Ý' => 'Y', 'Z' => 'Z', 'Z' => 'Z', 'Ž' => 'Z', 'à' => 'a',
        'á' => 'a', 'â' => 'a', 'ã' => 'a', 'a' => 'a', 'a' => 'a', 'a' => 'a',
        'å' => 'a', 'ç' => 'c', 'c' => 'c', 'c' => 'c', 'c' => 'c', 'c' => 'c',
        'd' => 'd', 'd' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
        'e' => 'e', 'e' => 'e', 'e' => 'e', 'e' => 'e', 'e' => 'e', 'ƒ' => 'f',
        'g' => 'g', 'g' => 'g', 'g' => 'g', 'g' => 'g', 'h' => 'h', 'h' => 'h',
        'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'i' => 'i', 'i' => 'i',
        'i' => 'i', 'i' => 'i', 'i' => 'i', 'j' => 'j', 'k' => 'k', '?' => 'k',
        'l' => 'l', 'l' => 'l', 'l' => 'l', 'l' => 'l', '?' => 'l', 'ñ' => 'n',
        'n' => 'n', 'n' => 'n', 'n' => 'n', '?' => 'n', '?' => 'n', 'ò' => 'o',
        'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ø' => 'o', 'o' => 'o', 'o' => 'o',
        'o' => 'o', 'r' => 'r', 'r' => 'r', 'r' => 'r', 's' => 's', 'š' => 's',
        't' => 't', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'u' => 'u', 'u' => 'u',
        'u' => 'u', 'u' => 'u', 'u' => 'u', 'u' => 'u', 'w' => 'w', 'ÿ' => 'y',
        'ý' => 'y', 'y' => 'y', 'z' => 'z', 'z' => 'z', 'ž' => 'z', '?' => 'A',
        '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A',
        '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A',
        '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'A',
        '?' => 'A', '?' => 'A', '?' => 'A', '?' => 'B', 'G' => 'G', '?' => 'D',
        '?' => 'E', '?' => 'E', '?' => 'E', '?' => 'E', '?' => 'E', '?' => 'E',
        '?' => 'E', '?' => 'E', '?' => 'E', '?' => 'Z', '?' => 'I', '?' => 'I',
        '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I',
        '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I',
        '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I',
        'T' => 'T', '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I',
        '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'I',
        '?' => 'I', '?' => 'I', '?' => 'I', '?' => 'K', '?' => 'L', '?' => 'M',
        '?' => 'N', '?' => 'K', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O',
        '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'P',
        '?' => 'R', '?' => 'R', 'S' => 'S', '?' => 'T', '?' => 'Y', '?' => 'Y',
        '?' => 'Y', '?' => 'Y', '?' => 'Y', '?' => 'Y', '?' => 'Y', '?' => 'Y',
        '?' => 'Y', '?' => 'Y', 'F' => 'F', '?' => 'X', '?' => 'P', 'O' => 'O',
        '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O',
        '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O',
        '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O', '?' => 'O',
        '?' => 'O', 'a' => 'a', '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a',
        '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a',
        '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a',
        '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a', '?' => 'a',
        '?' => 'a', '?' => 'a', '?' => 'a', 'ß' => 'b', '?' => 'g', 'd' => 'd',
        'e' => 'e', '?' => 'e', '?' => 'e', '?' => 'e', '?' => 'e', '?' => 'e',
        '?' => 'e', '?' => 'e', '?' => 'e', '?' => 'z', '?' => 'i', '?' => 'i',
        '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i',
        '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i',
        '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i',
        '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 't', '?' => 'i',
        '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i',
        '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i',
        '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'i', '?' => 'k',
        '?' => 'l', 'µ' => 'm', '?' => 'n', '?' => 'k', '?' => 'o', '?' => 'o',
        '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o',
        '?' => 'o', 'p' => 'p', '?' => 'r', '?' => 'r', '?' => 'r', 's' => 's',
        '?' => 's', 't' => 't', '?' => 'y', '?' => 'y', '?' => 'y', '?' => 'y',
        '?' => 'y', '?' => 'y', '?' => 'y', '?' => 'y', '?' => 'y', '?' => 'y',
        '?' => 'y', '?' => 'y', '?' => 'y', '?' => 'y', '?' => 'y', '?' => 'y',
        '?' => 'y', '?' => 'y', 'f' => 'f', '?' => 'x', '?' => 'p', '?' => 'o',
        '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o',
        '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o',
        '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o',
        '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'o', '?' => 'A',
        '?' => 'B', '?' => 'V', '?' => 'G', '?' => 'D', '?' => 'E', '?' => 'E',
        '?' => 'Z', '?' => 'Z', '?' => 'I', '?' => 'I', '?' => 'K', '?' => 'L',
        '?' => 'M', '?' => 'N', '?' => 'O', '?' => 'P', '?' => 'R', '?' => 'S',
        '?' => 'T', '?' => 'U', '?' => 'F', '?' => 'K', '?' => 'T', '?' => 'C',
        '?' => 'S', '?' => 'S', '?' => 'Y', '?' => 'E', '?' => 'Y', '?' => 'Y',
        '?' => 'A', '?' => 'B', '?' => 'V', '?' => 'G', '?' => 'D', '?' => 'E',
        '?' => 'E', '?' => 'Z', '?' => 'Z', '?' => 'I', '?' => 'I', '?' => 'K',
        '?' => 'L', '?' => 'M', '?' => 'N', '?' => 'O', '?' => 'P', '?' => 'R',
        '?' => 'S', '?' => 'T', '?' => 'U', '?' => 'F', '?' => 'K', '?' => 'T',
        '?' => 'C', '?' => 'S', '?' => 'S', '?' => 'Y', '?' => 'E', '?' => 'Y',
        '?' => 'Y', 'ð' => 'd', 'Ð' => 'D', 'þ' => 't', 'Þ' => 'T', '?' => 'a',
        '?' => 'b', '?' => 'g', '?' => 'd', '?' => 'e', '?' => 'v', '?' => 'z',
        '?' => 't', '?' => 'i', '?' => 'k', '?' => 'l', '?' => 'm', '?' => 'n',
        '?' => 'o', '?' => 'p', '?' => 'z', '?' => 'r', '?' => 's', '?' => 't',
        '?' => 'u', '?' => 'p', '?' => 'k', '?' => 'g', '?' => 'q', '?' => 's',
        '?' => 'c', '?' => 't', '?' => 'd', '?' => 't', '?' => 'c', '?' => 'k',
        '?' => 'j', '?' => 'h',
    );
 
    return str_replace(array_keys($transliteration), array_values($transliteration), $str);
}
?>