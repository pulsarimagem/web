<?php require_once('Connections/pulsar.php'); ?>
<?php 
unset($GLOBALS['MM_Username']);
unset($GLOBALS['MM_UserGroup']);
	
//register the session variables
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
session_unset();
$logged = false;

header("Location: main.php");
?>