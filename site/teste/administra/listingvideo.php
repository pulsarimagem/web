<?php require_once('Connections/pulsar.php'); ?>
<?php include('tool_auth.php'); ?>
<?php 

if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$edicao = $_GET['edicao'];
	if(count($edicao) > 0) {
		if($action=="Autorizar") {
			$query_update_status = "UPDATE Fotos_tmp SET status=1 WHERE tombo IN ('".implode("','",$edicao)."')";
			mysql_select_db($database_pulsar, $pulsar);
			$update_status = mysql_query($query_update_status, $pulsar) or die(mysql_error());
			$query_update_status = "UPDATE codigo_video SET status=1 WHERE codigo IN ('".implode("','",$edicao)."')";
			mysql_select_db($database_pulsar, $pulsar);
			$update_status = mysql_query($query_update_status, $pulsar) or die(mysql_error());
		}
		if($action=="Recusar") {
			$query_update_status = "UPDATE Fotos_tmp SET status=-1 WHERE tombo IN ('".implode("','",$edicao)."')";
			mysql_select_db($database_pulsar, $pulsar);
			$update_status = mysql_query($query_update_status, $pulsar) or die(mysql_error());
			$query_update_status = "UPDATE codigo_video SET status=-1 WHERE codigo IN ('".implode("','",$edicao)."')";
			mysql_select_db($database_pulsar, $pulsar);
			$update_status = mysql_query($query_update_status, $pulsar) or die(mysql_error());
		}
	}	
	if($action=="Finalizar") {
		$query_update_status = "UPDATE Fotos_tmp SET status=2 WHERE status=1";
		mysql_select_db($database_pulsar, $pulsar);
		$update_status = mysql_query($query_update_status, $pulsar) or die(mysql_error());
		$query_update_status = "UPDATE codigo_video SET status=2 WHERE status=1";
		mysql_select_db($database_pulsar, $pulsar);
		$update_status = mysql_query($query_update_status, $pulsar) or die(mysql_error());
		$query_update_status = "DELETE FROM Fotos_tmp WHERE status=-1";
		mysql_select_db($database_pulsar, $pulsar);
		$update_status = mysql_query($query_update_status, $pulsar) or die(mysql_error());
		$query_update_status = "UPDATE codigo_video SET status=-2 WHERE status=-1";
		mysql_select_db($database_pulsar, $pulsar);
		$update_status = mysql_query($query_update_status, $pulsar) or die(mysql_error());
	}		
}

mysql_select_db($database_pulsar, $pulsar);
$query_autor_tmp_select = sprintf("SELECT Fotos_tmp.id_autor, count(Fotos_tmp.id_autor) as total,fotografos.Nome_Fotografo as nome FROM Fotos_tmp, fotografos WHERE Fotos_tmp.tombo RLIKE '^[a-zA-Z]' AND (Fotos_tmp.status>=-1 AND Fotos_tmp.status<=1) AND Fotos_tmp.id_autor = fotografos.id_fotografo GROUP BY id_autor");
$autor_tmp_select = mysql_query($query_autor_tmp_select, $pulsar) or die(mysql_error());

$totalRows_autor_tmp_select = mysql_num_rows($autor_tmp_select);

if(isset($_GET['autor2'])) {
	$id_autor = $_GET['autor2'];
}
else if(isset($_POST['autor2'])) {
	$id_autor = $_POST['autor2'];
}
else if(isset($_SESSION['autor2']) && $_SESSION['autor2']!="") {
	$id_autor = $_SESSION['autor2'];
}

if(isset($id_autor)) {
	if($id_autor == "nada")
		unset($id_autor);
}

$_SESSION['last_search'] = $_SERVER['REQUEST_URI'];
$totalRows_retorno = 0;
$query = "";

$currentPage = $_SERVER["PHP_SELF"];

$show_preview = true;
//if(isset($_GET['preview']) && $_GET['preview'] != "preview")
//	$show_preview = false;

