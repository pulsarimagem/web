<?php require_once('Connections/pulsar.php'); ?>
<?php 
include("../tool_auth.php");
$tombo = "00000";
if (isset($_GET['tombo'])) {
  $MMColParam_dados_foto = (get_magic_quotes_gpc()) ? $_GET['tombo'] : addslashes($_GET['tombo']);
//  $tombo = $MMColParam_dados_foto;
  $tombos = array();
  $tombos[] = $MMColParam_dados_foto;
  $MMColParam_dados_fotos = $tombos;
}
if (isset($_GET['tombos'])) {
  $MMColParam_dados_fotos = (get_magic_quotes_gpc()) ? $_GET['tombos'] : $_GET['tombos'];
  $tombos = $MMColParam_dados_fotos;
}
/*
mysql_select_db($database_pulsar, $pulsar);
$query_dados_foto = sprintf("SELECT 
  Fotos.Id_Foto,
  Fotos.tombo,
  Fotos.id_autor,
  fotografos.Nome_Fotografo,
  Fotos.data_foto,
  Fotos.cidade,
  Estados.Sigla,
  Fotos.orientacao,
  Fotos.assunto_principal,
  paises.nome as pais
FROM
 Fotos
 INNER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
 LEFT OUTER JOIN Estados ON (Fotos.id_estado=Estados.id_estado)
 LEFT OUTER JOIN paises ON (paises.id_pais=Fotos.id_pais)
WHERE
  (Fotos.tombo LIKE '%s')", $MMColParam_dados_foto);
$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
$row_dados_foto = mysql_fetch_assoc($dados_foto);
$totalRows_dados_foto = mysql_num_rows($dados_foto);

mysql_select_db($database_pulsar, $pulsar);
$query_extra_foto = sprintf("SELECT * FROM Fotos_extra WHERE tombo = '%s'", $MMColParam_dados_foto);
$extra_foto = mysql_query($query_extra_foto, $pulsar) or die(mysql_error());
$row_extra_foto = mysql_fetch_assoc($extra_foto);
$totalRows_extra_foto = mysql_num_rows($extra_foto);

$assunto_download = $row_dados_foto['assunto_principal'];
*/
$has_video = false;
$has_foto = false;
$has_hd = false;

