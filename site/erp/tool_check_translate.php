<?php require_once('Connections/pulsar.php'); ?>
<?php
$tombo = $_GET['tombo'];
mysql_select_db($database_pulsar, $pulsar);

$sql = "SELECT * FROM Fotos WHERE tombo LIKE '$tombo'";
$rs = mysql_query($sql, $pulsar) or die(mysql_error());
$row = mysql_fetch_array($rs);
$assunto_principal = $row['assunto_principal'];
$extra = $row['extra'];
$assunto_principal_en = translateV2($assunto_principal);
$extra_en = translateV2($extra);

echo "Assunto: $assunto_principal<br>";
echo "Assunto_en: $assunto_principal_en<br><br>";
echo "Extra: $extra<br>";
echo "Extra_en: $extra_en<br><br>";
?>