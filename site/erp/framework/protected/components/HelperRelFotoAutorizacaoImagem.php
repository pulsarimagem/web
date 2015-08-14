<?php
class HelperRelFotoAutorizacaoImagem extends relFotoAutorizacaoImagemOfDao
{
	public $arrIdCodigo = null;
	public $arrIdAutorizacao = null;
	
	public function setArrIdCodigo ($strIdCodigo)
	{
		$strIdCodigo = substr($strIdCodigo, 1);
		$this->arrIdCodigo = explode(',', $strIdCodigo);
	}
	
	public function setArrIdAutorizacao ($strIdAutorizacao)
	{
		$strIdAutorizacao = substr($strIdAutorizacao, 1);
		$this->arrIdAutorizacao = explode(',', $strIdAutorizacao);
	}
	
	public function save()
	{
		foreach ($this->arrIdCodigo as $arrCodigo)
		{
			$this->deleteRelFotoAutorizacaoByIdAutorizacaoIsNullAndFlagAutorizacao0($arrCodigo);
			foreach ($this->arrIdAutorizacao as $arrAutorizacao)
			{
				$this->insertRelFotoAutorizacao($arrCodigo, $arrAutorizacao);
			}
		}
	}
}