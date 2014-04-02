<?php require_once('Connections/pulsar.php'); ?>
<?php
$colname_email = "1";
if (isset($_GET['email_id'])) {
  $colname_email = (get_magic_quotes_gpc()) ? $_GET['email_id'] : addslashes($_GET['email_id']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_email = sprintf("SELECT * FROM email WHERE id_email = %s", $colname_email);
$email = mysql_query($query_email, $pulsar) or die(mysql_error());
$row_email = mysql_fetch_assoc($email);
$totalRows_email = mysql_num_rows($email);

$colname_fotos = "1";
if (isset($_GET['email_id'])) {
  $colname_fotos = (get_magic_quotes_gpc()) ? $_GET['email_id'] : addslashes($_GET['email_id']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_fotos = sprintf("SELECT * FROM email_fotos WHERE id_email = %s", $colname_fotos);
$fotos = mysql_query($query_fotos, $pulsar) or die(mysql_error());
$row_fotos = mysql_fetch_assoc($fotos);
$totalRows_fotos = mysql_num_rows($fotos);

$email_id = $_GET['email_id'];
$nome = $row_email['nome'];
$mensagem = nl2br($row_email['texto']);
$email_tombo = $row_fotos['tombo']; 

$tipo = "foto";
if(isset($_GET['tipo'])) {
	$tipo = $_GET['tipo'];	
}

$idioma = "br";
if(isset($_GET['idioma'])) {
	$idioma = $_GET['idioma'];
}

if($tipo == "pasta")
	include($idioma.'/email_enviarpastaemail.php');
else if($tipo == "foto")
	include($idioma.'/email_enviarporemail.php');

echo $corpo_email;