<?php
if (($MMColParam_retorno == "")) {
$query_retorno = sprintf("DROP TEMPORARY TABLE IF EXISTS tmp;
							CREATE TEMPORARY TABLE tmp ENGINE = MEMORY
							SELECT Fotos.Id_Foto, Fotos.assunto_principal, Fotos.cidade, Fotos.id_estado, Estados.Sigla, Fotos.id_pais, paises.nome, Fotos.orientacao,  Fotos.tombo,  Fotos.data_foto, Fotos.dim_a, Fotos.dim_b, 9999 as total_prioridade, 9999 as prioridade  FROM  Fotos 
							LEFT JOIN Fotos_extra ON Fotos.tombo = Fotos_extra.tombo
							LEFT JOIN paises ON paises.id_pais = Fotos.id_pais  
							LEFT JOIN Estados ON Estados.id_estado = Fotos.id_estado  
							WHERE   (Fotos.tombo like '%s')", $MMColParam2_retorno);
//, Fotos_extra.extra
$query_retorno2 = $query_retorno;
//$novaQuery_retorno = $query_retorno; 
} else {
$query_retorno = sprintf("
DROP TEMPORARY TABLE IF EXISTS tmp;

CREATE TEMPORARY TABLE tmp ENGINE = MEMORY

SELECT
    Fotos.Id_Foto,
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
    Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
	999 as prioridade
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
    Fotos.assunto_principal,
    Fotos.orientacao,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 	
    Fotos.tombo,
    Fotos.data_foto,
	999 as prioridade
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
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
    Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
	999 as prioridade
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
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
    Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
	999 as prioridade
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
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
	999 as prioridade
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
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
	999 as prioridade
FROM
Estados
INNER JOIN Fotos ON (Estados.id_estado=Fotos.id_estado)
WHERE
(Estados.Estado LIKE '%s')  OR  (Estados.Sigla LIKE '%s');

INSERT INTO tmp

SELECT
    Fotos.Id_Foto,
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
	999 as prioridade
FROM
Fotos
WHERE
(TRIM(Fotos.cidade) LIKE '%s' OR TRIM(Fotos.cidade) LIKE '%s');

INSERT INTO tmp

SELECT
  Fotos.Id_Foto,
  Fotos.assunto_principal,
  Fotos.cidade, 
  Fotos.id_estado, 
  Fotos.id_pais, 
  Fotos.orientacao,
  Fotos.tombo,
  Fotos.data_foto,
  999 as prioridade
FROM
 Fotos
 INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
 INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id)
WHERE
  (temas.Id = ANY(
     SELECT id_tema FROM lista_temas WHERE id_pai = (
        SELECT Id FROM temas WHERE Tema LIKE '%s' LIMIT 0,1
  )));

".$MMColParam_uniao,
 $MMColParam_retorno,$MMColParam_retorno,$MMColParam_retorno,$MMColParam_retorno,
 $MMColParam_retorno2,$MMColParam_retorno2,$MMColParam_retorno2,$MMColParam_retorno2,
 $MMColParam_retorno3,$MMColParam_retorno3,$MMColParam_retorno3,$MMColParam_retorno3,
 $MMColParam_retorno,$MMColParam_retorno,$MMColParam_retorno,$MMColParam_retorno,
 $MMColParam_retorno2,$MMColParam_retorno2,$MMColParam_retorno2,$MMColParam_retorno2,
 $MMColParam_retorno, $MMColParam_retorno,
 $MMColParam_retorno,$MMColParam_retorno2,
 $MMColParam_retorno);
 
 
$query_final = "SELECT 
       Id_Foto,
       assunto_principal,
	   cidade, 
	   id_estado, 
	   id_pais, 
       orientacao,
       tombo,
       data_foto,
       sum(prioridade) as total_prioridade
FROM tmp
GROUP BY Id_Foto
HAVING total_prioridade >= ".($n_contador*10)."
ORDER BY Id_Foto DESC, total_prioridade DESC ";

$novaQuery_retorno = sprintf("
DROP TEMPORARY TABLE IF EXISTS tmp;

CREATE TEMPORARY TABLE tmp ENGINE = MEMORY

SELECT
    Fotos.Id_Foto,
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
    Fotos.dim_a,
    Fotos.dim_b,
    999 as prioridade
FROM
pal_chave
INNER JOIN rel_fotos_pal_ch ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
WHERE
   ((pal_chave.Pal_Chave LIKE '%% %s %%') OR
   (pal_chave.Pal_Chave LIKE '%s') OR
   (pal_chave.Pal_Chave LIKE '%s %%') OR
   (pal_chave.Pal_Chave LIKE '%% %s'));

   
".$MMColParam_uniao."
   
   
INSERT INTO tmp

SELECT
    Fotos.Id_Foto,
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
    Fotos.dim_a,
    Fotos.dim_b,
    999 as prioridade
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
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
    Fotos.dim_a,
    Fotos.dim_b,
    999 as prioridade
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
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
    Fotos.dim_a,
    Fotos.dim_b,
    999 as prioridade
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
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
    Fotos.dim_a,
    Fotos.dim_b,
    999 as prioridade
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
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
    Fotos.dim_a,
    Fotos.dim_b,
    999 as prioridade
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
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
    Fotos.dim_a,
    Fotos.dim_b,
    999 as prioridade
FROM
paises
INNER JOIN Fotos ON (paises.id_pais=Fotos.id_pais)
WHERE
(paises.nome LIKE '%s')  OR  (paises.id_pais LIKE '%s');

INSERT INTO tmp

SELECT
    Fotos.Id_Foto,
    Fotos.assunto_principal,
    Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
    Fotos.dim_a,
    Fotos.dim_b,
    999 as prioridade
FROM
Estados
INNER JOIN Fotos ON (Estados.id_estado=Fotos.id_estado)
WHERE
(Estados.Estado LIKE '%s')  OR  (Estados.Sigla LIKE '%s');

INSERT INTO tmp

SELECT
    Fotos.Id_Foto,
    Fotos.assunto_principal,
	Fotos.cidade, 
	Fotos.id_estado, 
	Fotos.id_pais, 
	Fotos.orientacao,
    Fotos.tombo,
    Fotos.data_foto,
    Fotos.dim_a,
    Fotos.dim_b,
    999 as prioridade
FROM
Fotos
WHERE
(TRIM(Fotos.cidade) LIKE '%s' OR TRIM(Fotos.cidade) LIKE '%s');

INSERT INTO tmp

SELECT
  Fotos.Id_Foto,
  Fotos.assunto_principal,
  Fotos.cidade, 
  Fotos.id_estado, 
  Fotos.id_pais, 
  Fotos.orientacao,
  Fotos.tombo,
  Fotos.data_foto,
  Fotos.dim_a,
  Fotos.dim_b,
  999 as prioridade
FROM
 Fotos
 INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
 INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id)
WHERE (%s);

",
 $MMColParam_retorno,$MMColParam_retorno,$MMColParam_retorno,$MMColParam_retorno,
 $MMColParam_retorno2,$MMColParam_retorno2,$MMColParam_retorno2,$MMColParam_retorno2,
 $MMColParam_retorno3,$MMColParam_retorno3,$MMColParam_retorno3,$MMColParam_retorno3,
 $MMColParam_retorno,$MMColParam_retorno,$MMColParam_retorno,$MMColParam_retorno,
 $MMColParam_retorno2,$MMColParam_retorno2,$MMColParam_retorno2,$MMColParam_retorno2,
 $MMColParam_retorno2,$MMColParam_retorno2,$MMColParam_retorno2,$MMColParam_retorno2,
 $MMColParam_retorno, $MMColParam_retorno,
 $MMColParam_retorno, $MMColParam_retorno,
 $MMColParam_retorno,$MMColParam_retorno2,$novaTemas_query);

 //	echo "<br><br>".$novaQuery_retorno."<br><br>";
 

