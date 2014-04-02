<?php 
mysql_select_db($database_pulsar, $pulsar);

$sql_create = "
CREATE TABLE log_count_temas 

SELECT
	tema AS id_tema, count(tema) AS contador 
FROM 
	pesquisa_tema 
WHERE 
	datahora > now() - INTERVAL 12 MONTH  
GROUP BY 
	id_tema
HAVING 
	(contador > 1) 
ORDER BY
	contador DESC;
";
if(!mysql_num_rows( mysql_query("SHOW TABLES LIKE 'log_count_temas'")))
{
	mysql_query($sql_create, $pulsar) or die(mysql_error());
}


$query_mais_vista3 = "
SELECT DISTINCT 
	Fotos.Id_Foto,   Fotos.tombo, Fotos.assunto_principal, Fotos.orientacao, Fotos.data_foto, temas.Id, fotografos.Nome_Fotografo, temas.id 
FROM 
	log_count_temas
LEFT JOIN (SELECT * FROM rel_fotos_temas ORDER BY RAND() LIMIT 2000) AS rel_fotos_temas ON (log_count_temas.id_tema = rel_fotos_temas.id_tema)
LEFT JOIN Fotos  ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)  
INNER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id) 
WHERE Fotos.orientacao = 'H'
		AND Fotos.tombo RLIKE '^[a-zA-Z]'
GROUP BY log_count_temas.id_tema
ORDER BY log_count_temas.contador DESC 
limit 20;
";
//	AND Fotos.tombo RLIKE '^[a-zA-Z]' 
//LIMIT 20;
//mysql_query($query_mais_vista1, $pulsar) or die(mysql_error());
//mysql_query($query_mais_vista2, $pulsar) or die(mysql_error());
$mais_vista = mysql_query($query_mais_vista3, $pulsar) or die(mysql_error());
$row_mais_vista = mysql_fetch_assoc($mais_vista);
$totalRows_mais_vista = mysql_num_rows($mais_vista);
?>
			<h2>Videos visualizados</h2>
			<div class="box" id="carouselB">
				<ul>
<?php do { ?>
					<li>
						<a href="details.php?tombo=<?php echo $row_mais_vista['tombo']."&search=mostviewed"; ?>">
<!-- <?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_mais_vista['tombo']; ?>p.jpg -->
							<img src="<?php echo $cloud_server?>Videos/thumbs/<?php echo $row_mais_vista['tombo']."_3s.jpg?search=mostviewed"?>" title="" onMouseover="ddrivetip('<?php echo $row_mais_vista['assunto_principal']; ?><?php  //
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
