<?php 
$idiomas = array ("br","en");

include("inc_menu.php");
$menu = new erpMenu();

function _get($name)
{
	return strip_tags($_GET[$name]);
}
function _post($name)
{
	return strip_tags($_POST[$name]);
}
function _any($name)
{
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	if(isset($_GET[$name]))
		return strip_tags($_GET[$name]);
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	if(isset($_POST[$name]))
		return strip_tags($_POST[$name]);
	return false;
}

#	BuildNav for Dreamweaver MX v0.2
#              10-02-2002
#	Alessandro Crugnola [TMM]
#	sephiroth: alessandro@sephiroth.it
#	http://www.sephiroth.it
#	
#	Function for navigation build ::
function buildNavigation3($pageNum_Recordset1,$totalPages_Recordset1,$prev_Recordset1,$next_Recordset1,$separator=" | ",$max_links=10, $show_page=true)
{
GLOBAL $maxRows_palavra_chave,$totalRows_palavra_chave;
	$pagesArray = ""; $firstArray = ""; $lastArray = "";
	if($max_links<2)$max_links=2;
	if($pageNum_Recordset1<=$totalPages_Recordset1 && $pageNum_Recordset1>=0)
	{
		if ($pageNum_Recordset1 > ceil($max_links/2))
		{
			$fgp = $pageNum_Recordset1 - ceil($max_links/2) > 0 ? $pageNum_Recordset1 - ceil($max_links/2) : 1;
			$egp = $pageNum_Recordset1 + ceil($max_links/2);
			if ($egp >= $totalPages_Recordset1)
			{
				$egp = $totalPages_Recordset1+1;
				$fgp = $totalPages_Recordset1 - ($max_links-1) > 0 ? $totalPages_Recordset1  - ($max_links-1) : 1;
			}
		}
		else {
			$fgp = 0;
			$egp = $totalPages_Recordset1 >= $max_links ? $max_links : $totalPages_Recordset1+1;
		}
		if($totalPages_Recordset1 >= 1) {
			#	------------------------
			#	Searching for $_GET vars
			#	------------------------
			$_get_vars = '';			
			if(!empty($_GET) || !empty($HTTP_GET_VARS)){
				$_GET = empty($_GET) ? $HTTP_GET_VARS : $_GET;
				foreach ($_GET as $_get_name => $_get_value) {
					if ($_get_name != "pageNum_palavra_chave") {
						$_get_vars .= "&$_get_name=$_get_value";
					}
				}
			}
			$successivo = $pageNum_Recordset1+1;
			$precedente = $pageNum_Recordset1-1;
 			$firstArray = ($pageNum_Recordset1 > 0) ? "<li><a href=\"$_SERVER[PHP_SELF]?pageNum_palavra_chave=$precedente$_get_vars\">$prev_Recordset1</a></li>" :  "<li class='disabled><a>$prev_Recordset1</a></li>";
//			$firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_palavra_chave=$precedente$_get_vars\">$prev_Recordset1</a>" :  "$prev_Recordset1";
//			$firstArray = "<li>".$firstArray."</a></li>";
			# ----------------------
			# page numbers
			# ----------------------
			for($a = $fgp+1; $a <= $egp; $a++){
				$theNext = $a-1;
				if($show_page)
				{
					$textLink = $a;
				} else {
					$min_l = (($a-1)*$maxRows_palavra_chave) + 1;
					$max_l = ($a*$maxRows_palavra_chave >= $totalRows_palavra_chave) ? $totalRows_palavra_chave : ($a*$maxRows_palavra_chave);
					$textLink = "$min_l - $max_l";
				}
				$_ss_k = floor($theNext/26);
				if ($theNext != $pageNum_Recordset1)
				{
					$pagesArray .= "<li><a href=\"$_SERVER[PHP_SELF]?pageNum_palavra_chave=$theNext$_get_vars\">";
//					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_palavra_chave=$theNext$_get_vars\">";
					$pagesArray .= "$textLink</a><li>" . ($theNext < $egp-1 ? $separator : "");
				} else {
					$pagesArray .= "<li class='active'><a>$textLink</a></li>"  . ($theNext < $egp-1 ? $separator : "");
				}
			}
			$theNext = $pageNum_Recordset1+1;
			$offset_end = $totalPages_Recordset1;
			$lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<li><a href=\"$_SERVER[PHP_SELF]?pageNum_palavra_chave=$successivo$_get_vars\">$next_Recordset1</a></li>" : "<li class='disabled'><a>$next_Recordset1</a></li>";
// 			$lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_palavra_chave=$successivo$_get_vars\">$next_Recordset1</a>" : "$next_Recordset1";
		}
	}
	return array($firstArray,$pagesArray,$lastArray);
}

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

