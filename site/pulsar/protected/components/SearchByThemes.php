<?php
class SearchByThemes
{
	public function searchThemesById($idDad = 0)
	{
		$objImageOfDao = new ImageOfDao();
		//array com o conteúdo da busca por temas
		$arrResult = $objImageOfDao->searchByThemes($idDad);
		for($intCount = 0; $intCount < count($arrResult); $intCount++)
		{ 
			if($arrResult[$intCount]['tombo'] == '' && $arrResult[$intCount]['Id'] == 8)
			{
				$strImage = $objImageOfDao->searchByThemes(8,true);
				$arrResult[$intCount]['tombo'] = $strImage[0]['tombo'];
			}
		}
		return $arrResult;
	}
}