<?php
class UploadFile
{
	public $strNomeDoArquivo 			= '';
	public $strTipoDoArquivo 			= '';
	public $strNomeTemporarioDoArquivo	= '';
	public $intErroDoArquivo			= '';
	public $strTamanhoDoArquivo			= '';
	public $strCaminhoDiretorio			= '';
	public $strCaminhoBase 				= '';
	public $strMensagemDeErro			= null;
	public $strRenomarArquivo			= '';
	public $strMensagemDeSucesso		= null;
	public $strSalvarArquivo			= '';
	
	
	public function __construct()
	{
		//Inicio, indentificando o servidor
			if($_SERVER['HTTP_HOST'] == 'localhost:8888')
			{
				$this->strCaminhoBase = '/Applications/MAMP/htdocs/erp_dev/framework/';
			}
			else
			{
				$this->strCaminhoBase = '/var/www/html/site/';
			}
		//Fim, indentificando o servidor
	}
	
	public function setInformacaoDoArquivo($arrArquivo = array())
	{
		//Inicio, verificando falta de informacoes em $arrArquivo
			if(!isset($arrArquivo['name']) || !isset($arrArquivo['type']) || !isset($arrArquivo['tmp_name']) || !isset($arrArquivo['size']))
			{
				$this->strMensagemDeErro = 'Arquivo com informações incompletas';
			}
			
			if(isset($arrArquivo['error']))
			{
				if($arrArquivo['error'] != 0)
				{
					$this->strMensagemDeErro = 'Erro de Upload vindo do formulário';	
				}
			}
		//Inicio, verificando falta de informacoes em $arrArquivo
		
		$this->strNomeDoArquivo 			= $arrArquivo['name'];
		$this->strTipoDoArquivo 			= $arrArquivo['type'];
		$this->strNomeTemporarioDoArquivo	= $arrArquivo['tmp_name'];
		$this->intErroDoArquivo				= $arrArquivo['error'];
		$this->strTamanhoDoArquivo			= $arrArquivo['size'];
	}
	
	public function getVerificaSePastaExiste($strUrlPasta)
	{
		if(is_dir($strUrlPasta))
		{
			return true;
		}
		else
		{
			if(mkdir($strUrlPasta,0777))
			{
				chmod($strUrlPasta,0777);
				return true;
			}
			else 
			{
				return false;
			}
		}
	}
	
	public function getNomeDoArquivo()
	{
		return $this->strRenomarArquivo;
	}
	
	public function salvarArquivoNoServidor()
	{
		$strGetExtensao = $this->getExtensaoDoArquivo();
		
		if(copy($this->strNomeTemporarioDoArquivo, $this->strSalvarArquivo.$this->strRenomarArquivo.'.'.$strGetExtensao))
		{
			return true;
		}
		else 
		{
			$this->strMensagemDeErro = 'Não foi possível salvar o arquivo no servidor, entrar em contado com o administrador do sistema.';
			return false;
		}
	}
	
	public function getExtensaoDoArquivo($strNomeDoArquivo = false)
	{
		if(!$strNomeDoArquivo)
		{
			$strNomeDoArquivo = $this->strNomeDoArquivo;
		}
		$strExtensao = explode('.',$strNomeDoArquivo);
		return $strExtensao[1];
	}
	
}