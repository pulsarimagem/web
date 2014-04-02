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

function output_iptc_data( $image_path ) {
	$iptc_pal = "";
	$size = getimagesize ( $image_path, $info);
	if(is_array($info)) {
		$iptc = iptcparse($info["APP13"]);

		$c = count ($iptc["2#025"]);

		for ($i=0; $i <$c; $i++)
		{
			if (valid_utf8($iptc["2#025"][$i])) {
				$iptc["2#025"][$i]=mb_convert_encoding($iptc["2#025"][$i],"iso-8859-1","UTF-8");
			}

			echo $iptc["2#025"][$i].'<br>';
			$iptc_pal .= $iptc["2#025"][$i].";";
		}
	}
	return $iptc_pal;
}

function get_iptc_caption( $image_path ) {
	$IPTC_Caption = "";
	$size = getimagesize ( $image_path, $info);
	if(is_array($info)) {
		$iptc = iptcparse($info["APP13"]);

        $IPTC_Caption = str_replace( "\000", "", $iptc["2#120"][0] );
        if(isset($iptc["1#090"]) && $iptc["1#090"][0] == "\x1B%G")
            $IPTC_Caption = utf8_decode($IPTC_Caption); 
	}
	return $IPTC_Caption;
}



   function valid_1byte($char) {
       if(!is_int($char)) return false;
       return ($char & 0x80) == 0x00;
   }
   
   function valid_2byte($char) {
       if(!is_int($char)) return false;
       return ($char & 0xE0) == 0xC0;
   }

   function valid_3byte($char) {
       if(!is_int($char)) return false;
       return ($char & 0xF0) == 0xE0;
   }

   function valid_4byte($char) {
       if(!is_int($char)) return false;
       return ($char & 0xF8) == 0xF0;
   }
   
   function valid_nextbyte($char) {
       if(!is_int($char)) return false;
       return ($char & 0xC0) == 0x80;
   }
   
   function valid_utf8($string) {
       $len = strlen($string);
       $i = 0;    
       while( $i < $len ) {
           $char = ord(substr($string, $i++, 1));
           if(valid_1byte($char)) {    // continue
               continue;
           } else if(valid_2byte($char)) { // check 1 byte
               if(!valid_nextbyte(ord(substr($string, $i++, 1))))
                   return false;
           } else if(valid_3byte($char)) { // check 2 bytes
               if(!valid_nextbyte(ord(substr($string, $i++, 1))))
                   return false;
               if(!valid_nextbyte(ord(substr($string, $i++, 1))))
                   return false;
           } else if(valid_4byte($char)) { // check 3 bytes
               if(!valid_nextbyte(ord(substr($string, $i++, 1))))
                   return false;
               if(!valid_nextbyte(ord(substr($string, $i++, 1))))
                   return false;
               if(!valid_nextbyte(ord(substr($string, $i++, 1))))
                   return false;
           } // goto next char
       }
       return true; // done
   }
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

output_iptc_data($fotosalta.$_GET['foto'].'.jpg');
//output_iptc_data('/var/www/www.pulsarimagens.com.br/bancoImagens/'.$_GET['foto'].'.jpg');

?>
</span>
</body>
</html>