$maxRows_retorno = 48;
if(isset($_SESSION['maxRows']) && ($_SESSION['maxRows']!= "")) {
  $maxRows_retorno = (get_magic_quotes_gpc()) ? $_SESSION['maxRows'] : addslashes($_SESSION['maxRows']);
}
if(isset($_GET['maxRows']) && ($_GET['maxRows']!= "")) {
  $maxRows_retorno = (get_magic_quotes_gpc()) ? $_GET['maxRows'] : addslashes($_GET['maxRows']);
  $_SESSION['maxRows'] = $maxRows_retorno; 
}

if(isset($_GET['ajustar']) && $_GET['ajustar'] == "ajustar") {
	$_SESSION['ajustar'] = "true";
} else if(isset($_GET['ajustar']) && $_GET['ajustar'] != "ajustar") {
	unset($_SESSION['ajustar']);
}

$pageNum_retorno = 0;
if (isset($_GET['pageNum_retorno'])) {
  $pageNum_retorno = $_GET['pageNum_retorno'];
}

$startRow_retorno = $pageNum_retorno * $maxRows_retorno;
if (isset($_GET['startRow_retorno'])) {
  $startRow_retorno = $_GET['startRow_retorno'];
  $pageNum_retorno = intval($startRow_retorno / $maxRows_retorno);
  $startRow_retorno = $pageNum_retorno * $maxRows_retorno;
}

$ordem = "recente";
if (isset($_GET['ordem'])) {
	$ordem = $_GET['ordem'];
}
else {
	$_GET['ordem'] = "recente";
}
		  
$query = "Edi��o Videos";
include("../tool_listing_videos.php");

include("../tool_buildnavigation.php");
	
$nav_bar = buildNavigation($pageNum_retorno, $maxRows_retorno, $totalRows_retorno);

$_SESSION['ultima_pesquisa'] = $super_string;
$_SESSION['ultima_pesquisa_query'] = $query;

//echo $super_string."<br>";
//echo $query."<br>";

