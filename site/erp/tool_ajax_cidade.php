<?php require_once('Connections/pulsar.php'); ?>
<?php
$return_arr = array();
$row_array = array();
$ret = array();

mysql_select_db($database_pulsar, $pulsar);

$where = "";
if(isset($_GET['term'])) {
	$term = $_GET['term'];
	$where = "cidade LIKE '$term%'";
}
else if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$where = "cidade LIKE '$id'";
}

$queryDesc = "SELECT DISTINCT(cidade) AS cidade FROM Fotos WHERE $where";
$rsDesc = mysql_query($queryDesc, $pulsar) or die(mysql_error());
$return = array();
while($rowDesc = mysql_fetch_array($rsDesc)) {
	$row_array['id'] = utf8_encode($rowDesc['cidade']); 
	$row_array['text'] = utf8_encode($rowDesc['cidade']);
	array_push($return_arr,$row_array);
}
if(isset($id))
	$ret = $return_arr;
else
	$ret['results'] = $return_arr;
	
echo json_encode($ret);
?>
