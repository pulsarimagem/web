		<div class="content">
<?php 


	mysql_select_db($database_pulsar, $pulsar);
	$query_droptmp = "DROP TEMPORARY TABLE IF EXISTS tmp_menu_videos;";
	mysql_query($query_droptmp, $pulsar) or die(mysql_error());

	//	$query_temas_menu = "select * from temas left join (select distinct id_pai from lista_temas left join (select distinct id_tema from rel_fotos_temas left join (select id_foto from rel_fotos_temas left join (select id from temas where pai in (select id from temas where pai = 3 and Tema like \"".$row_estado['Estado']."\") union select id from temas where pai = 3 and Tema like \"".$row_estado['Estado']."\") as temas_estado on rel_fotos_temas.id_tema = temas_estado.id where id_tema = id) as fotos_tema_estado on rel_fotos_temas.id_foto = fotos_tema_estado.id_foto where rel_fotos_temas.id_foto = fotos_tema_estado.id_foto) as  id_temas_faltando on lista_temas.id_tema = id_temas_faltando.id_tema where lista_temas.id_tema = id_temas_faltando.id_tema) as temas_estado_id on temas.Id = temas_estado_id.id_pai where temas.Id = temas_estado_id.id_pai order by Pai,Tema ASC";
	$query_temas_menu_adv = "
		create temporary table tmp_menu_videos select * from temas left join
		(select distinct id_pai from lista_temas left join
		(select distinct id_tema from rel_fotos_temas left join
		(select distinct id_foto from Fotos where tombo RLIKE '^[a-zA-Z]')
		as fotos_tema_estado on rel_fotos_temas.id_foto = fotos_tema_estado.id_foto where rel_fotos_temas.id_foto = fotos_tema_estado.id_foto)
		as  id_temas_faltando on lista_temas.id_tema = id_temas_faltando.id_tema where lista_temas.id_tema = id_temas_faltando.id_tema)
		as temas_estado_id on temas.Id = temas_estado_id.id_pai where temas.Id = temas_estado_id.id_pai order by Pai,Tema ASC;";

	$temas_menu_adv = mysql_query($query_temas_menu_adv, $pulsar) or die(mysql_error());

$idioma="";
if($lingua != "br")
	$idioma = "_en";
	
mysql_select_db($database_pulsar, $pulsar);
$query_temas = "SELECT Id,Tema$idioma as Tema, Pai FROM tmp_menu_videos where Pai = 0 ORDER BY Pai,Tema ASC";
$temas_menu = mysql_query($query_temas, $pulsar) or die(mysql_error());
   
   $html = "
			<ul class=\"menu-nossos-temas\">";
   rootTree_video($temas_menu, "tmp_menu_videos", $html, $pulsar, $idioma);
   $html .= "
			</ul>
			";
 
   printf("%s", $html);

?>

		</div>
