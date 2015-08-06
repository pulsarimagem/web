<?php
class fotografosOfDao 
{
	public function fotografoFotoDropDown()
	{
		return Yii::app()->db->createCommand('
			SELECT 
				distinct
				f.Iniciais_Fotografo AS value,
				f.Iniciais_Fotografo AS sigla
			FROM 
				fotografos AS f 
			INNER JOIN 
				Fotos AS ft ON ft.id_autor = f.id_fotografo
			WHERE	
				boo_ativo = 1
			ORDER BY
				Nome_Fotografo
		')->queryAll();
	}
}