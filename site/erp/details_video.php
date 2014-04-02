<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_details_video.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Edição Vídeos</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
    <?php //include("../tool_tooltip.php")?>
<?php 
$tmp_res = $row_dados_foto['dim_a']."x".$row_dados_foto['dim_b'];

switch ($tmp_res) {
	case "1920x1080":
		break;
	case "1280x720":
		break;
	case "720x480":
		break;
	case "720x586":
		break;
	case "0x0":
		echo "<script>alert('Video com resolução não detectada.');</script>";
		break;
	default:
		echo "<script>alert('Video fora de proporçao!!! Resolução ".$tmp_res."');</script>";
}
?> 
  </head>
  <body>

		<?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Edição Videos</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Indexação</a>
        <a href="indexacao_videos.php">Vídeos</a>
        <a href="edicao_videos.php">Edição</a>
        <a href="#" class=" current">Detalhes</a>
      </div>
      <div class="container-fluid">
        
         <div class="row-fluid cadastro_videos">

         		<div class="details">
			<h2><?php echo $row_dados_foto['assunto_principal']; ?></h2>
			<div class="image">
				<p>
					<span class="pag">
<?php if ($ordem_prev > -1) {?>					
						<a href="details_video.php?total_foto=<?php echo $total_foto;?>&ordem_foto=<?php echo $ordem_prev;?>&tombo=<?php echo $tombo_array[$ordem_prev];?>" class="prev">Anterior</a>
<?php } if ($ordem_next > -1) {?>					
						<a href="details_video.php?total_foto=<?php echo $total_foto;?>&ordem_foto=<?php echo $ordem_next;?>&tombo=<?php echo $tombo_array[$ordem_next];?>" class="next">Proxima</a>
<?php } ?>					
					</span>
					<img id="mp<?php echo $row_dados_foto['tombo']; ?>"/>
										<!--
						<span id="mp<?php echo $row_dados_foto['tombo']; ?>"></span>
					<img id="mp<?php echo $row_dados_foto['tombo']; ?>"/>
					<div id="mp<?php echo $row_dados_foto['tombo']; ?>"></div>
										
<span class="video" style="width:640px;height:0px;"></span>
					<span class="video" style="width:0px;height:360px;"></span>
					<div class="video" id="2mp<?php echo $row_dados_foto['tombo']; ?>" style="width:640px;height:360px; position:absolute;right:37px;top:125px"></div>
 -->
 <?php 
 $res_detail = "640x360";
 if($row_dados_foto['resolucao']=="720x480")
 	$res_detail = "540x360";
 else if($row_dados_foto['resolucao']=="720x586")
 	$res_detail = "440x360";
 ?>
 					
	<script type="text/javascript">
		jwplayer("mp<?php echo $row_dados_foto['tombo']; ?>").setup({
			flashplayer: "video/player.swf",
			file: "<?php echo $cloud_server?>/Videos/previews/<?php echo $tombo?>_<?php echo $res_detail?>.flv",
			height: 360,
	        width: 640,
			autostart: true,
			repeat: "always"
		});
		//			provider:'http',
		//	'http.startparam':'starttime',
		
		//			image: "<?php echo $cloud_server?>/Videos/thumbs/<?php echo $tombo?>_3s.jpg",
		
	</script>

					<span>Código:  <?php echo $detail_tombo; ?></span>
					<a href="<?php echo $cloud_server?>/download_videos.php?c=<?php echo $row_dados_foto['tombo'];?>&u=<?php echo $row_login['usuario']?>&p=<?php echo $row_login['senha']?>&f=true" class="save">Salvar video original</a>
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
					<p>Nome do Arquivo: <strong><?php echo $row_codigo_video['arquivo']?></strong></p>
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
				</div>
			</div>
		</div>
         
         
         
         
        </div>
    <div class="row-fluid">
        <div class="span10"></div>
        <div class="span2">
        	<a class="btn btn-primary edicao_aprovar" href="tool_addmesadeluz_video.php?status=1&tombo=<?php echo $tombo; ?>" onclick="return false">Aprovar</a>&nbsp;
        	<a class="btn btn-danger edicao_recusar" href="tool_addmesadeluz_video.php?status=-1&tombo=<?php echo $tombo; ?>" onclick="return false">Rejeitar</a></div>
    </div>

        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>
    
  </body>
</html>