// DATA M�S

if ($MMColParam24a_retorno != "") {

	$frase = sprintf("
	FROM
	  Fotos
	WHERE
	  substring(Fotos.data_foto,5,2) like '%s' 
	", $MMColParam24a_retorno); 

	$query_retorno_mes  = "
	DELETE FROM tmp
	WHERE tmp.Id_Foto
	NOT IN (
		SELECT 
  Fotos.Id_Foto
	".$frase.");";

	$novaQuery_retorno .=   $query_retorno_mes; 
}

// DATA ANO

	if ($MMColParam24b_retorno != "") {
	
		$frase = sprintf("
		FROM
		  Fotos
		WHERE
		  substring(Fotos.data_foto,1,4) like '%s' 
		", $MMColParam24b_retorno); 
	
		$query_retorno_ano  = "
		DELETE FROM tmp
		WHERE tmp.Id_Foto
		NOT IN (
			SELECT 
	  Fotos.Id_Foto
		".$frase.");";
	
		$novaQuery_retorno .=   $query_retorno_ano;	 
	}
	

// DATA DIA

	if ($MMColParam24c_retorno != "") {
	
		$frase = sprintf("
		FROM
		  Fotos
		WHERE
		  substring(Fotos.data_foto,7,2) like '%s' 
		", $MMColParam24c_retorno); 
	
		$query_retorno_dia  = "
		DELETE FROM tmp
		WHERE tmp.Id_Foto
		NOT IN (
			SELECT 
	  Fotos.Id_Foto
		".$frase.");";

		$novaQuery_retorno .=   $query_retorno_dia;	 
	}
		
// DATA ANTES/DEPOIS

	if ($MMColParam24d_retorno != "") {
	
		$frase = sprintf("
		FROM
		  Fotos
		WHERE
		  data_foto %s '%s' 
		", $MMColParam24dsinal_retorno, $MMColParam24d_retorno); 
	
		$query_retorno_data  = "
		DELETE FROM tmp
		WHERE tmp.Id_Foto
		NOT IN (
			SELECT 
	  Fotos.Id_Foto
		".$frase.");";

		$novaQuery_retorno .=   $query_retorno_data;	 
	}
		

 // LOCAL
 
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
	
			$query_retorno_local = "
		DELETE FROM tmp
		WHERE tmp.Id_Foto
		NOT IN (
			SELECT 
	  Fotos.Id_Foto
	" . $frase . ");";

		$novaQuery_retorno .=   $query_retorno_local;	 
	 }	 
 
// AUTOR

	 if ($MMColParam23_retorno != "") {
		$frase = sprintf("
	FROM
	  Fotos
	WHERE
	  (Fotos.id_autor IN (%s))
	
	", $MMColParam23_retorno); 
	
		$query_retorno_autor = "
		DELETE FROM tmp
			WHERE tmp.Id_Foto
		NOT IN (
			SELECT 
	  Fotos.Id_Foto
		".$frase.");";

		$novaQuery_retorno .=   $query_retorno_autor;
	 }
	
	
$novaQuery_final = "SELECT distinct 
       Id_Foto,
       assunto_principal,
	   cidade, 
	   id_estado, 
	   id_pais, 
       orientacao,
       tombo,
       data_foto,
       dim_a,
       dim_b,
       sum(prioridade) as total_prioridade
FROM tmp
GROUP BY Id_Foto
ORDER BY Id_Foto DESC ";

}

$query_retorno2 = $query_retorno;
?>
