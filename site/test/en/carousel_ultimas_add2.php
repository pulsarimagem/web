<?php 

mysql_select_db($database_pulsar, $pulsar);
$query_mais_novas = "
SELECT * from (
SELECT *, count(*) as contador from (
SELECT 
	Fotos.Id_Foto, Fotos.id_autor, 
	Fotos.cidade, Fotos.id_estado, Fotos.id_pais, paises.nome as pais, Estados.Estado, Estados.Sigla, 
	Fotos.assunto_principal, Fotos.orientacao, Fotos.tombo, left(Fotos.tombo, 4) as lote, Fotos.data_foto,
	fotografos.Nome_Fotografo
FROM 
	Fotos
INNER JOIN 
	fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
LEFT OUTER JOIN 
	Estados ON (Fotos.id_estado=Estados.id_estado)
LEFT OUTER JOIN 
	paises ON (paises.id_pais=Fotos.id_pais)
WHERE
	Fotos.orientacao = 'H'
ORDER BY 
	Fotos.Id_Foto DESC
LIMIT 4000
) as Fotos
GROUP BY 
	lote
ORDER BY
	RAND()
) as Fotos_rand
ORDER BY
	RAND()
LIMIT 100;
";
/*
GROUP BY
	Fotos_rand.id_autor
ORDER BY
	RAND()
LIMIT 100;
";*/
$mais_novas = mysql_query($query_mais_novas, $pulsar) or die(mysql_error());
$row_mais_novas = mysql_fetch_assoc($mais_novas);
$totalRows_mais_novas = mysql_num_rows($mais_novas);
?>
			<div class="box" id="carouselC">
				<ul>
<?php do { ?>
					<li>
						<a href="details.php?tombo=<?php echo $row_mais_novas['tombo']."&search=lastadd"; ?>">
							<img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_mais_novas['tombo']; ?>p.jpg" title="<?php echo $row_mais_novas['assunto_principal']; ?><?php 
if (strlen($row_mais_novas['data_foto']) == 4) {
	echo ' - '.$row_mais_novas['data_foto'];
} elseif (strlen($row_mais_novas['data_foto']) == 6) {
	echo ' - '.substr($row_mais_novas['data_foto'],4,2).'/'.substr($row_mais_novas['data_foto'],0,4);
} elseif (strlen($row_mais_novas['data_foto']) == 8) {
	echo ' - '.substr($row_mais_novas['data_foto'],6,2).'/'.substr($row_mais_novas['data_foto'],4,2).'/'.substr($row_mais_novas['data_foto'],0,4);
}
						?>">
							<span><strong><?php echo $row_mais_novas['Nome_Fotografo']; ?></strong></span>
<!-- 							<span>
<?php
$detail_local = $row_mais_novas['cidade']; 
if (($row_mais_novas['Sigla'] <> '') AND ( ( is_null($row_mais_novas['pais'])) OR ($row_mais_novas['pais'] == 'Brasil'))) { 
	if ($row_mais_novas['cidade'] <> '') {
		$detail_local .=' - ';
	}
	$detail_local .= $row_mais_novas['Sigla']; 
}

if ((!is_null($row_mais_novas['pais'])) and ($row_mais_novas['pais']!='Brasil')) {
					$detail_local = "</span>
							<span>".$row_mais_novas['pais'];
}

echo $detail_local;
?>
							</span> -->
							<span><?php echo $row_mais_novas['tombo']; ?></span>
						</a>
					</li>
<?php } while ($row_mais_novas = mysql_fetch_assoc($mais_novas)); ?>
					<div class="clear"></div>
				</ul>
			</div>
