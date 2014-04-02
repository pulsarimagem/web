<?php
// alter table log_count_view add unique (Id_foto);
	    
	    $query_vistas =	
" 
REPLACE INTO log_count_view 

SELECT
	Fotos.Id_Foto, tmp2.tombo, count(tmp2.tombo) as contador 
FROM 

(
SELECT
	tombo, ip 
FROM 
	log_pop 
WHERE 
	datahora > now() - INTERVAL 12 MONTH
GROUP BY 
	tombo,ip
) as tmp2

LEFT JOIN 
	Fotos on Fotos.tombo = tmp2.tombo
GROUP BY 
	tmp2.tombo 
ORDER BY
	contador desc;
"	  	;
