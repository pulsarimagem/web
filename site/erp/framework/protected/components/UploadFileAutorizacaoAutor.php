<?php
class UploadFileAutorizacaoAutor extends UploadFile
{
	private $strNomeDaPasta = 'AutorizacaoImagem';
	private $strNomeComplemento = '0001';
	
	public function setInformacaoDoArquivoAutorizacao($arrArquivo)
	{
		if(count($arrArquivo) > 0)
		{
			$arrArquivoSet['name'] 		= $arrArquivo['AutorizacaoImagem']['name']['str_nome_arquivo_autorizacao'];
			$arrArquivoSet['type'] 		= $arrArquivo['AutorizacaoImagem']['type']['str_nome_arquivo_autorizacao'];
			$arrArquivoSet['tmp_name'] 	= $arrArquivo['AutorizacaoImagem']['tmp_name']['str_nome_arquivo_autorizacao'];
			$arrArquivoSet['error'] 	= $arrArquivo['AutorizacaoImagem']['error']['str_nome_arquivo_autorizacao'];
			$arrArquivoSet['size'] 		= $arrArquivo['AutorizacaoImagem']['size']['str_nome_arquivo_autorizacao'];
			
			$this->setInformacaoDoArquivo($arrArquivoSet);
		}
	}
	
	public function setDiretorio($strSiglaAutor)
	{
		if($this->getVerificaSePastaExiste($this->strCaminhoBase.$this->strNomeDaPasta))
		{
			if($this->getVerificaSePastaExiste($this->strCaminhoBase.$this->strNomeDaPasta.'/'.$strSiglaAutor))
			{
				$this->strSalvarArquivo = $this->strCaminhoBase.$this->strNomeDaPasta.'/'.$strSiglaAutor.'/';
				return true;
			}
			else 
			{
				return false;
			}
		}
	}
	
	public function setNomeFileBase($strNomeBaseDoArquivo = 'default')
	{
		$this->strRenomarArquivo = 'LUI_'.strtoupper($strNomeBaseDoArquivo).'_'.$this->strNomeComplemento;
	}
	
	public function setComplementoNome($intCount)
	{
		if($intCount > 0 && $intCount < 10)
		{
			$this->strNomeComplemento = '000'.$intCount;
		}
		elseif($intCount > 10 && $intCount < 100)
		{
			$this->strNomeComplemento = '00'.$intCount;
		}
		elseif($intCount > 100 && $intCount < 1000)
		{
			$this->strNomeComplemento = '0'.$intCount;
		}
		elseif($intCount > 1000 && $intCount < 10000)
		{
			$this->strNomeComplemento = $intCount;
		}
	}
	
	public function salvarPelaModel($objModel)
	{
		if($objModel->save())
		{
			$this->strMensagemDeSucesso = 'Upload realizado com sucesso';
		}
		else 
		{
			$this->strMensagemDeErro = 'Ocorreu um erro, o arquivo não pode ser gravado no BD. Entrar em contato com o administrador do sistema.';
		}
	}
	
}