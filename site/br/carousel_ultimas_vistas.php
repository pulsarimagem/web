<?php 
mysql_select_db($database_pulsar, $pulsar);
$query_mais_vista1 = "
DROP TEMPORARY TABLE IF EXISTS tmp2;
";
$query_mais_vista2 = "
CREATE TEMPORARY TABLE 
	tmp2 
ENGINE = MEMORY 
SELECT
	distinct(tombo) 
FROM 
	log_pop 
WHERE 
	datahora > now() - INTERVAL 1 MONTH  
ORDER BY
	id_pop desc limit 20;
";
$query_mais_vista2 = "
CREATE TEMPORARY TABLE
	tmp2
ENGINE = MEMORY
SELECT
	distinct(tombo)
FROM
	log_pop
ORDER BY
	id_pop desc limit 30000;
";


$query_mais_vista3 = "
SELECT 
	Fotos.Id_Foto, Fotos.id_autor, 
	Fotos.cidade, Fotos.id_estado, Fotos.id_pais, paises.nome as pais, Estados.Estado, Estados.Sigla, 
	Fotos.assunto_principal, Fotos.orientacao, Fotos.tombo, Fotos.data_foto, 
	fotografos.Nome_Fotografo 
FROM 
	Fotos, tmp2, fotografos, Estados, paises
WHERE
	Fotos.tombo = tmp2.tombo and 
	Fotos.orientacao = 'H' and
	Fotos.id_autor=fotografos.id_fotografo and 
	Fotos.id_estado=Estados.id_estado and 
	paises.id_pais=Fotos.id_pais 
LIMIT 20;
";
//	AND Fotos.tombo NOT RLIKE '^[a-zA-Z]' 
//LIMIT 20;
mysql_query($query_mais_vista1, $pulsar) or die(mysql_error());
mysql_query($query_mais_vista2, $pulsar) or die(mysql_error());
$mais_vista = mysql_query($query_mais_vista3, $pulsar) or die(mysql_error());
$row_mais_vista = mysql_fetch_assoc($mais_vista);
$totalRows_mais_vista = mysql_num_rows($mais_vista);
?>
			<h2>Últimas pesquisadas</h2>
			<div class="box" id="carouselD">
				<ul>
<?php 
do { 
	$isVideo = isVideo($row_mais_vista['tombo']);
?>
					<li>
						<a href="details.php?tombo=<?php echo $row_mais_vista['tombo']."&search=mostviewed"; ?>">
							<img <?php if($isVideo) { ?>src="<?php echo $cloud_server?>Videos/thumbs/<?php echo $row_mais_vista['tombo']; ?>_3s.jpg"<?php } else { ?>src="<?php echo "http://www.pulsarimagens.com.br/" //$homeurl; ?>bancoImagens/<?php echo $row_mais_vista['tombo']; ?>p.jpg" <?php } ?> title="" onMouseover="ddrivetip('<?php echo $row_mais_vista['assunto_principal']; ?><?php 
if (strlen($row_mais_vista['data_foto']) == 4) {
	echo ' - '.$row_mais_vista['data_foto'];
} elseif (strlen($row_mais_vista['data_foto']) == 6) {
	echo ' - '.substr($row_mais_vista['data_foto'],4,2).'/'.substr($row_mais_vista['data_foto'],0,4);
} elseif (strlen($row_mais_vista['data_foto']) == 8) {
	echo ' - '.substr($row_mais_vista['data_foto'],6,2).'/'.substr($row_mais_vista['data_foto'],4,2).'/'.substr($row_mais_vista['data_foto'],0,4);
}
						?>')" onMouseout="hideddrivetip()">
<!--							<span><strong><?php echo $row_mais_vista['Nome_Fotografo']; ?></strong></span>
 							<span>
<?php
$detail_local = $row_mais_vista['cidade']; 
if (($row_mais_vista['Sigla'] <> '') AND ( ( is_null($row_mais_vista['pais'])) OR ($row_mais_vista['pais'] == 'Brasil'))) { 
	if ($row_mais_vista['cidade'] <> '') {
		$detail_local .=' - ';
	}
	$detail_local .= $row_mais_vista['Sigla']; 
}

if ((!is_null($row_mais_vista['pais'])) and ($row_mais_vista['pais']!='Brasil')) {
					$detail_local = "</span>
							<span>".$row_mais_vista['pais'];
}

echo $detail_local;
?>
							</span>
							<span><?php echo $row_mais_vista['tombo']; ?></span> -->
						</a>
					</li>
<?php } while ($row_mais_vista = mysql_fetch_assoc($mais_vista)); ?>
					<div class="clear"></div>
				</ul>
			</div>
