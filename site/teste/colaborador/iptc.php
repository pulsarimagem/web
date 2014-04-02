<?php
function output_all_iptc( $image_path ) {   
    $size = getimagesize ( $image_path, $info);       
     if(is_array($info)) {   
        $iptc = iptcparse($info["APP13"]);
        foreach (array_keys($iptc) as $s) {             
            $c = count ($iptc[$s]);
            for ($i=0; $i <$c; $i++)
            {
                echo $s.' = '.$iptc[$s][$i].'<br>';
            }
        }                 
    }            
}

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

function output_iptc_caption( $image_path ) {
	$caption = "";
	$size = getimagesize ( $image_path, $info);
	if(is_array($info)) {
		$iptc = iptcparse($info["APP13"]);
/*
		if (valid_utf8($iptc["2#120"][0])) {
			$iptc["2#120"][0]=mb_convert_encoding($iptc["2#120"][0],"iso-8859-1","UTF-8");
		}
		$caption = $iptc["2#120"][0];
		if(isset($iptc["1#090"]) && $iptc["1#090"][0] == "\x1B%G")
            $caption = utf8_decode($IPTC_Caption); 
*/
        $caption = str_replace( "\000", "", $iptc["2#120"][0] );
        if(isset($iptc["1#090"]) && $iptc["1#090"][0] == "\x1B%G")
            $caption = utf8_decode($IPTC_Caption); 
		
	}
	return $caption;
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
<?php
  $output_str = ""; 
  $tipo1[0] = "/Assunto:/i";
  $tipo1[1] = "/Local:/i";
  $tipo1[2] = "/Pais:/i";
  $tipo1[3] = "/País:/i";
  $tipo1[4] = "/Data:/i";
  $tipo1[5] = "/Autor:/i";
  $tipo2[0] = "Assunto:";
  $tipo2[1] = "; Local:";
  $tipo2[2] = "; Pais:";
  $tipo2[3] = "; País:";
  $tipo2[4] = "; Data:";
  $tipo2[5] = "; Autor:";

$exif = exif_read_data($fotosalta.$_GET['tombo'].'.jpg', 'IFD0');
//$exif = exif_read_data('/var/www/www.pulsarimagens.com.br/bancoImagens/'.$_GET['foto'].'.jpg', 'IFD0');
echo $exif===false ? "No EXIF data found.<br />\n" : "";
$exif = exif_read_data($fotosalta.$_GET['tombo'].'.jpg', 0, true);
//$exif = exif_read_data('/var/www/www.pulsarimagens.com.br/bancoImagens/'.$_GET['foto'].'.jpg', 0, true);

/*
foreach ($exif as $key => $section) {
   foreach ($section as $name => $val) {
       echo "$key.$name: $val<br />\n";
   }
}
*/

   $output_str = $exif["IFD0"]["ImageDescription"]; 

   if($output_str=="" || $output_str==null) {
   		$output_str = output_iptc_caption($fotosalta.$_GET['tombo'].'.jpg');
   		//echo "IPTC Data:<br />\n"; echo $output_str; echo "<br>";
   }
   $fff = preg_replace($tipo1,$tipo2,$output_str);
	$array_final = split(";",$fff);
	
	foreach ($array_final as $aa => $bb)
	if (valid_utf8($bb)) {
		echo "<strong>". mb_convert_encoding(str_replace(":",":</strong>",$bb),"iso-8859-1","UTF-8") . "</strong><br />";
	} else {
	echo "<strong>". str_replace(":",":</strong>",$bb) . "</strong><br />";
	}

echo "<p>\n<strong>Orienta&ccedil;&atilde;o: </strong>";


if ($exif["COMPUTED"]["Height"] > $exif["COMPUTED"]["Width"]) {
	echo "Vertical"; }
else {
	echo "Horizontal"; }

echo "<br /><br /><strong>---Pal. Chaves---</strong><br />\n";

$iptc_pal = output_iptc_data($fotosalta.$_GET['tombo'].'.jpg');
//output_iptc_data('/var/www/www.pulsarimagens.com.br/bancoImagens/'.$_GET['foto'].'.jpg');

//$iptc_assunto = str_replace(" ","+",str_replace(";","&",str_replace(":", "=", $fff)));

$iptc_assunto = "";
$iptc_local = "";
$iptc_pais = "Brasil";
$iptc_estado = "";
$iptc_data = "";

foreach ($array_final as $aa => $bb) {
	if (valid_utf8($bb)) {
		$bb=mb_convert_encoding($bb,"iso-8859-1","UTF-8");
	}
	if(stripos($bb,"Assunto") !== false) {
		$iptc_assunto = trim(substr(strstr($bb, ':'),1));
	}
	if(stripos($bb,"Local") !== false) {
		$iptc_local = trim(substr(strstr($bb, ':'),1));
		if(stripos($bb,"-") !== false) {
			$local_estado = split("-",$iptc_local);
			$iptc_local = trim($local_estado[0]);
			$iptc_estado = trim($local_estado[1]);
		}
	}
	if(stripos($bb,"Pais") !== false) {
		$iptc_pais = trim(substr(strstr($bb, ':'),1));
	}
	if(stripos($bb,"País") !== false) {
		$iptc_pais = trim(substr(strstr($bb, ':'),1));
	}
	if(stripos($bb,"Data") !== false) {
		$iptc_data = trim(substr(strstr($bb, ':'),1));
	}
}

//echo "1".$iptc_assunto;
//echo "2".$iptc_local;
//echo "3".$iptc_data;
//echo "4".$iptc_pal
//echo "5".$iptc_pais

?>
</p>
