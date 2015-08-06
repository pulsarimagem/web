<?php require_once('Connections/pulsar.php'); ?>
<?php

// Carregar pastas
if(isset($_GET['tombo']) && $_GET['tombo'] != "") {
	$insertSQL = "UPDATE Fotos_tmp SET status = ".$_GET['status']." WHERE tombo like '".$_GET['tombo']."'";
echo $insertSQL;
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	$insertSQL = "UPDATE codigo_video SET status = ".$_GET['status']." WHERE codigo like '".$_GET['tombo']."'";
echo $insertSQL;
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	
/*	
	if($head)
		header("Location: ". $_SESSION['last_search']);
*/
}

?>Success