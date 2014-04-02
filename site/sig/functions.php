<?php 
$idiomas = array ("br","en");

$opt_menu = array	("Relatório de Comissões"=>"menu_consulta.php?has_deate=true&has_autores=true&has_luis=true&title=Relatório de Comissões&redirect=relatorio_comissoes.php",
					"Relatório de Vendas"=>"menu_consulta.php?has_deate=true&has_autores=true&title=Relatório de Vendas&redirect=relatorio_vendas.php",
					"Relatório de Contratos"=>"menu_consulta.php?has_deate=true&has_fantasia=true&has_simples=true&title=Relatório de Contratos&redirect=consulta_contrato_busca.php&relatorio=true",
					"Relatório de Cromos"=>"menu_consulta.php?has_combobox=true&has_deate=true&has_codigo=true&title=Relatório de Cromos&redirect=consulta_contrato_busca.php&cromos=true",
					"Relatório de Licenças de Cromos"=>"menu_consulta.php?has_codigo=true&title=Relatório de Licenças de Cromos&redirect=relatorio_cromos_licenca.php",
					"Novo Contrato"=>"menu_consulta.php?has_fantasia=true&has_razao&title=Novo Contrato&redirect=consulta_contrato_busca.php&novo=true",
					"Consulta de Contratos"=>"menu_consulta.php?has_contrato&has_deate=true&has_fantasia=true&title=Consulta de Contratos&redirect=consulta_contrato_busca.php",
					"Baixa de Contratos"=>"menu_consulta.php?has_contrato&has_deate=true&has_fantasia=true&has_lote=true&title=Baixa de Contratos&redirect=consulta_contrato_baixa.php&baixa=true",
					"Excluir Contratos"=>"menu_consulta.php?has_contrato&has_deate=true&has_fantasia=true&title=Excluir Contratos&redirect=consulta_contrato_busca.php&delete=true",
					"Consulta Clientes"=>"menu_consulta.php?btnNovo=true&has_fantasia=true&has_razao&title=Consulta Clientes&redirect=consulta_contrato_busca.php&cliente=true",
					"Consulta Autores"=>"menu_consulta.php?btnNovo=true&has_autor=true&has_sigla=true&title=Consulta Autores&redirect=consulta_autor.php",
					"Administração de Contratos"=>"adm_contratos.php",
					"Administração de Uso"=>"adm_uso_tipo.php",
					"Administração de Preços"=>"adm_precos.php",
					"Alterar Senha"=>"alterar_senha.php");


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
	$indios = array("Kalapalo" => 0,  "Yanomami" => 0, "Kamayurá" => 0, "Xavante" => 0, "Yawalapiti" => 0, "Guarani" => 0, "Kambeba" => 0, "Tukano" => 0, "Kayapo" => 0, "Kayapó" => 0, "Kuikuro" => 0, "Maiá" => 0, "Maturacá" => 0 , "Guarani-Kaiowa" => 0, "Guarani-Kaiowá" => 0, "Surui" => 0, "Suruí" => 0, "Paresi" => 0, "Kapinawá" => 0, "Kapinawa" => 0, "Guató" => 0, "Guato" => 0, "Umutina" => 0, "Waurá" => 0, "Waujá" => 0, "Umutina" => 0, "Enawene nawe" => 0, "Enawenê nawê" => 0); //"Guarani-Kaiowas" => 0, "Guarani-Kaiowás" => 0
	return $indios;	
}


function merge_tribos(&$tribos) {
	$same_tribos = array("Kaingang" => "Caingangue", "Kolulu" => "Yanomami", "Kayapo" => "Kayapó", "Guarani-Kaiowá" => "Guarani-Kaiowa", "Surui" => "Suruí", "Kapinawá" => "Kapinawa", "Guató" => "Guato", "Waujá" => "Waurá", "Enawenê nawê" => "Enawene nawe"); //"Guarani-Kaiowás" => "Guarani-Kaiowa","Guarani-Kaiowas" => "Guarani-Kaiowa",  
	
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
	$caracteres_especiais = array('Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A','Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I','Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U','Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a','å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f');
	return strtolower(strtr($str,$caracteres_especiais));
}

function strtolower_br($term) {
	$palavra = strtr(strtolower($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
	return $palavra;
}

function strtoupper_br($term) {
	$palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
	return $palavra;
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

$print = isset($_GET['print'])?true:false;

//ini_set('session.gc_maxlifetime', 5);
//ini_set('session.gc_probability',1);
//ini_set('session.gc_divisor',1);

session_start();

$logged = false;
if (isset($_SESSION['MM_Username_Sig'])) {
	$colname_login = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username_Sig'] : addslashes($_SESSION['MM_Username_Sig']);
	$query_top_login = sprintf("SELECT * FROM USUARIOS WHERE usuario like '%s'", $colname_login);
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
