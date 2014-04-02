<?php 
if($_SERVER['HTTP_HOST'] == "www.pulsarimages.com") {
	header("location: ./en/");
}
else {
	header("location: ./br/");
}
//    header('HTTP/1.0 404 Not Found');
//    echo "<h1>Manutenção do Sistema</h1>";
//    echo "The page that you have requested could not be found.";
//    exit();
?>