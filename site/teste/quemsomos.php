<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_gethomeimg.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Imagens</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>

<?php include("part_topbar.php")?>

<div class="main size960">

<?php include("part_grid_left.php")?>

	<div class="grid-right">
		<div class="quemsomos">
<!-- 			<p class="welcome"></p> -->
			<img src="<?php echo $home_img;?>" style="max-width:716px; max-height:221px;" class="big" />
			<div class="colA">
				<p>A Pulsar Imagens nasceu em 1991 e desde então vem crescendo e consolidando sua presença no mercado fotográfico. Nossos fotógrafos trabalham  com equipamentos de ponta produzindo originais de alta definição sempre em sintonia com a demanda do mercado. </p>
				<p>Nosso acervo fotográfico possui mais de um milhão de imagens, com uma extensa documentação de festas populares, paisagens, estradas, indústrias, parques nacionais, artesanato, turismo, etc  do Brasil. Possuímos um dos arquivos mais ricos sobre as belezas e características do nosso país, além de um grande número de fotos do exterior.</p>
<br /><br /><h2>Clientes</h2>
				<p>A Pulsar Imagens tem atualmente entre os seus clientes as maiores editoras de livros didáticos do país,  alem de outras grandes empresas do mercado editorial brasileiro. As principais agências de publicidade brasileiras  também comprovaram a nossa qualidade utilizando nossas fotos em grandes campanhas espalhadas por todo o país. Possuímos também  imagens publicadas em diversos países, como França, Inglaterra, Alemanha e EUA.    </p>
			</div>
			<div class="colB">
				<p>Nossos autores renovam constantemente seus equipamentos buscando sempre a melhor qualidade e garantindo a atualização de nosso material. Todas as nossas imagens analógicas, cromos/slides, foram  escaneadas e tratadas com equipamentos de ponta, garantindo assim a qualidade dos originais digitais para qualquer veículo e em qualquer tamanho. </p>
				<p>Nosso staff de fotógrafos é formado por profissionais experientes e ganhadores de prêmios como o Nikon de Fotografia, Esso de Jornalismo e Wladimir Herzog de Direitos Humanos entre outros. Muitas de nossas imagens também estão no acervo de grandes instituições como MASP/SP, Instituto Moreira Salles, Itaú Cultural, MAM/RJ e National Museum of Natural History / Smithsonian Institute. </p>
		  <p class="quote">Ao trabalhar conosco, você  conta com um atendimento especializado e experiente na área de edição fotográfica, para que você receba a imagem que precisa no tempo que precisa. Navegue pelo nosso acervo e <a href="contato.php">fale conosco</a>.
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
