<?php

// IN�CIO DA PESQUISA:

$query_retorno = "
DROP TEMPORARY TABLE IF EXISTS tmp;

CREATE TEMPORARY TABLE tmp ENGINE = MEMORY
"
;

$query_retornob = "";

if ($MMColParam11_retorno != "") {
	$query_retornob .= sprintf("
SELECT
  Fotos.Id_Foto,
  Fotos.tombo,
  Fotos.orientacao,
  Fotos.assunto_principal,
  Fotos.cidade, 
  Fotos.id_estado, 
  Fotos.id_pais, 			
  Fotos.dim_a,
  Fotos.dim_b,
  Fotos.data_foto
FROM
pal_chave
INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
WHERE
pal_chave.Pal_Chave LIKE '%%%s%%';

INSERT INTO tmp

SELECT
  Fotos.Id_Foto,
  Fotos.tombo,
  Fotos.orientacao,
  Fotos.assunto_principal,
  Fotos.cidade, 
  Fotos.id_estado, 
  Fotos.id_pais, 
  Fotos.dim_a,
  Fotos.dim_b,
  Fotos.data_foto
FROM
Fotos
WHERE
   (Fotos.assunto_principal LIKE '%%%s%%')
;

INSERT INTO tmp

SELECT
  Fotos.Id_Foto,
  Fotos.tombo,
  Fotos.orientacao,
  Fotos.assunto_principal,
  Fotos.cidade, 
  Fotos.id_estado, 
  Fotos.id_pais, 
  Fotos.dim_a,
  Fotos.dim_b,
  Fotos.data_foto
FROM
Fotos
LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
WHERE
   (Fotos_extra.extra LIKE '%%%s%%')
;

INSERT INTO tmp

SELECT
  Fotos.Id_Foto,
  Fotos.tombo,
  Fotos.orientacao,
  Fotos.assunto_principal,
  Fotos.cidade, 
  Fotos.id_estado, 
  Fotos.id_pais, 
  Fotos.dim_a,
  Fotos.dim_b,
  Fotos.data_foto
FROM
 Fotos
 INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
 INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id)
WHERE
  (temas.Id = ANY(
     SELECT id_tema FROM lista_temas WHERE id_pai = (
        SELECT Id FROM temas WHERE Tema LIKE '%%%s%%' LIMIT 0,1
  )))

", $MMColParam11_retorno, $MMColParam11_retorno, $MMColParam11_retorno, $MMColParam11_retorno); 
}


//1� PAL CHAVE

if ($MMColParam12_retorno != "") {
	if ($query_retornob == "") {
	$query_retornob .= sprintf("
		SELECT 
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		pal_chave
		INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
		INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
		WHERE
		   ((pal_chave.Pal_Chave LIKE '%% %s %%') OR
		   (pal_chave.Pal_Chave LIKE '%s') OR
		   (pal_chave.Pal_Chave LIKE '%s %%') OR
		   (pal_chave.Pal_Chave LIKE '%% %s'));
		
		INSERT INTO tmp
		
		SELECT
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		Fotos
		WHERE
		   ((Fotos.assunto_principal LIKE '%% %s %%') OR
		   (Fotos.assunto_principal LIKE '%s') OR
		   (Fotos.assunto_principal LIKE '%s %%') OR
		   (Fotos.assunto_principal LIKE '%% %s'));
		
		INSERT INTO tmp
		
		SELECT
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		Fotos
		LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		WHERE
		   ((Fotos_extra.extra LIKE '%% %s %%') OR
		   (Fotos_extra.extra LIKE '%s') OR
		   (Fotos_extra.extra LIKE '%s %%') OR
		   (Fotos_extra.extra LIKE '%% %s'));
		
		   INSERT INTO tmp
		
		SELECT
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		 Fotos
		 INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
		 INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id)
		WHERE
		  (temas.Id = ANY(
			 SELECT id_tema FROM lista_temas WHERE id_pai = (
				SELECT Id FROM temas WHERE Tema LIKE '%s' LIMIT 0,1
		  )))

	", $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, 
   $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, 
   $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, 
   $MMColParam12_retorno);
	} else {
	$query_retornob .= sprintf("
	;
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
	  		Fotos.Id_Foto
		FROM
			pal_chave
		INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
		INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
		WHERE
		   ((pal_chave.Pal_Chave LIKE '%% %s %%') OR
		   (pal_chave.Pal_Chave LIKE '%s') OR
		   (pal_chave.Pal_Chave LIKE '%s %%') OR
		   (pal_chave.Pal_Chave LIKE '%% %s'))
		   
		 UNION 
		
			SELECT
			  Fotos.Id_Foto
			FROM
			  Fotos
			LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
			  WHERE
			   ((Fotos_extra.extra LIKE '%% %s %%') OR
			   (Fotos_extra.extra LIKE '%s') OR
			   (Fotos_extra.extra LIKE '%s %%') OR
			   (Fotos_extra.extra LIKE '%% %s'))
			   
		   UNION 
		
			SELECT
			  Fotos.Id_Foto
			FROM
			  Fotos
			WHERE
			   ((Fotos.assunto_principal LIKE '%% %s %%') OR
			   (Fotos.assunto_principal LIKE '%s') OR
			   (Fotos.assunto_principal LIKE '%s %%') OR
			   (Fotos.assunto_principal LIKE '%% %s'))
			   
		 UNION 
		
			SELECT
			  Fotos.Id_Foto
			FROM
			 Fotos
			 INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
			 INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id)
			WHERE
			  (temas.Id = ANY(
				 SELECT id_tema FROM lista_temas WHERE id_pai = (
					SELECT Id FROM temas WHERE Tema LIKE '%s' LIMIT 0,1
			  )))
		
		) 
