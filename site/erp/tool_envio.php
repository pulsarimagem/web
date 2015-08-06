<?php 
$idLogin = -1;
$idLogin = isset($_GET['id_login'])?$_GET['id_login']:$idLogin;
$idLogin = isset($_POST['id_login'])?$_POST['id_login']:$idLogin;

$titulo = "";
$titulo_error = false;
$action  = isset($_POST['action'])?$_POST['action']:"";

if($action == "copiarFoto") {
	$file = $_POST['tombo'].'.jpg';
	$insertSQL = sprintf("INSERT INTO log_download2 (arquivo, data_hora, ip, id_login, usuario, projeto, formato, uso, obs) VALUES ('%s','%s','%s',%s,'%s','%s','%s','%s','%s')",
			$file,
			date("Y-m-d h:i:s", strtotime('now')),
			"Email",
			$idLogin,
			$row_login['login'],
			$_POST['titulo'],
			$_POST['tamanho'],
			$_POST['uso'],
			$_POST['observacoes']
	);
	mysql_select_db($database_pulsar, $pulsar);
		echo $insertSQL;
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

}

else if($action == "copiarVideo") {
	$file = $_POST['tombo'];
	$insertSQL = sprintf("INSERT INTO log_download2 (arquivo, data_hora, ip, id_login, usuario, projeto, formato, uso, obs) VALUES ('%s','%s','%s',%s,'%s','%s','%s','%s','%s')",
			$file,
			date("Y-m-d h:i:s", strtotime('now')),
			"Email",
			$idLogin,
			$row_login['login'],
			$_POST['titulo'],
			$_POST['tamanho'],
			$_POST['uso'],
			$_POST['observacoes']
	);
	mysql_select_db($database_pulsar, $pulsar);
// 		echo $insertSQL;
	$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

}

mysql_select_db($database_pulsar, $pulsar);
$query_diretorios = "SELECT ftp.id_ftp,   cadastro.login, cadastro.empresa,   ftp.id_login, cadastro.nome, cadastro.email FROM cadastro  INNER JOIN ftp ON (cadastro.id_cadastro=ftp.id_login) ORDER BY cadastro.nome";
$diretorios = mysql_query($query_diretorios, $pulsar) or die(mysql_error());
$totalRows_diretorios = mysql_num_rows($diretorios);

?>
