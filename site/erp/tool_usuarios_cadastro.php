<?php
mysql_select_db($database_pulsar, $pulsar);
mysql_select_db($database_sig, $sig);

$isNew = true;
$isEdit = isset($_GET['idUser'])?$_GET['idUser']:-1;
$isUpdate = isset($_POST['updateUser'])?$_POST['updateUser']:-1;
$isSave = isset($_POST['saveUser'])?true:false;
$isDel = isset($_GET['delUser'])?$_GET['delUser']:-1;

$queryRoles = "SELECT id, nome FROM roles WHERE status >= 0";
$rsRoles = mysql_query($queryRoles, $pulsar) or die(mysql_error());

if($isSave) {
	$nome = $_POST['name'];
	$usuario = $_POST['user'];
	$senha = $_POST['password'];
	$status = $_POST['status'];
	$role = $_POST['role'];
	
	$queryUsers = "INSERT INTO USUARIOS (nome,usuario,senha,status,role) VALUES ('$nome','$usuario','$senha','$status',$role)";
	if($siteDebug)
		echo $queryUsers;
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	$isEdit = mysql_insert_id();
}
if($isUpdate > 0) {
	$nome = $_POST['name'];
	$usuario = $_POST['user'];
	$senha = $_POST['password'];
	$status = $_POST['status'];
	$role = $_POST['role'];
	
	$queryUsers = "UPDATE USUARIOS SET nome = '$nome', usuario = '$usuario', senha = '$senha', status='$status', role = $role WHERE id = $isUpdate";
	if($siteDebug)
		echo $queryUsers;
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	$isEdit = $isUpdate;
}
if($isEdit>0) {
	$isNew = false;
	$queryUsers = "select USUARIOS.id, USUARIOS.nome, USUARIOS.usuario, USUARIOS.status, roles.nome as role from USUARIOS LEFT JOIN roles ON roles.id = USUARIOS.role WHERE USUARIOS.id = ".$isEdit;
	if($siteDebug)
		echo $queryUsers;
	$rsUsers = mysql_query($queryUsers, $pulsar) or die(mysql_error());
	$rowUsers = mysql_fetch_assoc($rsUsers);
}
if($isDel > 0) {
	$isNew = false;
	$queryDelUsers = "UPDATE USUARIOS SET status = 'D' WHERE id = $isDel";
	$rsDelUsers = mysql_query($queryDelUsers, $pulsar) or die(mysql_error());
	if($siteDebug)
		echo $queryDelUsers;
	header("location: usuarios.php");
}
?>