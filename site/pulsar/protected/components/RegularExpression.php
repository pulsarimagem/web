<?php
class RegularExpression
{
	private $arrMapChar = array(
		'ñ' => 'n','Ñ' => 'N',
		'á' => 'a','Á' => 'A','â' => 'a','Â' => 'A','à' => 'a','À' => 'A','ã' => 'a','Ã' => 'A','ä' => 'a','Ä' => 'A',
		'é' => 'e','É' => 'E','ê' => 'e','Ê' => 'E','è' => 'e','È' => 'E','ë' => 'e','Ë' => 'E',
		'í' => 'i','Í' => 'I','î' => 'i','Î' => 'I','ì' => 'i','Ì' => 'I','ï' => 'i','Ï' => 'I',
		'ó' => 'o','Ó' => 'O','ô' => 'o','Ô' => 'O','ò' => 'o','Ò' => 'O','õ' => 'o','Õ' => 'O','ö' => 'o','Ö' => 'O',
		'ú' => 'u','Ú' => 'U','û' => 'u','Û' => 'U','ù' => 'u','Ù' => 'U','ü' => 'u','Ü' => 'U',
		'ç' => 'c','Ç' => 'C',	
		'ñ' => 'n','Ñ' => 'N'
	);
	private $arrMapCharBDSearch = array();
	/**
	 * @param Receber string do buscador 
	 * 
	 * @return mensagem de erro ou de busca com quatro ou mais palavras ou array de palavras para o buscador
	 */
	public function validatingArraySize($strWord)
	{
		//separa o que vem do buscador
		$arrWordSearchSearch = explode(' ',$strWord);
		$intSizeArray = count($arrWordSearchSearch);
		
		foreach ($arrWordSearchSearch as $intKey => $strValue)
		{
			if(strlen($strValue) <= 2)
			{
				if($intSizeArray==1)
				{
					return false;
				}
			}
			else
			{
				$arrReturn[$intKey] = $strValue;	
			}
		}
		if(count($arrReturn)>3)
		{
			return false;
		}
		else
			return $arrReturn;
	}
	
	/**
	 *
	 * @param array $arrWord com palavras para a traducao
	 * 
	 * @return array $arrReturn com as palavras traduzidas
	 */
	public function setWordTranslation($arrWord)
	{
		foreach ($arrWord as $intKey => $strValue)
		{
			
			$strTempValue = strtr($strValue, $this->arrMapChar); 
			
			$strTempValue = str_ireplace('a', '[aàâäãá]', $strTempValue);
			$strTempValue = str_ireplace('e', '[eêëé]', $strTempValue);
			$strTempValue = str_ireplace('i', '[iìîïí]', $strTempValue);
			$strTempValue = str_ireplace('o', '[oòôöõó]', $strTempValue);
			$strTempValue = str_ireplace('u', '[uùûüú]', $strTempValue);
			$strTempValue = str_ireplace('c', '[cç]', $strTempValue);
			$strTempValue = str_ireplace('n', '[nñ]', $strTempValue);
			//$strTempValue = str_ireplace('[aàâäãá][oòôöõó]', '[aàâäãáoòôöõó]', $strTempValue);
			
			$this->arrMapCharBDSearch[$intKey] = utf8_decode($strTempValue);
		}
		
		return $this->arrMapCharBDSearch;
	} 
}