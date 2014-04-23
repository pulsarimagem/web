<?php
/**
 * Dao para Imagens, Serao chamadas e consultas a banco para trazer todos as imagens do site
 * 
 * @author Fernando Machado Dib
 * create of date  02/04/2014
 * 
 * update
 * 
 * @author Fernando Machado Dib
 * @version 1.0
 * last update 02/04/2014
 * 
 * @todo
 *  
 */
class ImageOfDao 
{
	private $strWhere = '';
	private $arrResult = array();
	
	/**
	 * 
	 * Imagens randomicas de acordo com o limit passado como parametro e excluindo ultima imagem 
	 * na sessao
	 *  
	 * @param $arrConditions ('imageSession', 'limit')
	 * @return $strImage
	 */
	public function randonPhotoExcludingSessionLimit($arrConditions = array('imageSession'=>null,'limit'=>1))
	{
		if($arrConditions['imageSession'])
			$this->strWhere = 'WHERE fotos_homepage.tombo != "'.$arrConditions['imageSession'].'"';
		$this->arrResult = Yii::app()->db->createCommand('SELECT tombo FROM  fotos_homepage '.$this->strWhere.' ORDER BY RAND() LIMIT 1')->queryAll();
		return $this->arrResult;
	}
	
	/**
	 * 
	 * Recupera as ultimas 20 imagens 
	 * 
	 * @return arrResult
	 */
	public function addedLastCarousel()
	{
		$this->arrResult = Yii::app()->db->createCommand('
			SELECT * from (
				SELECT * from (
					SELECT 
						Fotos.Id_Foto, 
						Fotos.id_autor, 
						Fotos.cidade, 
						Fotos.id_estado, 
						Fotos.id_pais, 
						paises.nome as pais, 
						Estados.Estado, Estados.Sigla, 
						Fotos.assunto_principal, 
						Fotos.orientacao, 
						Fotos.tombo, left(Fotos.tombo, 4) as lote, Fotos.data_foto,
						fotografos.Nome_Fotografo
					FROM 
						Fotos
					INNER JOIN 
						fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
					LEFT OUTER JOIN 
						Estados ON (Fotos.id_estado=Estados.id_estado)
					LEFT OUTER JOIN 
						paises ON (paises.id_pais=Fotos.id_pais)
					WHERE
						Fotos.orientacao = "H"
					ORDER BY 
						Fotos.Id_Foto DESC
					LIMIT 2000
				) as Fotos
				ORDER BY
					RAND()
				) as Fotos_rand
			GROUP BY
				Fotos_rand.id_autor
			ORDER BY
				RAND()
			LIMIT 20
		')->queryAll();
		return $this->arrResult;
	}
	
	/**
	 * 
	 * Recupera as ultimas 20 imagens pesquisadas 
	 * 
	 * @return arrResult
	 */
	public function latestCarouselSearch()
	{
		$this->createTmp2();
		$this->arrResult = Yii::app()->db->createCommand('
			SELECT 
				Fotos.Id_Foto, 
				Fotos.id_autor, 
				Fotos.cidade, 
				Fotos.id_estado, 
				Fotos.id_pais, 
				paises.nome as pais, 
				Estados.Estado, 
				Estados.Sigla, 
				Fotos.assunto_principal, 
				Fotos.orientacao, 
				Fotos.tombo, 
				Fotos.data_foto, 
				fotografos.Nome_Fotografo 
			FROM 
				Fotos, tmp2, fotografos, Estados, paises
			WHERE
				Fotos.tombo = tmp2.tombo 
			AND 
				Fotos.orientacao = "H"   
			AND 
				Fotos.tombo NOT RLIKE "^[a-zA-Z]"
			AND
				Fotos.id_autor=fotografos.id_fotografo 
			AND 
				Fotos.id_estado=Estados.id_estado 
			AND 
				paises.id_pais=Fotos.id_pais 
			LIMIT 20
		')->queryAll();
		
		return $this->arrResult;
	}
	
	/**
	 * 
	 * Montagem dinamica do do menu por tema
	 */
	public function searchByThemes($intIdDad = 0, $booEmptyTheme = false)
	{	
		if(Yii::app()->user->getState('strFormType')=='ext')
			$strLanguage = '_en';
		else 
			$strLanguage = '';
				
		if($booEmptyTheme == true)
		{
			switch ($intIdDad)
			{
				case '8':
					$strSelect = '';
					$strWhere = 'AND tmf.Id = "87"';
					break;
				default:
					$strSelect = '';
					$strWhere = '';
					break;	
			}
		}
		else 
		{
			$strSelect = '
				tmf.Id,
				tmf.Tema'.$strLanguage.' as Tema, 
				tmf.Pai,
			';
			$strWhere = '';
		}
		
		$arrResult = Yii::app()->db->createCommand('
			SELECT 
				'.$strSelect.'
				(
					SELECT 
						f.tombo
					FROM 
						rel_fotos_temas AS rft 
					INNER JOIN
						Fotos AS f ON f.Id_Foto = rft.id_foto
					WHERE 
						rft.id_tema = tmf.id AND f.orientacao = "H"  
					AND 
						f.tombo NOT RLIKE "^[a-zA-Z]"
					ORDER BY 
						RAND( ) 
					LIMIT 1
				) AS tombo
			FROM 
				tmp_menu_fotos AS tmf
			WHERE 
				tmf.Pai = "'.$intIdDad.'" '.$strWhere.'
			ORDER BY 
				tmf.Pai,
				tmf.Tema ASC
			
		')->queryAll();
		if(count($arrResult)<1)
		{
			return array('0'=>array('Id'=>false,'tombo'=>false,'Tema'=>false));
		}
		return $arrResult;
	}
	
	/**
	 * Montagem e atualizacao de breadcrumb
	 * 
	 * @return array
	 */
	public function searchBreadcrumbThemesById($intIdDad)
	{
		if(Yii::app()->user->getState('strFormType')=='ext')
			$strLanguage = '_en';
		else 
			$strLanguage = '';
		
		$arrResult = Yii::app()->db->createCommand('SELECT id,tema'.$strLanguage.' AS tema from tmp_menu_fotos WHERE id = "'.$intIdDad.'"')->queryAll();
		
		$objSessionComponents = new SessionComponents();
		
		if(count($arrResult) < 1)
		{
			$objSessionComponents->setBreadcrumb($arrResult);
		}
		else
		{
			$objSessionComponents->setBreadcrumb($arrResult);
		}
	}
	
	
	/**
	 * 
	 * Montagem da tabela tmp2
	 * 
	 */
	private function createTmp2()
	{
		$this->dropTmp2();
		Yii::app()->db->createCommand('
			CREATE TEMPORARY TABLE
				tmp2
			ENGINE = MEMORY
			SELECT
				distinct(tombo)
			FROM
				log_pop
			ORDER BY
				id_pop desc 
			LIMIT 30000
		')->execute();
	}
	
	/**
	 * 
	 * Apaga tabela tmp2
	 */
	private function dropTmp2()
	{
		Yii::app()->db->createCommand('DROP TEMPORARY TABLE IF EXISTS tmp2')->execute();
	}
}