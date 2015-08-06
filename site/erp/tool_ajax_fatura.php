<?php require_once('Connections/pulsar.php'); ?>
<?php
if (isset($_GET['id_log'])) {
	$id_log = $_GET['id_log'];
	if ($_GET['marca']=="true") {
		$marca = 1;
	} else {
		$marca = 0;
	}
}
mysql_select_db($database_pulsar, $pulsar);
$query = "SELECT * FROM log_download2 WHERE id_log = ".$id_log;
//echo $query;
$doQuery = mysql_query($query, $pulsar) or die(mysql_error());
$row_query = mysql_fetch_assoc($doQuery);
mysql_free_result($doQuery);

$query = "UPDATE log_download2 SET faturado=".$marca." WHERE arquivo LIKE '".$row_query['arquivo']."' AND EXTRACT(DAY FROM data_hora) = EXTRACT(DAY FROM '".$row_query['data_hora']."') AND projeto LIKE '".$row_query['projeto']."' AND id_login = ".$row_query['id_login'];
echo $query;
$doQuery = mysql_query($query, $pulsar) or die(mysql_error());
mysql_free_result($doQuery);
?>Success!