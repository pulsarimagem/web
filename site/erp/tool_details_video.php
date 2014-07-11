<?php
$_SESSION['last_detail_erp'] = $_SERVER['REQUEST_URI'];

$lingua="br";
// include('../language_br.php');

$MMColParam_dados_foto = "0000";
if (isset($_GET['tombo'])) {
  $MMColParam_dados_foto = (get_magic_quotes_gpc()) ? $_GET['tombo'] : addslashes($_GET['tombo']);
  
// insere log de popz

//$insertSQL = sprintf("INSERT INTO log_pop (tombo, datahora) VALUES ('%s', now())", $_GET['tombo']);

mysql_select_db($database_pulsar, $pulsar);
//$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

}
mysql_select_db($database_pulsar, $pulsar);
$query_dados_foto = sprintf("SELECT 
  Fotos_tmp.Id_Foto,
  Fotos_tmp.tombo,
  Fotos_tmp.id_autor,
  fotografos.Nome_Fotografo,
  Fotos_tmp.data_foto,
  Fotos_tmp.cidade,
  Estados.Sigla,
  Fotos_tmp.orientacao,
  Fotos_tmp.dim_a,
  Fotos_tmp.dim_b,
  Fotos_tmp.extra,
  Fotos_tmp.pal_chave,
  Fotos_tmp.assunto_principal,
  videos_extra.resolucao,
  paises.nome as pais
FROM
 Fotos_tmp
 INNER JOIN fotografos ON (Fotos_tmp.id_autor=fotografos.id_fotografo)
 LEFT OUTER JOIN Estados ON (Fotos_tmp.id_estado=Estados.id_estado)
 LEFT OUTER JOIN paises ON (paises.id_pais=Fotos_tmp.id_pais)
 LEFT JOIN videos_extra ON (videos_extra.tombo = Fotos_tmp.tombo) 
WHERE
  (Fotos_tmp.tombo LIKE '%s')", $MMColParam_dados_foto);
$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
$row_dados_foto = mysql_fetch_assoc($dados_foto);
$totalRows_dados_foto = mysql_num_rows($dados_foto);


$query_codigo_video = sprintf("SELECT
		arquivo,codigo
		FROM
		codigo_video
		WHERE
		codigo LIKE '%s'", $MMColParam_dados_foto);
$codigo_video = mysql_query($query_codigo_video, $pulsar) or die(mysql_error());
$row_codigo_video = mysql_fetch_assoc($codigo_video);
$totalRows_codigo_video = mysql_num_rows($codigo_video);


$MMColParam_temas = "28433";
if (isset($_GET['tombo'])) {
  $MMColParam_temas = (get_magic_quotes_gpc()) ? $_GET['tombo'] : addslashes($_GET['tombo']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_temas = sprintf("SELECT Fotos_tmp.tombo, super_temas.Tema_total as Tema, super_temas.Id FROM super_temas INNER JOIN rel_fotos_temas_tmp ON (super_temas.Id=rel_fotos_temas_tmp.id_tema) INNER JOIN Fotos_tmp ON (Fotos_tmp.Id_Foto=rel_fotos_temas_tmp.id_foto) WHERE (Fotos_tmp.tombo = '%s')", $MMColParam_temas);
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);

mysql_select_db($database_pulsar, $pulsar);
$query_video_extra = sprintf("SELECT * FROM videos_extra WHERE tombo = '%s'", $MMColParam_dados_foto);
$video_extra = mysql_query($query_video_extra, $pulsar) or die(mysql_error());
$row_video_extra = mysql_fetch_assoc($video_extra);
$totalRows_video_extra = mysql_num_rows($video_extra);

$res_pop = "640x360";
if($row_video_extra['resolucao'] == "720x480") {
	$res_pop = "540x360";
} else if($row_video_extra['resolucao'] == "720x586") {
	$res_pop = "440x360";
}

$MMColParam_palavras = "xxxx";
if (isset($_GET['tombo'])) {
  $MMColParam_palavras = (get_magic_quotes_gpc()) ? $_GET['tombo'] : addslashes($_GET['tombo']);
}

$detail_tombo = $row_dados_foto['tombo']; 
if (! is_numeric($row_dados_foto['tombo'])) { 
	$detail_tombo.=" (original digital)";
}

$detail_local = "";
if($row_dados_foto['cidade']!= "") {
	$detail_local = "<p>Local: ".$row_dados_foto['cidade']; 
	if (($row_dados_foto['Sigla'] <> '') AND ( ( is_null($row_dados_foto['pais'])) OR ($row_dados_foto['pais'] == 'Brasil'))) { 
		if ($row_dados_foto['cidade'] <> '') {
			$detail_local .=' - ';
		}
		$detail_local .= $row_dados_foto['Sigla'];
	}
	$detail_local .= "</p>";
}
if ((!is_null($row_dados_foto['pais'])) and ($row_dados_foto['pais']!='Brasil')) {
					$detail_local .= "<p>País: ".$row_dados_foto['pais']."</p>";
}

$detail_data = "";
if (strlen($row_dados_foto['data_foto']) == 4) {
	$detail_data .= $row_dados_foto['data_foto'];
} elseif (strlen($row_dados_foto['data_foto']) == 6) {
	$detail_data .= substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
} elseif (strlen($row_dados_foto['data_foto']) == 8) {
	$detail_data .= substr($row_dados_foto['data_foto'],6,2).'/'.substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
}

$detail_autor = "<a href=\"listing.php?pa_action=&tipo=inc_pa.php&id_autor[]=".$row_dados_foto['id_autor']."&horizontal=H&vertical=V\">".$row_dados_foto['Nome_Fotografo']."</a>";

$detail_dim = "";

/*
$file = "/var/fotos_alta/".$row_dados_foto['tombo'].".jpg";

if (!file_exists($file)) {				// check se o arquivo existe com extensao jpg e JPG
	$file = "/var/fotos_alta/".$row_dados_foto['tombo'].".JPG";
}

if (file_exists($file)) {				// se existir, abre e imprime a resolucao
	$getimgsize = getimagesize($file);

	if ($getimgsize) {
		list($width, $height, $type, $attr) = $getimgsize; 
                
		$detail_dim .= "Dimensões da imagem: ".$width." px X ".$height." px   -   300 DPI. Caso necessite esse arquivo em outras dimensões, <a href=\"contato.php\">entre em contato.</a><br/><br/>";
	}
}
*/
if($row_dados_foto['dim_a']!=NULL &&$row_dados_foto['dim_a']!=0) {
	$detail_dim .= "Dimensões da imagem: ".$row_dados_foto['dim_a']." px X ".$row_dados_foto['dim_b']." px.</a><br/><br/>";
}


$tombo = "";
if(isset($_GET['tombo'])) {
	$tombo = $_GET['tombo'];
}
$search = "";
if(isset($_GET['search'])) {
	$search = $_GET['search'];
}
$show_addimg = false;
// Carregar pastas
if((isset($_GET['addimg'])) || (isset($_GET['action'])&&(isset($_GET['nova_pasta']) && ($_GET['nova_pasta'] != "")))) {

	include("tool_auth.php");

	$show_addimg = true;
	
	if (isset($_GET['nova_pasta'])&&($_GET['nova_pasta']!="")) {
		$insertSQL = sprintf("INSERT INTO pastas (id_cadastro, nome_pasta, data_cria, data_mod) VALUES (%s, '%s', now(),now())", $row_top_login['id_cadastro'], $_GET['nova_pasta']);
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
		
		$getidSQL = sprintf("SELECT id_pasta FROM pastas WHERE id_cadastro = %s ORDER BY id_pasta DESC LIMIT 1", $row_top_login['id_cadastro']);
		mysql_select_db($database_pulsar, $pulsar);
		$insert_id = mysql_query($getidSQL, $pulsar) or die(mysql_error());
		$row_insert_id =  mysql_fetch_assoc($insert_id);
		$_GET['id_pasta'][] = $row_insert_id['id_pasta'];
	}
	if(isset($_GET['action']) && ($_GET['action'] == "Enviar")) {
		$show_addimg = false;
	}
	$colname_pastas = "1";
	if (isset($_SESSION['MM_Username'])) {
		$colname_pastas = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
	}
	mysql_select_db($database_pulsar, $pulsar);
	$query_pastas = sprintf("SELECT pastas.id_pasta,   pastas.nome_pasta 	FROM cadastro  INNER JOIN pastas ON (cadastro.id_cadastro=pastas.id_cadastro) WHERE (cadastro.login LIKE '%s') GROUP BY pastas.id_pasta ORDER BY pastas.nome_pasta", $colname_pastas);
	$pastas = mysql_query($query_pastas, $pulsar) or die(mysql_error());
	$row_pastas = mysql_fetch_assoc($pastas);
	$totalRows_pastas = mysql_num_rows($pastas);
}

// Codigo cotar

if ((isset($_GET["cotar"])) && ($_GET["cotar"] == "true")) {

	include("tool_auth.php");
	
	$insertSQL = sprintf("INSERT IGNORE INTO cotacao (tombo, id_cadastro, `data`) VALUES (%s, %s, now())",
                       GetSQLValueString($tombo, "text"),
                       GetSQLValueString($row_top_login['id_cadastro'], "int"));

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
  echo "<script>alert('Foto adicionada com sucesso.\\n**Visite a seção COTAÇÃO para concluir o processo.** ')</script>";
}


// Codigo adicionar a minhas imagens

if(isset($_GET['action']) && ($_GET['action'] == "Enviar")) {
	// que pastas já tem esta foto
	$quem_fecha="sim";
	mysql_select_db($database_pulsar, $pulsar);
	$query_jatem = sprintf("
	SELECT 
	  pasta_fotos.tombo,
	  pastas.nome_pasta
	FROM
	 pasta_fotos
	 INNER JOIN pastas ON (pasta_fotos.id_pasta=pastas.id_pasta)
	WHERE
	  pasta_fotos.tombo = '%s'
	AND
	 (pasta_fotos.id_pasta in (%s))
	ORDER BY 
	 pastas.nome_pasta
	", $_GET['tombo'], implode(',',$_GET['id_pasta']));
	$jatem = mysql_query($query_jatem, $pulsar) or die(mysql_error());
	$row_jatem = mysql_fetch_assoc($jatem);
	$totalRows_jatem = mysql_num_rows($jatem);
	$quem_jatem = "";
	if ($totalRows_jatem > 0) { // Show if recordset not empty
		do {
			//		$quem_jatem = "&quot;".$row_jatem['nome_pasta']."&quot;, ";
			$quem_jatem .= $row_jatem['nome_pasta'].", ";
		} while ($row_jatem = mysql_fetch_assoc($jatem));
		$quem_jatem = substr($quem_jatem,0,-2) . ".";
	} // Show if recordset not empty

	// inclui a imagem nas pastas

	$stringglue = ",'".$_GET['tombo']."'),(";
	$insertSQL = "INSERT IGNORE INTO pasta_fotos (id_pasta, tombo) VALUES (".implode($stringglue,$_GET['id_pasta']).",'".$_GET['tombo']."')";

	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	 
	$insertSQL = "UPDATE pastas SET data_mod = '".date("Y-m-d", strtotime('now'))."' WHERE id_pasta IN (".implode(",",$_GET['id_pasta']).")";

	$Result2 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

	/*
	 $updateGoTo = "Cgerenciador.php?jatem=".$quem_jatem;
	 if (isset($_SERVER['QUERY_STRING'])) {
	 $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
	 $updateGoTo .= $_SERVER['QUERY_STRING'];
	 }
	 */
}

$ordem_prev = -1;
$ordem_next = -1;
$ordem_foto = -1;
$total_foto = -1;
if(isset($_SESSION['ultima_pesquisa_erp'])&&isset($_GET['ordem_foto'])&&isset($_GET['total_foto'])) {
	$tombo_array = explode('|',$_SESSION['ultima_pesquisa_erp']);
	$ordem_foto = $_GET['ordem_foto'];
	$scroll_startpos = $ordem_foto;
	$total_foto = $_GET['total_foto'];
	if($ordem_foto > 0) {
		$ordem_prev = $ordem_foto - 1;
	}
	if($ordem_foto < $total_foto - 1) {
		$ordem_next = $ordem_foto + 1;
	}
}
?>