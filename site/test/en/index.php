<?php require_once('Connections/pulsar.php'); ?>
<?php include("../tool_gethomeimg.php"); ?>
<?php
include("../tool_index.php");
mysql_select_db($database_pulsar, $pulsar);
$query_texto = "SELECT * FROM texto_inicial";
$texto = mysql_query($query_texto, $pulsar) or die(mysql_error());
$row_texto = mysql_fetch_assoc($texto);
$totalRows_texto = mysql_num_rows($texto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>
<?php include("../tool_tooltip.php")?>

<?php include("part_topbar.php")?>

<div class="home-welcome">
	<img src="<?php echo $home_img;?>" class="big" onclick="document.location.href='details.php?tombo=<?php echo $row_home['tombo'];?>'" style="cursor: pointer;"/>
<!--	<div class="busca">
  		<h2>Busca:</h2>
		<a href="buscaavancada.php" class="adv">Busca avançada</a>
		<form name="form1" method="get" action="listing.php">
			<div class="clear"></div>
		    <select class="select" name="filtro">
		        <option value="foto" selected="selected">Fotos</option>
      			<option value="video">Vídeos</option>
			</select>
			<input name="query" type="text" class="text" />
			<input name="pc_action" type="submit" class="button" value="Ir" />
			<div class="clear"></div>
			<label><input name="type" type="radio" value="pc" class="radio" checked="checked" /> &nbsp;Por Palavra Chave</label>
			<label><input name="type" type="radio" value="tombo" class="radio" /> &nbsp;Código de imagem</label>
      
			<div class="clear"></div>
			<input name="tipo" type="hidden" value="inc_pc.php"/>
			<input name="home" type="hidden" value="true"/>
			<input name="pc_action" type="hidden" value="Ir"/>
		</form>
	</div>-->
	<div class="bemvindo">
		<span class="cadastrese"><a href="cadastro.php">Register</a></span>
		<div class="col">
			<h2>Welcome to Pulsar Images</h2>
			We are an image bank gathering the photographic documentation of over forty professional photographers, <br />with solid careers and focused on documenting Brazil,
		</div>
		<div class="col" style="padding-top: 28px;">
			our population, culture and behavior, economic production, nature and environment in all its continental extension
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="main size960">

<!--	<div class="grid-left">
		<div class="badv"><a href="buscaavancada.php"></a></div>
<br>		

<?php include("menu_coolmenu.php" )?>
		
	</div>-->
	<div class=""><!-- .grid-right -->
		<div class="home-imagens">

<?php 
$timeStart = microtime(true);
?>

<?php include("carousel_videos_temas_mais_vistos.php")?>

<?php 
$timeEnd = microtime(true);
$diff = $timeEnd - $timeStart;
$c3 = $diff;
if($siteDebug) {
	echo "<strong>delay carousel_videos_temas_mais_vistos: </strong>".$diff."</strong><br>";
}
//if($siteDebug) {
	$timeStart = microtime(true);
//}
?>		
		
<?php include("carousel_ultimas_add.php")?>		

<?php 
$timeEnd = microtime(true);
$diff = $timeEnd - $timeStart;
$c1 = $diff;
if($siteDebug) {
	echo "<strong>delay carousel_ultimas_add: </strong>".$diff."</strong><br>";
}
//if($siteDebug) {
	$timeStart = microtime(true);
//}
?>		

<?php //include("carousel_ultimas_add2.php")?>		

<?php //include("carousel_mais_vistas.php")?>

<?php include("carousel_ultimas_vistas.php")?>

<?php 
$timeEnd = microtime(true);
$diff = $timeEnd - $timeStart;
$c2 = $diff;
if($siteDebug) {
	echo "<strong>delay carousel_ultimas_vistas: </strong>".$diff."</strong><br>";
}
//if($siteDebug) {
	$timeStart = microtime(true);
//}
?>		

<?php //include("carousel_temas_mais_vistos.php")?>

<?php 
$timeEnd = microtime(true);
$diff = $timeEnd - $timeStart;
//$c3 = $diff;
if($siteDebug) {
	echo "<strong>delay carousel_temas_mais_vistos: </strong>".$diff."</strong><br>";
}
?>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php include("part_footer.php")?>

</body>
</html>
<!-- 
<?php 
echo "<strong>delay carousel_ultimas_add: </strong>".$c1."</strong><br>";
echo "<strong>delay carousel_ultimas_vistas: </strong>".$c2."</strong><br>";
echo "<strong>delay carousel_videos_temas_mais_vistos: </strong>".$c3."</strong><br>";
?>
 -->