", $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, 
   $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, 
   $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, $MMColParam12_retorno, 
   $MMColParam12_retorno);

}
};

// 2� PAL CHAVE
if ($MMColParam13_retorno != "") {
	if ($query_retornob == "") {
	$query_retornob .= sprintf("
		SELECT 
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		pal_chave
		INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
		INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
		WHERE
		   ((pal_chave.Pal_Chave LIKE '%% %s %%') OR
		   (pal_chave.Pal_Chave LIKE '%s') OR
		   (pal_chave.Pal_Chave LIKE '%s %%') OR
		   (pal_chave.Pal_Chave LIKE '%% %s'));
		
		INSERT INTO tmp
		
		SELECT
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		Fotos
		WHERE
		   ((Fotos.assunto_principal LIKE '%% %s %%') OR
		   (Fotos.assunto_principal LIKE '%s') OR
		   (Fotos.assunto_principal LIKE '%s %%') OR
		   (Fotos.assunto_principal LIKE '%% %s'));
		
		INSERT INTO tmp
		
		SELECT
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		Fotos
		LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		WHERE
		   ((Fotos_extra.extra LIKE '%% %s %%') OR
		   (Fotos_extra.extra LIKE '%s') OR
		   (Fotos_extra.extra LIKE '%s %%') OR
		   (Fotos_extra.extra LIKE '%% %s'));
		
		   INSERT INTO tmp
		
		SELECT
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		 Fotos
		 INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
		 INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id)
		WHERE
		  (temas.Id = ANY(
			 SELECT id_tema FROM lista_temas WHERE id_pai = (
				SELECT Id FROM temas WHERE Tema LIKE '%s' LIMIT 0,1
		  )))

	", $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, 
	   $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, 
	   $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, 
	   $MMColParam13_retorno);
	} else {
	$query_retornob .= sprintf("
	;
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
	  		Fotos.Id_Foto
		FROM
			pal_chave
		INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
		INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
		WHERE
		   ((pal_chave.Pal_Chave LIKE '%% %s %%') OR
		   (pal_chave.Pal_Chave LIKE '%s') OR
		   (pal_chave.Pal_Chave LIKE '%s %%') OR
		   (pal_chave.Pal_Chave LIKE '%% %s'))
		   
		 UNION 
		
			SELECT
			  Fotos.Id_Foto
			FROM
			  Fotos
			WHERE
			   ((Fotos.assunto_principal LIKE '%% %s %%') OR
			   (Fotos.assunto_principal LIKE '%s') OR
			   (Fotos.assunto_principal LIKE '%s %%') OR
			   (Fotos.assunto_principal LIKE '%% %s'))
			   
		 UNION 
		
			SELECT
			  Fotos.Id_Foto
			FROM
			  Fotos
			LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
			  WHERE
			   ((Fotos_extra.extra LIKE '%% %s %%') OR
			   (Fotos_extra.extra LIKE '%s') OR
			   (Fotos_extra.extra LIKE '%s %%') OR
			   (Fotos_extra.extra LIKE '%% %s'))
			   
			   UNION 
		
			SELECT
			  Fotos.Id_Foto
			FROM
			 Fotos
			 INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
			 INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id)
			WHERE
			  (temas.Id = ANY(
				 SELECT id_tema FROM lista_temas WHERE id_pai = (
					SELECT Id FROM temas WHERE Tema LIKE '%s' LIMIT 0,1
			  )))
		
		) 
