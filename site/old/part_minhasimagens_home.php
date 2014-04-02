<?php 
$colname_login = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_login = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_login = sprintf("SELECT id_cadastro, tipo FROM cadastro WHERE login like '%s'", $colname_login);
$login = mysql_query($query_login, $pulsar) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);
$totalRows_login = mysql_num_rows($login);

mysql_select_db($database_pulsar, $pulsar);
$query_fotos_pasta = sprintf("SELECT   cotacao.id_cadastro,  cotacao.id_cotacao,  cotacao.tombo,  fotografos.Nome_Fotografo,  fotografos.Iniciais_Fotografo,  Fotos.data_foto,  Fotos.cidade,  Estados.Estado,  Estados.Sigla,  Fotos.assunto_principal, paises.nome as pais FROM Fotos LEFT JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo) INNER JOIN cotacao ON (cotacao.tombo=Fotos.tombo) LEFT OUTER JOIN Estados ON (Fotos.id_estado=Estados.id_estado) LEFT JOIN paises ON (paises.id_pais=Fotos.id_pais) WHERE cotacao.id_cadastro = %s ORDER BY tombo", $row_top_login['id_cadastro']);
$fotos_pasta = mysql_query($query_fotos_pasta, $pulsar) or die(mysql_error());
$row_fotos_pasta = mysql_fetch_assoc($fotos_pasta);
$totalRows_fotos_pasta = mysql_num_rows($fotos_pasta);
/*
$query_fotos_pasta = sprintf("SELECT   cotacao.id_cadastro,  cotacao.id_cotacao,  cotacao.tombo,  fotografos.Nome_Fotografo,  fotografos.Iniciais_Fotografo,  Fotos.data_foto,  Fotos.cidade,  Estados.Estado,  Estados.Sigla,  Fotos.assunto_principal, paises.nome as pais FROM Fotos LEFT JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo) INNER JOIN cotacao ON (cotacao.tombo=Fotos.tombo) LEFT OUTER JOIN Estados ON (Fotos.id_estado=Estados.id_estado) LEFT JOIN paises ON (paises.id_pais=Fotos.id_pais) WHERE cotacao.id_cadastro = %s ORDER BY tombo
limit 4", $row_top_login['id_cadastro']);
$fotos_pasta = mysql_query($query_fotos_pasta, $pulsar) or die(mysql_error());
$row_fotos_pasta = mysql_fetch_assoc($fotos_pasta);
*/

