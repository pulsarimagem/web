		<div class="content">
<?php 
if($siteDebug) {
	$timeBefore = microtime(true);
}

mysql_select_db($database_pulsar, $pulsar);
$queryShowtmp = "SHOW TABLES LIKE 'tmp_menu_fotos'";
$rsShowtmp = mysql_query($queryShowtmp, $pulsar) or die(mysql_error());

if(mysql_num_rows($rsShowtmp) != 1) {
 	mysql_select_db($database_pulsar, $pulsar);
 	$query_droptmp = "DROP TABLE IF EXISTS tmp_menu_fotos;";
 	mysql_query($query_droptmp, $pulsar) or die(mysql_error());

	//	$query_temas_menu = "select * from temas left join (select distinct id_pai from lista_temas left join (select distinct id_tema from rel_fotos_temas left join (select id_foto from rel_fotos_temas left join (select id from temas where pai in (select id from temas where pai = 3 and Tema like \"".$row_estado['Estado']."\") union select id from temas where pai = 3 and Tema like \"".$row_estado['Estado']."\") as temas_estado on rel_fotos_temas.id_tema = temas_estado.id where id_tema = id) as fotos_tema_estado on rel_fotos_temas.id_foto = fotos_tema_estado.id_foto where rel_fotos_temas.id_foto = fotos_tema_estado.id_foto) as  id_temas_faltando on lista_temas.id_tema = id_temas_faltando.id_tema where lista_temas.id_tema = id_temas_faltando.id_tema) as temas_estado_id on temas.Id = temas_estado_id.id_pai where temas.Id = temas_estado_id.id_pai order by Pai,Tema ASC";
	$query_temas_menu_adv = "
		create table if not exists tmp_menu_fotos ENGINE = MEMORY select * from temas left join
		(select distinct id_pai from lista_temas left join
		(select distinct id_tema from rel_fotos_temas left join
		(select distinct id_foto from Fotos where tombo NOT RLIKE '^[a-zA-Z]')
		as fotos_tema_estado on rel_fotos_temas.id_foto = fotos_tema_estado.id_foto where rel_fotos_temas.id_foto = fotos_tema_estado.id_foto)
		as  id_temas_faltando on lista_temas.id_tema = id_temas_faltando.id_tema where lista_temas.id_tema = id_temas_faltando.id_tema)
		as temas_estado_id on temas.Id = temas_estado_id.id_pai where temas.Id = temas_estado_id.id_pai order by Pai,Tema ASC;";

	$temas_menu_adv = mysql_query($query_temas_menu_adv, $pulsar) or die(mysql_error());
}

$idioma="";
if($lingua != "br")
	$idioma = "_en";
//$query_temas = "SELECT DISTINCT Id,Tema$idioma as Tema, Pai FROM temas LEFT JOIN rel_fotos_temas on temas.Id = rel_fotos_temas.id_tema LEFT JOIN Fotos on rel_fotos_temas.id_foto = Fotos.Id_foto WHERE Pai = 0 AND tombo NOT RLIKE '^[a-zA-Z]' ORDER BY Pai,Tema ASC";
$query_temas = "SELECT Id,Tema$idioma as Tema, Pai FROM tmp_menu_fotos where Pai = 0 ORDER BY Pai,Tema ASC";
$temas_menu = mysql_query($query_temas, $pulsar) or die(mysql_error());
   
   $html = "
			<ul class=\"menu-nossos-temas\">";
   $table = "tmp_menu_fotos";
   rootTree($temas_menu, $table, $html, $pulsar, $idioma);
   $html .= "
			</ul>
			";
 
   printf("%s", $html);
if($siteDebug) {
	$timeAfter = microtime(true);
	$diff = $timeAfter - $timeBefore;
	echo "<strong>Tempo tema: </strong>".$diff."<br>";
}
?>

		</div>
