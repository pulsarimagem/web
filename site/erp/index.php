<?php require_once('Connections/pulsar.php'); ?>
<?php 
unset($GLOBALS['MM_Username_erp']);
unset($GLOBALS['MM_UserGroup_erp']);
	
//register the session variables
unset($_SESSION['MM_Username_erp']);
unset($_SESSION['MM_UserGroup_erp']);
session_unset();
$logged = false;

header("Location: main.php");
?>