mysql_select_db($database_pulsar, $pulsar);
$query_fotos_download = sprintf("SELECT downloads.id_login, downloads.tombo, fotografos.Nome_Fotografo, fotografos.Iniciais_Fotografo, Fotos.data_foto, Fotos.cidade, Estados.Estado, Estados.Sigla, Fotos.assunto_principal, paises.nome as pais from Fotos INNER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo) INNER JOIN (SELECT log_download2.id_login, log_download2.arquivo, left(arquivo,length(arquivo)-4) as tombo from log_download2 WHERE log_download2.id_login = %s ORDER BY log_download2.data_hora DESC LIMIT 50) as downloads ON (downloads.tombo=Fotos.tombo) LEFT OUTER JOIN Estados ON (Fotos.id_estado=Estados.id_estado) LEFT JOIN paises ON (paises.id_pais=Fotos.id_pais)
limit 4;", $row_top_login['id_cadastro']);
$fotos_download = mysql_query($query_fotos_download, $pulsar) or die(mysql_error());
$row_fotos_download = mysql_fetch_assoc($fotos_download);
$totalRows_fotos_download = mysql_num_rows($fotos_download);

$i = 0;
?>

			<div class="minhasimagens home-imagens">
				<h2>
                    Aguardando cotação
<?php if ($totalRows_fotos_pasta > 0) { echo ": $totalRows_fotos_pasta imagens"?>
                    <a href="solicitarcotacao.php" class="finalizar">Finalizar cotação</a>
<?php } ?>
                    <div class="clear"></div>
                </h2>
<?php if ($totalRows_fotos_pasta == 0) { ?>
				<div class="error-msg">
<!-- 					Nenhuma imagem baixada ou aguardando cotação por enquanto. Que tal <a href="buscaavancada.php">ir atrás de algumas?</a> -->
					Nenhuma imagem aguardando cotação.
				</div>
<?php } else { ?>
				<div class="box" style="padding-bottom: 0;" id="carouselA">
					<ul>
<?php do { ?>
<?php 	$i++;?>
						<li>
							<a href="details.php?tombo=<?php echo $row_fotos_pasta['tombo']."&search=mostviewed"; ?>">
								<img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_fotos_pasta['tombo']; ?>p.jpg" title="" onMouseover="ddrivetip('<?php echo $row_fotos_pasta['assunto_principal']; ?><?php 
if (strlen($row_fotos_pasta['data_foto']) == 4) {
	echo ' - '.$row_fotos_pasta['data_foto'];
} elseif (strlen($row_fotos_pasta['data_foto']) == 6) {
	echo ' - '.substr($row_fotos_pasta['data_foto'],4,2).'/'.substr($row_fotos_pasta['data_foto'],0,4);
} elseif (strlen($row_fotos_pasta['data_foto']) == 8) {
	echo ' - '.substr($row_fotos_pasta['data_foto'],6,2).'/'.substr($row_fotos_pasta['data_foto'],4,2).'/'.substr($row_fotos_pasta['data_foto'],0,4);
}
						?>')" onMouseout="hideddrivetip()">
								<span><strong><?php echo $row_fotos_pasta['Nome_Fotografo']; ?></strong></span>
<!-- 								<span>
<?php
$detail_local = $row_fotos_pasta['cidade']; 
if (($row_fotos_pasta['Sigla'] <> '') AND ( ( is_null($row_fotos_pasta['pais'])) OR ($row_fotos_pasta['pais'] == 'Brasil'))) { 
	if ($row_fotos_pasta['cidade'] <> '') {
		$detail_local .=' - ';
	}
	$detail_local .= $row_fotos_pasta['Sigla']; 
}

if ((!is_null($row_fotos_pasta['pais'])) and ($row_fotos_pasta['pais']!='Brasil')) {
					$detail_local = "</span>
							<span>".$row_fotos_pasta['pais'];
}

echo $detail_local;
?>
								</span> -->
								<span><?php echo $row_fotos_pasta['tombo']; ?></span>
								
							</a>
						</li>
<?php } while (($row_fotos_pasta = mysql_fetch_assoc($fotos_pasta)) && $i < 4); ?>
						<div class="clear"></div>
					</ul>
				</div>
<?php } ?>
			</div>
			
			<div class="minhasimagens home-imagens">
				<h2>
					Histórico de download
<?php if (($totalRows_fotos_download > 0)) { ?>
					<a href="historicodownload.php" class="vertodas">Ver todas as imagens baixadas</a>
<?php } ?>
					<div class="clear"></div>
				</h2>
<?php if (($totalRows_fotos_download == 0)) { ?>
				<div class="error-msg">
<!-- 					Nenhuma imagem baixada por enquanto. Que tal <a href="buscaavancada.php">ir atrás de algumas?</a> -->
					Nenhuma imagem baixada.
				</div>
<?php } else { ?>
				<div class="box" style="padding-bottom: 0;" id="carouselB">
					<ul>
<?php do { ?>
						<li>
							<a href="details.php?tombo=<?php echo $row_fotos_download['tombo']."&search=mostviewed"; ?>">
								<img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_fotos_download['tombo']; ?>p.jpg" title="" onMouseover="ddrivetip('<?php echo $row_fotos_download['assunto_principal']; ?><?php 
if (strlen($row_fotos_download['data_foto']) == 4) {
	echo ' - '.$row_fotos_download['data_foto'];
} elseif (strlen($row_fotos_download['data_foto']) == 6) {
	echo ' - '.substr($row_fotos_download['data_foto'],4,2).'/'.substr($row_fotos_download['data_foto'],0,4);
} elseif (strlen($row_fotos_download['data_foto']) == 8) {
	echo ' - '.substr($row_fotos_download['data_foto'],6,2).'/'.substr($row_fotos_download['data_foto'],4,2).'/'.substr($row_fotos_download['data_foto'],0,4);
}
						?>')" onMouseout="hideddrivetip()">
								<span><strong><?php echo $row_fotos_download['Nome_Fotografo']; ?></strong></span>
<!-- 								<span>
<?php
$detail_local = $row_fotos_download['cidade']; 
if (($row_fotos_download['Sigla'] <> '') AND ( ( is_null($row_fotos_download['pais'])) OR ($row_fotos_download['pais'] == 'Brasil'))) { 
	if ($row_fotos_download['cidade'] <> '') {
		$detail_local .=' - ';
	}
	$detail_local .= $row_fotos_download['Sigla']; 
}

if ((!is_null($row_fotos_download['pais'])) and ($row_fotos_download['pais']!='Brasil')) {
					$detail_local = "</span>
							<span>".$row_fotos_download['pais'];
}

echo $detail_local;
?>
								</span> -->
								<span><?php echo $row_fotos_download['tombo']; ?></span>
								
							</a>
						</li>
<?php } while ($row_fotos_download = mysql_fetch_assoc($fotos_download)); ?>
						<div class="clear"></div>
					</ul>
				</div>
<?php } ?>				
			</div>