if(isset($tombos)) {
	foreach ($tombos as $tombo) {
		if(isVideo($tombo)) {
			$has_video = true;
		} else {
			$has_foto = true;
		}
	}
	
	$download_url_param = "downloads[]=";
	$download_url_param .= implode("&downloads[]=", $tombos);
	$layout_url_param = "layouts[]=";
	$layout_url_param .= implode("&layouts[]=", $tombos);
	
	if(count($tombos) > 1) {
		$assunto_download = "Download Multiplo (".count($tombos)." Imagens)";
	} else {
		mysql_select_db($database_pulsar, $pulsar);
		$query_dados_foto = sprintf("SELECT 
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.id_autor,
		  fotografos.Nome_Fotografo,
		  Fotos.data_foto,
		  Fotos.cidade,
		  Estados.Sigla,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  paises.nome as pais
		FROM
		 Fotos
		 INNER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
		 LEFT OUTER JOIN Estados ON (Fotos.id_estado=Estados.id_estado)
		 LEFT OUTER JOIN paises ON (paises.id_pais=Fotos.id_pais)
		WHERE
		  (Fotos.tombo LIKE '%s')", $MMColParam_dados_fotos[0]);
		$dados_foto = mysql_query($query_dados_foto, $pulsar) or die(mysql_error());
		$row_dados_foto = mysql_fetch_assoc($dados_foto);
		$totalRows_dados_foto = mysql_num_rows($dados_foto);
		
		mysql_select_db($database_pulsar, $pulsar);
		$query_extra_foto = sprintf("SELECT * FROM Fotos_extra WHERE tombo = '%s'", $MMColParam_dados_fotos[0]);
		$extra_foto = mysql_query($query_extra_foto, $pulsar) or die(mysql_error());
		$row_extra_foto = mysql_fetch_assoc($extra_foto);
		$totalRows_extra_foto = mysql_num_rows($extra_foto);

		mysql_select_db($database_pulsar, $pulsar);
		$query_extra_video = sprintf("SELECT * FROM videos_extra WHERE tombo = '%s'", $MMColParam_dados_fotos[0]);
		$extra_video = mysql_query($query_extra_video, $pulsar) or die(mysql_error());
		$row_extra_video = mysql_fetch_assoc($extra_video);
		$totalRows_extra_video = mysql_num_rows($extra_video);
		
		$assunto_download = $row_dados_foto['assunto_principal'];
	}
} 
if($has_video) {
	if($row_extra_video['resolucao']=="1920x1080") {
		$has_hd = true;
	}
}

if($has_video && !$has_foto) {
	if(count($tombos) == 1) {
		if(strstr($row_top_login['download'], 'V')) {
			$location = "details_download_form.php?name=$tombos[0]&contrato=V&resolucao=HD";
			if(!$has_hd) {
				$location .= "&hd=false";
			}
			header("location: $location");
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>

<?php include("part_topbar.php")?>

<div class="main size960">

<?php //include("part_grid_left.php")?>

	<div class="grid-center">
		<div class="details">
			<a href="<?php echo $_SESSION['last_detail'];?>" class="voltar">« Back</a>
			<br/><br/>
			<!--<h2><?php echo $assunto_download;?></h2>-->
            <h2><?php echo translateText($assunto_download); ?></h2>
			<br/>
<?php if($has_video && !$has_foto) {?>			
<?php 	if(count($tombos) == 1) { 
			if(strstr($row_top_login['download'], 'V')) { ?>			
			<div class="tipo-de-download">
<?php if($has_hd) { ?>			
            	<h3><a href="details_download_form.php?name=<?php echo $tombos[0]?>&contrato=V&resolucao=HD&<?php echo $download_url_param;?>">HD</a> or <a href="details_video_form.php?name=<?php echo "/dist/".$tombos[0]."_1280x720"?>&resolucao=SD&<?php echo $download_url_param;?>">SD</a></h3>
<?php } else { ?> 
            	<h3><a href="details_download_form.php?name=<?php echo $tombos[0]?>&contrato=V&resolucao=SD&<?php echo $download_url_param;?>">SD</a></h3>
<?php } ?>           	
            </div>
<?php 		} else { ?>
			<div class="tipo-de-download">
            	<h3>User not authorized to download.</h3>
            </div>
<?php 		}?>
<?php 	} else { ?>
			<div class="tipo-de-download">
            	<h3>You can not donwload more than one file at a time.</h3>
            </div>
<?php 	}?>
<?php } else if(!$has_video && $has_foto){ ?>
<?php 	if(strstr($row_top_login['download'],'S')) { ?>
			<div class="tipo-de-download">
<?php 		if(isset($tombos)) {?>
            	<h3><a href="details_download_form.php?<?php echo $download_url_param;?>">Download</a> or <a href="details_layout_form.php?<?php echo $layout_url_param;?>">Layout</a></h3>
<?php 		} else {?>
            	<h3><a href="details_download_form.php?download=<?php echo $tombo;?>">Download</a> or <a href="details_layout_form.php?layout=<?php echo $tombo;?>">Layout</a></h3>
<?php 		} ?>
            </div>
<?php 	} else if(strstr($row_top_login['download'],'L')) { ?>			
			<div class="tipo-de-download">
<?php 		if(isset($tombos)) {?>
            	<h3><a href="details_layout_form.php?<?php echo $layout_url_param;?>">Layout</a></h3>
<?php 		} else {?>
            	<h3><a href="details_layout_form.php?layout=<?php echo $tombo;?>">Layout</a></h3>
<?php 		} ?>
            </div>
<?php 	} else { ?>
			<div class="tipo-de-download">
            	<h3>>User not authorized to download.</h3>
            </div>
<?php 	}?>
<?php } else { ?>
			<div class="tipo-de-download">
            	<h3>You can not donwload more than one file at a time.</h3>
            </div>
<?php } ?>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>
<?php if(isset($tombos) && count($tombos) > 1) {?>
<script>
alert('To download multiple files they must belong to the same project.');
</script>
<?php }?>
</body>
</html>