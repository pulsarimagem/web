<?php require_once('Connections/pulsar.php'); ?>
<?php 
include("tool_auth.php");
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
if(isset($tombos)) {
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
		
		$assunto_download = $row_dados_foto['assunto_principal'];
	}
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>

<?php include("part_topbar.php")?>

<div class="main size960">

<?php include("part_grid_left.php")?>

	<div class="grid-right">
		<div class="details">
			<a href="<?php echo $_SESSION['last_detail'];?>" class="voltar">« Voltar</a>
			<br/><br/>
			<h2><?php echo $assunto_download;?></h2>
			<br/>
<?php if($row_top_login['download']=='S') { ?>			
			<div class="tipo-de-download">
<?php if(isset($tombos)) {?>
            	<h3><a href="details_download_form.php?<?php echo $download_url_param;?>">Download</a> ou <a href="details_layout_form.php?<?php echo $layout_url_param;?>">Layout</a></h3>
<?php } else {?>
            	<h3><a href="details_download_form.php?download=<?php echo $tombo;?>">Download</a> ou <a href="details_layout_form.php?layout=<?php echo $tombo;?>">Layout</a></h3>
<?php } ?>
            </div>
<?php } else if($row_top_login['download']=='L') { ?>			
			<div class="tipo-de-download">
<?php if(isset($tombos)) {?>
            	<h3><a href="details_layout_form.php?<?php echo $layout_url_param;?>">Layout</a></h3>
<?php } else {?>
            	<h3><a href="details_layout_form.php?layout=<?php echo $tombo;?>">Layout</a></h3>
<?php } ?>
            </div>
<?php } else { ?>
			<div class="tipo-de-download">
            	<h3>Você não tem permissão para download.</h3>
            </div>
<?php }?>            
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>
<?php if(isset($tombos) && count($tombos) > 1) {?>
<script>
alert('Para baixar vários arquivos simultaneamente é necessário que todos pertençam ao mesmo projeto/livro.');
</script>
<?php }?>
</body>
</html>