", $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, 
   $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, 
   $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, $MMColParam13_retorno, 
   $MMColParam13_retorno);

}
};

// 3� PAL CHAVE
if ($MMColParam14_retorno != "") {
	if ($query_retornob == "") {
	$query_retornob .= sprintf("
		SELECT 
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		pal_chave
		INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
		INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
		WHERE
		   ((pal_chave.Pal_Chave LIKE '%% %s %%') OR
		   (pal_chave.Pal_Chave LIKE '%s') OR
		   (pal_chave.Pal_Chave LIKE '%s %%') OR
		   (pal_chave.Pal_Chave LIKE '%% %s'));
		
		INSERT INTO tmp
		
		SELECT
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		Fotos
		WHERE
		   ((Fotos.assunto_principal LIKE '%% %s %%') OR
		   (Fotos.assunto_principal LIKE '%s') OR
		   (Fotos.assunto_principal LIKE '%s %%') OR
		   (Fotos.assunto_principal LIKE '%% %s'));
		
		INSERT INTO tmp
		
		SELECT
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		Fotos
		LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
		WHERE
		   ((Fotos_extra.extra LIKE '%% %s %%') OR
		   (Fotos_extra.extra LIKE '%s') OR
		   (Fotos_extra.extra LIKE '%s %%') OR
		   (Fotos_extra.extra LIKE '%% %s'));
		
		   INSERT INTO tmp
		
		SELECT
		  Fotos.Id_Foto,
		  Fotos.tombo,
		  Fotos.orientacao,
		  Fotos.assunto_principal,
		  Fotos.cidade, 
		  Fotos.id_estado, 
		  Fotos.id_pais, 
		  Fotos.dim_a,
		  Fotos.dim_b,
		  Fotos.data_foto
		FROM
		 Fotos
		 INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
		 INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id)
		WHERE
		  (temas.Id = ANY(
			 SELECT id_tema FROM lista_temas WHERE id_pai = (
				SELECT Id FROM temas WHERE Tema LIKE '%s' LIMIT 0,1
		  )))

	", $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, 
	   $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, 
	   $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, 
	   $MMColParam14_retorno);
	} else {
	$query_retornob .= sprintf("
	;
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
	  		Fotos.Id_Foto
		FROM
			pal_chave
		INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
		INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
		WHERE
		   ((pal_chave.Pal_Chave LIKE '%% %s %%') OR
		   (pal_chave.Pal_Chave LIKE '%s') OR
		   (pal_chave.Pal_Chave LIKE '%s %%') OR
		   (pal_chave.Pal_Chave LIKE '%% %s'))
		   
		 UNION 
		
			SELECT
			  Fotos.Id_Foto
			FROM
			  Fotos
			WHERE
			   ((Fotos.assunto_principal LIKE '%% %s %%') OR
			   (Fotos.assunto_principal LIKE '%s') OR
			   (Fotos.assunto_principal LIKE '%s %%') OR
			   (Fotos.assunto_principal LIKE '%% %s'))
			   
		 UNION 
		
			SELECT
			  Fotos.Id_Foto
			FROM
			  Fotos
			LEFT JOIN Fotos_extra ON Fotos_extra.tombo = Fotos.tombo
			  WHERE
			   ((Fotos_extra.extra LIKE '%% %s %%') OR
			   (Fotos_extra.extra LIKE '%s') OR
			   (Fotos_extra.extra LIKE '%s %%') OR
			   (Fotos_extra.extra LIKE '%% %s'))
			   
			   UNION 
		
			SELECT
			  Fotos.Id_Foto
			FROM
			 Fotos
			 INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
			 INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id)
			WHERE
			  (temas.Id = ANY(
				 SELECT id_tema FROM lista_temas WHERE id_pai = (
					SELECT Id FROM temas WHERE Tema LIKE '%s' LIMIT 0,1
			  )))
		
		) 
", $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, 
   $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, 
   $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, $MMColParam14_retorno, 
   $MMColParam14_retorno);

}
};

// LOCAL (CIDADE)

