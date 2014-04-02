<?php
function translateEn($palavra, $idioma) {
	if($palavra != '' && $idioma != ''){
		$data = file_get_contents ("http://translate.google.com/translate_a/t?client=t&text=".urlencode($palavra)."&hl=en&sl=en&tl=".$idioma."&ie=ISO-8859-1&oe=ISO-8859-1&multires=1&otf=1&ssel=0&tsel=0&sc=1");
		$data = explode('"',$data);
		if($data[1] != "")
			return $data[1];
		else
			return $palavra;
	}
}

echo translateEn($_GET['string'], $_GET['lang']);
?>