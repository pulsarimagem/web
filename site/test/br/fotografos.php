<?php require_once('Connections/pulsar.php'); ?>
<?php 
mysql_select_db($database_pulsar, $pulsar);
$query_fotografos_thumb = "
SELECT 
	Fotos.Id_Foto, Fotos.id_autor, 
	Fotos.cidade, Fotos.id_estado, Fotos.id_pais, paises.nome as pais, Estados.Estado, Estados.Sigla, 
	Fotos.assunto_principal, Fotos.orientacao, Fotos.tombo, Fotos.data_foto,
	fotografos.Nome_Fotografo, count(*) as counter
FROM 
	(SELECT Id_Foto, id_autor, cidade, id_estado, id_pais, assunto_principal, orientacao, tombo, data_foto 
	FROM Fotos 
	ORDER BY rand()) 
	as Fotos
INNER JOIN 
	fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
LEFT OUTER JOIN 
	Estados ON (Fotos.id_estado=Estados.id_estado)
LEFT OUTER JOIN 
	paises ON (paises.id_pais=Fotos.id_pais)
GROUP BY 
	Fotos.id_autor
ORDER BY 
	fotografos.Nome_Fotografo ASC
";
$fotografos_thumb = mysql_query($query_fotografos_thumb, $pulsar) or die(mysql_error());
$totalRows_fotografos_thumb = mysql_num_rows($fotografos_thumb);

include("../tool_buildnavigation.php");
$actual_page = 0;
if(isset($_GET['pageNum_retorno']))
	$actual_page = $_GET['pageNum_retorno'];

$maxRows_retorno = 200;//48;
if(isset($_GET['maxRows']) && ($_GET['maxRows']!= ""))
	$maxRows_retorno = $_GET['maxRows'];
	
$totalRows_query = $totalRows_fotografos_thumb;	
$nav_bar = buildNavigation($actual_page, $maxRows_retorno, $totalRows_query);


$offset = $actual_page * $maxRows_retorno;
$query_fotografos_thumb .= "LIMIT $offset,$maxRows_retorno";
$fotografos_thumb = mysql_query($query_fotografos_thumb, $pulsar) or die(mysql_error());
$row_fotografos_thumb = mysql_fetch_assoc($fotografos_thumb);

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

<?php 
if (isset($_GET['ajustar'])) echo "<div class=\"main size-wide\">";
else echo "<div class=\"main size960\">";
?>

<!--<?php //include("part_grid_left.php")?>-->

			
	<div class="grid-center">
		<div class="resultado">
			<form name="listing_opts" action="fotografos.php" method="get">		
				<div class="title">
	
					<h2>Fotógrafos </h2>
					<div class="p">
<?php //include("part_listing_options.php")?>
						<div class="clear"></div>
					</div>
	
					<div class="clear"></div>
				</div>
			</form>
			<div class="nav">
<?php 
echo $nav_bar[0];
//echo $nav_bar[1];
echo $nav_bar[2];
?>
				<div class="clear"></div>
			</div>
		
			<ol>
<?php do { ?>
				<li>
					<a href="listing.php?id_autor[]=<?php echo $row_fotografos_thumb['id_autor']."&pa_action=ok&tipo=inc_pa.php&horizontal=H&vertical=V&clear=true"; ?>" class="img">
					<span><img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_fotografos_thumb['tombo']; ?>p.jpg" title="<?php echo $row_fotografos_thumb['assunto_principal']; ?>"/></span>
					</a>
					<p><?php echo $row_fotografos_thumb['Nome_Fotografo']; ?></p>
				</li>
<?php } while ($row_fotografos_thumb = mysql_fetch_assoc($fotografos_thumb)); ?>
				<div class="clear"></div>
			</ol>
			
			<div class="nav">
<?php 
echo $nav_bar[0];
//echo $nav_bar[1];
echo $nav_bar[2];
?>
				<div class="clear"></div>
			</div>

			
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
<!-- 
<?php echo $nav_bar[3];?>
 -->