if ($MMColParam22_retorno != "") {

	$frase = sprintf("
FROM
  Fotos
WHERE
((TRIM(Fotos.cidade) LIKE '%s')
OR
(Fotos.id_pais = (
SELECT paises.id_pais
FROM paises
WHERE
paises.nome like '%s'))
)

", $MMColParam22_retorno, $MMColParam22_retorno); 

	if ($query_retornob != "") {
		$query_retornob .= "
	;
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
  Fotos.Id_Foto
" . $frase . ")";
	} else {
		$query_retornob .= "
	SELECT 
  Fotos.Id_Foto,
  Fotos.tombo,
  Fotos.orientacao,
  Fotos.assunto_principal,
  Fotos.cidade, 
  Fotos.id_estado, 
  Fotos.id_pais, 
  Fotos.dim_a,
  Fotos.dim_b,
  Fotos.data_foto
" . $frase;
	}
}

// LOCAL (ESTADO)

if ($MMColParam22b_retorno != "") {

	$frase = sprintf("
FROM
  Fotos
WHERE
(Fotos.id_estado = 
(
SELECT Estados.id_estado
FROM Estados
WHERE
Estados.Sigla like '%s'
)
)
", $MMColParam22b_retorno); 

	if ($query_retornob != "") {
		$query_retornob .= "
	;
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
  Fotos.Id_Foto
	".$frase.")";
	} else {
		$query_retornob .= "
	SELECT 
	  Fotos.Id_Foto,
	  Fotos.tombo,
	  Fotos.orientacao,
	  Fotos.assunto_principal,
	  Fotos.cidade, 
	  Fotos.id_estado, 
	  Fotos.id_pais, 
	  Fotos.dim_a,
	  Fotos.dim_b,
	  Fotos.data_foto
		".$frase;
	}
}

// LOCAL (PA�S)

if ($MMColParam22c_retorno != "") {

	$frase = sprintf("
	FROM
	  Fotos
	WHERE
	  Fotos.id_pais like '%s' 
	", $MMColParam22c_retorno); 

	if ($query_retornob != "") {
		$query_retornob .= "
	;
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
  Fotos.Id_Foto
	".$frase.")";
	} else {
		$query_retornob .= "
	SELECT 
	  Fotos.Id_Foto,
	  Fotos.tombo,
	  Fotos.orientacao,
	  Fotos.assunto_principal,
	  Fotos.cidade, 
	  Fotos.id_estado, 
	  Fotos.id_pais, 
	  Fotos.dim_a,
	  Fotos.dim_b,
	  Fotos.data_foto
		".$frase;
	}
}

// DATA M�S

if ($MMColParam24a_retorno != "") {

	$frase = sprintf("
	FROM
	  Fotos
	WHERE
	  substring(Fotos.data_foto,5,2) like '%s' 
	", $MMColParam24a_retorno); 

	if ($query_retornob != "") {
		$query_retornob .= "
	;
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
  Fotos.Id_Foto
	".$frase.")";
	} else {
		$query_retornob .= "
	SELECT 
	  Fotos.Id_Foto,
	  Fotos.tombo,
	  Fotos.orientacao,
	  Fotos.assunto_principal,
	  Fotos.cidade, 
	  Fotos.id_estado, 
	  Fotos.id_pais, 
	  Fotos.dim_a,
	  Fotos.dim_b,
	  Fotos.data_foto
		".$frase;
	}
}

// DATA ANO

if ($MMColParam24b_retorno != "") {

	$frase = sprintf("
	FROM
	  Fotos
	WHERE
	  substring(Fotos.data_foto,1,4) like '%s' 
	", $MMColParam24b_retorno); 

	if ($query_retornob != "") {
		$query_retornob .= "
	;
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
  Fotos.Id_Foto
	".$frase.")";
	} else {
		$query_retornob .= "
	SELECT 
	  Fotos.Id_Foto,
	  Fotos.tombo,
	  Fotos.orientacao,
	  Fotos.assunto_principal,
	  Fotos.cidade, 
	  Fotos.id_estado, 
	  Fotos.id_pais, 
	  Fotos.dim_a,
	  Fotos.dim_b,
	  Fotos.data_foto
		".$frase;
	}
}

// DATA DIA

if ($MMColParam24c_retorno != "") {

	$frase = sprintf("
	FROM
	  Fotos
	WHERE
	  substring(Fotos.data_foto,7,2) like '%s' 
	", $MMColParam24c_retorno); 

	if ($query_retornob != "") {
		$query_retornob .= "
	;
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
  Fotos.Id_Foto
	".$frase.")";
	} else {
		$query_retornob .= "
	SELECT 
	  Fotos.Id_Foto,
	  Fotos.tombo,
	  Fotos.orientacao,
	  Fotos.assunto_principal,
	  Fotos.cidade, 
	  Fotos.id_estado, 
	  Fotos.id_pais, 
	  Fotos.dim_a,
	  Fotos.dim_b,
	  Fotos.data_foto
		".$frase;
	}
}

