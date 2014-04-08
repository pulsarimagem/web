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
	if(($login = $_POST['login']) == "") {
		$login_error = true;
		$login_error_msg = LOGIN_LOGIN_ERROR;
		$has_error = true;
	}
	if(($senha = $_POST['senha']) == "") {
		$senha_error = true;
		$senha_error_msg = LOGIN_SENHA_ERROR;
		$has_error = true;
	}
}

if (isset($_GET['login']) && isset($_GET['senha'])) {
	$submit = true;
	
	$login = $_GET['login'];
	$senha = $_GET['senha'];
}


/*
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

	switch ($theType) {
		case "text":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		case "long":
		case "int":
			$theValue = ($theValue != "") ? intval($theValue) : "NULL";
			break;
		case "double":
			$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
			break;
		case "date":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		case "defined":
			$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
			break;
	}
	return $theValue;
}
*/

if(!$has_error && $submit) {
//	$loginUsername=$_POST['login'];
//	$password=$_POST['senha'];
	$loginUsername=$login;
	$password=$senha;
	$MM_fldUserAuthorization = "tipo";
//	$MM_redirectLoginSuccess = "primeirapagina.php?welcome=";
	$MM_redirectLoginSuccess = $_SESSION['last_uri'];
	$MM_redirectLoginFailed = "login.php";
	$MM_redirecttoReferrer = false;
	mysql_select_db($database_pulsar, $pulsar);
	 
	$LoginRS__query=sprintf("SELECT login, senha, download FROM cadastro WHERE login='%s'",
	get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password));
	 
	$LoginRS = mysql_query($LoginRS__query, $pulsar) or die(mysql_error());
	$loginDataUser = mysql_fetch_assoc($LoginRS);
	$loginFoundUser = mysql_num_rows($LoginRS);
	if ($loginFoundUser) {


		$LoginRS__query=sprintf("SELECT id_cadastro, login, senha, download FROM cadastro WHERE login='%s' AND senha='%s'",
		get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password));
		 
		$LoginRS = mysql_query($LoginRS__query, $pulsar) or die(mysql_error());
		$loginDataUser = mysql_fetch_assoc($LoginRS);
		$loginFoundPass = mysql_num_rows($LoginRS);
		 
		 
		if ($loginFoundPass) {
			 
			$loginStrGroup  = mysql_result($LoginRS,0,'download');
			 
			//declare two session variables and assign them
//			$GLOBALS['MM_Username'] = $loginUsername;
//			$GLOBALS['MM_UserGroup'] = $loginStrGroup;

			//register the session variables
//			session_register("MM_Username");
//			session_register("MM_UserGroup");
			$_SESSION['MM_Username'] = $loginUsername;
			$_SESSION['MM_UserGroup'] = $loginStrGroup;
			

			if (isset($_SESSION['PrevUrl'])) { // && false) {
				$MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
				unset($_SESSION['PrevUrl']);
			}
			
			$sqlCarrinho = "SELECT tombo, id_uso FROM carrinho WHERE id_cadastro = ".$loginDataUser['id_cadastro'];
			$rsCarrinho = mysql_query($sqlCarrinho, $pulsar) or die(mysql_error());
			while($rowCarrinho = mysql_fetch_array($rsCarrinho)) {
				$_SESSION['produto']['produtos_'.$rowCarrinho['tombo']] = '1';
				$id_uso = $rowCarrinho['id_uso'];
				$_SESSION['produto'.$rowCarrinho['tombo']]['uso'] = $id_uso;
				
				mysql_select_db($database_sig, $sig);
			
				$queryUso = "select uso.valor
				from USO as uso
				WHERE uso.Id = $id_uso";
				$rsUso = mysql_query($queryUso, $sig) or die(mysql_error());
				$totalUso = mysql_num_rows($rsUso);
				$rowUso = mysql_fetch_array($rsUso);
				
				//			$_SESSION['produto'.$_GET['add']]['valor'] = ($lingua!="br"?convertPounds($rowUso['valor']):$rowUso['valor']);
				$_SESSION['produto'.$rowCarrinho['tombo']]['valor'] = $rowUso['valor'];
			}
			
			header("Location: " . $MM_redirectLoginSuccess );

echo $_SESSION['last_uri']."<br>" ;
echo $_SESSION['PrevUrl']."<br>" ;
echo $MM_redirectLoginSuccess."<br>" ;
		}
		else {
			$has_error = true;
			$senha_error = true;
			$senha_error_msg = LOGIN_SENHA_INVALID;
		}
	}
	else {
		$has_error = true;
		$login_error = true;
		$login_error_msg = LOGIN_LOGIN_INVALID;
	}
}

if($has_error) {
	if(isset($_SESSION['last_uri'])) {
		$_SESSION['this_uri'] = $_SESSION['last_uri'];
	}
}
?>