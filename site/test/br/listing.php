<?php require_once('Connections/pulsar.php'); ?>
<?php include("../tool_listing.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens<?php echo $extraTitle?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
<script type="text/javascript">

function update_listing(nav_btn, array_ss, page_qty, total_img) {
	var timer_lampada;
	var nav_id = $(nav_btn).attr("id");
	var nav_num = nav_id.split("-");
	page = nav_num[1];

//	sessvars.page_num = page;
	
	var dataString = 'action=get_nav&page_num='+page+'&max_row='+page_qty+'&total_row='+total_img;
	$.ajax({
		type: "POST",
		url: "../tool_ajax_listing.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$(".nav").html(html);
			$(".nav_page_num").attr("href", "#");

			$(".nav_page_num").click(function() {
				update_listing(this, array_ss, page_qty, total_img);
				var url = location.href;
				url = url.replace(/&pageNum_retorno=[0-9]*/gi,"");
				url = url.replace(/&clear=true*/gi,"");
				url = url.replace("#","");
				url = url+"&pageNum_retorno="+page;
				window.history.pushState({foo:"bar"},"Pulsar Imagens P�gina "+page, url);
			});
		}
	});
	
	first_img = page*page_qty;
	last_img = first_img + page_qty;
	count = 0;
	$("#lista-script").html("");
	$(".nnav").html(first_img + " de " + total_img + " imagem(ns)");

	var dataString = 'action=get_li&page_num='+page+'&max_row='+page_qty+'&total_row='+total_img;
	$.ajax({
		type: "POST",
		url: "../tool_ajax_listing.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#lista-script").html(html);
		    jQuery('.add_pasta').click(function(){
		    	jQuery('.form').toggle();
		    });
		    jQuery('.add_mesa').click(function(){
		    	$.get($(this).attr('id'));
		    	$(this).css("color", "#bc690f"); 
		    	alert('<?php echo SCRIPT_IMAGEM_ADD?>');
		    	return false;
		    });
			$("ul#lista-script li div.bt-mesadeluz a.icon").click(function(){
				$(this).parent().children("div.box").toggle();
				clearTimeout(timer_lampada);
				timer_lampada = setTimeout(function () {
			        $('ul#lista-script li div.bt-mesadeluz div.box').hide();
				}, 5000);
				$('ul#lista-script li div.bt-mesadeluz div.box').mouseenter(function() {
					clearTimeout(timer_lampada);
				});
				$('ul#lista-script li div.bt-mesadeluz div.box').mouseleave(function() {
					timer_lampada = setTimeout(function () {
				        $('ul#lista-script li div.bt-mesadeluz div.box').hide();
					}, 5000);
				});
			});
			$("ul#lista-script li div.bt-zoom").hover(
				function () {
					$(this).children("div.mzoom").show();
					var $img = $(this).find("img");
					if($img.attr('class') == 'on-demand') {
						$img.attr('src',$img.attr('longdesc')).removeClass('on-demand');
					}
					var $jwp = $(this).children("div.mzoom").children("div");
					var $jwp_id = $jwp.attr('id').split('_')[0];
					jwplayer($jwp_id).play(true);
				},
				function () {
					$(this).children("div.mzoom").hide();
					var $jwp = $(this).children("div.mzoom").children("div");
					var $jwp_id = $jwp.attr('id').split('_')[0];
					jwplayer($jwp_id).stop(true);
				}
			);
		}
	});
}


jQuery(document).ready(function() {
	var ss = "<?php echo $_SESSION['ultima_pesquisa']?>";
	var array_ss = ss.split("|");
	var page_qty = <?php echo $maxRows_retorno?>;
<?php //if($pageNum_retorno == 0 && !isset($_GET['clear'])) { ?>
//	var page = sessvars.page_num;
<?php //} else { ?>
	var page = <?php echo $pageNum_retorno?>;
<?php //} ?>
	var first_img = page*page_qty;
	var total_img = <?php echo $totalRows_retorno?>;

 	update_listing($('<a href="#" id="nav_page-'+page+'"></a>'), array_ss, page_qty, total_img);
});
</script>

</head>
<body>
<?php include("../tool_clickTale_Header.php")?>
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
<?php if (isset($_SESSION['ajustar'])) echo "<div class=\"espaco1\"></div>";?>
			<h2>0 Resultados para a pesquisa</h2> <!-- "<?php echo $query?>" -->
			<p class="p">
                Infelizmente, <strong>n�o encontramos</strong> resultados para sua busca.<br/>
                Talvez alterando os termos ou verificando a ortografia correta voc� consiga encontrar o que est� procurando.
            </p>
<?php 
if(isset($_GET['query'])) {
//	include("tool_similar_word.php");
}
?>            
			<a href="buscaavancada.php" class="back">� Tente uma busca avan�ada</a>
<?php if (isset($_SESSION['ajustar'])) echo "<div class=\"espaco2\"></div>";?>
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
<!-- 	                  <option value="recente" <?php if($ordem == "recente") echo "selected"; ?>>�ltimas adicionadas</option> -->
<!-- 	                  <option value="data" <?php if($ordem == "data") echo "selected"; ?>>Data da foto</option> -->
 	                  <option value="vistas" <?php if($ordem == "vistas") echo "selected"; ?>>Mais visualizadas</option>
	                  <option value="maior" <?php if($ordem == "maior") echo "selected"; ?>>Tamanho do arquivo</option>  
	                </select>
				</div>
<!--         		<div class="ordenar">
					<p>Filtrar por:</p>
	                <select name="filtro" onChange="listing_opts.submit();">
 	                  <option value="foto" <?php if($filtro == "foto") echo 'selected="selected"'; ?>> Fotos</option>
	                  <option value="video" <?php if($filtro == "video") echo 'selected="selected"'; ?>>V�deos</option>  
	                </select>
				</div> -->
		        <input type="hidden" value="true" name="clear"/>		
			</form>

			<div class="nnav">
				<?php echo $startRow_retorno?> de <?php echo $totalRows_retorno ?> imagem(ns) 
			</div>
			<div class="clear"></div>
			
			<div class="nav">
			</div>
<?php if (isset($_SESSION['ajustar'])) echo "<div class=\"espaco2\"></div>";?>
		
			<ul id="lista-script">
			</ul>
			<div class="clear"></div>
			
			<div class="nav">
			</div>
			
		</div>
	</div>
<?php }?>
	<div class="clear"></div>
</div>

<?php include("part_footer.php");?>

<?php include("google_details.php");?>

<?php include("../tool_clickTale_Footer.php")?>

</body>
</html>
<?php
if($siteDebug) {
	$timeEnd = microtime(true);
	$diff = $timeEnd - $startRenderTime;
	echo "<strong>delay Total: </strong>".$diff."</strong><br>";
}
