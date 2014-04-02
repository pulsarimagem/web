<?php require_once('./Connections/pulsar.php');

// Include the required files for reading and writing Photoshop File Info
include 'JPEG.php';
include 'XMP.php';
include 'Photoshop_IRB.php';
include 'EXIF.php';
include 'Photoshop_File_Info.php';
include 'IPTCClass.php';

// Get TOMBO
//$_GET["tombo"] = "02JPR718";

$tombo = $_POST['tombo'];

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

$IPTCkwords = implode(",",$palavras_chave_arry);
$ii = new iptc($dest_file);
$IPTCcaption = $ii->get(IPTC_CAPTION);

//This function removes all header data from a JPG
/*
function remove_XMP($image_in, $filename) {
  $filename_in = addslashes($image_in);
  list($width, $height) = getimagesize($filename_in);
  $image_dest = imagecreatetruecolor($width, $height);
  $image = imagecreatefromjpeg($filename_in);
  imagecopyresampled($image_dest, $image, 0, 0, 0, 0,  $width, $height,$width, $height);
  imagejpeg($image_dest, $filename);
}
*/
//remove_XMP($dest_file,$dest_file);
//XMP_remove_from_jpegfile ("test.jpg", "test_clear.jpg");

$image_name_old = $dest_file;

	if ($siteDebug) {
		echo "<strong>dest_file: </strong>".$dest_file."<br>";
	}

	
//$image_name_old = $fotosalta."/". $tombo . ".jpg";
//$image_name_old = "02JPR718.JPG";
//$image_name_old = "test_iptc.jpg";



// Retrieve the header information from the JPEG file
$jpeg_header_data = get_jpeg_header_data ( $image_name_old );

// Retrieve EXIF information from the JPEG file
$Exif_array = get_EXIF_JPEG ( $image_name_old );

// Retrieve XMP information from the JPEG file
$XMP_array = read_XMP_array_from_text ( get_XMP_text ( $jpeg_header_data ) );

// Retrieve Photoshop IRB information from the JPEG file
$IRB_array = get_Photoshop_IRB ( $jpeg_header_data );

// Retrieve Photoshop File Info from the three previous arrays
$PS_file_info_array = get_photoshop_file_info ( $Exif_array, $XMP_array, $IRB_array );

//Update copyright statement:
$i = new iptc($dest_file);
$i->removeAllTags();

//$IPTCcaption = $PS_file_info_array['caption'];
//$IPTCcaption = $ii->get(IPTC_CAPTION);
$IPTCcpwrite = $PS_file_info_array['copyrightnotice']." - ".$PS_file_info_array['ownerurl'];

//$IPTCkwords = implode(",",$PS_file_info_array['keywords']);

$IPTCdate = str_replace("-","",$PS_file_info_array['date']);

echo $i->set(IPTC_CAPTION,$IPTCcaption);
echo $i->set(IPTC_KEYWORDS,$IPTCkwords);
echo $i->set(IPTC_COPYRIGHT_STRING,$IPTCcpwrite);
echo $i->set(IPTC_CREATED_DATE,$IPTCdate);
$i->write();

// Writing of new JPEG succeeded

?>