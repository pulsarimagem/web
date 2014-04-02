<?php require_once('Connections/pulsar.php'); ?>
<?php 
unset($GLOBALS['MM_Username_Sig']);
unset($GLOBALS['MM_UserGroup_Sig']);
	
//register the session variables
unset($_SESSION['MM_Username_Sig']);
unset($_SESSION['MM_UserGroup_Sig']);
session_unset();
$logged = false;

header("Location: menu.php");
?>