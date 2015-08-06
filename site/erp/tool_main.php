<?php
mysql_select_db($database_pulsar, $pulsar);
$query_dwn1 = "select count(id_login) as qtd, id_login, cadastro.login, cadastro.empresa
from log_download2
LEFT JOIN cadastro ON log_download2.id_login = cadastro.id_cadastro
WHERE to_days(now())-to_days(log_download2.data_hora) <= 3
group by id_login";
$dwn1 = mysql_query($query_dwn1, $pulsar) or die(mysql_error());
$row_dwn1 = mysql_fetch_assoc($dwn1);
$totalRows_dwn1 = mysql_num_rows($dwn1);


$query_lastadd = "	SELECT 
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
					ORDER BY 
						Fotos.Id_Foto DESC
					LIMIT 5";
$lastadd = mysql_query($query_lastadd, $pulsar) or die(mysql_error());

$query_totalpending = "SELECT COUNT(*) AS pending FROM Fotos_tmp";
$totalpending = mysql_query($query_totalpending, $pulsar) or die(mysql_error());
$row_totalpending = mysql_fetch_array($totalpending);
$num_pending = $row_totalpending['pending']; 

$query_pendings = "	SELECT 
						Fotos.Id_Foto, Fotos.id_autor, 
						Fotos.cidade, Fotos.id_estado, Fotos.id_pais, paises.nome as pais, Estados.Estado, Estados.Sigla, 
						Fotos.assunto_principal, Fotos.orientacao, Fotos.tombo, left(Fotos.tombo, 4) as lote, Fotos.data_foto,
						fotografos.Nome_Fotografo, count(*) as pending
					FROM 
						Fotos_tmp as Fotos
					INNER JOIN 
						fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
					LEFT OUTER JOIN 
						Estados ON (Fotos.id_estado=Estados.id_estado)
					LEFT OUTER JOIN 
						paises ON (paises.id_pais=Fotos.id_pais)
					GROUP BY 
						Fotos.id_autor
					ORDER BY 
						Fotos.Id_Foto DESC
					LIMIT 3";
$pendings = mysql_query($query_pendings, $pulsar) or die(mysql_error());


?>