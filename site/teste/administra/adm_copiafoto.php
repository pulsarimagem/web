<?php
function imageResize($width, $height, $target) { 

// takes the larger size of the width and height and applies the  
// formula accordingly...this is so this script will work  
// dynamically with any size image 

if ($width > $height) { 
$percentage = ($target / $width); 
} else { 
$percentage = ($target / $height); 
} 

// gets the new value and applies the percentage, then rounds the value 
$width = round($width * $percentage); 
$height = round($height * $percentage); 

// returns the new sizes in html image tag format...this is so you 
// can plug this function inside an image tag and just get the 

return "width=\"$width\" height=\"$height\""; 
}
?>

<?php
$file = $_GET['tombo'].'.jpg';
$fileTmp = $_GET['tombo'].'TMP.jpg';
$source_file = '/var/fotos_alta/'.$file; 
$dest_file = '/var/www/public_html/fotos_home/'.$fileTmp; 

if (!copy($source_file, $dest_file)) {
	$erro = "nok";
} else {
	$erro = "ok";
	$fp = fopen($dest_file, "r");
	$s_array=fstat($fp);
	$tamanho = $s_array["size"];
	fclose($fp); 
}


$mysock = getimagesize($dest_file);
imageResize($mysock[0],$mysock[1], 500); 


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php
echo $erro;
?>
</body>
</html>
