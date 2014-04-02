<?php require_once('Connections/pulsar.php'); ?>
<?php include('tool_auth.php'); ?>
<?php include ("tool_detailsvideo.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="../br/style.css" rel="stylesheet" type="text/css" />
<link href="css.css" rel="stylesheet" type="text/css" />
<?php include("../br/scripts.php")?>
<script>
function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
</script>
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
<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FF9900">
   <tr>
     <td class="style1">pulsarimagens.com.br<br>
         indexa&ccedil;&atilde;o</td>
     <td class="style1"><div align="right">
       <input name="Button" type="button" onClick="MM_goToURL('parent','administra2.php');return document.MM_returnValue" value="Menu Principal">
     </div></td>
   </tr>
</table>
<?php include("../tool_tooltip.php")?>

<?php if($show_addimg) {?> 
<div class="overflow"></div>
<form name="form1" method="get" action="details.php">
	<div class="adicionarimagem" style="margin: -225px 0 0 -200px;">
		<a href="details.php?tombo=<?php echo $tombo;?>&search=<?php echo $search;?>" class="close">x</a>
	    <h2>Adicionar a "Minhas Imagens"</h2>
	    <div class="imagens"><img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_dados_foto['tombo']; ?>p.jpg" style="max-width:150px; max-height:150px;" /></div>
	    <h3>Selecione a(s) pasta(s):</h3>
	    <ul>
<?php do { ?>    
	        <li><input name="id_pasta[]" type="checkbox" value="<?php echo $row_pastas['id_pasta']; ?>" /> <label><?php echo $row_pastas['nome_pasta']; ?></label><div class="clear"></div></li>
<?php } while ($row_pastas = mysql_fetch_assoc($pastas));?>
	        <li><input name="nova" id="chkNovaPasta" type="checkbox" value=""/> <label class="blue">Criar nova pasta</label><div class="clear"></div></li>
	        <li id='novapasta' ><input name="nova_pasta" type="text" class="digite" /><input name="action" type="submit" class="ok" value="ok" /><div class="clear"></div></li>
	    </ul>
	    <input name="tombo" type="hidden" value="<?php echo $tombo;?>"/>
	    <input name="search" type="hidden" value="<?php echo $search;?>"/>
	    <input name="total_foto" type="hidden" value="<?php echo $total_foto;?>"/>
	    <input name="ordem_foto" type="hidden" value="<?php echo $ordem_foto;?>"/>
	    <p class="button"><input name="action" type="submit" class="button" value="Enviar" /></p>
	</div>
</form>
<?php } ?>
<?php //include("part_topbar.php");?>

<div class="main size960">

<?php //include("part_grid_left.php")?>

	<div class="grid-right-videos">

		<div class="details">
			<a href="listingvideo.php" class="voltar">« Voltar</a>
            <br/>
			<br/>
			<h2><?php echo $row_dados_foto['assunto_principal']; ?></h2>
			<div class="image">
				<p>
					<span class="pag">
<?php if ($ordem_prev > -1) {?>					
						<a href="detailsvideo.php?total_foto=<?php echo $total_foto;?>&ordem_foto=<?php echo $ordem_prev;?>&tombo=<?php echo $tombo_array[$ordem_prev];?>" class="prev">Anterior</a>
<?php } if ($ordem_next > -1) {?>					
						<a href="detailsvideo.php?total_foto=<?php echo $total_foto;?>&ordem_foto=<?php echo $ordem_next;?>&tombo=<?php echo $tombo_array[$ordem_next];?>" class="next">Proxima</a>
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
					<a href="<?php echo $cloud_server?>/download_videos.php?c=<?php echo $row_dados_foto['tombo'];?>&u=<?php echo $row_login['login']?>&p=<?php echo $row_login['senha']?>&f=true" class="save">Salvar video original</a>
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
			<div class="bts">
				<div class="left">
					<div class="bt-aprovar"><a class="edicao_aprovar" href="tool_addmesadeluz_video.php?status=1&tombo=<?php echo $tombo; ?>" onclick="return false">Aprovar</a></div>
					<div class="bt-recusar"><a class="edicao_recusar" href="tool_addmesadeluz_video.php?status=-1&tombo=<?php echo $tombo; ?>" onclick="return false">Recusar</a></div>
					</div>
				<div class="right">
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

<?php //include("part_footer.php");?>

</body>
</html>


