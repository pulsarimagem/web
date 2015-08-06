<?php
$idLogin = -1;
$idLogin = isset($_GET['id_login'])?$_GET['id_login']:$idLogin;
$idLogin = isset($_POST['id_login'])?$_POST['id_login']:$idLogin;

$tmpLogin = -1;
$tmpLogin = isset($_GET['tmp_login'])?$_GET['tmp_login']:$tmpLogin;
$tmpLogin = isset($_POST['tmp_login'])?$_POST['tmp_login']:$tmpLogin;

$isCriarTmp = isset($_GET['createtmp'])?true:false;
$isCriarTmp = isset($_POST['createtmp'])?true:$isCriarTmp;

$colname_cliente = "-1";
if ($idLogin!=-1) {

	$colname_cliente = (get_magic_quotes_gpc()) ? $idLogin : addslashes($idLogin);

	mysql_select_db($database_pulsar, $pulsar);
	$query_cliente = sprintf("SELECT * FROM cadastro WHERE id_cadastro = '%s'", $colname_cliente);
	$cliente = mysql_query($query_cliente, $pulsar) or die(mysql_error());
	$row_cliente = mysql_fetch_assoc($cliente);
	$totalRows_cliente = mysql_num_rows($cliente);

	$query_ftp = sprintf("SELECT * FROM ftp WHERE id_login = %s", $row_cliente['id_cadastro']);
	$ftp = mysql_query($query_ftp, $pulsar) or die(mysql_error());
	$row_ftp = mysql_fetch_assoc($ftp);
	$totalRows_ftp = mysql_num_rows($ftp);

	if ($totalRows_ftp == 0) {

		//			$ftproot = "/var/www/public_html/ftp/";
		//			$srcroot = "/var/www/public_html/ftp/";
		$ftproot = $homeftp;
		$srcroot = $homeftp;
		$srcrela = ltrim($row_cliente['id_cadastro'],"0");

		mkdir ($ftproot.$srcrela, 0777);

		$msg = "Diretório criado com sucesso!!!";
		
		$insertSQL = sprintf("INSERT INTO ftp (id_login, data_cria) VALUES (%s,%s)",
                    GetSQLValueString($row_cliente['id_cadastro'], "int"),
					GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"));

		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	} else {
		$error = "Diretório já existe!!!";
	};
};

$colname_cliente_tmp = "-1";
if ($tmpLogin!=-1) {

	$colname_cliente_tmp = (get_magic_quotes_gpc()) ? $tmpLogin : addslashes($tmpLogin);

	mysql_select_db($database_pulsar, $pulsar);
	$query_cliente = sprintf("SELECT * FROM cadastro WHERE login = '%s'", $colname_cliente_tmp);
	$cliente = mysql_query($query_cliente, $pulsar) or die(mysql_error());
	$row_cliente = mysql_fetch_assoc($cliente);
	$totalRows_cliente = mysql_num_rows($cliente);

	if($totalRows_cliente > 0) {
		$error = "Login já existente!";
	}
	else if($_GET['senha']=="") {
		$error = "Senha em branco!";
	}
	else {
		$insertSQL = sprintf("INSERT INTO cadastro (nome,login, senha, email, data_cadastro,temporario, download) VALUES (%s,%s,%s,%s,%s,'S','SV')",
				GetSQLValueString("Temporário - ".$tmpLogin, "text"),
				GetSQLValueString($tmpLogin, "text"),
				GetSQLValueString($_GET['senha'], "text"),
				GetSQLValueString($_GET['email'], "text"),
				GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"));
	
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	
		mysql_free_result($cliente);
	
		mysql_select_db($database_pulsar, $pulsar);
		$query_cliente = sprintf("SELECT * FROM cadastro WHERE login = '%s'", $colname_cliente_tmp);
		$cliente = mysql_query($query_cliente, $pulsar) or die(mysql_error());
		$row_cliente = mysql_fetch_assoc($cliente);
		$totalRows_cliente = mysql_num_rows($cliente);
	
		$query_ftp = sprintf("SELECT * FROM ftp WHERE id_login = %s", $row_cliente['id_cadastro']);
		$ftp = mysql_query($query_ftp, $pulsar) or die(mysql_error());
		$row_ftp = mysql_fetch_assoc($ftp);
		$totalRows_ftp = mysql_num_rows($ftp);
	
		if ($totalRows_ftp == 0) {
	
				//			$ftproot = "/var/www/public_html/ftp/";
				//			$srcroot = "/var/www/public_html/ftp/";
			$ftproot = $homeftp;
			$srcroot = $homeftp;
			$srcrela = ltrim($row_cliente['id_cadastro'],"0");
				/*
				 $ftpc = ftp_connect("ftp.pulsarimagens.com.br");
				$ftpr = ftp_login($ftpc,"admpul","padm25sar");
	
				if ((!$ftpc) || (!$ftpr)) { echo "FTP connection not established!"; die(); }
				if (!chdir($srcroot)) { echo "Could not enter local source root directory."; die(); }
				if (!ftp_chdir($ftpc,$ftproot)) { echo "Could not enter FTP root directory."; die(); }
	
				ftp_mkdir    ($ftpc,$ftproot.$srcrela);
				//chmod($srcroot.$srcrela,0777);
				//ftp_chmod ($ftpc, 0777, $ftproot.$srcrela);
				$chmod_cmd="CHMOD 0777 ".$ftproot.$srcrela;
				$chmod=ftp_site($ftpc, $chmod_cmd);
				*/
	
			mkdir ($ftproot.$srcrela, 0777);
	
			$msg = "Diretório criado com sucesso!!!";
	
			$insertSQL = sprintf("INSERT INTO ftp (id_login, data_cria) VALUES (%s,%s)",
	                GetSQLValueString($row_cliente['id_cadastro'], "int"),
					GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"));
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
		} else {
			$error = "Diretório já existe!!!";
		};
	};
};

mysql_select_db($database_pulsar, $pulsar);
$query_diretorios = "SELECT * FROM cadastro ORDER BY nome ASC";
$diretorios = mysql_query($query_diretorios, $pulsar) or die(mysql_error());
$totalRows_diretorios = mysql_num_rows($diretorios);

$sql3="select * from log_download2 where id_login = ".$idLogin." order by id_log desc";

mysql_select_db($database_pulsar, $pulsar);
$formulario = mysql_query($sql3, $pulsar) or die(mysql_error());
$row_formulario = mysql_fetch_assoc($formulario);
$totalRows_formulario = mysql_num_rows($formulario);

mysql_select_db($database_pulsar, $pulsar);
$query_ftps = "SELECT cadastro.login,   cadastro.id_cadastro,   cadastro.email, cadastro.nome, cadastro.temporario FROM ftp  INNER JOIN cadastro ON (ftp.id_login=cadastro.id_cadastro)";
$ftps = mysql_query($query_ftps, $pulsar) or die(mysql_error());
$row_ftps = mysql_fetch_assoc($ftps);
$totalRows_ftps = mysql_num_rows($ftps);

mysql_select_db($database_pulsar, $pulsar);
$query_emails = "SELECT * FROM usuarios";
$emails = mysql_query($query_emails, $pulsar) or die(mysql_error());
$row_emails = mysql_fetch_assoc($emails);
$totalRows_emails = mysql_num_rows($emails);

mysql_select_db($database_pulsar, $pulsar);
$query_to = sprintf("SELECT * FROM cadastro WHERE id_cadastro = %s", $idLogin);
$to = mysql_query($query_to, $pulsar) or die(mysql_error());
$row_to = mysql_fetch_assoc($to);
$totalRows_to = mysql_num_rows($to);

$titulo = "";
$titulo_error = false;
$action  = isset($_POST['action'])?$_POST['action']:"";

$colname_arquivos = "-1";
if ($idLogin!=-1) {
  $colname_arquivos = (get_magic_quotes_gpc()) ? $idLogin : addslashes($idLogin);
}

mysql_select_db($database_pulsar, $pulsar);
$query_arquivos = sprintf("SELECT * FROM ftp_arquivos WHERE id_ftp = %s ORDER BY nome", $colname_arquivos);
// echo $query_arquivos; 
$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
$row_arquivos = mysql_fetch_assoc($arquivos);
$totalRows_arquivos = mysql_num_rows($arquivos);
?>