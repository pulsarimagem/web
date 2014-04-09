<?php require_once('Connections/pulsar.php'); ?>
<?php 
function check_exist($id_pasta, $tombo, $database_pulsar, $pulsar) {
	//echo "*".$id_pasta.$tombo."*";
	mysql_select_db($database_pulsar, $pulsar);
	$query_tombo_pastas = sprintf("SELECT tombo, id_pasta FROM pasta_fotos where id_pasta = %s and tombo like '%s';",$id_pasta, $tombo);
	$tombo_pastas = mysql_query($query_tombo_pastas, $pulsar) or die(mysql_error());
	$totalRows_pastas = mysql_num_rows($tombo_pastas);
	if($totalRows_pastas > 0)
		return true;
	return false;
}

$action = $_POST['action'];

if($action == "get_li") {
	
	header('Content-Type: text/html; charset=ISO-8859-1');
	
	
	$num = $_POST['max_row'];
	$page_num = $_POST['page_num'];
	if(isset($_SESSION['page_num_details_li'])) {
		$page_num = $_SESSION['page_num_details_li'];
	}
	$start = $page_num*$num;
	$total = $_POST['total_row'];
	
	$ss = $_SESSION['ultima_pesquisa'];
	$ss_array = explode('|',$ss);
	
	$small_ss_array = array_slice($ss_array, $start, $num);
	$small_ss = implode(",", $small_ss_array);
	
	include('inc_pesquisa_obj.php');
	$engine = new pesquisaPulsar();
	$engine->idioma = "br";
	$engine->dbConn = $pulsar;
	$engine->db = $database_pulsar;
	
	$retorno = $engine->getRetornoSuperString($small_ss);  
	$row_retorno = mysql_fetch_assoc($retorno);

	$totalRows_retorno = $total;
	$show_preview = true;
	
	$lingua = isset($_POST['lingua'])?$_POST['lingua']:"";
	// Carregar pastas
	
	$colname_pastas = "1";
	if (isset($_SESSION['MM_Username'])) {
		$colname_pastas = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
	}
	mysql_select_db($database_pulsar, $pulsar);
	$query_pastas = sprintf("SELECT pastas.id_pasta,   pastas.nome_pasta 	FROM cadastro  INNER JOIN pastas ON (cadastro.id_cadastro=pastas.id_cadastro) WHERE (cadastro.login LIKE '%s') GROUP BY pastas.id_pasta ORDER BY pastas.nome_pasta", $colname_pastas);
	$pastas = mysql_query($query_pastas, $pulsar) or die(mysql_error());
	$row_pastas = mysql_fetch_assoc($pastas);
	$totalRows_pastas = mysql_num_rows($pastas);
	
$tot_fotos = 1;
$count_fotos = $start;
do { 
	$isVideo = isVideo($row_retorno['tombo']);
	?>
				<li>
					<a href="details.php?tombo=<?php echo $row_retorno['tombo']."&search=PA&ordem_foto=$count_fotos&page_num=$page_num&total_foto=$totalRows_retorno"; ?>">
						<img <?php if($isVideo) { ?>src="<?php echo $cloud_server?>Videos/thumbs/<?php echo $row_retorno['tombo']; ?>_3s.jpg"<?php } else { ?>src="<?php echo "http://www.pulsarimagens.com.br/" //$homeurl; ?>bancoImagens/<?php echo $row_retorno['tombo']; ?>p.jpg" <?php } ?> title="" onMouseover="ddrivetip('<?php echo addslashes(delQuote(($lingua=="en"?$row_retorno['assunto_en']:$row_retorno['assunto_principal']))); ?><?php if ($row_retorno['extra'] != NULL && $lingua!="en") echo ' - '.delQuote($row_retorno["extra"]);?><?php echo ' - '.addslashes($row_retorno['cidade']); ?><?php echo ' - '.addslashes($row_retorno['Sigla']!=""?$row_retorno['Sigla']:$row_retorno['nome']); ?><?php 
if (strlen($row_retorno['data_foto']) == 4) {
	echo ' - '.$row_retorno['data_foto'];
} elseif (strlen($row_retorno['data_foto']) == 6) {
	echo ' - '.substr($row_retorno['data_foto'],4,2).'/'.substr($row_retorno['data_foto'],0,4);
} elseif (strlen($row_retorno['data_foto']) == 8) {
	echo ' - '.substr($row_retorno['data_foto'],6,2).'/'.substr($row_retorno['data_foto'],4,2).'/'.substr($row_retorno['data_foto'],0,4);
}
						?> <?php if($row_retorno['direito_img'] == 1) echo LISTING_DIRETO_IMG;
else if($row_retorno['direito_img'] == 2) echo LISTING_DIRETO_IMG_ACRESCIMO;
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
			wmode: "opaque",
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
								<p><?php echo LISTING_ADD_MY_IMG?></p>
								<div class="page_navigation"></div>
								<ul class="content">
<?php 
if($logged) {
	if ($totalRows_pastas > 0)  { 
		do {
?>
									<span><a class="add_mesa" href="#" id="../tool_addmesadeluz.php?id_pasta=<?php echo $row_pastas['id_pasta']; ?>&tombo=<?php echo $row_retorno['tombo']; ?>" style="<?php if(check_exist($row_pastas['id_pasta'], $row_retorno['tombo'], $database_pulsar, $pulsar)) echo "color:#bc690f;";?>"><?php echo $row_pastas['nome_pasta']; ?></a></span>
<?php 
		} while ($row_pastas = mysql_fetch_assoc($pastas));
		mysql_data_seek($pastas, 0);
		$row_pastas = mysql_fetch_assoc($pastas);
	}
?>
								</ul>
								<a href="" class="add_pasta" onclick="return false" ><strong>+</strong> <?php echo LISTING_NEW_FOLDER?></a>
								<form name="form1" method="get" action="../tool_addmesadeluz.php" onsubmit="alert('<?php echo SCRIPT_IMAGEM_ADD?>');">
									<div class="form" style="display: none;">
										<input name="nova_pasta" type="text" class="text" />
										<input name="action" type="submit" class="button" value="Ok" />
										<input name="tombo" type="hidden" value="<?php echo $row_retorno['tombo']; ?>" />
										<div class="clear"></div>
									</div>
								</form>
<?php 
} else { 
		echo LISTING_ADD_MSG_ERROR;
} 
?>
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
<?php 
	if(isset($_SESSION['page_num_details_li'])) {
		$_SESSION['page_num_details_li'] = "";
		unset($_SESSION['page_num_details_li']);
	}

}
else if($action == "get_nav") {
	$pageNum_retorno = $_POST['page_num'];
	if(isset($_SESSION['page_num_details_nav'])) {
		$pageNum_retorno = $_SESSION['page_num_details_nav'];
	}
	$maxRows_retorno = $_POST['max_row'];
	$totalRows_retorno = $_POST['total_row'];
	
	include("tool_buildnavigation_ajax.php");
	$nav_bar = buildNavigation($pageNum_retorno, $maxRows_retorno, $totalRows_retorno);
	//echo json_encode($nav_bar);
	echo $nav_bar[0];
	echo $nav_bar[1];
	echo $nav_bar[2];
	echo "<div class=\"clear\"></div>";
	if(isset($_SESSION['page_num_details_nav'])) {
		$_SESSION['page_num_details_nav'] = "";
		unset($_SESSION['page_num_details_nav']);
	}
	
}
?>