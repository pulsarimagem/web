<?php require_once('../Connections/pulsar.php');

// Include the required files for reading and writing Photoshop File Info
include 'JPEG.php';
include 'XMP.php';
include 'Photoshop_IRB.php';
include 'EXIF.php';
include 'Photoshop_File_Info.php';
include 'IPTCClass.php';

// Get TOMBO
//$_GET["tombo"] = "02JPR718";

$tombo = "02JPR718";//$_POST['tombo'];

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


//This function removes all header data from a JPG
function remove_XMP($image_in, $filename) {
  $filename_in = addslashes($image_in);
  list($width, $height) = getimagesize($filename_in);
  $image_dest = imagecreatetruecolor($width, $height);
  $image = imagecreatefromjpeg($filename_in);
  imagecopyresampled($image_dest, $image, 0, 0, 0, 0,  $width, $height,$width, $height);
  imagejpeg($image_dest, $filename);
}

remove_XMP("02JPR718.jpg","02JPR718_2.jpg");
//XMP_remove_from_jpegfile ("test.jpg", "test_clear.jpg");

$image_name_old = "02JPR718.jpg";//$dest_file;
$dest_file = "02JPR718.jpg";

	if ($siteDebug) {
		echo "<strong>dest_file: </strong>".$dest_file."<br>";
	}

	
//$image_name_old = $fotosalta."/". $tombo . ".jpg";
//$image_name_old = "02JPR718.JPG";
//$image_name_old = "test_iptc.jpg";


// New file name
$image_name_new = "test_iptc.jpg";
//$image_name_new = $dest_file;

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

$PS_file_info_array ['keywords'] = $palavras_chave_arry;



						// ZOCA BUG FIX do campo caption da imagem
						
/*                if ( array_key_exists( 270, $Exif_array[0] ) )
                {
                        $PS_file_info_array ['caption'] = $Exif_array[0][270]['Data'][0];
                }*/




                        // Check if there is a default for the date defined
                        if ( ( ! array_key_exists( 'date', $PS_file_info_array ) ) ||
                             ( ( array_key_exists( 'date', $PS_file_info_array ) ) &&
                               ( $PS_file_info_array['date'] == '' ) ) )
                        {
                                // No default for the date defined
                                // figure out a default from the file

                                // Check if there is a EXIF Tag 36867 "Date and Time of Original"
                                if ( ( $Exif_array != FALSE ) &&
                                     ( array_key_exists( 0, $Exif_array ) ) &&
                                     ( array_key_exists( 34665, $Exif_array[0] ) ) &&
                                     ( array_key_exists( 0, $Exif_array[0][34665] ) ) &&
                                     ( array_key_exists( 36867, $Exif_array[0][34665][0] ) ) )
                                {
                                        // Tag "Date and Time of Original" found - use it for the default date
                                        $PS_file_info_array['date'] = $Exif_array[0][34665][0][36867]['Data'][0];
                                        $PS_file_info_array['date'] = preg_replace( "/(\d\d\d\d):(\d\d):(\d\d)( \d\d:\d\d:\d\d)/", "$1-$2-$3", $PS_file_info_array['date'] );
                                }
                               // Check if there is a EXIF Tag 36868 "Date and Time when Digitized"
                                else if ( ( $Exif_array != FALSE ) &&
                                     ( array_key_exists( 0, $Exif_array ) ) &&
                                     ( array_key_exists( 34665, $Exif_array[0] ) ) &&
                                     ( array_key_exists( 0, $Exif_array[0][34665] ) ) &&
                                     ( array_key_exists( 36868, $Exif_array[0][34665][0] ) ) )
                                {
                                        // Tag "Date and Time when Digitized" found - use it for the default date
                                        $PS_file_info_array['date'] = $Exif_array[0][34665][0][36868]['Data'][0];
                                        $PS_file_info_array['date'] = preg_replace( "/(\d\d\d\d):(\d\d):(\d\d)( \d\d:\d\d:\d\d)/", "$1-$2-$3", $PS_file_info_array['date'] );
                                }
                                // Check if there is a EXIF Tag 306 "Date and Time"
                                else if ( ( $Exif_array != FALSE ) &&
                                     ( array_key_exists( 0, $Exif_array ) ) &&
                                     ( array_key_exists( 306, $Exif_array[0] ) ) )
                                {
                                        // Tag "Date and Time" found - use it for the default date
                                        $PS_file_info_array['date'] = $Exif_array[0][306]['Data'][0];
                                        $PS_file_info_array['date'] = preg_replace( "/(\d\d\d\d):(\d\d):(\d\d)( \d\d:\d\d:\d\d)/", "$1-$2-$3", $PS_file_info_array['date'] );
                                }
                                else
                                {
                                        // Couldn't find an EXIF date in the image
                                        // Set default date as creation date of file
                                        $PS_file_info_array['date'] = date ("Y-m-d", filectime( $image_name_old ));
                                }
                        }
















$jpeg_header_data = put_photoshop_file_info ( $jpeg_header_data, $PS_file_info_array, $Exif_array, $XMP_array, $IRB_array );

// Check if the Update worked
if ($jpeg_header_data == FALSE) {
	// Update of file info didn't work - output error message
	echo "Error - Failure update Photoshop File Info : $image_name_old <br>\n";
	// Abort processing
	exit ();
}

// Attempt to write the new JPEG file
if (FALSE == put_jpeg_header_data ( $image_name_old, $image_name_new, $jpeg_header_data )) {
	// Writing of the new file didn't work - output error message
	echo "Error - Failure to write new JPEG : $image_name_new <br>\n";
	// Abort processing
	exit ();
}

$ii = new iptc("02JPR718.jpg");
echo "***IPTC _orig***   ".$ii->get(IPTC_CAPTION);
echo "   ".$ii->get(IPTC_KEYWORDS);

$i = new iptc("02JPR718_3.jpg");
echo "***IPTC _3***   ".$i->get(IPTC_CAPTION);
echo "   ".$i->get(IPTC_CREATED_DATE);

$i = new iptc("test_iptc.jpg");
echo "   ".$i->get(IPTC_CAPTION);

//Update copyright statement:
$i = new iptc("02JPR718_2.jpg");

//$IPTCcaption = $PS_file_info_array['caption'];
$IPTCcaption = $ii->get(IPTC_CAPTION);
$IPTCcpwrite = $PS_file_info_array['copyrightnotice']." - ".$PS_file_info_array['ownerurl'];

$IPTCkwords = implode(",",$PS_file_info_array['keywords']);

$IPTCdate = str_replace("-","",$PS_file_info_array['date']);

echo $i->set(IPTC_CAPTION,$IPTCcaption);
echo $i->set(IPTC_KEYWORDS,$IPTCkwords);
echo $i->set(IPTC_COPYRIGHT_STRING,$IPTCcpwrite);
echo $i->set(IPTC_CREATED_DATE,$IPTCdate);
$i->write();

// Writing of new JPEG succeeded

?>