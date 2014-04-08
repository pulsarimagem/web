<?php require_once('Connections/pulsar.php'); ?>
<?php if(isset($_GET['forceLogin'])) include ("../tool_auth.php");?>
<?php include ("../tool_details.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php")?>
<script src="../js/backfix.min.js" type="text/javascript"></script>
<script type="text/javascript">
<?php 
if(isset($_GET['forceLogin'])) { 
?>
$(function() {
    $(document).scrollTop( $("#ancora_uso").offset().top );  
});
<?php
	unset($_GET['forceLogin']);
} 
?> 
bajb_backdetect.OnBack = function() {
	var dataString = "action=savePage&page_num=<?php echo $page_num?>";
	$.ajax({
		type: "POST",
		url: "../tool_ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
		} 
	});
	history.back();
};
</script>
</head>
<body>
<?php include("../tool_tooltip.php")?>

<?php if($show_addimg) {?> 
<div class="overflow"></div>
<form name="form1" method="get" action="details.php">
	<div class="adicionarimagem" style="margin: -225px 0 0 -200px;">
		<a href="details.php?tombo=<?php echo $tombo;?>&search=<?php echo $search;?>" class="close">x</a>
	    <h2>Add to My Folders</h2>
	    <div class="imagens"><img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_dados_foto['tombo']; ?>p.jpg" style="max-width:150px; max-height:150px;" /></div>
	    <h3>Select folder(s):</h3>
	    <ul>
<?php do { ?>    
	        <li><input name="id_pasta[]" type="checkbox" value="<?php echo $row_pastas['id_pasta']; ?>" /> <label><?php echo $row_pastas['nome_pasta']; ?></label><div class="clear"></div></li>
<?php } while ($row_pastas = mysql_fetch_assoc($pastas));?>
	        <li><input name="nova" id="chkNovaPasta" type="checkbox" value=""/> <label class="blue">Create new folder</label><div class="clear"></div></li>
	        <li id='novapasta' ><input name="nova_pasta" type="text" class="digite" /><input name="action" type="submit" class="ok" value="ok" /><div class="clear"></div></li>
	    </ul>
	    <input name="tombo" type="hidden" value="<?php echo $tombo;?>"/>
	    <input name="search" type="hidden" value="<?php echo $search;?>"/>
	    <input name="total_foto" type="hidden" value="<?php echo $total_foto;?>"/>
	    <input name="ordem_foto" type="hidden" value="<?php echo $ordem_foto;?>"/>
	    <input name="page_num" type="hidden" value="<?php echo $page_num;?>"/>
	    <p class="button"><input name="action" type="submit" class="button" value="Add" /></p>
	</div>
</form>
<?php } ?>
<?php include("part_topbar.php");?>

<div class="main size960">

<?php //include("part_grid_left.php")?>

	<div><!-- class="grid-right" -->

		<div class="details">
			<a href="<?php echo isset($_SESSION['last_search'])?$_SESSION['last_search']."&pageNum_retorno=$page_num":"index.php";?>" class="voltar">« Back</a> <!-- <?php echo $_SESSION['last_search'];?> onclick="javascript:history.go('http://www.pulsarimagens.com.br/teste/listing.php')"-->
            <br/>
			<br/>
 			<!--<h2><?php echo $row_dados_foto['assunto_principal']; ?></h2>
			<h2><?php //echo translateText($row_dados_foto['assunto_principal']); ?></h2>-->
			<h2><span class="label">Code:</span> <?php echo $row_dados_foto['tombo']; ?></h2>
			<div class="wrapper-image">
				<div class="image <?php if($isVideo) echo "video";?>">
					<span class="pag">
<?php if ($ordem_prev > -1 && isset($tombo_array[$ordem_prev])) {?>					
						<a href="details.php?total_foto=<?php echo $total_foto;?>&ordem_foto=<?php echo $ordem_prev;?>&page_num=<?php echo $page_num?>&tombo=<?php echo $tombo_array[$ordem_prev];?>" class="prev">Previous</a>
<?php } if ($ordem_next > -1 && isset($tombo_array[$ordem_next])) {?>					
						<a href="details.php?total_foto=<?php echo $total_foto;?>&ordem_foto=<?php echo $ordem_next;?>&page_num=<?php echo $page_num?>&tombo=<?php echo $tombo_array[$ordem_next];?>" class="next">Next</a>
<?php } else $total_foto = -1; ?>					
					</span>
