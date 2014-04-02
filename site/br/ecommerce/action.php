<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
session_start();
//instancia pagina carrinho

$pagina = '../carrinho.php';

if(isset($_GET['add'])){
	//cria uma sessao unica para cada produto uma unica vez
	if(empty($_SESSION['produto']['produtos_'.$_GET['add']])){
		$_SESSION['produto']['produtos_'.$_GET['add']] = '1';
		$_SESSION['produto'.$_GET['add']]['valor'] = 1.20;
	}
	
	header('Location: '.$pagina);
		
}

if(isset($_GET['del'])){
		unset($_SESSION['produto']['produtos_'.$_GET['del']]);
		unset($_SESSION['produto'.$_GET['del']]['valor']);
		header('Location: '.$pagina);
	}

?>

