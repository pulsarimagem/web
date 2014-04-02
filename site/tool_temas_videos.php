<?php
$query_temas_menu_video = "
		select * from temas left join
		(select distinct id_pai from lista_temas left join
		(select distinct id_tema from rel_fotos_temas left join
		(select distinct id_foto from Fotos where tombo rlike '^[A-Z]')
		as fotos_tema_estado on rel_fotos_temas.id_foto = fotos_tema_estado.id_foto where rel_fotos_temas.id_foto = fotos_tema_estado.id_foto)
		as  id_temas_faltando on lista_temas.id_tema = id_temas_faltando.id_tema where lista_temas.id_tema = id_temas_faltando.id_tema)
		as temas_estado_id on temas.Id = temas_estado_id.id_pai where temas.Id = temas_estado_id.id_pai order by Pai,Tema ASC;";

$temas_menu_video = mysql_query($query_temas_menu_video, $pulsar) or die(mysql_error());
$row_temas_menu_video = mysql_fetch_assoc($temas_menu_video);
$totalRows_temas_menu_video = mysql_num_rows($temas_menu_video);
?>