<?php if($isVideo) { ?>
					<div id="mp<?php echo $row_dados_foto['tombo']; ?>"></div>
	<script type="text/javascript">
		jwplayer("mp<?php echo $row_dados_foto['tombo']; ?>").setup({
			flashplayer: "../video/player.swf",
			file: "<?php echo $cloud_server?>/Videos/previews/<?php echo $tombo?>_<?php echo $res_pop?>.flv",
			height: 360,
	        width: 640,
			autostart: true
		});
	</script>
<!-- 			image: "<?php echo $cloud_server?>/Videos/thumbs/<?php echo $tombo?>_3s.jpg", -->
<?php } else { ?>
					<img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_dados_foto['tombo']; ?>.jpg"/>
<?php }?>
<!--					<span>Código:  <?php echo $detail_tombo; ?></span>-->
<?php //if(!$isVideo) {?>
<!--					<a href="tool_downloader.php?tombo=<?php echo $row_dados_foto['tombo'];?>" class="save">Salvar imagem em baixa</a>-->
<?php //} ?>
					<div class="clear"></div>
				</div>
        <div class="action-image">
          <ul>
<?php if($logged) { ?>
            <li class="cotacao"><a href="#ancora_uso" title="Cotação">Price calculator</a></li>
<?php } else { ?>
			<li class="cotacao"><a href="<?php echo $_SESSION['this_uri']?>&forceLogin=true#ancora_uso" title="Cotação">Price calculator</a></li>
            <li class="carrinho"><a href="add_carrinho.php?add=<?php echo $tombo;?>" title="Adicionar ao carrinho">Add to shopping cart</a></li>
<?php } ?>
            <li class="minhas-pastas"><a href="details.php?tombo=<?php echo $tombo;?>&search=<?php echo $search;?>&total_foto=<?php echo $total_foto;?>&ordem_foto=<?php echo $ordem_foto;?>&page_num=<?php echo $page_num;?>&addimg=true" title="Adicionar às Minhas Pastas">Add to My Folder</a></li>
<?php if($isVideo) {?>
            <li class="salvar"><a href="<?php echo $cloud_server."/Videos/previews/".$row_dados_foto['tombo']."_$res_pop.flv";?>" title="Salvar em baixa resolução">Save preview</a></li>
<?php } else { ?>
            <li class="salvar"><a href="../tool_downloader.php?tombo=<?php echo $row_dados_foto['tombo'];?>" title="Salvar em baixa resolução">Save preview</a></li>
<?php } ?>
            <li class="download"><a href="details_download.php?tombo=<?php echo $tombo;?>" title="Download">Download</a></li>
            <li class="email"><a href="enviarporemail.php?tombo=<?php echo $tombo;?>" title="Enviar por email">Send via e-mail</a></li>
          </ul>
        </div>
			</div>
      <div class="clear"></div>
			<div class="info">
				<div class="infA">
          <p><span class="label">Code:</span> <?php echo $detail_tombo; ?></p>
          <!--<p><span class="label">Assunto:</span> <?php echo $row_dados_foto['assunto_principal'];?></p>-->
          <p><span class="label">Caption:</span> <?php echo ($row_dados_foto['assunto_en']!=""?$row_dados_foto['assunto_en']:translateText($row_dados_foto['assunto_principal'])); ?></p>
<?php if($row_dados_foto['extra'] != "") {?>
        			<!--<p><span class="label">Informa&ccedil;&atilde;o Adicional:</span> <?php echo $row_extra_foto['extra']; ?></p>-->
        			<p><span class="label">Additional information:</span> <?php echo translateText($row_dados_foto['extra']); ?></p>
<?php }?>
					<?php echo $detail_local; ?>				
					<p><span class="label">Date:</span> <?php echo $detail_data; ?></p>
					<p><span class="label">Author:</span> <?php echo $detail_autor; ?></p>
				</div>
                <div class="clear"></div>
				<div class="clear divisor"></div>
                <div class="infA">
<?php 
if($row_dados_foto['direito_img'] == 1) echo "<p><span class=\"label\">Model Release:</span> Yes</p>";
else if($row_dados_foto['direito_img'] == 2) echo "<p><span class=\"label\">Model Release:</span> Yes - 100% Over price list</p>"; 
else echo "<span class=\"label\">Model Release:</span> No";
?>
				</div>
                <div class="clear"></div>
				<div class="clear divisor"></div>
				<div class="infC">
				<?php echo $detail_dim; ?>		
          <div class="clear divisor"></div>
					<p class="label">Categories: </p>
					<dl>
