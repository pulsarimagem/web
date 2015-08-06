<?php
$toLoad = false;
$multiLoad = false;
$tomboExists = false;
$tombos = array();
$isFotoTmp = (isset($_GET['fotoTmp'])?true:false);
$deleteFotoTmp = (isset($_POST['deleteVideoTmp'])?true:false); 
$isCopy = (isset($_GET['copiar'])?true:false);
$isCopyDesc = (isset($_GET['copiar_desc'])?true:false);
$isCopyIptc = (isset($_GET['copy_iptc'])?true:false);
$action = isset($_GET['action'])?strtolower($_GET['action']):"";
$action = isset($_POST['action'])?strtolower($_POST['action']):$action;

$msg = isset($_GET['msg'])?$_GET['msg']:"";

// print_r($_POST);
// print_r($_GET);
mysql_select_db($database_pulsar, $pulsar);

if ($action == "excluir") {
	$codigo = strtoupper_br($_GET['tombo']);
	
	$user = "pulsar";
	$param = array('user'=>$user, 'tombo'=>$codigo);
	$data = curl_request_async($cloud_server.'remove_from_s3.php', $param, "GET");
	//  
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/fotos/previews/".$codigo.".jpg";
// 	$out = shell_exec($cmd);
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/fotos/previews/".$codigo."p.jpg";
// 	$out = shell_exec($cmd);
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/fotos/orig/".$codigo.".jpg";
// 	$out = shell_exec($cmd);
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/videos/previews/".$codigo."_640x360.flv";
// 	$out = shell_exec($cmd);
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/videos/previews/".$codigo."_640x360.mp4";
// 	$out = shell_exec($cmd);
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/videos/orig/".$codigo.".mov";
// 	$out = shell_exec($cmd);

	header("Location: administracao_s3.php?msg=Excluído com sucesso!");
}


// if(isset($_POST['tombos']))
// 	$_POST['tombos'] = strtoupper($_POST['tombos']);
// if(isset($_GET['tombos']))
// 	$_GET['tombos'] = strtoupper($_GET['tombos']);

$colname_dados_foto = "0";
if (isset($_GET['action'])) {
	if($_GET['action'] == "multi") {
		$tombos = array();
		$id_fotos = array();
		$prefix = $_GET['prefix'];
		for ($i = $_GET['inicio']; $i <= $_GET['fim']; $i++) {
			$sufix = str_pad((int) $i,3,"0",STR_PAD_LEFT);
			$codigo = strtoupper("$prefix$sufix");
			
			$user = "pulsar";
			$param = array('user'=>$user, 'tombo'=>$codigo);
			$data = curl_request_async($cloud_server.'remove_from_s3.php', $param, "GET");
			
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/fotos/previews/".$codigo.".jpg";
//  	$out = shell_exec($cmd);
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/fotos/previews/".$codigo."p.jpg";
//  	$out = shell_exec($cmd);
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/fotos/orig/".$codigo.".jpg";
//  	$out = shell_exec($cmd);
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/videos/previews/".$codigo."_640x360.flv";
//  	$out = shell_exec($cmd);
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/videos/previews/".$codigo."_640x360.mp4";
//  	$out = shell_exec($cmd);
// 	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/videos/orig/".$codigo.".mov";
//  	$out = shell_exec($cmd);
	
		}
		header("Location: administracao_s3.php?msg=Excluídos com sucesso!");
	}
}
?>