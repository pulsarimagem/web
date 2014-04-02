<?php 
$action = isset($_GET["action"])?$_GET["action"]:false;
$action = isset($_POST["action"])?$_POST["action"]:$action;

$isShow = false;
$isHist = false;
$isAtendida = false;

if($action == "show") {
	$idCotacao = $_GET["id_cotacao"];
	
	mysql_select_db($database_pulsar, $pulsar);
	$query_cliente = sprintf("SELECT    cadastro.nome,   cadastro.empresa,   cadastro.email,   cadastro.telefone,   cadastro.cidade,   cadastro.estado,   cotacao_2.id_cotacao2,   cotacao_2.mensagem,   cotacao_2.distribuicao,   cotacao_2.descricao_uso,    cotacao_2.data_hora,  cotacao_2.atendida FROM  cotacao_2  INNER JOIN cadastro ON (cotacao_2.id_cadastro=cadastro.id_cadastro) WHERE id_cotacao2 = %s GROUP BY   cotacao_2.id_cotacao2,   cotacao_2.id_cadastro,   cotacao_2.distribuicao,   cotacao_2.descricao_uso,   cotacao_2.data_hora,   cotacao_2.atendida,   cadastro.nome,   cadastro.empresa ", $idCotacao);
	$cliente = mysql_query($query_cliente, $pulsar) or die(mysql_error());
	$row_cliente = mysql_fetch_assoc($cliente);
	$totalRows_cliente = mysql_num_rows($cliente);
	
	mysql_select_db($database_pulsar, $pulsar);
	$query_fotos = sprintf("SELECT    cotacao_cromos.tombo,   pastas.nome_pasta FROM  cotacao_cromos  LEFT OUTER JOIN pastas ON (cotacao_cromos.id_pasta=pastas.id_pasta) WHERE   (cotacao_cromos.id_cotacao2 = %s) ", $idCotacao);
	$fotos = mysql_query($query_fotos, $pulsar) or die(mysql_error());
	$row_fotos = mysql_fetch_assoc($fotos);
	$totalRows_fotos = mysql_num_rows($fotos);
	
	if($row_cliente["atendida"] != 0)
		$isAtendida = true;
	
	$isShow = true;
}
else if($action == "send") {
	$updateSQL = "UPDATE cotacao_2 SET atendida = 1, data_hora_atendida = '".date("Y-m-d H:i:s", strtotime('now'))."',mensagem  = '".stripslashes( $_POST['FCKeditor1'] )."',respondida_por = '".$_POST["responder"]."' WHERE id_cotacao2 = ".$_POST['id_cotacao2'];
	echo $updateSQL;
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
	
	
	$to      = $_POST['to'] . "\n";
	$subject = $_POST['subject']."\n";
	
	include('email_cotacao.php');
	
	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: Pulsar Imagens <".($_POST["responder"])."@pulsarimagens.com.br>\n";
	$headers .= "Bcc: ".($_POST["responder"])."@pulsarimagens.com.br\n";
	$headers .= "Bcc: Cotacao <cotacao@pulsarimagens.com.br>\n";
	$headers .= "Return-Path: ".($_POST["responder"])."@pulsarimagens.com.br\n";
	
	mail($to,$subject,$message,$headers);
	$msg = "Enviado com sucesso!";
}
else if ($action == "historico") {
	$colname_ordem = "data_hora DESC";
	if (isset($_GET['ordem'])) {
		$colname_ordem = (get_magic_quotes_gpc()) ? $_GET['ordem'] : addslashes($_GET['ordem']);
	} else {
		$_GET['ordem'] = $colname_ordem;
	}
	mysql_select_db($database_pulsar, $pulsar);
	$query_atendidas = sprintf("SELECT    cotacao_2.id_cotacao2,   cadastro.nome,   cadastro.empresa,   cotacao_2.data_hora,   cotacao_2.data_hora_atendida FROM  cotacao_2  INNER JOIN cadastro ON (cotacao_2.id_cadastro=cadastro.id_cadastro) WHERE  cotacao_2.atendida = 1 ORDER BY %s",$colname_ordem);
	$atendidas = mysql_query($query_atendidas, $pulsar) or die(mysql_error());
	$row_atendidas = mysql_fetch_assoc($atendidas);
	$totalRows_atendidas = mysql_num_rows($atendidas);
	
	$isHist = true;	
}
if (isset($_POST['id_cotacao2'])) {
  $updateSQL = "UPDATE cotacao_2 SET atendida = 1, data_hora_atendida = '".date("Y-m-d H:i:s", strtotime('now'))."' WHERE id_cotacao2 = ".$_POST['id_cotacao2'];

  mysql_select_db($database_pulsar, $pulsar);
  $Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
}
mysql_select_db($database_pulsar, $pulsar);
$query_pendentes = "SELECT    cotacao_2.id_cotacao2,   cotacao_2.id_cadastro,   cotacao_2.distribuicao,   cotacao_2.descricao_uso,   cotacao_2.data_hora,   cotacao_2.atendida,   cadastro.nome,   cadastro.empresa,   count(cotacao_cromos.id_cromo) AS total_cromos FROM  cotacao_2  LEFT OUTER JOIN cadastro ON (cotacao_2.id_cadastro=cadastro.id_cadastro)  LEFT OUTER JOIN cotacao_cromos ON (cotacao_2.id_cotacao2=cotacao_cromos.id_cotacao2) WHERE cotacao_2.atendida=0 GROUP BY   cotacao_2.id_cotacao2,   cotacao_2.id_cadastro,   cotacao_2.distribuicao,   cotacao_2.descricao_uso,   cotacao_2.data_hora,   cotacao_2.atendida,   cadastro.nome,   cadastro.empresa";
$pendentes = mysql_query($query_pendentes, $pulsar) or die(mysql_error());
$row_pendentes = mysql_fetch_assoc($pendentes);
$totalRows_pendentes = mysql_num_rows($pendentes);
?>
