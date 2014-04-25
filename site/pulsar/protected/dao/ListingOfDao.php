<?php
/**
 * Dao para o buscador
 * 
 * @author Fernando Machado Dib
 * create of date  17/04/2014
 * 
 * update
 * 
 * @author Fernando Machado Dib
 * @version 1.0
 * last update 17/04/2014
 * 
 * @todo
 *  
 */
class ListingOfDao 
{
	private $strWhere = '';
	public $arrResult = array();
	public $arrPesq0 = array();
	public $arrPesq1 = array();
	public $arrPesq2 = array();
	public $arrWordRegular = array();
	public $arrWord = array();
	public $arrQuantidade = array();
	
	/**
	 * 
	 * O metodo realiza a busca para salvar os ids dos temas no arrResult
	 * 
	 * @param unknown_type $arrWordRergular
	 * @param unknown_type $arrWord
	 * 
	 */
	public function searchWordByThemes($arrWordRergular,$arrWord)
	{
		$this->arrWordRegular = $arrWordRergular;
		$this->arrWord = $arrWord;
		foreach ($arrWordRergular as $intKey => $strValue)
		{
			$strVar = utf8_encode(strtolower($arrWordRergular[$intKey]));	
			$this->arrResult[$intKey] = Yii::app()->db->createCommand("
				SELECT 
					id_tema 
				FROM 
					lista_temas 
				WHERE 
					id_pai IN 
					( 
						SELECT 
							Id 
						FROM 
							temas 
						WHERE 
							(Tema RLIKE '[[:<:]]".$strVar."s?[[:>:]]')
							OR Tema like ('%".$arrWord[$intKey]."%')
					)
					
			")->queryAll();
		}
	}
	
	/**
	 * 
	 * Montagem das consultas para o resultado final, aqui faremos as buscas pelo $this->arrResult e buscaremos o
	 * resultado final ou retornaremos false para a exibição da mensagem para que o cliente vá por busca avanzada
	 * 
	 * @return arrResultFinal ou False em caso de não retornar nada
	 */
	public function searchByWordAndThemes()
	{
		//insere com as palavras procuradas na tabela temporaria
		$intCont = 0;
		foreach ($this->arrResult as $intKey => $strValue)
		{
			$this->arrQuantidade['pesq'.$intCont] = $this->createTemporaryTablesAndInsertAll($intCont, $intKey , count($this->arrResult[$intKey]));	
			$intCont++;
		}
		//faz a busca nas tamporárias array do menor para o maior
		$this->searchTempTables($this->arrQuantidade);
	}
	
	private function createTemporaryTablesAndInsertAll ($intTableTemp, $intKeyArray, $insertByThemes = 0)
	{
		
		Yii::app()->db->createCommand('DROP TEMPORARY TABLE IF EXISTS pesq'.$intTableTemp.'')->execute();
		Yii::app()->db->createCommand('CREATE TEMPORARY TABLE pesq'.$intTableTemp.' (Id_Foto int(11) PRIMARY KEY NOT NULL DEFAULT 0) ENGINE = MEMORY')->execute();
		
		Yii::app()->db->createCommand('INSERT IGNORE INTO pesq'.$intTableTemp.' SELECT Fotos.Id_Foto FROM Fotos WHERE Fotos.tombo RLIKE "'.$this->arrWord[$intKeyArray].'"')->execute();
		Yii::app()->db->createCommand('INSERT IGNORE INTO pesq'.$intTableTemp.' SELECT Fotos.Id_Foto FROM rel_fotos_pal_ch STRAIGHT_JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto) LEFT JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE (pal_chave.Pal_Chave RLIKE "[[:<:]]'.utf8_encode(strtolower($this->arrWordRegular[$intKeyArray])).'") AND Fotos.Id_Foto != 0;')->execute();
		Yii::app()->db->createCommand('INSERT IGNORE INTO pesq'.$intTableTemp.' SELECT Fotos.Id_Foto FROM (SELECT Id_Foto,assunto_principal FROM Fotos WHERE convert(assunto_principal USING utf8) LIKE "%'.substr($this->arrWord[$intKeyArray],0, strlen($this->arrWord[$intKeyArray])-1).'%") as Fotos WHERE (Fotos.assunto_principal RLIKE "[[:<:]]'.utf8_encode(strtolower($this->arrWordRegular[$intKeyArray])).'")')->execute();
		Yii::app()->db->createCommand('INSERT IGNORE INTO pesq'.$intTableTemp.' SELECT Fotos.Id_Foto FROM Fotos WHERE (Fotos.extra RLIKE "[[:<:]]'.utf8_encode(strtolower($this->arrWordRegular[$intKeyArray])).'")')->execute();
		Yii::app()->db->createCommand('INSERT IGNORE INTO pesq'.$intTableTemp.' SELECT Fotos.Id_Foto FROM Fotos WHERE (Fotos.cidade RLIKE "'.utf8_encode(strtolower($this->arrWordRegular[$intKeyArray])).'")')->execute();
		Yii::app()->db->createCommand('INSERT IGNORE INTO pesq'.$intTableTemp.' SELECT Fotos.Id_Foto FROM Fotos RIGHT JOIN ( SELECT * FROM Estados WHERE ((Estados.Estado RLIKE "'.utf8_encode(strtolower($this->arrWordRegular[$intKeyArray])).'") OR (Estados.Sigla RLIKE "'.utf8_encode(strtolower($this->arrWordRegular[$intKeyArray])).'")) ) as Estados ON (Estados.id_estado=Fotos.id_estado);')->execute();
		Yii::app()->db->createCommand('INSERT IGNORE INTO pesq'.$intTableTemp.' SELECT Fotos.Id_Foto FROM Fotos RIGHT JOIN ( SELECT * from paises WHERE ((paises.nome RLIKE "'.utf8_encode(strtolower($this->arrWordRegular[$intKeyArray])).'") OR (paises.id_pais RLIKE "'.utf8_encode(strtolower($this->arrWordRegular[$intKeyArray])).'")) ) as paises ON (paises.id_pais=Fotos.id_pais);')->execute();
		//se o array de themas tiver algo faça o insert por temas
		if($insertByThemes >=1)
		{
			$intCount = 1;
			$strWhereIn = '';
			foreach ($this->arrResult[$intKeyArray] as $strValue)
			{
				if($intCount < $insertByThemes)
					$strWhereIn .= $strValue['id_tema'].',';
				else
					$strWhereIn .= $strValue['id_tema'];
				$intCount++;
			}
			Yii::app()->db->createCommand('INSERT IGNORE INTO pesq'.$intTableTemp.' SELECT Fotos.Id_Foto FROM Fotos INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) INNER JOIN temas ON (temas.Id=rel_fotos_temas.id_tema) WHERE temas.Id in ('.$strWhereIn.')')->execute();
		}
		$quantidade =  Yii::app()->db->createCommand('SELECT count(id_foto) as qtd FROM pesq'.$intTableTemp)->queryAll();

		return $quantidade[0]['qtd'];
	}
	
	public function searchTempTables($arrTableOrderSearch)
	{
		//organiza o array
		asort($arrTableOrderSearch);
		//Cria a tabla de pesquisa final
		Yii::app()->db->createCommand('DROP TEMPORARY TABLE IF EXISTS pesqFinal')->execute();
		Yii::app()->db->createCommand('CREATE TEMPORARY TABLE pesqFinal (Id_Foto int(11) PRIMARY KEY NOT NULL DEFAULT 0) ENGINE = MEMORY')->execute();
		
		$intCount = 0;
		foreach ($arrTableOrderSearch as $intKey => $intValue)
		{
			if($intCount == 0)
			{
				$arrSearchTables[0] = $intKey;
				$intQuery = 0; 
			}
			elseif($intCount == 1) 
			{
				$arrSearchTables[1] = $intKey;
				$intQuery = 1;
			}
			else
			{
				$arrSearchTables[2] = $intKey;
				$intQuery = 2;
			}
			$intCount++;
		}
		$this->insertFinalTable($intQuery, $arrSearchTables);
	}
	
	public function insertFinalTable($intQuery = null, $arrSearchTables = array())
	{
	 		switch ($intQuery)
	 		{
	 			case '0':
	 				Yii::app()->db->createCommand('
						INSERT IGNORE INTO 
							pesqFinal 
							SELECT 
								'.$arrSearchTables[0].'.Id_Foto 
							FROM 
								'.$arrSearchTables[0].' 	
					')->execute();
	 				break;
	 			case '1':
					Yii::app()->db->createCommand('
						INSERT IGNORE INTO 
							pesqFinal 
							SELECT 
								'.$arrSearchTables[0].'.Id_Foto 
							FROM 
								'.$arrSearchTables[0].' 
							INNER JOIN 
								'.$arrSearchTables[1].' ON '.$arrSearchTables[0].'.Id_Foto = '.$arrSearchTables[1].'.Id_Foto 	
					')->execute();
	 				break;
	 			case '3':
					Yii::app()->db->createCommand('
						INSERT IGNORE INTO 
							pesqFinal 
							SELECT 
								'.$arrSearchTables[0].'.Id_Foto 
							FROM 
								'.$arrSearchTables[0].' 
							INNER JOIN 
								'.$arrSearchTables[1].' ON '.$arrSearchTables[0].'.Id_Foto = '.$arrSearchTables[1].'.Id_Foto
							INNER JOIN 
								'.$arrSearchTables[2].' ON '.$arrSearchTables[1].'.Id_Foto = '.$arrSearchTables[2].'.Id_Foto  AND '.$arrSearchTables[0].'.Id_Foto = '.$arrSearchTables[2].'.Id_Foto 	
					')->execute();
	 				break;
	 		}
	 		
	 		$this->arrResult = Yii::app()->db->createCommand('
			SELECT DISTINCT 
				tmp.Id_Foto, 
				Fotos.assunto_principal,
				Fotos.assunto_principal_en, 
				pal_chave.Pal_Chave,
				Fotos_extra.extra, 
				Fotos.cidade, 
				Estados.Sigla, 
				paises.nome as nome, 
				Fotos.orientacao, 
				Fotos.tombo, 
				Fotos.data_foto, 
				Fotos.dim_a, 
				Fotos.dim_b, 
				videos_extra.resolucao
			FROM 
				pesqFinal as tmp 	
			LEFT JOIN 
				Fotos ON tmp.Id_Foto = Fotos.Id_Foto 	
			LEFT JOIN 
				Fotos_extra ON Fotos.tombo = Fotos_extra.tombo 
			LEFT JOIN 
				videos_extra ON Fotos.tombo = videos_extra.tombo 
			LEFT JOIN 
				Estados ON Fotos.id_estado = Estados.id_estado 
			LEFT JOIN 
				paises ON Fotos.id_pais = paises.id_pais 
			LEFT JOIN 
				log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto 
			LEFT JOIN 	
				rel_fotos_pal_ch ON rel_fotos_pal_ch.id_foto = tmp.Id_Foto
			LEFT JOIN
				pal_chave ON pal_chave.Id = rel_fotos_pal_ch.id_palavra_chave 	
			WHERE 
			(
				Fotos.tombo RLIKE "^[A-Z]" 
			AND 
				videos_extra.resolucao = "1920x1080"
			) 
			OR 
			(
					Fotos.tombo RLIKE "^[A-Z]" 
				AND 
					videos_extra.resolucao = "1280x720"
			) 
			OR 
			(
					Fotos.tombo RLIKE "^[A-Z]" 
				AND 
				(
					videos_extra.resolucao = "768x576" 
				OR 
					videos_extra.resolucao = "720x480"
				)
			) 
			OR 
			(
					Fotos.tombo RLIKE "^[0-9]" 
				AND 
					Fotos.dim_a > Fotos.dim_b
			) 
			OR 
			(
					Fotos.tombo RLIKE "^[0-9]" 
				AND 
					Fotos.dim_a < Fotos.dim_b
			) 
			GROUP BY 
				tmp.Id_Foto 
			ORDER BY 
				Fotos.data_foto DESC, Fotos.id_autor ASC, Fotos.tombo 
			DESC 
		')->queryAll();
	}
}