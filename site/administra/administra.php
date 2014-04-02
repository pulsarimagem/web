<?php require_once('Connections/pulsar.php'); ?>
<?php
// *** Validate request to login to this site.
//session_start();

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($accesscheck)) {
//  $GLOBALS['PrevUrl'] = $accesscheck;
//  session_register('PrevUrl');
  $_SESSION['PrevUrl'] = $accesscheck;
}

if (isset($_POST['login'])) {
  $loginUsername=$_POST['login'];
  $password=$_POST['senha'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "administra2.php";
  $MM_redirectLoginFailed = "administra.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_pulsar, $pulsar);
  
  $LoginRS__query=sprintf("SELECT login, senha FROM usuarios WHERE login='%s' AND senha='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $pulsar) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
//    $GLOBALS['MM_Username'] = $loginUsername;
//    $GLOBALS['MM_UserGroup'] = $loginStrGroup;	      

    //register the session variables
//    session_register("MM_Username");
//    session_register("MM_UserGroup");
	
	$_SESSION['MM_Username'] = $loginUsername;
	$_SESSION['MM_UserGroup'] = $loginStrGroup;


    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
</head>

<body>
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td><span class="style1">pulsarimagens.com.br<br>
         tela do administrador</span></td>
   </tr>
</table>
<br>
<form action="<?php echo $loginFormAction; ?>" method="POST" name="form1">
  <font face="Verdana, Arial, Helvetica, sans-serif">Login: 
  <input name="login" type="text" id="login">
  <br>
  Senha: 
  <input name="senha" type="password" id="senha">
  <input name="Submit" type="submit" value="Enviar">
  </font> 
</form>
<script language="javascript">
var bFound = false;

  // for each form
  for (f=0; f < document.forms.length; f++)
  {
    // for each element in each form
    for(i=0; i < document.forms[f].length; i++)
    {
      // if it's not a hidden element
      if (document.forms[f][i].type != "hidden")
      {
        // and it's not disabled
        if (document.forms[f][i].disabled != true)
        {
            // set the focus to it
            document.forms[f][i].focus();
            var bFound = true;
        }
      }
      // if found in this element, stop looking
      if (bFound == true)
        break;
    }
    // if found in this form, stop looking
    if (bFound == true)
      break;
  }
</script>
</body>
</html>
