<?php require_once('Connections/pulsar.php');
$file = $_GET['f']; 
$directory = $_GET['d'];
$insertSQL = sprintf("INSERT INTO log_download (arquivo, data_hora, ip, id_login) VALUES ('%s','%s','%s',%s)",
	$file,
	date("Y-m-d h:i:s", strtotime('now')),
	GetHostByName($_SERVER['REMOTE_ADDR']),
	$directory
);
mysql_select_db($database_pulsar, $pulsar);
$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
Header( "Content-type: image"); 
header("Content-Disposition: attachment; filename=\"$file\""); 
readfile($homeurl."ftp/".$directory."/".$file); 
?> 