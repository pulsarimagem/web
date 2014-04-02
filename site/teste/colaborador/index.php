<?php require_once('Connections/pulsar.php'); ?>
<?php 
unset($GLOBALS['MM_Username_Fotografo']);
unset($GLOBALS['MM_UserGroup_Fotografo']);
	
//register the session variables
unset($_SESSION['MM_Username_Fotografo']);
unset($_SESSION['MM_UserGroup_Fotografo']);
session_unset();
$logged = false;

header("Location: menu.php");
?>