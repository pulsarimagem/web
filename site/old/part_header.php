<?php
$currentURL = $_SERVER["PHP_SELF"];
$partsURL = Explode('/', $currentURL);
$this_page = $partsURL[count($partsURL) - 1];
?>

<div class="header size960">
	<a href="index.php" class="logo"></a>
	<div class="menu">
		<ul>
<?php if($this_page == "index.php") { ?>
			<li><a href="index.php"><strong>Home</strong></a></li>
<?php } else {?>
			<li><a href="index.php">Home</a></li>
<?php }?>
<?php if($this_page == "comofunciona.php") { ?>
			<li><a href="comofunciona.php"><strong>Como Funciona?</strong></a></li>
<?php } else {?>
			<li><a href="comofunciona.php">Como Funciona?</a></li>
<?php }?>
<?php if($this_page == "fotografos.php") { ?>
			<li><a href="fotografos.php"><strong>Fotógrafos</strong></a></li>
<?php } else {?>
			<li><a href="fotografos.php">Fotógrafos</a></li>
<?php }?>
<?php /*if($this_page == "quemsomos.php") { ?>
			<li><a href="quemsomos.php"><strong>Quem Somos</strong></a></li>
<?php } else {?>
			<li><a href="quemsomos.php">Quem Somos</a></li>
<?php }*/?>
<?php if($this_page == "primeirapagina.php") { ?>
			<li><a href="primeirapagina.php"><strong>Minhas Imagens</strong></a></li>
<?php } else {?>
			<li><a href="primeirapagina.php">Minhas Imagens</a></li>
<?php }?>
<?php if($this_page == "solicitarcotacao.php") { ?>
			<li><a href="solicitarcotacao.php"><strong>Cotação</strong></a></li>
<?php } else {?>
			<li><a href="solicitarcotacao.php">Cotação</a></li>
<?php }?>
<?php if($this_page == "cadastro.php" || $this_page == "cadastro_pj.php" ) { ?>
			<li><a href="cadastro_pj.php"><strong>Cadastro</strong></a></li>
<?php } else {?>
			<li><a href="cadastro_pj.php">Cadastro</a></li>
<?php }?>
<?php if($this_page == "buscaavancada.php") { ?>
			<li><a href="buscaavancada.php"><strong>Busca avançada</strong></a></li>
<?php } else {?>
			<li><a href="buscaavancada.php">Busca avançada</a></li>
<?php }?>
		</ul>
	</div>
	<div class="clear"></div>
</div>