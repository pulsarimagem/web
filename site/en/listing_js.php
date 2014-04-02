<?php require_once('Connections/pulsar.php'); ?>
<?php include("../tool_listing.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
<script type="text/javascript">

function update_listing(nav_btn, array_ss, page_qty, total_img) {
//	var ss = "<?php echo $super_string?>";
//	var array_ss = ss.split("|");
//	page_qty = 48;
//	total_img = 123;

	var nav_id = $(nav_btn).attr("id");
	var nav_num = nav_id.split("-");
	page = nav_num[1];

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
			});
		}
	});
	
	first_img = page*page_qty;
	last_img = first_img + page_qty;
	count = 0;
	$("#lista-script").html("");
	$.each(array_ss, function() {
		if(count >= first_img && count < last_img) {
			var li = " \
				<li> \
					<a href='details.php?tombo=" + this + "&amp;search=PA&amp;ordem_foto="+count+"&amp;total_foto="+total_img+"'> \
						<img src='http://www.pulsarimagens.com.br/bancoImagens/"+this+"p.jpg' title='' onmouseover='' onmouseout='hideddrivetip()'> \
						<span><strong></strong></span> \
					</a> \
					<div class='opt'> \
						<div class='bt-zoom'> \
		            		<a href='#'></a> \
		                	<div class='mzoom' style='display: none;'> \
		                		<img class='on-demand' src='images/cm_fill.gif' longdesc='http://www.pulsarimagens.com.br/bancoImagens/"+this+".jpg' style='max-width:300px; max-height:300px;'> \
			                </div> \
		                </div> \
						<span class='iconFoto'></span> \
						<span>"+this+"</span> \
						<div class='clear'></div> \
					</div> \
				</li> \
				";
			$("#lista-script").append(li);
		}
		count++;
	});
}


jQuery(document).ready(function() {
	var ss = "<?php echo $super_string?>";
	var array_ss = ss.split("|");
	var count = 0;
	var page_qty = <?php echo $maxRows_retorno?>;
	var page = <?php echo $pageNum_retorno?>;
	var first_img = page*page_qty;
	var last_img = first_img + page_qty;
	var total_img = <?php echo $totalRows_retorno?>;

/*
 
 I ran into the same problem before. Turns out jQuery loses all bindings on elements that are added after loading. You should use the delegate method

$("#editBioButton").delegate("#saveBioText", 'click', function(){
  alert("this.");
}); 

 
 */
 	update_listing($('<a href="#" id="nav_page-0"></a>'), array_ss, page_qty, total_img);
/* 	
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
			});
		} 
	});
	
//	each(function() { 
//		alert($(this.attr("href")));
//		$(this).attr("href", "#"); 
//	});

	$.each(array_ss, function() {
		if(count >= first_img && count < last_img) {
			var li = " \
				<li> \
					<a href='details.php?tombo=" + this + "&amp;search=PA&amp;ordem_foto="+count+"&amp;total_foto="+total_img+"'> \
						<img src='http://www.pulsarimagens.com.br/bancoImagens/"+this+"p.jpg' title='' onmouseover='' onmouseout='hideddrivetip()'> \
						<span><strong></strong></span> \
					</a> \
					<div class='opt'> \
						<div class='bt-zoom'> \
		            		<a href='#'></a> \
		                	<div class='mzoom' style='display: none;'> \
		                		<img class='on-demand' src='images/cm_fill.gif' longdesc='http://www.pulsarimagens.com.br/bancoImagens/"+this+".jpg' style='max-width:300px; max-height:300px;'> \
			                </div> \
		                </div> \
						<span class='iconFoto'></span> \
						<span>"+this+"</span> \
						<div class='clear'></div> \
					</div> \
				</li> \
				";
			$("#lista-script").append(li);
		}
		count++;
	});

	$(".nav_page_num").attr("href", "#");

*/
//	$(".nav_page_num").click(update_listing(this));	
});

</script>

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
<?php if (isset($_SESSION['ajustar'])) echo "<div class=\"espaco1\"></div>";?>
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
			</ul>
			<div class="clear"></div>
			
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
