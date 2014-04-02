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
	paises.nome_en as pais
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
	pal_chave.Pal_Chave_en as Pal_Chave,
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


$IPTCtitle = "";//$row_dados_foto ['assunto_principal'];
$IPTCcreator = $row_dados_foto ['nome_fotografo']; 
$IPTCbylinetitle = $tombo;
$IPTCdescription = "";//$row_dados_foto ['assunto_principal'];
$IPTClocation = $local;
$IPTCcity = $row_dados_foto['cidade'];
$IPTCstate = $row_dados_foto['estado'];
$IPTCcountry = $row_dados_foto['pais'];
$IPTCdatecreated = $data;
$IPTCdatecreated2 = $data2;
$IPTCkeywords = implode(",",$palavras_chave_arry);
$IPTCcopyright = "Pulsar Images - http://www.pulsarimages.com";

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
	
	$command_set = "exiftool ".$dest_file." -overwrite_original -L -Title=\"".$IPTCtitle."\" -Creator=\"".$IPTCcreator."\" -\"By-lineTitle\"=\"".$IPTCbylinetitle."\" -Description=\"".$IPTCdescription." Place: ".$IPTClocation." Date: ".$IPTCdatecreated2." Code:  ".$IPTCbylinetitle." Author: ".$IPTCcreator."\" -Location=\"".$IPTClocation."\" -XMP:City=\"".$IPTCcity."\" -XMP:State=\"".$IPTCstate."\" -XMP:Country=\"".$IPTCcountry."\" -CreateDate=\"".$IPTCdatecreated."\" -Subject=\"".$IPTCkeywords."\" -Rights=\"".$IPTCcopyright."\" -Copyright=\"".$IPTCcopyright."\" -\"CopyrightFlag\"=true -CopyrightNotice=\"".$IPTCcopyright."\"";
	$command_set2 = "exiftool ".$dest_file." -overwrite_original -L -\"Caption-Abstract\"=\"".$IPTCdescription." Place: ".$IPTClocation." Date: ".$IPTCdatecreated2." Code:  ".$IPTCbylinetitle." Author: ".$IPTCcreator."\" -Credit=\"".$IPTCcreator."\" -\"Writer-Editor\"=\"".$IPTCcreator."\"";
	$command_chmod = "chmod 666 ".$dest_file."";
	$command_chown = "chown admpul ".$dest_file."";
	
	if ($siteDebug) {
		echo $command_clean."<br>";
		echo $command_set."<br>";
		echo $command_set2."<br>";
		echo $command_chmod."<br>";
		echo $command_chown."<br>";
	}
	
	$output_clean = shell_exec($command_clean);
	$output_set = shell_exec($command_set);
	$output_set2 = shell_exec($command_set2);
	$output_chmod = shell_exec($command_chmod);
	$output_chown = shell_exec($command_chown);
	
	if ($siteDebug) {
		echo $output_clean."<br>";
		echo $output_set."<br>";
		echo $output_set2."<br>";
		echo $output_chmod."<br>";
		echo $output_chown."<br>";
	}
	
}	
?>