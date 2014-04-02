<?php 
/*
 * 
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rel_fotos_comp` (
  `id_rel` int(11) NOT NULL auto_increment,
  `id_foto` int(11) default NULL,
  `id_comp` int(11) default NULL,
  PRIMARY KEY  (`id_rel`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `rel_fotos_comp`
--

LOCK TABLES `rel_fotos_comp` WRITE;
INSERT INTO `rel_fotos_comp` VALUES (1,48486,1),(2,48485,1),(3,29368,2),(4,29367,2),(5,48487,1);
UNLOCK TABLES;
 * 
 */


$show_comparing = true;

if (isset($_GET['search'])) {
	$type_search = $_GET['search'];
}
/*
if($type_search == "mostviewed")
	$show_comparing = false;
if($type_search == "lastadd")
	$show_comparing = false;

$row_dados_foto['Id_Foto'];

*/

mysql_select_db($database_pulsar, $pulsar);
$query_comparativo1 = "
DROP TEMPORARY TABLE IF EXISTS tmp6;
";
$query_comparativo2 = "
CREATE TEMPORARY TABLE 
	tmp6 
ENGINE = MEMORY 
SELECT
	id_foto 
FROM 
	rel_fotos_comp
WHERE 
	id_comp in (SELECT id_comp FROM rel_fotos_comp WHERE id_foto = ".$row_dados_foto['Id_Foto'].")   
ORDER BY
	id_foto desc;
";
$query_comparativo3 = "
SELECT 
	Fotos.Id_Foto, Fotos.id_autor, 
	Fotos.cidade, Fotos.id_estado, Fotos.id_pais, paises.nome as pais, Estados.Estado, Estados.Sigla, 
	Fotos.assunto_principal, Fotos.orientacao, Fotos.tombo, Fotos.data_foto, 
	fotografos.Nome_Fotografo 
FROM 
	Fotos, tmp6, fotografos, Estados, paises
WHERE
	Fotos.Id_Foto = tmp6.Id_Foto and 
	Fotos.orientacao = 'H' and
	Fotos.id_autor=fotografos.id_fotografo and 
	Fotos.id_estado=Estados.id_estado and 
	paises.id_pais=Fotos.id_pais and
	tmp6.Id_Foto != ".$row_dados_foto['Id_Foto']."
";
mysql_query($query_comparativo1, $pulsar) or die(mysql_error());
mysql_query($query_comparativo2, $pulsar) or die(mysql_error());
$comparativo = mysql_query($query_comparativo3, $pulsar) or die(mysql_error());
$row_comparativo = mysql_fetch_assoc($comparativo);
$totalRows_comparativo = mysql_num_rows($comparativo);

if($totalRows_comparativo > 0)
	$show_comparing = true;
else
	$show_comparing = false;
	
if($show_comparing) {	
?>
			<h2>Comparativos desta imagem</h2>
			<div class="box" id="carouselB">
				<ul>
<?php do {?>				
					<li>
						<a href="details.php?tombo=<?php echo $row_comparativo['tombo']."&search=comparativo"; ?>">
							<img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_comparativo['tombo']; ?>p.jpg" title="" onMouseover="ddrivetip('<?php echo $row_comparativo['assunto_principal']; ?><?php 
if (strlen($row_comparativo['data_foto']) == 4) {
	echo ' - '.$row_comparativo['data_foto'];
} elseif (strlen($row_comparativo['data_foto']) == 6) {
	echo ' - '.substr($row_comparativo['data_foto'],4,2).'/'.substr($row_comparativo['data_foto'],0,4);
} elseif (strlen($row_comparativo['data_foto']) == 8) {
	echo ' - '.substr($row_comparativo['data_foto'],6,2).'/'.substr($row_comparativo['data_foto'],4,2).'/'.substr($row_comparativo['data_foto'],0,4);
}
						?>')" onMouseout="hideddrivetip()" />
							<span><strong><?php echo $row_comparativo['Nome_Fotografo']; ?></strong></span>
							<span><?php echo $row_comparativo['tombo']; ?></span>
							
						</a>
					</li>
<?php } while($row_comparativo = mysql_fetch_assoc($comparativo));?>					
					<div class="clear"></div>
				</ul>
			</div>
<?php 
}
?>