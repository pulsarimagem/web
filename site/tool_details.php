<?php
$_SESSION['last_detail'] = $_SERVER['REQUEST_URI'];

$MMColParam_dados_foto = "0000";
if (isset($_GET['tombo'])) {
  $MMColParam_dados_foto = (get_magic_quotes_gpc()) ? $_GET['tombo'] : addslashes($_GET['tombo']);
  
// insere log de popz

$insertSQL = sprintf("INSERT INTO log_pop (tombo, datahora, ip) VALUES ('%s', now(), '%s')", $_GET['tombo'], $_SERVER['REMOTE_ADDR']);

mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

}
mysql_select_db($database_pulsar, $pulsar);
$query_dados_foto = sprintf("SELECT 
  Fotos.Id_Foto,
  Fotos.tombo,
  Fotos.id_autor,
  fotografos.Nome_Fotografo,
  Fotos.data_foto,
  Fotos.cidade,
  Estados.Sigla,
  Fotos.orientacao,
  Fotos.dim_a,
  Fotos.dim_b,
  Fotos.direito_img,
  Fotos.assunto_principal,
  Fotos.assunto_en,
  Fotos.extra,
  paises.nome as pais
FROM
 Fotos
 LEFT OUTER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
 LEFT OUTER JOIN Estados ON (Fotos.id_estado=Estados.id_estado)
 LEFT OUTER JOIN paises ON (paises.id_pais=Fotos.id_pais)
WHERE
  (Fotos.tombo LIKE '%s')", $MMColParam_dados_foto);
// INNER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
//LEFT JOIN videos_extra ON (videos_extra.tombo=Fotos.tombo)
//LEFT JOIN Fotos_extra ON (Fotos_extra.tombo=Fotos.tombo)


$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
$row_dados_foto = mysql_fetch_assoc($dados_foto);
$totalRows_dados_foto = mysql_num_rows($dados_foto);

if($row_dados_foto['assunto_en'] == "") {
	$assunto = $row_dados_foto['assunto_principal'];
	$assunto_en = addslashes(translateText($assunto));
	if($siteDebug)
		echo "$assunto || $assunto_en <br>";
	
	if($assunto_en != $assunto) {
		$update = "UPDATE Fotos SET assunto_en = '$assunto_en' WHERE Id_foto = ".$row_dados_foto['Id_Foto'];
		if($siteDebug)
			echo $update."<br>";
		mysql_query($update, $pulsar) or die(mysql_error());
	}
}

if($row_dados_foto['dim_a'] == "") {
	$tombo = $row_dados_foto['tombo'];
	$id_foto = $row_dados_foto['Id_Foto'];
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
			
			$updateSQL = sprintf("UPDATE Fotos SET orientacao=%s, dim_a=%s, dim_b=%s WHERE Id_Foto=%s",
					GetSQLValueString($orientacao, "text"),
					GetSQLValueString($width, "int"),
					GetSQLValueString($height, "int"),
					GetSQLValueString($id_foto, "int"));

			mysql_query($updateSQL, $pulsar) or die(mysql_error());
			
			$row_dados_foto['dim_a'] = $width;
			$row_dados_foto['dim_b'] = $height;
		}
	}
}
$isVideo = isVideo($row_dados_foto['tombo']);

mysql_select_db($database_pulsar, $pulsar);
$query_extra_foto = sprintf("SELECT * FROM Fotos_extra WHERE tombo = '%s'", $MMColParam_dados_foto);
$extra_foto = mysql_query($query_extra_foto, $pulsar) or die(mysql_error());
$row_extra_foto = mysql_fetch_assoc($extra_foto);
$totalRows_extra_foto = mysql_num_rows($extra_foto);

$query_extra_video = sprintf("SELECT * FROM videos_extra WHERE tombo = '%s'", $MMColParam_dados_foto);
$extra_video = mysql_query($query_extra_video, $pulsar) or die(mysql_error());
$row_extra_video = mysql_fetch_assoc($extra_video);
$totalRows_extra_video = mysql_num_rows($extra_video);
$res_pop = "640x360";
if($row_extra_video['resolucao']=="720x480")
	$res_pop = "540x360";
else if($row_extra_video['resolucao']=="720x586")
	$res_pop = "440x360";

$MMColParam_temas = "28433";
if (isset($_GET['tombo'])) {
  $MMColParam_temas = (get_magic_quotes_gpc()) ? $_GET['tombo'] : addslashes($_GET['tombo']);
}

$idioma = "";
if($lingua != "br")
	$idioma = "_en";

mysql_select_db($database_pulsar, $pulsar);
$query_temas = sprintf("SELECT Fotos.tombo, super_temas.Tema_total$idioma as Tema, super_temas.Id FROM super_temas INNER JOIN rel_fotos_temas ON (super_temas.Id=rel_fotos_temas.id_tema) INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) WHERE (Fotos.tombo = '%s')", $MMColParam_temas);
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);

$MMColParam_palavras = "xxxx";
if (isset($_GET['tombo'])) {
  $MMColParam_palavras = (get_magic_quotes_gpc()) ? $_GET['tombo'] : addslashes($_GET['tombo']);
}

mysql_select_db($database_pulsar, $pulsar);
$query_palavras = sprintf("SELECT    pal_chave.Pal_Chave$idioma as Pal_Chave,   pal_chave.Id FROM  rel_fotos_pal_ch  INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE   (Fotos.tombo LIKE '%s' AND Pal_Chave$idioma IS NOT NULL) GROUP BY Pal_Chave$idioma order by Pal_Chave$idioma", $MMColParam_palavras);
$palavras = mysql_query($query_palavras, $pulsar) or die(mysql_error());
$row_palavras = mysql_fetch_assoc($palavras);
$totalRows_palavras = mysql_num_rows($palavras);


