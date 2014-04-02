<?php require_once('Connections/pulsar.php'); ?>
<?php include ("../tool_detailsvideo.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php")?>
</head>
<body>
<?php include("tool_tooltip.php")?>

<?php if($show_addimg) {?> 
<div class="overflow"></div>
<form name="form1" method="get" action="details.php">
	<div class="adicionarimagem" style="margin: -225px 0 0 -200px;">
		<a href="details.php?tombo=<?php echo $tombo;?>&search=<?php echo $search;?>" class="close">x</a>
	    <h2>Add to "My Folders"</h2>
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
	    <p class="button"><input name="action" type="submit" class="button" value="Send" /></p>
	</div>
</form>
<?php } ?>
<?php include("part_topbar.php");?>

<div class="main size960">

<?php include("part_grid_left.php")?>

	<div class="grid-right">

		<div class="details">
			<a href="<?php echo $_SESSION['last_search'];?>" class="voltar">« Back</a>
            <br/>
			<br/>
			<h2><?php echo $row_dados_foto['assunto_principal']; ?></h2>
			<div class="image">
				<p>
					<span class="pag">
<?php if ($ordem_prev > -1) {?>					
						<a href="details.php?total_foto=<?php echo $total_foto;?>&ordem_foto=<?php echo $ordem_prev;?>&tombo=<?php echo $tombo_array[$ordem_prev];?>" class="prev">Previous</a>
<?php } if ($ordem_next > -1) {?>					
						<a href="details.php?total_foto=<?php echo $total_foto;?>&ordem_foto=<?php echo $ordem_next;?>&tombo=<?php echo $tombo_array[$ordem_next];?>" class="next">Next</a>
<?php } ?>					
					</span>
					<img id="mp<?php echo $row_dados_foto['tombo']; ?>"/>
<!--
 					<span class="video" style="width:640px;height:0px;"></span>
					<span class="video" style="width:0px;height:360px;"></span>
					<div class="video" id="2mp<?php echo $row_dados_foto['tombo']; ?>" style="width:640px;height:360px; position:absolute;right:37px;top:125px"></div>
 -->					
	<script type="text/javascript">
		jwplayer("mp<?php echo $row_dados_foto['tombo']; ?>").setup({
			flashplayer: "video/player.swf",
			file: "<?php echo $cloud_server?>/Videos/previews/<?php echo $tombo?>_640x320.flv",
			image: "<?php echo $cloud_server?>/Videos/thumbs/<?php echo $tombo?>_0s.jpg",
			height: 360,
	        width: 640,
			autostart: true
		});
	</script>

					<span>Código:  <?php echo $detail_tombo; ?></span>
					<a href="tool_downloader.php?tombo=<?php echo $row_dados_foto['tombo'];?>" class="save">Salvar imagem em baixa</a>
					<div class="clear"></div>
				</p>
			</div>
			<div class="info">
				<div class="infA">
        			<p>Assunto: <?php echo $row_dados_foto['assunto_principal'];?></p>
<?php if($row_dados_foto['extra'] != "") {?>
        			<p>Informa&ccedil;&atilde;o Adicional: <?php echo $row_dados_foto['extra']; ?></p>
<?php }?>
					<?php echo $detail_local; ?>				
					<p>Data: <?php echo $detail_data; ?></p>
					<p>Autor: <strong><?php echo $detail_autor; ?></strong></p>
				</div>
				<div class="infB">
<!-- 					Uso de imagem autorizado  -->
				</div>
				<div class="clear"></div>
				<div class="infC">
				<?php echo $detail_dim; ?>				
					<p>Temas: </p>
					<dl>
<?php do { ?>
        				<dt><a href="listing.php?tema_action=&tema=<?php echo $row_temas['Id']; ?>"><?php echo $row_temas['Tema']; ?></a></dt>
<?php } while ($row_temas = mysql_fetch_assoc($temas)); ?>
					</dl>
				</div>
				<div class="tags">
					<div class="title">Palavras-chave:</div>
					<div class="list">
<?php 
$palavras = explode(";",$row_dados_foto['pal_chave']);
foreach ($palavras as $palavra) {
?>
						<a href="#" class="add"><strong>+</strong> <?php echo $palavra?></a>  
<?php } ?>
					</div>
					<div class="clear"></div>
					<form name="busca_pc" action="listing.php" method="get">
						<div class="buscar">
							<h3>Buscar imagens com as tags:</h3>
							<p>

							</p>
							<input name="action" type="submit" class="button" value="Buscar" />
							<input name="pc_action" type="hidden" value="Ir" />
							<input name="type" type="hidden" value="pc" />
							<input name="tipo" type="hidden" value="inc_pc.php" />
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
			<div class="bts">
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
			</div>
		</div>

		<div class="home-imagens">

<?php // include("carousel_resultados.php")?>

<?php // include("carousel_comparativos.php")?>

		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php");?>

</body>
</html>


