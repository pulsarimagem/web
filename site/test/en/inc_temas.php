<?php
$query_retorno = sprintf("
SELECT DISTINCT 

Fotos.Id_Foto,   Fotos.tombo, Fotos.assunto_principal, Fotos.cidade, Fotos.id_estado, Fotos.id_pais, Fotos.orientacao, Fotos.data_foto, Fotos.dim_a, Fotos.dim_b,

FROM 

Fotos  

INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)  

INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id) 

WHERE (temas.Id = ANY (  SELECT  id_tema  FROM    lista_temas WHERE id_pai = %s  ) ) ORDER BY Fotos.Id_Foto DESC", $MMColParam_retorno);
//$query_retorno = sprintf("SELECT DISTINCT Fotos.Id_Foto,   Fotos.tombo, Fotos.assunto_principal, Fotos.orientacao,  temas.Tema,   temas.Id FROM Fotos  INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)  INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id) WHERE (temas.Id = ANY (  SELECT  id_tema  FROM    lista_temas  WHERE id_pai = %s  ) ) ORDER BY Fotos.tombo", $MMColParam_retorno);
$query_retorno2 = $query_retorno;

$novaQuery_retorno = sprintf("
SELECT DISTINCT 

Fotos.Id_Foto,   Fotos.tombo, Fotos.assunto_principal, Fotos.cidade, Estados.Sigla, paises.nome, Fotos.orientacao, Fotos.data_foto, Fotos.dim_a, Fotos.dim_b, Fotos.id_estado, Fotos.id_pais

FROM 

Fotos  

LEFT JOIN Fotos_extra ON Fotos.tombo = Fotos_extra.tombo
		
LEFT JOIN Estados ON Fotos.id_estado = Estados.id_estado 
LEFT JOIN paises ON Fotos.id_pais = paises.id_pais
		
INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)  

INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id) 

WHERE ( %s  ) ORDER BY Fotos.Id_Foto DESC", $novaTemas_query);
$novaQuery_retorno2 = $novaQuery_retorno;
?>