if(isset($_GET['show_tombo'])) {
	header("Location: details_video.php?tombo=".$_GET['show_tombo']."&ordem_foto=".$_GET['ordem_foto']."&total_foto=".$totalRows_retorno);
	$_SESSION['last_search'] = "listing.php?email_action=&email_id=".$_GET['email_id'];
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<link href="css.css" rel="stylesheet" type="text/css" />
<?php include("../scripts.php");?>
<script>
function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
</script>
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

<form method="get" name="form3" class="style2">
   Lista Autores: 
   <select name="autor2">
   		<option value="nada">--- Todos ---</option>
<?php while ($row_autor_tmp_select = mysql_fetch_assoc($autor_tmp_select)){ ?>
   		<option value="<?php echo $row_autor_tmp_select['id_autor'];?>" <?php if($row_autor_tmp_select['id_autor'] == $id_autor) echo " SELECTED"?>><?php echo $row_autor_tmp_select['nome'];?> [<?php echo $row_autor_tmp_select['total'];?> foto(s)]</option>
<?php } ?>
   </select>
   <input type="submit" name="Submit" value="Consultar">
</form>

<?php include("../tool_tooltip.php")?>

<?php //include("part_topbar.php");?>

<?php 
if (isset($_SESSION['ajustar'])) echo "<div class=\"main size-wide\">";
else echo "<div class=\"main size960\">";
?>

<?php //include("part_grid_left.php");?>
			
<?php 
if ($totalRows_retorno == 0) {
?>
	<div class="grid-right">
		<div class="cadastro">
			<h2>0 Resultados para "<?php echo $query?>"</h2>
			<p class="p">
                Infelizmente, <strong>n�o encontramos</strong> resultados para sua busca.<br/>
                Talvez alterando os termos ou verificando a ortografia correta voc� consiga encontrar o que est� procurando.
            </p>
			<a href="buscaavancada.php" class="back">� Tente uma busca avan�ada</a>
		</div>
	</div>
<?php }
else {
?>
	<div class="grid-right-videos">
		<div class="resultado">
			<form name="listing_opts" action="listingvideo.php" method="get">		
				<div class="title">
					<h2>Resultados para "<?php echo $query?>"</h2>
					<div class="p">
<?php include("../part_listing_options.php")?>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
<!--			
				<div class="ordenar">
					<p>Ordenar por:</p>
	                <select name="ordem" onChange="listing_opts.submit();">
	                  <option value="recente" <?php if($ordem == "recente") echo "selected"; ?>>�ltimas adicionadas</option>
	                  <option value="data" <?php if($ordem == "data") echo "selected"; ?>>Data da foto</option>
                  	  <option value="vistas" <?php if($ordem == "vistas") echo "selected"; ?>>Mais visualizadas</option>
	                  <option value="maior" <?php if($ordem == "maior") echo "selected"; ?>>Tamanho do arquivo</option>  
	                </select>
				</div>-->
			</form>

			<div class="nnav">
				<?php echo $startRow_retorno?> de <?php echo $totalRows_retorno ?> video(s) 
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
			<form name="edicao" action="listingvideo.php" method="get">
			<ul id="lista-script">
<?php 
$tot_fotos = 1;
$count_fotos = $startRow_retorno;
do { ?>
				<li>
					<a <?php if($row_retorno['status'] == 1) echo "class=\"approved\""; else if ($row_retorno['status'] == -1) echo "class=\"rejected\"";?>href="detailsvideo.php?tombo=<?php echo $row_retorno['tombo']."&search=PA&ordem_foto=$count_fotos&total_foto=$totalRows_retorno"; ?>">
						<img src="<?php echo $cloud_server?>Videos/thumbs/<?php echo $row_retorno['tombo']; ?>_3s.jpg" title="" onMouseover="ddrivetip('<?php echo addslashes($row_retorno['assunto_principal']); ?><?php if ($row_retorno['extra'] != NULL) echo ' - '.$row_retorno["extra"];?><?php 
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
						<div class="bt-mesadeluz">
<!-- 							<input type="checkbox" name="edicao[]" value="<?php echo $row_retorno['tombo'];?>" <?php if($row_retorno['status']==1) echo "checked"?>/> -->
							<a href="#" class="icon"></a>
							<div class="box_video" id="page_container<?php echo $row_retorno['tombo']?>">
								<ul class="content">
									<span><a class="edicao_aprovar" href="tool_addmesadeluz_video.php?status=1&tombo=<?php echo $row_retorno['tombo']; ?>" onclick="return false">Aprovar</a></span>
									<span><a class="edicao_recusar" href="tool_addmesadeluz_video.php?status=-1&tombo=<?php echo $row_retorno['tombo']; ?>" onclick="return false">Rejeitar</a></span>
								</ul>
							</div>
						</div>
						<span><?php echo $row_retorno['tombo']; ?></span>
<?php if ($show_preview) { ?>						
						<div class="bt-zoom">
                        	<a href="#"></a>
	                        <div class="mzoom" style="display: none;"><div id="mp<?php echo $row_retorno['tombo']; ?>">JW Player goes here</div>
	<script type="text/javascript">
		jwplayer("mp<?php echo $row_retorno['tombo']; ?>").setup({
			flashplayer: "video/player.swf",
			file: "<?php echo $cloud_server?>/Videos/previews/<?php echo $row_retorno['tombo']?>_320x180.flv",
			width: 320,
			height: 180,
			controlbar : "none",
			autostart: true
		});
//			image: "<?php echo $cloud_server?>/Videos/thumbs/<?php echo $row_retorno['tombo']?>_3s.jpg",
	</script>
	                        
	                        
	                        </div>
                        </div>
<?php } ?>						
						<div class="clear"></div>
					</div>
				</li>
<?php
	$tot_fotos++;
	$count_fotos++;
?>
<?php } while ($row_retorno = mysql_fetch_assoc($retorno)); ?>
				<div class="clear"></div>
			</ul>
			<input type="submit" name="action" value="Finalizar"/>
			</form>
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

<?php //include("part_footer.php");?>

<?php //include("../google_details.php");?>

</body>
</html>
<?php
if($siteDebug) {
	$timeEnd = microtime(true);
	$diff = $timeEnd - $timeStart;
	echo "<strong>delay Total: </strong>".$diff."</strong><br>";
}
