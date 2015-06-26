<?php require_once('Connections/pulsar.php'); ?>
<?php
$id = $_POST['id'];
$id_arr = explode("|",$id);
$id = $id_arr[0];
$table = $id_arr[1];

$value = utf8_decode($_POST['value']);
$value_arr = explode("|",$value);
$val = $value_arr[0];
if($id != "") {
	mysql_select_db($database_pulsar, $pulsar);
	$query = "UPDATE log_download2 SET $table = '".mysql_real_escape_string($val)."' WHERE id_log = $id";
	$rs = mysql_query($query, $pulsar) or die($query." - ".mysql_error());
	if($table == "USO") {
		$query = "UPDATE log_download2 SET formato = '".mysql_real_escape_string($value_arr[1])."' WHERE id_log = $id";
		$rs = mysql_query($query, $pulsar) or die($query." - ".mysql_error());
	}
	if($table == "projeto")
		echo utf8_encode("Título: $value");
	else if($table == "obs")
		echo utf8_encode("Obs: $value");
	else if($table == "USO")
		echo utf8_encode("Atualizando uso e tamanho...");
	else 
		echo utf8_encode("Atualizando...");
}
else
	echo "Erro!".$query."|".json_encode($_POST);
?>