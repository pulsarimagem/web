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
	tema, count(tema) as contador 
FROM 
	pesquisa_tema 
WHERE 
	datahora > now() - INTERVAL 12 MONTH  
GROUP BY 
	tema
HAVING 
	(count(tema) > 1) 
ORDER BY
	count(tema) desc limit 20;
";
$query_mais_vista3 = "
SELECT DISTINCT 
	Fotos.Id_Foto,   Fotos.tombo, Fotos.assunto_principal, Fotos.orientacao, Fotos.data_foto, temas.Id, fotografos.Nome_Fotografo, temas.id 
FROM 
tmp2
LEFT JOIN (SELECT * FROM rel_fotos_temas ORDER BY RAND()) AS rel_fotos_temas ON (tmp2.tema = rel_fotos_temas.id_tema)
LEFT JOIN Fotos  ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)  
INNER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id) 
WHERE Fotos.orientacao = 'H'
GROUP BY tmp2.tema
ORDER BY tmp2.contador DESC 
limit 20;
";
//LIMIT 20;
mysql_query($query_mais_vista1, $pulsar) or die(mysql_error());
mysql_query($query_mais_vista2, $pulsar) or die(mysql_error());
$mais_vista = mysql_query($query_mais_vista3, $pulsar) or die(mysql_error());
$row_mais_vista = mysql_fetch_assoc($mais_vista);
$totalRows_mais_vista = mysql_num_rows($mais_vista);
?>
			<h2>Temas mais vistos</h2>
			<div class="box" id="carouselB">
				<ul>
<?php do { ?>
					<li>
						<a href="details.php?tombo=<?php echo $row_mais_vista['tombo']."&search=mostviewed"; ?>">
							<img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_mais_vista['tombo']; ?>p.jpg" title="" onMouseover="ddrivetip('<?php echo $row_mais_vista['assunto_principal']; ?><?php 
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