<?php do { ?>
        				<dt><a href="listing.php?tema_action=&tema=<?php echo $row_temas['Id']; ?>&clear=true"><?php echo $row_temas['Tema']; ?></a></dt>
<?php } while ($row_temas = mysql_fetch_assoc($temas)); ?>
					</dl>
				</div>
        <div class="clear divisor"></div>
				<div class="tags">
					<div class="title label">Keywords:</div>
					<div class="list">
<?php do { ?>
						<a href="#" class="add"><strong>+</strong> <?php echo $row_palavras['Pal_Chave']; ?></a>  
<?php } while ($row_palavras = mysql_fetch_assoc($palavras)); ?>
					</div>
					<div class="clear"></div>
					<form name="busca_pc" action="listing.php" method="get">
						<div class="buscar">
							<h3>Search images with tags:</h3>
							<p>
                
							</p>
							<input name="action" type="submit" class="button" value="Search" />
							<input name="pc_action" type="hidden" value="Go" />
							<input name="type" type="hidden" value="pc" />
							<input name="tipo" type="hidden" value="inc_pc.php" />
							<input name="clear" type="hidden" value="true" />
							<div class="clear"></div>
						</div>
					</form>
				</div>
			</div>
			<script type="text/javascript">
			$(document).ready(function(){

				$('.list a.add').live('click', function() {
					$(this).find("strong").remove();
					var pc = jQuery.trim($(this).text());
					$(this).prepend('<strong>-</strong>');
					$(this).removeClass('add').addClass('remove');
					$('.buscar p').append( $(this) );
					$('.buscar p').append( $('<input name="pc_arr[]" type="hidden" value="' + pc + '"/>') );
					
				return false;
				});

				$('.buscar p a.remove').live('click', function() {
					$(this).find("strong").remove();
					var pc = jQuery.trim($(this).text());
					$(this).prepend('<strong>+</strong>');
					$(this).removeClass('remove').addClass('add');
					$('.list').append( $(this) );

					$('.buscar p').find('input').each(function() {
							var val = $(this).attr('value');
							if(val == pc) {
								$(this).remove();
							}
					});
					
				return false;
				});

			});
			</script>
<!--			<div class="bts">
				<div class="left">
					<div class="bt-enviarporemail"><a href="enviarporemail.php?tombo=<?php echo $tombo;?>"></a></div>
					<div class="bt-download"><a href="details_download.php?tombo=<?php echo $tombo;?>"></a></div>
					<div class="bt-cotacao"><?php if (isQuoting($row_dados_foto['tombo'], $fotos_cotacao)) echo "<span>Aguardando cotação</span>"; else echo "<a href=\"".$_SESSION['last_detail']."&cotar=true\"></a>"; ?></div>
<?php 
/*

            <div class="enviarcotacao"><span class="set"></span>

            
            	<h2>Enviar para cotação</h2>
                <div class="alert-message">Ops! Você precisa arrumar os campos em destaque para continuar o seu pedido.</div>
            	<ul>
                	<li>
                        <label>Nome completo</label>
                        <input name="" type="text" class="text" />
                        <div class="clear"></div>

                    </li>
                	<li>
                        <label>CPF</label>
                        <input name="" type="text" class="text" />
                        <div class="clear"></div>
                    </li>
                	<li>
                        <label>Telefone</label>

                        <input name="" type="text" class="text" />
                        <div class="clear"></div>
                    </li>
                	<li>
                        <label>Email</label>
                        <input name="" type="text" class="text" />
                        <div class="clear"></div>
                    </li>

                    <li>
                    	<input name="" type="button" class="button" value="Buscar" /> <span>or <a href="#">Cotar logado em sua conta</a></span>
                    </li>
                </ul>
                <div class="image-select">
                	<h3>Imagem Selecionada:</h3>
                    <img src="http://dummyimage.com/150x100" width="150" height="100" />

                    <p>Descarga de colheitadeiras de soja em fazenda na área rural </p>
	            </div>
                <div class="clear"></div>
            
            </div>

 */
?>				
				</div>
				<div class="right">
					<div class="bt-adicionaraminhasimagens">
						<a href="details.php?tombo=<?php echo $tombo;?>&search=<?php echo $search;?>&total_foto=<?php echo $total_foto;?>&ordem_foto=<?php echo $ordem_foto;?>&addimg=true"></a>
					</div>
				</div>
				<div class="clear"></div>
			</div>-->
			<a id="ancora_uso"></a>
<?php
if($logged)  
	include("part_form_uso.php")
?>			
		</div>


	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php");?>

</body>
</html>