// DATA ANTES/DEPOIS

if ($MMColParam24d_retorno != "") {

	$frase = sprintf("
	FROM
	  Fotos
	WHERE
	  data_foto %s '%s' 
		", $MMColParam24dsinal_retorno, $MMColParam24d_retorno); 

	if ($query_retornob != "") {
		$query_retornob .= "
	;
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
  Fotos.Id_Foto
	".$frase.")";
	} else {
		$query_retornob .= "
	SELECT 
	  Fotos.Id_Foto,
	  Fotos.tombo,
	  Fotos.orientacao,
	  Fotos.assunto_principal,
	  Fotos.cidade, 
	  Fotos.id_estado, 
	  Fotos.id_pais, 
	  Fotos.dim_a,
	  Fotos.dim_b,
	  Fotos.data_foto
		".$frase;
	}
}


// AUTORES

if ($MMColParam23_retorno != "") {
	$frase = sprintf("
FROM
  Fotos
WHERE
  (Fotos.id_autor IN (%s))

", $MMColParam23_retorno); 

	if ($query_retornob != "") {
		$query_retornob .= "
	;
	DELETE FROM tmp
		WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
  Fotos.Id_Foto
	".$frase.")";
	} else {
		// Pegar nome do autor
		$query_nomeautor = sprintf("SELECT Nome_Fotografo FROM fotografos WHERE id_fotografo IN (%s);", $MMColParam23_retorno); 
		$nomeautor_retorno = mysql_query($query_nomeautor);
		$row_nomeautor_retorno = mysql_fetch_assoc($nomeautor_retorno);
		$query = $row_nomeautor_retorno['Nome_Fotografo'];
		
		$query_retornob .= "
	SELECT 
	  Fotos.Id_Foto,
	  Fotos.tombo,
	  Fotos.orientacao,
	  Fotos.assunto_principal,
	  Fotos.cidade, 
	  Fotos.id_estado, 
	  Fotos.id_pais, 
	  Fotos.dim_a,
	  Fotos.dim_b,
	  Fotos.data_foto
		".$frase;
	}
}

// ORIENTA��O

if ($MMColParam31_retorno == "" OR $MMColParam32_retorno == "") {
	if ($query_retornob != "") {
		$query_retornob .= "
	;
DELETE FROM
  tmp
WHERE	
(	";
	}
if ($MMColParam31_retorno == "") {
	$query_retornob .= sprintf("
  (tmp.orientacao = '%s')
  ", "H"); 
}

if ($MMColParam31_retorno == "" AND $MMColParam32_retorno == "") {
	$query_retornob .= " OR ";
}

if ($MMColParam32_retorno == "") {
	$query_retornob .= sprintf("
  (tmp.orientacao = '%s')
  ", "V"); 
}

	$query_retornob .= " ) ";
}
// N�O TENHA A PALAVRA

if ($MMColParam21_retorno != "") {
	if ($query_retornob != "") {
		$query_retornob .= "
	;
	";
	}
	$query_retornob .= sprintf("
DELETE FROM
  tmp
WHERE
  tmp.Id_Foto IN
(
SELECT 
  Fotos.Id_Foto
FROM
pal_chave
INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
WHERE
   ((pal_chave.Pal_Chave LIKE '%% %s %%') OR
   (pal_chave.Pal_Chave LIKE '%s') OR
   (pal_chave.Pal_Chave LIKE '%s %%') OR
   (pal_chave.Pal_Chave LIKE '%% %s'))
)
;
DELETE FROM
  tmp
WHERE
  tmp.Id_Foto IN
(
SELECT
  Fotos.Id_Foto
FROM
Fotos
WHERE
   (Fotos.assunto_principal LIKE '%%%s%%')
)
;
DELETE FROM
  tmp
WHERE
  tmp.Id_Foto IN
(
SELECT
  Fotos.Id_Foto
FROM
 Fotos
 INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
 INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id)
WHERE
  (temas.Id = ANY(
     SELECT id_tema FROM lista_temas WHERE id_pai = (
        SELECT Id FROM temas WHERE Tema LIKE '%% %s %%' LIMIT 0,1
  )))
)
  ", $MMColParam21_retorno, 
     $MMColParam21_retorno,
     $MMColParam21_retorno,
     $MMColParam21_retorno,
     $MMColParam21_retorno,
	 $MMColParam21_retorno);
}

$query_retorno2 = $query_retorno.$query_retornob;
?>
