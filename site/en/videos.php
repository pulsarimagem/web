<?php require_once('Connections/pulsar.php'); ?>
<?php include("../tool_listing_videos.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>
<?php include("../tool_tooltip.php")?>

<?php include("part_topbar.php");?>

<?php 
if (isset($_SESSION['ajustar'])) echo "<div class=\"main size-wide\">";
else echo "<div class=\"main size960\">";
?>

<?php include("part_grid_left.php");?>
			
<?php 
if ($totalRows_retorno == 0) {
?>
	<div class="grid-right">
		<div class="cadastro">
			<h2>0 Resultados para a pesquisa</h2> <!-- "<?php echo $query?>" -->
			<p class="p">
                Infelizmente, <strong>não encontramos</strong> resultados para sua busca.<br/>
                Talvez alterando os termos ou verificando a ortografia correta você consiga encontrar o que está procurando.
            </p>
<?php 
if(isset($_GET['query'])) {
//	include("tool_similar_word.php");
}
?>            
			<a href="buscaavancada.php" class="back">« Tente uma busca avançada</a>
		</div>
	</div>
<?php }
else {
?>
	<div class="grid-right">
		<div class="resultado">
<?php if (isset($_SESSION['ajustar'])) echo "<div class=\"espaco1\"></div>";?>
			<form name="listing_opts" action="listing.php" method="get">		
				<div class="title">
					<h2><?php echo $totalRows_retorno?> resultados para sua pesquisa</h2>
					<div class="p">
<?php include("part_listing_options.php")?>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			
				<div class="ordenar">
					<p>Ordenar por:</p>
	                <select name="ordem" onChange="listing_opts.submit();">
 	                  <option value="relevancia" <?php if($ordem == "relevancia") echo "selected"; ?>>Mais recentes</option>
<!-- 	                  <option value="recente" <?php if($ordem == "recente") echo "selected"; ?>>Últimas adicionadas</option> -->
<!-- 	                  <option value="data" <?php if($ordem == "data") echo "selected"; ?>>Data da foto</option> -->
 	                  <option value="vistas" <?php if($ordem == "vistas") echo "selected"; ?>>Mais visualizadas</option>
	                  <option value="maior" <?php if($ordem == "maior") echo "selected"; ?>>Tamanho do arquivo</option>  
	                </select>
				</div>
<!--         		<div class="ordenar">
					<p>Filtrar por:</p>
	                <select name="filtro" onChange="listing_opts.submit();">
 	                  <option value="foto" <?php if($filtro == "foto") echo 'selected="selected"'; ?>> Fotos</option>
	                  <option value="video" <?php if($filtro == "video") echo 'selected="selected"'; ?>>Vídeos</option>  
	                </select>
				</div> -->
			</form>

			<div class="nnav">
				<?php echo $startRow_retorno?> de <?php echo $totalRows_retorno ?> imagem(ns) 
			</div>
			<div class="clear"></div>
			
			<div class="nav">
<?php 
echo $nav_bar[0];
echo $nav_bar[1];
echo $nav_bar[2];
?>
				<div class="clear"></div>
			</div>
<?php if (isset($_SESSION['ajustar'])) echo "<div class=\"espaco2\"></div>";?>
		
			<ul id="lista-script">
<?php 
$tot_fotos = 1;
$count_fotos = $startRow_retorno;
do { 
	$isVideo = isVideo($row_retorno['tombo']);
	?>
				<li>
					<a href="details.php?tombo=<?php echo $row_retorno['tombo']."&search=PA&ordem_foto=$count_fotos&total_foto=$totalRows_retorno"; ?>">
						<img <?php if($isVideo) { ?>src="<?php echo $cloud_server?>Videos/thumbs/<?php echo $row_retorno['tombo']; ?>_3s.jpg"<?php } else { ?>src="<?php echo "http://www.pulsarimagens.com.br/" //$homeurl; ?>bancoImagens/<?php echo $row_retorno['tombo']; ?>p.jpg" <?php } ?> title="" onMouseover="ddrivetip('<?php echo addslashes(delQuote($row_retorno['assunto_principal'])); ?><?php if ($row_retorno['extra'] != NULL) echo ' - '.delQuote($row_retorno["extra"]);?><?php echo ' - '.addslashes($row_retorno['cidade']); ?><?php echo ' - '.addslashes($row_retorno['Sigla']!=""?$row_retorno['Sigla']:$row_retorno['nome']); ?><?php 
if (strlen($row_retorno['data_foto']) == 4) {
	echo ' - '.$row_retorno['data_foto'];
} elseif (strlen($row_retorno['data_foto']) == 6) {
	echo ' - '.substr($row_retorno['data_foto'],4,2).'/'.substr($row_retorno['data_foto'],0,4);
} elseif (strlen($row_retorno['data_foto']) == 8) {
	echo ' - '.substr($row_retorno['data_foto'],6,2).'/'.substr($row_retorno['data_foto'],4,2).'/'.substr($row_retorno['data_foto'],0,4);
}
						?>')" onMouseout="hideddrivetip()"/>
						<span><strong><?php //echo $row_retorno['Nome_Fotografo']; ?></strong></span>
					</a>
					<div class="opt">
<?php 
if ($show_preview) { 
$res_lupa = "640x360";
if($row_retorno['resolucao']=="720x480")
	$res_lupa = "270x180";
else if($row_retorno['resolucao']=="720x586")
	$res_lupa = "220x180";
?>						
						<div class="bt-zoom">
                        	<a href="#"></a>
	                        <div class="mzoom" style="display: none;">
	                        <?php if($isVideo){ ?><div id="mp<?php echo $row_retorno['tombo']?>">JW Player goes here</div>
	<script type="text/javascript">
		jwplayer("mp<?php echo $row_retorno['tombo']; ?>").setup({
			flashplayer: "../video/player.swf",
			file: "<?php echo $cloud_server?>/Videos/previews/<?php echo $row_retorno['tombo']?>_<?php echo $res_lupa?>.flv",
			width: 320,
			height: 180,
			controlbar : "none",
			wmode : "opaque",
			autostart: true
		});
		//			image: "<?php echo $cloud_server?>/Videos/thumbs/<?php echo $row_retorno['tombo']?>_3s.jpg",
	</script>
	                        <?php } else { ?>
	                    	    <img class="on-demand" src="images/cm_fill.gif" longdesc="<?php echo "http://www.pulsarimagens.com.br/"//$homeurl; ?>bancoImagens/<?php echo $row_retorno['tombo']; ?>.jpg" style="max-width:300px; max-height:300px;" />
	                        <?php } ?>
	                        </div>
                        </div>
<?php 
} 
?>						
						<div class="bt-mesadeluz">
							<a class="icon"></a>
							<div class="box" style="display: none;" id="page_container<?php echo $row_retorno['tombo']?>">
								<p>Adicionar a Minhas Imagens:</p>
								<div class="page_navigation"></div>
								<ul class="content">
<?php 
if($logged) {
	if ($totalRows_pastas > 0)  { 
		do {
?>
									<span><a class="add_mesa" href="tool_addmesadeluz.php?id_pasta=<?php echo $row_pastas['id_pasta']; ?>&tombo=<?php echo $row_retorno['tombo']; ?>" onclick="return false" style="<?php if(check_exist($row_pastas['id_pasta'], $row_retorno['tombo'], $database_pulsar, $pulsar)) echo "color:#bc690f;";?>"><?php echo $row_pastas['nome_pasta']; ?></a></span>
<?php 
		} while ($row_pastas = mysql_fetch_assoc($pastas));
		mysql_data_seek($pastas, 0);
		$row_pastas = mysql_fetch_assoc($pastas);
	}
?>
								</ul>
								<a href="" class="add_pasta" onclick="return false" ><strong>+</strong> Criar nova pasta</a>
								<form name="form1" method="get" action="tool_addmesadeluz.php">
									<div class="form" style="display: none;">
										<input name="nova_pasta" type="text" class="text" />
										<input name="action" type="submit" class="button add_mesa" value="Ok" />
										<input name="tombo" type="hidden" value="<?php echo $row_retorno['tombo']; ?>" />
										<div class="clear"></div>
									</div>
								</form>
<?php } else { ?>
Para adicionar essa foto a Minhas Imagens você deve estar logado.
<?php } ?>
							</div>
						</div>
						<span class="<?php echo $isVideo?"iconVideo":"iconFoto"; ?>"></span>
						<span><?php echo $row_retorno['tombo']; ?></span>					
						<div class="clear"></div>
					</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#page_container<?php echo $row_retorno['tombo']?>').pajinate({
		nav_label_first : '<<',
		nav_label_last : '>>',
		nav_label_prev : '<',
		nav_label_next : '>',
        items_per_page : 10,
        start_page : 0,
        num_page_links_to_display : 4,
        show_first_last: false,
		abort_on_small_lists: true
	});
});
</script>					
				</li>
<?php
	$tot_fotos++;
	$count_fotos++;
?>
<?php } while ($row_retorno = mysql_fetch_assoc($retorno)); ?>
				<div class="clear"></div>
			</ul>
			
			<div class="nav">
<?php 
echo $nav_bar[0];
echo $nav_bar[1];
echo $nav_bar[2];
?>
				<div class="clear"></div>
			</div>
			
		</div>
	</div>
<?php }?>
	<div class="clear"></div>
</div>

<?php include("part_footer.php");?>

<?php include("google_details.php");?>

</body>
</html>
<?php
if($siteDebug) {
	$timeEnd = microtime(true);
	$diff = $timeEnd - $startRenderTime;
	echo "<strong>delay Total: </strong>".$diff."</strong><br>";
}
