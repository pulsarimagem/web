<?php
$lingua = isset($_GET['lingua'])?$_GET['lingua']:"br";
include("language_$lingua.php");
session_start();

$fullcc = "";
if($lingua!="br") {
	$fullcc .= ", saulo@pulsarimagens.com.br, icaro@pulsarimagens.com.br";
}

$url_ok = $_SESSION['this_uri'];

$has_error = false;
$nome_error = false;
$telefone_error = false;
$email_error = false;
$setor_error = false;
$mensagem_error = false;
$submit = false;

$nome = "";
$telefone = "";
$email = "";
$setor = "laura";
$mensagem = "";
$newsletter = "";

if (isset($_GET['action'])) {
	$submit = true;
	if(($email = $_GET['email']) == "") {
		$email_error = true;
		$email_error_msg = NEWLETTER_EMAIL_ERROR;
		$has_error = true;
	}
	if(($newsletter = $_GET['tipo']) == "") {
		// $has_error = true;
	}
}

if(!$has_error && $submit) {
/*	$insertSQL = sprintf("INSERT INTO contato (nome, email, setor, mensagem, telefone) VALUES (%s, %s, %s, %s, %s)",
	GetSQLValueString($nome, "text"),
	GetSQLValueString($email, "text"),
	GetSQLValueString($setor, "text"),
	GetSQLValueString($mensagem, "text"),
	GetSQLValueString($telefone, "text"));
		
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
*/	
	$to      = "pulsarimagensltda@gmail.com";//$setor;
	$subject = "[$setor] Pedido de inscrição no Newsletter $lingua em " . date("d/m/Y") . " às " . date("H:i");
	$message = "Email:" . $email . "\r\n<br> 
			Newsletter: " . $newsletter  ;
		$headers = "Content-Type: text/html; charset=iso-8859-15\n";
	$headers .= "From: <".($email).">\n";
	if (strlen($to) < 16) {
		mail($to.$fullcc,$subject,$message,$headers);
	}
?>
<script type="text/javascript">
function confirmacao() {
	alert('<?php echo NEWLETTER_CONFIRMACAO?>');
	window.location.href="<?php echo $url_ok; ?>";
}
</script>
<body onLoad="confirmacao();">
</body>
<?php
}
?>