$detail_tombo = $row_dados_foto['tombo']; 
if (! is_numeric($row_dados_foto['tombo']) && !$isVideo) { 
	$detail_tombo.=" (".DETAILS_ORIGINAL.")";
}

$detail_local = "";
if($row_dados_foto['cidade']!= "" || $row_dados_foto['Sigla']!= "") {
	$detail_local = "<p><span class=\"label\">".DETAILS_LOCAL.": </span>";
	if($row_dados_foto['cidade'] <> '') {
		$detail_local .= $row_dados_foto['cidade'];
	}
	if (($row_dados_foto['Sigla'] <> '') AND ( ( is_null($row_dados_foto['pais'])) OR ($row_dados_foto['pais'] == 'Brasil'))) { 
		if ($row_dados_foto['cidade'] <> '') {
			$detail_local .=' - ';
		}
		$detail_local .= $row_dados_foto['Sigla'];
	}
	$detail_local .= "</p>";
}
if ((!is_null($row_dados_foto['pais'])) and ($row_dados_foto['pais']!='Brasil')) {
					$detail_local .= "<p><span class=\"label\">".DETAILS_PAIS.":</span> ".$row_dados_foto['pais']."</p>";
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
                
		$detail_dim .= "Dimens�es da imagem: ".$width." px X ".$height." px   -   300 DPI. Caso necessite esse arquivo em outras dimens�es, <a href=\"contato.php\">entre em contato.</a><br/><br/>";
	}
}
*/
if($isVideo) {
	if($row_extra_video['resolucao']!=NULL && $row_extra_video['resolucao']!="") {
		$detail_dim .= "<p><span class=\"label\">".DETAILS_RESOLUCAO.":</span> ".$row_extra_video['resolucao']."</p>";
	}
	if($row_extra_video['codec']!=NULL && $row_extra_video['codec']!="") {
		if($row_extra_video['codec'] == "proxyEncoder")
			$row_extra_video['codec'] = "H.264";
		$detail_dim .= "<p><span class=\"label\">".DETAILS_CODEC.":</span> ".$row_extra_video['codec']."</p>";
	}
	if($row_extra_video['fps']!=NULL && $row_extra_video['fps']!="") {
		if($row_extra_video['fps'] < 130)
			$detail_dim .= "<p><span class=\"label\">".DETAILS_FPS.":</span> ".$row_extra_video['fps']."</p>";
	}
	if($row_extra_video['audio']!=NULL && $row_extra_video['audio']!="") {
		$has_audio = $row_extra_video['audio']==1?"Sim":"N�o";
//		$detail_dim .= "<p><span class=\"label\">".DETAILS_AUDIO.":</span> $has_audio</p>";
	}
}else {
	if($row_dados_foto['dim_a']!=NULL &&$row_dados_foto['dim_a']!=0) {
		$detail_dim .= "<p class=\"label\">".DETAILS_DIMENSAO.":</p> ".$row_dados_foto['dim_a']." px X ".$row_dados_foto['dim_b']." px   -   300 DPI. ".DETAILS_DIMENSAO_FOTO."<br/><br/>";
	}
}


$tombo = "";
if(isset($_GET['tombo'])) {
	$tombo = $_GET['tombo'];
}
$page_num = 0;
if(isset($_GET['page_num'])) {
	$page_num = $_GET['page_num'];
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
  $add_script .= "<script>alert('".DETAILS_COTACAO."')</script>";
}



$fotos_cotacao = false;

if($logged) {
	mysql_select_db($database_pulsar, $pulsar);
	$query_fotos_cotacao = sprintf("SELECT   cotacao.tombo  FROM cotacao WHERE cotacao.id_cadastro = %s ORDER BY tombo", $row_top_login['id_cadastro']);
	$fotos_cotacao = mysql_query($query_fotos_cotacao, $pulsar) or die(mysql_error());
	$row_fotos_cotacao = mysql_fetch_assoc($fotos_cotacao);
	$totalRows_fotos_cotacao = mysql_num_rows($fotos_cotacao);
	
	if($totalRows_fotos_cotacao) {
		function isQuoting($tombo, $result) {
			mysql_data_seek($result, 0);
			while ($row = mysql_fetch_assoc($result)) {
				if($row['tombo'] == $tombo)	
					return true;	
			}
			return false;	
		}
	} else {
		function isQuoting($tombo, $result) { return false; }
	}
}
else {
	function isQuoting($tombo, $result) { return false; }
}


// Codigo adicionar a minhas imagens

if(isset($_GET['action']) && (($_GET['action'] == "Enviar")||($_GET['action'] == "Add"))) {
	// que pastas j� tem esta foto
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
$page_num = 0;
if(isset($_SESSION['ultima_pesquisa'])&&isset($_GET['ordem_foto'])&&isset($_GET['total_foto'])) {
	$tombo_array = explode('|',$_SESSION['ultima_pesquisa']);
	$ordem_foto = $_GET['ordem_foto'];
	$scroll_startpos = $ordem_foto;
	$page_num = $_GET['page_num'];
	$total_foto = $_GET['total_foto'];
	if($ordem_foto > 0) {
		$ordem_prev = $ordem_foto - 1;
	}
	if($ordem_foto < $total_foto - 1) {
		$ordem_next = $ordem_foto + 1;
	}
}

//$isVideo = isVideo($row_dados_foto['tombo']);
?>