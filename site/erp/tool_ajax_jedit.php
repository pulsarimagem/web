<?php require_once('Connections/pulsar.php'); ?>
<?php
$id = $_POST['id'];
$value = utf8_decode($_POST['value']);
if($id != "") {
	mysql_select_db($database_pulsar, $pulsar);
	$query = "UPDATE log_download2 SET projeto = '".mysql_real_escape_string($value)."' WHERE id_log = $id";
	$rs = mysql_query($query, $pulsar) or die($query." - ".mysql_error());
	echo utf8_encode("Título: $value");
}
else
	echo "Erro!";
?>