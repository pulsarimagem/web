<?php
mysql_select_db($database_pulsar, $pulsar);
mysql_select_db($database_sig, $sig);


$isNew = true;
$isEdit = isset($_GET['idUser'])?$_GET['idUser']:-1;
$isUpdate = isset($_POST['updateUser'])?$_POST['updateUser']:-1;
$isSave = isset($_POST['saveUser'])?true:false;
$isDel = isset($_GET['delUser'])?$_GET['delUser']:-1;

$menuArr = $menu->getMenuArr();

foreach($menuArr as $submenu=>$val) {

	$sql = "SHOW COLUMNS FROM roles LIKE '$submenu'";
	$rs = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($rs) < 1) {
		$sql = "ALTER TABLE roles ADD COLUMN $submenu INT(1) NOT NULL DEFAULT -1";
		$rs = mysql_query($sql) or die(mysql_error());
	}
}

if($isSave) {
	$nome = $_POST['name'];
	$status = $_POST['status'];
	
	$valueNames = "";
	$valueVal = "";
	
	foreach($menuArr as $submenu=>$val) {
		$menuArr[$submenu] = $_POST[$submenu];
		$valueNames .= ",$submenu";
		$valueVal .= ",$menuArr[$submenu]";
	}
	
	$queryUsers = "INSERT INTO roles (nome,status$valueNames) VALUES ('$nome','$status'$valueVal)";
	if($siteDebug)
		echo $queryUsers;
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	$isEdit = mysql_insert_id();
	$msg = "Inserido com sucesso!";
}
if($isUpdate > 0) {
	$nome = $_POST['name'];
	$status = $_POST['status'];
	
	$valueNamesVal = "";
	
	foreach($menuArr as $submenu=>$val) {
		$menuArr[$submenu] = $_POST[$submenu];
		$valueNamesVal .= ",$submenu = $menuArr[$submenu]";
	}
	
	$queryUsers = "UPDATE roles SET nome = '$nome', status='$status' $valueNamesVal WHERE id = $isUpdate";
// 	if($siteDebug)
		echo $queryUsers;
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	$isEdit = $isUpdate;
	$msg = "Atualizado com sucesso!";
}
if($isEdit>0) {
	$isNew = false;
	$queryUsers = "select * from roles WHERE roles.id = ".$isEdit;
	if($siteDebug)
		echo $queryUsers;
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	$rowUsers = mysql_fetch_assoc($rsUsers);
}
if($isDel > 0) {
	$isNew = false;
	$queryDelUsers = "UPDATE roles SET status = -1 WHERE id = $isDel";
	$rsDelUsers = mysql_query($queryDelUsers, $pulsar) or die(mysql_error());
	if($siteDebug)
		echo $queryDelUsers;
	header("location: roles.php?msg=Excluído com sucesso!");
}
?>