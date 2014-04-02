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
		}
//		$_SESSION['produto'.$_GET['add']]['valor'] = 1.20;
	}
	header('Location: '.$pagina);
		
}

if(isset($_GET['del'])){
		unset($_SESSION['produto']['produtos_'.$_GET['del']]);
		unset($_SESSION['produto'.$_GET['del']]['valor']);
		header('Location: '.$pagina);
	}

?>

