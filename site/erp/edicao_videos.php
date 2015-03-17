<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_edicao_videos.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Edição Vídeos</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
    <?php //include("../tool_tooltip.php")?>
    
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
        <a href="#" class=" current">Edição</a>
      </div>
        <form method="get">
           Lista Autores: 
		   <select name="autor2">
		   		<option value="nada">--- Todos ---</option>
		<?php while ($row_autor_tmp_select = mysql_fetch_assoc($autor_tmp_select)){ ?>
		   		<option value="<?php echo $row_autor_tmp_select['id_autor'];?>" <?php if(isset($id_autor) && ($row_autor_tmp_select['id_autor'] == $id_autor)) echo " SELECTED"?>><?php echo $row_autor_tmp_select['nome'];?> [<?php echo $row_autor_tmp_select['total'];?> foto(s)]</option>
		<?php } ?>
		   </select>
		   <input type="submit" name="Submit" value="Consultar">
		</form>
        <form method="get">
	  <div class="container-fluid">
         <div class="row-fluid cadastro_videos">
 	            <div class="pagination pagination-right">
	              <ul>
<?php 
echo str_replace("/span>","/a></li>",str_replace("<span","<li><a",str_replace("</a>", "</a></li>", str_replace("<a", "<li><a", $nav_bar[1]))));
?>            
	              </ul>
	            </div>
          <ul class="thumbnails lista-imagens">
          
<?php 
$tot_fotos = 1;
$count_fotos = $startRow_retorno;
do { 
	
	$res_lupa = "320x180";
	if($row_retorno['resolucao']=="720x480")
		$res_lupa = "270x180";
	else if($row_retorno['resolucao']=="720x586")
		$res_lupa = "220x180";
?>          
          
  <li class="span2">
    <input type="checkbox" class="checkbox" name="edicao[]" value="<?php echo $row_retorno['tombo']; ?>">
    <div class="thumbnail">
      <a <?php if($row_retorno['status'] == 1) echo "class=\"approved\""; else if ($row_retorno['status'] == -1) echo "class=\"rejected\"";?>href="details_video.php?tombo=<?php echo $row_retorno['tombo']."&search=PA&ordem_foto=$count_fotos&total_foto=$totalRows_retorno"; ?>">
      <img src="https://s3-sa-east-1.amazonaws.com/pulsar-media/fotos/previews/<?php echo $row_retorno['tombo']; ?>p.jpg" alt=""> <!-- <?php echo $cloud_server?>Videos/thumbs/<?php echo $row_retorno['tombo']; ?>_3s.jpg" -->
      </a>
      <div class="clearfix">
	      <h4><?php echo $row_retorno['tombo']; ?></h4>
	      <div class="bt-zoom">
		      <a class="icon icon-zoom-in" href="#" alt="visualizar"></a>
			  <div class="mzoom" style="display: none;"><div id="mp<?php echo $row_retorno['tombo']; ?>">JW Player goes here</div>
					<script type="text/javascript">
						jwplayer("mp<?php echo $row_retorno['tombo']; ?>").setup({
							flashplayer: "video/player.swf",
							file: "<?php echo $cloud_server?>/Videos/previews/<?php echo $row_retorno['tombo']?>_<?php echo $res_lupa?>.flv",
							width: 320,
							height: 180,
							controlbar : "none",
							autostart: true
						});
					</script>
			  </div>
		  </div>
	    </div>
    </div>
  </li>
  
<?php
	$tot_fotos++;
	$count_fotos++;
?>
<?php } while ($row_retorno = mysql_fetch_assoc($retorno)); ?>  
  
</ul>
            
            
        </div>
 	            <div class="pagination pagination-right">
	              <ul>
<?php 
echo str_replace("/span>","/a></li>",str_replace("<span","<li><a",str_replace("</a>", "</a></li>", str_replace("<a", "<li><a", $nav_bar[1]))));
?>            
	              </ul>
	            </div>
        
    <div class="row-fluid">
        <div class="span9"></div>
        <div class="span3">
        	<input type="submit" class="btn btn-success" name="action" value="Aprovar"/>&nbsp;
        	<input type="submit" class="btn btn-danger" name="action" value="Rejeitar"/>&nbsp;
        	<input type="submit" class="btn btn-primary" name="action" value="Finalizar"/>
        </div>
    </div>

        <?php include('page_bottom.php'); ?>
      </div>
      </form>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>
    
  </body>
</html>