function DoFormatNumber($theObject,$NumDigitsAfterDecimal,$DecimalSeparator,$GroupDigits) {
	$currencyFormat=number_format($theObject,$NumDigitsAfterDecimal,$DecimalSeparator,$GroupDigits);
	return ($currencyFormat);
}

function makeStamp($theString) {
	if (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/", $theString, $strReg)) {
		$theStamp = mktime($strReg[4],$strReg[5],$strReg[6],$strReg[2],$strReg[3],$strReg[1]);
	} else if (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/", $theString, $strReg)) {
		$theStamp = mktime(0,0,0,$strReg[2],$strReg[3],$strReg[1]);
	} else if (preg_match("/([0-9]{2}):([0-9]{2}):([0-9]{2})/", $theString, $strReg)) {
		$theStamp = mktime($strReg[1],$strReg[2],$strReg[3],0,0,0);
	}
	return $theStamp;
}

function makeDateTime($theString, $theFormat) {
	$theDate=date($theFormat, makeStamp($theString));
	return $theDate;
}

function translate_iduso_array ($id_uso, $idioma, $sig) {
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

	return $row;
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

function isContratoVideo($tipo_contrato, $sig) {
	$query = "SELECT tipo FROM CONTRATOS_DESC WHERE Id = $tipo_contrato";
	$result = mysql_query($query, $sig) or die(mysql_error());
	$totalRows = mysql_num_rows($result);


	if($totalRows > 0) {
		$row = mysql_fetch_assoc($result);
		if($row['tipo'] == "F")
			return false;
		else if($row['tipo'] == "V")
			return true;
	}
	return false;
}

function isVideo($codigo) {
	$x;
	if ( preg_match( "/^[A-Za-z]+[0-9]+/", $codigo,$x)) {
		return 1;
	} else {
		return 0;
	} // end if
}
function isIndioOld($tipo_contrato) {
	if($tipo_contrato == "5" || $tipo_contrato == "9" || $tipo_contrato == "12" || $tipo_contrato == "13" || $tipo_contrato == "15" || $tipo_contrato == "19" || $tipo_contrato == "20" || $tipo_contrato == "23" || $tipo_contrato == "24" || $tipo_contrato == "27" || $tipo_contrato == "28" || $tipo_contrato == "30" || $tipo_contrato == "32" || $tipo_contrato == "34" || $tipo_contrato == "36" || $tipo_contrato == "38")
		return true;
	return false;
}
function get_tribos() {
//	$indios = array("Kalapalo" => 0, "Caingangue" => 0, "Bororo" => 0, "Yanomami" => 0, "Kamayurá" => 0, "Xavante" => 0, "Yawalapiti" => 0, "Guarani" => 0, "Kambeba" => 0, "Kolulu" => 0, "Kaingang" => 0, "Tukano" => 0, "Kayapo" => 0, "Kayapó" => 0, "Kuikuro" => 0, "Maiá" => 0, "Maturacá" => 0 , "Guarani-Kaiowa" => 0, "Guarani-Kaiowas" => 0);
	$indios = array("Kalapalo" => 0,  "Yanomami" => 0, "Kamayurá" => 0, "Xavante" => 0, "Yawalapiti" => 0, "Guarani" => 0, "Kambeba" => 0, "Tukano" => 0, "Kayapo" => 0, "Kayapó" => 0, "Kuikuro" => 0, "Maiá" => 0, "Maturacá" => 0 , "Guarani-Kaiowa" => 0, "Guarani-Kaiowas" => 0, "Surui" => 0, "Suruí" => 0, "Paresi" => 0);
	return $indios;	
}

function getTribos($sig) {
	$indios = array();
	$sql = "SELECT GROUP_CONCAT(tribo SEPARATOR ';') AS tribos1, GROUP_CONCAT(sinonimos SEPARATOR ';') as tribos2 FROM (SELECT * FROM indios ORDER BY LENGTH(tribo) DESC) as indios";
	$obj = mysql_query($sql, $sig) or die(mysql_error());
	$row = mysql_fetch_array($obj);
	$tribos_concat = $row['tribos1'].";".$row['tribos2'];
	$tribos_arr = explode(';',$tribos_concat);
	foreach ($tribos_arr as $tribo) {
		$indios[$tribo] = 0;
	}
	return $indios;
}

function matchTribos($str, $tribo) {
	if(stristr($str,$tribo)!==false) {
		if(stristr($str,$tribo."-")!==false)
			return false;
		else
			return true;
	}
	else {
		return false;
	}
}
function mergeTribos(&$tribos, $sig) {
	$same_tribos = array();
	$sql = "SELECT tribo, sinonimos FROM indios WHERE sinonimos IS NOT NULL";
	$obj = mysql_query($sql, $sig) or die(mysql_error());
	while($row = mysql_fetch_array($obj)) {
		$sinonimos = $row['sinonimos'];
		$sinonimos_arr = explode(';',$sinonimos);
		foreach ($sinonimos_arr as $sinonimo) {
			$same_tribos[$row['tribo']] = $sinonimo;
		}
	}
	foreach($same_tribos as $tribo => $same_tribo) {
//		echo "Antes: $tribos[$same_tribo]<br>";
		$tribos[$same_tribo] += $tribos[$tribo];
		$tribos[$tribo] = 0;
//		echo "Depois: $tribos[$same_tribo]<br>";
	}
}

function merge_tribos(&$tribos) {
	$same_tribos = array("Kaingang" => "Caingangue", "Kolulu" => "Yanomami", "Kayapo" => "Kayapó", "Guarani-Kaiowas" => "Guarani-Kaiowa", "Surui" => "Suruí");
	
	foreach($same_tribos as $tribo => $same_tribo) {
//		echo "Antes: $tribos[$same_tribo]<br>";
		$tribos[$same_tribo] += $tribos[$tribo];
		$tribos[$tribo] = 0;
//		echo "Depois: $tribos[$same_tribo]<br>";
	}
}

function fixContrato($id_contrato,$sig) {
	$fix_cromos = "UPDATE CROMOS SET VALOR_FINAL = cast(replace(VALOR,',','.') as decimal(10,2))-cast(replace(DESCONTO,',','.') as decimal(10,2)) WHERE ID_CONTRATO = $id_contrato";
	mysql_query($fix_cromos,$sig);
	$fix_contrato = "UPDATE CONTRATOS SET VALOR_TOTAL = replace((select sum(cast(replace(VALOR,',','.') as decimal(10,2))-cast(replace(DESCONTO,',','.') as decimal(10,2))) as total from CROMOS where ID_CONTRATO = $id_contrato),'.',',') WHERE ID = $id_contrato";
	mysql_query($fix_contrato,$sig);
}

function strtolower_clean($str) {
	$caracteres_especiais = array('Š'=>'S', 'š'=>'s', 'Ğ'=>'Dj',''=>'Z', ''=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A','Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I','Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U','Û'=>'U', 'Ü'=>'U', 'İ'=>'Y', 'Ş'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a','å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ğ'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ı'=>'y', 'ı'=>'y', 'ş'=>'b', 'ÿ'=>'y', 'ƒ'=>'f');
	return strtolower(strtr($str,$caracteres_especiais));
}

function strtolower_br($term) {
	$palavra = strtr(strtolower($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏĞÑÒÓÔÕÖ×ØÙÜÚŞß","àáâãäåæçèéêëìíîïğñòóôõö÷øùüúşÿ");
	return $palavra;
}

function strtoupper_br($term) {
	$palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïğñòóôõö÷øùüúşÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏĞÑÒÓÔÕÖ×ØÙÜÚŞß");
	return $palavra;
}

function removeAccent($palavra) {
	$palavra = preg_replace("/[àâäãá]/","a", $palavra);
	$palavra = preg_replace("/[èêëé]/","e", $palavra);
	$palavra = preg_replace("/[ìîïí]/","i", $palavra);
	$palavra = preg_replace("/[òôöõó]/","o", $palavra);
	$palavra = preg_replace("/[ùûüú]/","u", $palavra);
	$palavra = preg_replace("/[ç]/","c", $palavra);
	$palavra = preg_replace("/[ñ]/","n", $palavra);
	return $palavra;
}

function clearInput($input) {
	$input = str_replace("  "," ",$input);
	$input = trim($input);
	return $input;
}

function translateText($palavra, $idioma = "pt") {
	$return = array();
	if($palavra != '' && $idioma != ''){
		$palavra = preg_replace("/[ÀàÂâÄäÃãÁá]/","a", $palavra);
		$palavra = preg_replace("/[ÈèÊêËëÉé]/","e", $palavra);
		$palavra = preg_replace("/[ÌìÎîÏïÍí]/","i", $palavra);
		$palavra = preg_replace("/[ÒòÔôÖöÕõÓó]/","o", $palavra);
		$palavra = preg_replace("/[ÙùÛûÜüÚú]/","u", $palavra);
		$palavra = preg_replace("/[Çç]/","c", $palavra);
		$palavra = preg_replace("/[Ññ]/","n", $palavra);

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

function translateV2($strWord, $strLanguage = 'en', $strLanguageStart = 'pt',$strEncode = 'UTF-8')
{
	$strKeyAPI = 'AIzaSyDUXJdrrSk4Fk6G43Ga8xSOtXP1seWecJg';
	$strUrl = 'https://www.googleapis.com/language/translate/v2?key=';
	$arrExcludeWord = array('do');

	if(!in_array($strWord, $arrExcludeWord))
	{
		$strWord = utf8_encode($strWord);
		$objCurl = curl_init($strUrl.$strKeyAPI.'&q=' . rawurlencode($strWord) . '&source='.$strLanguageStart.'&target='.$strLanguage.'');
		curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, true);
		$arrReturn = json_decode(curl_exec($objCurl),true);
		//$jsonReturnCode = curl_getinfo($objCurl, CURLINFO_HTTP_CODE);
		curl_close($objCurl);
			
		if(isset($arrReturn['data']['translations'][0]['translatedText']))
		{
			return utf8_decode($arrReturn['data']['translations'][0]['translatedText']);
		}
		else
		{
			return utf8_decode($strWord);
		}
	}
	else
	{
		return $strWord;
	}

}

function formatdate($date) {
	$objDate = new DateTime($date);
	$fixDate = $objDate->format('d/m/Y');
	return $fixDate;
}
function formatcurrency($number) {
	$number = str_replace(".",",",$number);
	return "R$ ".$number;
}

function formatnumber($number) {
//	setlocale(LC_MONETARY, 'pt_BR');
//	$numStr = money_format($format, $number);
//	$locale = localeconv();
//	$numStr = $locale['currency_symbol'].number_format($number, 2, $locale['decimal_point'], $locale['thousands_sep']);
	$numStr = number_format($number, 2, ",", ".");
	return $numStr;
}

function convertPounds($reais) {
	$pounds = ceil(($reais - ($reais*0.3))*0.66);
	return $pounds.".00";
}

function fixnumber($number) {
	$number = str_replace(".","",$number);
	$number = str_replace(",",".",$number);
	return $number;
}

function replacedot($number) {
	$number = str_replace(".",",",$number);
	return $number;
}

function right($value, $count){
	$value = substr($value, (strlen($value) - $count), strlen($value));
	return $value;
}

function left($string, $count){
	return substr($string, 0, $count);
}

function getMonthName($month) {
	$arr_month = array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
	return $arr_month[$month-1];
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
function fix_iptc_date($iptcDate) {
	if (strlen($iptcDate) == 0) {
		return $iptcDate;
	}
	else if (strlen($iptcDate) == 4) {
		return $iptcDate;
	}
	else if (strlen($iptcDate) == 7) {
		return substr($iptcDate, 3,4).substr($iptcDate, 0,2);
	}
	else if (strlen($iptcDate) == 10) {
		return substr($iptcDate, 6,4).substr($iptcDate, 3,2).substr($iptcDate, 0,2);
	}
	return strlen($iptcDate);
}
function output_all_iptc($image_path) {
	$size = getimagesize ( $image_path, $info );
	if (is_array ( $info )) {
		$iptc = iptcparse ( $info ["APP13"] );
		foreach ( array_keys ( $iptc ) as $s ) {
			$c = count ( $iptc [$s] );
			for($i = 0; $i < $c; $i ++) {
				echo $s . ' = ' . $iptc [$s] [$i] . '<br>';
			}
		}
	}
}
function output_iptc_data($image_path) {
	$iptc_pal = "";
	$size = getimagesize ( $image_path, $info );
	if (is_array ( $info )) {
		$iptc = iptcparse ( $info ["APP13"] );
		
		$c = count ( $iptc ["2#025"] );
		
		for($i = 0; $i < $c; $i ++) {
			if (valid_utf8 ( $iptc ["2#025"] [$i] )) {
				$iptc ["2#025"] [$i] = mb_convert_encoding ( $iptc ["2#025"] [$i], "iso-8859-1", "UTF-8" );
			}
			
// 			echo $iptc ["2#025"] [$i] . '<br>';
			$iptc_pal .= $iptc ["2#025"] [$i] . ";";
		}
	}
	return $iptc_pal;
}
function output_iptc_caption($image_path) {
	$caption = "";
	$size = getimagesize ( $image_path, $info );
	if (is_array ( $info )) {
		$iptc = iptcparse ( $info ["APP13"] );
		/*
		 * if (valid_utf8($iptc["2#120"][0])) { $iptc["2#120"][0]=mb_convert_encoding($iptc["2#120"][0],"iso-8859-1","UTF-8"); } $caption = $iptc["2#120"][0]; if(isset($iptc["1#090"]) && $iptc["1#090"][0] == "\x1B%G") $caption = utf8_decode($IPTC_Caption);
		 */
		$caption = str_replace ( "\000", "", $iptc ["2#120"] [0] );
		if (isset ( $iptc ["1#090"] ) && $iptc ["1#090"] [0] == "\x1B%G")
			$caption = utf8_decode ( $caption );
	}
	return $caption;
}
function get_iptc_caption($image_path) {
	$IPTC_Caption = "";
	$size = getimagesize ( $image_path, $info );
	if (is_array ( $info )) {
		$iptc = iptcparse ( $info ["APP13"] );
		
		$IPTC_Caption = str_replace ( "\000", "", $iptc ["2#120"] [0] );
		if (isset ( $iptc ["1#090"] ) && $iptc ["1#090"] [0] == "\x1B%G")
			$IPTC_Caption = utf8_decode ( $IPTC_Caption );
	}
	return $IPTC_Caption;
}
function valid_1byte($char) {
	if (! is_int ( $char ))
		return false;
	return ($char & 0x80) == 0x00;
}
function valid_2byte($char) {
	if (! is_int ( $char ))
		return false;
	return ($char & 0xE0) == 0xC0;
}
function valid_3byte($char) {
	if (! is_int ( $char ))
		return false;
	return ($char & 0xF0) == 0xE0;
}
function valid_4byte($char) {
	if (! is_int ( $char ))
		return false;
	return ($char & 0xF8) == 0xF0;
}
function valid_nextbyte($char) {
	if (! is_int ( $char ))
		return false;
	return ($char & 0xC0) == 0x80;
}
function valid_utf8($string) {
	$len = strlen ( $string );
	$i = 0;
	while ( $i < $len ) {
		$char = ord ( substr ( $string, $i ++, 1 ) );
		if (valid_1byte ( $char )) { // continue
			continue;
		} else if (valid_2byte ( $char )) { // check 1 byte
			if (! valid_nextbyte ( ord ( substr ( $string, $i ++, 1 ) ) ))
				return false;
		} else if (valid_3byte ( $char )) { // check 2 bytes
			if (! valid_nextbyte ( ord ( substr ( $string, $i ++, 1 ) ) ))
				return false;
			if (! valid_nextbyte ( ord ( substr ( $string, $i ++, 1 ) ) ))
				return false;
		} else if (valid_4byte ( $char )) { // check 3 bytes
			if (! valid_nextbyte ( ord ( substr ( $string, $i ++, 1 ) ) ))
				return false;
			if (! valid_nextbyte ( ord ( substr ( $string, $i ++, 1 ) ) ))
				return false;
			if (! valid_nextbyte ( ord ( substr ( $string, $i ++, 1 ) ) ))
				return false;
		} // goto next char
	}
	return true; // done
}

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
			'C' => 'C', 'C' => 'C', 'C' => 'C', 'D' => 'D', 'Ğ' => 'D', 'È' => 'E',
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
			'Ÿ' => 'Y', 'İ' => 'Y', 'Z' => 'Z', 'Z' => 'Z', '' => 'Z', 'à' => 'a',
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
			'ı' => 'y', 'y' => 'y', 'z' => 'z', 'z' => 'z', '' => 'z', '?' => 'A',
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
			'?' => 'Y', 'ğ' => 'd', 'Ğ' => 'D', 'ş' => 't', 'Ş' => 'T', '?' => 'a',
			'?' => 'b', '?' => 'g', '?' => 'd', '?' => 'e', '?' => 'v', '?' => 'z',
			'?' => 't', '?' => 'i', '?' => 'k', '?' => 'l', '?' => 'm', '?' => 'n',
			'?' => 'o', '?' => 'p', '?' => 'z', '?' => 'r', '?' => 's', '?' => 't',
			'?' => 'u', '?' => 'p', '?' => 'k', '?' => 'g', '?' => 'q', '?' => 's',
			'?' => 'c', '?' => 't', '?' => 'd', '?' => 't', '?' => 'c', '?' => 'k',
			'?' => 'j', '?' => 'h',
	);

	return str_replace(array_keys($transliteration), array_values($transliteration), $str);
}

function curl_request_async($url, $params, $type='POST')
{
	foreach ($params as $key => &$val) {
		if (is_array($val)) $val = implode(',', $val);
		$post_params[] = $key.'='.urlencode($val);
	}
	$post_string = implode('&', $post_params);

	$parts=parse_url($url);

	$fp = fsockopen($parts['host'],
			isset($parts['port'])?$parts['port']:80,
			$errno, $errstr, 30);

	// Data goes in the path for a GET request
	if('GET' == $type) $parts['path'] .= '?'.$post_string;

	$out = "$type ".$parts['path']." HTTP/1.1\r\n";
	$out.= "Host: ".$parts['host']."\r\n";
	$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
	$out.= "Content-Length: ".strlen($post_string)."\r\n";
	$out.= "Connection: Close\r\n\r\n";
	// Data goes in the request body for a POST request
	if ('POST' == $type && isset($post_string)) $out.= $post_string;
	//echo $out."<br>";
	fwrite($fp, $out);
	fclose($fp);
}


$print = isset($_GET['print'])?true:false;

//ini_set('session.gc_maxlifetime', 5);
//ini_set('session.gc_probability',1);
//ini_set('session.gc_divisor',1);

session_start();

$logged = false;
if (isset($_SESSION['MM_Username_erp'])) {
	$colname_login = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username_erp'] : addslashes($_SESSION['MM_Username_erp']);
	//$query_top_login = sprintf("SELECT * FROM USUARIOS WHERE usuario like '%s'", $colname_login);
	$query_top_login = sprintf("SELECT *,USUARIOS.nome as login FROM USUARIOS left join roles on roles.id = USUARIOS.role WHERE USUARIOS.usuario like '%s'", $colname_login);
	$top_login = mysql_query($query_top_login, $sig) or die(mysql_error());
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
