<?php require_once('Connections/pulsar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>
<?php
/*
function output_iptc_data( $image_path ) {    
   $size = getimagesize ( $image_path, $info);        
     if(is_array($info)) {    
       $iptc = iptcparse($info["APP13"]);

$c = count ($iptc["2#025"]);
for ($i=0; $i <$c; $i++) 
{
   echo $iptc["2#025"][$i].'<br>';
}

/*
       foreach (array_keys($iptc) as $s) {              
           $c = count ($iptc[$s]);
           for ($i=0; $i <$c; $i++) 
           {
               echo $s.'('.$c.') = '.$iptc[$s][$i].'<br>';
           }
       }                  

   }            
}*/
?>
<body>
<span class="style1">
<?php
  $output_str = ""; 
  $tipo1[0] = "/Assunto/";
  $tipo1[1] = "/Local/";
  $tipo1[2] = "/País/";
  $tipo1[2] = "/Pais/";
  $tipo1[3] = "/Data/";
  $tipo1[4] = "/Autor/";
  $tipo2[0] = "Assunto";
  $tipo2[1] = "; Local";
  $tipo2[2] = "; País";
  $tipo2[2] = "; Pais";
  $tipo2[3] = "; Data";
  $tipo2[4] = "; Autor";

$exif = exif_read_data($fotosalta.$_GET['foto'].'.jpg', 'IFD0');
//$exif = exif_read_data('/var/www/www.pulsarimagens.com.br/bancoImagens/'.$_GET['foto'].'.jpg', 'IFD0');
echo $exif===false ? "No header data found.<br />\n" : "";
$exif = exif_read_data($fotosalta.$_GET['foto'].'.jpg', 0, true);
//$exif = exif_read_data('/var/www/www.pulsarimagens.com.br/bancoImagens/'.$_GET['foto'].'.jpg', 0, true);

/*
foreach ($exif as $key => $section) {
   foreach ($section as $name => $val) {
       echo "$key.$name: $val<br />\n";
   }
}
*/

   $output_str = $exif["IFD0"]["ImageDescription"]; 
   if($output_str == null || $output_str == "") {
   	$output_str = get_iptc_caption($fotosalta.$_GET['foto'].'.jpg');
   }

   $fff = preg_replace($tipo1,$tipo2,$output_str);
	$array_final = split(";",$fff);
	
	foreach ($array_final as $aa => $bb)
	if (valid_utf8($bb)) {
		echo "<strong>". mb_convert_encoding(str_replace(":",":</strong>",$bb),"iso-8859-1","UTF-8") . "<br />";
	} else {
	echo "<strong>". str_replace(":",":</strong>",$bb) . "<br />";
	}

echo "<br />\n<strong>Orienta&ccedil;&atilde;o: </strong>";


if ($exif["COMPUTED"]["Height"] > $exif["COMPUTED"]["Width"]) {
	echo "Vertical"; }
else {
	echo "Horizontal"; }

echo "<br /><br /><strong>---Pal. Chaves---</strong><br />\n";

$pal_html = output_iptc_data($fotosalta.$_GET['foto'].'.jpg');
$pal_html = str_ireplace(";", "<br>", $pal_html);
echo $pal_html;
//output_iptc_data('/var/www/www.pulsarimagens.com.br/bancoImagens/'.$_GET['foto'].'.jpg');

?>
</span>
</body>
</html>
