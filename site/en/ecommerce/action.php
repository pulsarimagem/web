<?php require_once('../Connections/pulsar.php'); ?>
<?php require_once('../Connections/sig.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
function convertPounds($reais) {
	$pounds = ceil(($reais - ($reais*0.3))*0.66);
	return $pounds.".00";
}


session_start();
//instancia pagina carrinho
$pagina = '../carrinho.php';
if(isset($_GET['add'])){
	$lingua = isset($_GET['lingua'])?$_GET['lingua']:"br";
	//cria uma sessao unica para cada produto uma unica vez
	if(empty($_SESSION['produto']['produtos_'.$_GET['add']]) || true){
		$_SESSION['produto']['produtos_'.$_GET['add']] = '1';
		if(isset($_GET['uso'])) {
			$_SESSION['produto'.$_GET['add']]['uso'] = $_GET['uso'];
			$id_uso = $_GET['uso'];
			$queryUso = "select uso.valor
						from USO as uso
						WHERE uso.Id = $id_uso";
			
			$rsUso = mysql_query($queryUso, $sig) or die(mysql_error());
			$totalUso = mysql_num_rows($rsUso);
			$rowUso = mysql_fetch_array($rsUso);
//			$_SESSION['produto'.$_GET['add']]['valor'] = ($lingua!="br"?convertPounds($rowUso['valor']):$rowUso['valor']);
			$_SESSION['produto'.$_GET['add']]['valor'] = $rowUso['valor'];
			$_SESSION['lastUso'] = $id_uso;
			
			mysql_select_db($database_pulsar, $pulsar);
			
			$sqlLogin = "SELECT id_cadastro, nome, email, download, empresa, login, senha FROM cadastro WHERE login like '".$_SESSION['MM_Username']."'";
			$rsLogin = mysql_query($sqlLogin, $pulsar) or die(mysql_error());
			$rowLogin = mysql_fetch_array($rsLogin);
				
			$sqlCarrinho  = "INSERT INTO carrinho (tombo,id_cadastro,id_uso) VALUES ('".$_GET['add']."',".$rowLogin['id_cadastro'].",$id_uso)";
			$rsCarrinho = mysql_query($sqlCarrinho, $pulsar) or die(mysql_error());
				
		}
//		$_SESSION['produto'.$_GET['add']]['valor'] = 1.20;
	}
	header('Location: '.$pagina);
		
}

if(isset($_GET['del'])){
		unset($_SESSION['produto']['produtos_'.$_GET['del']]);
		unset($_SESSION['produto'.$_GET['del']]['valor']);
		
		mysql_select_db($database_pulsar, $pulsar);
			
		$sqlLogin = "SELECT id_cadastro, nome, email, download, empresa, login, senha FROM cadastro WHERE login like '".$_SESSION['MM_Username']."'";
		$rsLogin = mysql_query($sqlLogin, $pulsar) or die(mysql_error());
		$rowLogin = mysql_fetch_array($rsLogin);
		
		$sqlCarrinho  = "DELETE FROM carrinho WHERE tombo = '".$_GET['del']."' AND id_cadastro = ".$rowLogin['id_cadastro'];
		$rsCarrinho = mysql_query($sqlCarrinho, $pulsar) or die(mysql_error());

		header('Location: '.$pagina);
	}

?>

