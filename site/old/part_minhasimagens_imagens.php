<?php include("tool_minhasimagens_imagens.php")?>
			<div class="minhasimagens">
				<h2>Minhas imagens - <?php echo $row_nome_pasta['nome_pasta'];?></h2>
				<form name="form1" method="post" action="primeirapagina.php?id_pasta=<?php echo $_GET['id_pasta']?>">
					<input type="hidden" name="opcao" value="">
					<input type="hidden" name="id_pasta" value="<?php echo $_GET['id_pasta']?>">
					<input type="hidden" name="cotar" value="">
					<input type="hidden" name="who" value="">
<?php include("part_minhasimagens_botoes_imagens.php")?>
<?php if ($totalRows_fotos_pasta == 0) { ?>				
					<div class="error-msg">
						Nenhuma imagem adicionada por enquanto. Que tal <a href="buscaavancada.php">ir atr�s de algumas?</a>
					</div>
<?php } else { ?>
					<div class="minhasimages-pastas">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<td width="14"><input name="checkbox1" type="checkbox" value="checkbox" onClick="MM_callJS('checkAll(document.form1);')"/></td>
									<td width="83">&nbsp;</td>
									<td><!-- Sobre --></td>
								</tr>
							</thead>
							<tbody>
<?php $count_fotos = 0;
do { 
		
	mysql_select_db($database_pulsar, $pulsar);
	$query_temas = sprintf("SELECT Fotos.tombo, super_temas.Tema_total as Tema, super_temas.Id FROM super_temas INNER JOIN rel_fotos_temas ON (super_temas.Id=rel_fotos_temas.id_tema) INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) WHERE (Fotos.tombo = '%s')", $row_fotos_pasta['tombo']);
	$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
	$row_temas = mysql_fetch_assoc($temas);
	$totalRows_temas = mysql_num_rows($temas);
	
	mysql_select_db($database_pulsar, $pulsar);
	$query_palavras = sprintf("SELECT  DISTINCT  pal_chave.Pal_Chave,   pal_chave.Id FROM  rel_fotos_pal_ch  INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE   (Fotos.tombo LIKE '%s')", $row_fotos_pasta['tombo']);
	$palavras = mysql_query($query_palavras, $pulsar) or die(mysql_error());
	$row_palavras = mysql_fetch_assoc($palavras);
	$totalRows_palavras = mysql_num_rows($palavras);
?>						
								<tr>
									<td width="14" class="check"><input name="chkbox[]" type="checkbox" value="<?php echo $row_fotos_pasta['id_foto_pasta']; ?>" /></td>
									<td width="152"><p align="center"><a href="details.php?tombo=<?php echo $row_fotos_pasta['tombo']."&search=pasta&ordem_foto=$count_fotos&total_foto=$totalRows_fotos_pasta"; ?>"><img src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $row_fotos_pasta['tombo']; ?>p.jpg" title="<?php echo $row_fotos_pasta['assunto_principal']; ?>"/></a></p></td>
									<td class="sobre">
										C�digo: <strong><?php echo $row_fotos_pasta['tombo']; ?></strong><br/>
										Assunto: <strong><?php echo $row_fotos_pasta['assunto_principal']; ?></strong><br/>
										Local: <strong><?php echo $row_fotos_pasta['cidade']; ?><?php if ($row_fotos_pasta['Sigla'] <> '') { echo ' - ';};?><?php echo $row_fotos_pasta['Sigla']; ?></strong><br/>
										<?php if ($row_fotos_pasta['pais']<>"") { ?> Pa�s: <strong><?php echo $row_fotos_pasta['pais']; ?></strong><br/><?php } ?>
										Data: <strong><?php
		if (strlen($row_fotos_pasta['data_foto']) == 4) {
			echo $row_fotos_pasta['data_foto'];
		} elseif (strlen($row_fotos_pasta['data_foto']) == 6) {
			echo substr($row_fotos_pasta['data_foto'],4,2).'/'.substr($row_fotos_pasta['data_foto'],0,4);
		} elseif (strlen($row_fotos_pasta['data_foto']) == 8) {
			echo substr($row_fotos_pasta['data_foto'],6,2).'/'.substr($row_fotos_pasta['data_foto'],4,2).'/'.substr($row_fotos_pasta['data_foto'],0,4);
		}	?></strong><br/>
										Autor: <strong><?php echo $row_fotos_pasta['Nome_Fotografo']; ?></strong>
										<br/><br/>
										Temas relacionados: <br/>
<?php do { ?>
								        <strong><a href="listing.php?tema_action=&tema=<?php echo $row_temas['Id']; ?>"><?php echo $row_temas['Tema']; ?></a></strong><br>
<?php } while ($row_temas = mysql_fetch_assoc($temas)); ?>
										<br/>
										Descritores:<br/> |
<?php do { ?>
										<a href="listing.php?query=<?php echo $row_palavras['Pal_Chave']; ?>&pc_action=Ir&type=pc&tipo=inc_pc.php"><?php echo $row_palavras['Pal_Chave']; ?></a> | 
<?php } while ($row_palavras = mysql_fetch_assoc($palavras)); ?>
										<div class="mbuttons">
<!-- 											<a href="tool_downloader.php?tombo=<?php echo $row_fotos_pasta["tombo"];?>" class="download">Download</a>  -->
 											<a href="details_download.php?tombo=<?php echo $row_fotos_pasta["tombo"];?>" class="download">Download</a> 
											<?php if (!isQuoting($row_fotos_pasta['tombo'], $fotos_cotacao)) { ?><a href="#" onClick="MM_callJS('document.form1.cotar.value=\'<?php echo $row_fotos_pasta['tombo']; ?>\';document.form1.submit();')">Cotar</a><?php } else { ?><span>Aguardando Cota��o</span><?php } ?>
											<a href="details.php?tombo=<?php echo $row_fotos_pasta['tombo']."&search=pasta"; ?>">Ampliar</a>
											<a href="#" class="excluir" onClick="MM_callJS('document.form1.who.value=\'<?php echo $row_fotos_pasta['id_foto_pasta']; ?>\';validate3();')">Excluir</a>
										</div>
									</td>
								</tr>
<?php 
	$count_fotos++;
	if(!isset($super_string)) {
		$super_string = $row_fotos_pasta["tombo"];
	}
	else {
		$super_string .= "|".$row_fotos_pasta["tombo"];
	}	
} while ($row_fotos_pasta = mysql_fetch_assoc($fotos_pasta));
$_SESSION['ultima_pesquisa'] = $super_string;
$_SESSION['ultima_pesquisa_query'] = "Pasta ".$row_nome_pasta['nome_pasta'];

/* 						
							
							<tr class="select">
								<td width="14" class="check"><input name="" type="checkbox" value="" /></td>
								<td width="152"><p align="center"><img src="http://local.opg.co/dummyimage/152x100" width="152" height="100" /></p></td>
								<td class="sobre">
									C�digo: <strong>07JPR030</strong><br/>
									Assunto: <strong>Caf� da manh� em hotel fazenda de It� com fog�o a lenha</strong><br/>
									Local: <strong>Itu - SP</strong><br/>
									Pa�s: <strong>Brasil</strong><br/>
									Data: <strong>09/2009</strong><br/>
									Autor: <strong>Jo�o Prudente</strong>
									<br/><br/>
									Temas relacionados: <strong>Culin�ria</strong>
									<br/><br/>
									Descritores:<br/>
									alimento | balaio | bule | caf� da manh� | calor | caseiro | cesta | chama | comida | fog�o | latc�nio | lenha | p�es | p�o de forma | queijo | quente | Regi�o Sudeste | t�pico
									<div class="mbuttons">
										<a href="#" class="download">Download</a>
										<span>Aguardando Cota��o</span>
										<a href="#">Ampliar</a>
										<a href="#" class="excluir">Excluir</a>
									</div>
								</td>
							</tr>
*/ ?>							
							</tbody>
						</table>
					</div>
<?php } ?>
<?php include("part_minhasimagens_botoes_imagens.php")?>
				</form>
			</div>