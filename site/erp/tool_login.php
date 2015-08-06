<?php
$url_ok = "emailsucesso.php?anterior=index.php";

$has_error = false;
$login_error = false;
$senha_error = false;
$submit = false;

$login = "";
$senha = "";

if (isset($_POST['action'])) {
	$submit = true;
	if(($login = strtoupper($_POST['login'])) == "") {
		$login_error = true;
		$login_error_msg = "O Login é um campo obrigatório!";
		$has_error = true;
	}
	if(($senha = $_POST['senha']) == "") {
		$senha_error = true;
		$senha_error_msg = "A Senha é um campo obrigatório!";
		$has_error = true;
	}
}

if (isset($_GET['login']) && isset($_GET['senha'])) {
	$submit = true;
	
	$login = strtoupper($_GET['login']);
	$senha = $_GET['senha'];
}

if(!$has_error && $submit) {
	$loginUsername=$login;
	$password=$senha;
	$MM_fldUserAuthorization = "tipo";
	$MM_redirectLoginSuccess = $_SESSION['last_uri'];
	$MM_redirectLoginFailed = "login.php";
	$MM_redirecttoReferrer = false;
	mysql_select_db($database_sig, $sig);
	 
//	$LoginRS__query=sprintf("SELECT * FROM usuarios WHERE login like '%s'",
	$LoginRS__query=sprintf("SELECT usuario FROM USUARIOS WHERE usuario='%s'",
	get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername)); 
// echo $LoginRS__query;
  	
	$LoginRS = mysql_query($LoginRS__query, $pulsar) or die(mysql_error());
	$loginDataUser = mysql_fetch_assoc($LoginRS);
	$loginFoundUser = mysql_num_rows($LoginRS);
	if ($loginFoundUser) {


//	  	$LoginRS__query=sprintf("SELECT * FROM usuarios WHERE login like '%s' AND senha='%s'",
	  	$LoginRS__query=sprintf("SELECT * FROM USUARIOS WHERE usuario='%s' AND senha='%s'",
	  			
    	strtoupper(get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername)), get_magic_quotes_gpc() ? $password : addslashes($password));
// echo $LoginRS__query;
	  	
//		$LoginRS__query=sprintf("SELECT * FROM fotografos WHERE Iniciais_Fotografo='%s'",
//    	get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername)); 
    	
		$LoginRS = mysql_query($LoginRS__query, $pulsar) or die(mysql_error());
		$loginDataUser = mysql_fetch_assoc($LoginRS);
		$loginFoundPass = mysql_num_rows($LoginRS);
		
//		$loginFoundPass = ($senha==$loginUsername."2012");
		 
		if ($loginFoundPass) {
			 
			$loginStrGroup  = mysql_result($LoginRS,0,'download');
			 
			//register the session variables
			$_SESSION['MM_Username_erp'] = $loginUsername;
			$_SESSION['MM_UserGroup_erp'] = $loginStrGroup;
				

			if (isset($_SESSION['PrevUrl'])) { // && false) {
				$MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
				unset($_SESSION['PrevUrl']);
			}
			header("Location: " . $MM_redirectLoginSuccess );

echo $_SESSION['this_uri']."<br>" ;
echo $_SESSION['last_uri']."<br>" ;
echo $_SESSION['PrevUrl']."<br>" ;
echo $MM_redirectLoginSuccess."<br>" ;
		}
		else {
			$has_error = true;
			$senha_error = true;
			$senha_error_msg = "Senha incorreta!";
		}
	}
	else {
		$has_error = true;
		$login_error = true;
		$login_error_msg = "Usuário não encontrado!";
	}
}

if($has_error) {
	if(isset($_SESSION['last_uri'])) {
		$_SESSION['this_uri'] = $_SESSION['last_uri'];
	}
}
?>