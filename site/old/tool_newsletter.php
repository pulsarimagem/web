<?php
session_start();
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
		$email_error_msg = "O Email é um campo obrigatório!";
		$has_error = true;
	}
	if(($newsletter = $_GET['tipo']) == "") {
		 $has_error = true;
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
	$to      = $setor;
	$subject = "\Pedido de inscrição no Newsletter em " . date("d/m/Y") . " às " . date("H:i");
	$message = "Email:" . $email . "\r\n<br> 
			Newsletter: " . $newsletter  ;
		$headers = "Content-Type: text/html; charset=iso-8859-15\n";
	$headers .= "From: <".($email).">\n";
	if (strlen($to) < 16) {
		mail($to."@pulsarimagens.com.br",$subject,$message,$headers);
	}
?>
<script type="text/javascript">
function confirmacao() {
	alert('Pedido de cadastro na newsletter realizado.');
	window.location.href="<?php echo $url_ok; ?>";
}
</script>
<body onLoad="confirmacao();">
</body>
<?php
}
?>