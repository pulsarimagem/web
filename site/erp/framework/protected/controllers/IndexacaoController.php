<?php
class IndexacaoController extends Controller
{
	public function actionAutorizacao()
	{	
		//Inicio, instancia de classe
			$objHelperHtmlBreadCrumb 		= new HelperHtmlBreadCrumb($this->arrBreadCrumb, $this->arrBreadCrumbControllerView, $this->strUrlManagerMenuFramework, $this->strUrlManagerMenuOld);
			$objHelperHtmlPaginaCabecalho 	= new HelperHtmlPaginaCabecalho();
			$objModelAutorizacaoImagem		= new AutorizacaoImagem;
			$objModelFotografo				= new Fotografos();
			$objUploadFileAutorizacaoAutor	= new UploadFileAutorizacaoAutor();
		//Fim, instancia de classe
		
		//Inicio, variavel que define a aba que vai ser mostrada
			$strPostOrDefault = 'default';
		//Fim, variavel que define a aba que vai ser mostrada
		
		//Inicio, validacao do formulario de subir autorizacao
			(isset($_POST['str_sigla_autor']) ? $_POST['AutorizacaoImagem']['str_sigla_autor'] = $_POST['str_sigla_autor'] : '');
			(isset($_FILES['AutorizacaoImagem']['name']['str_nome_arquivo_autorizacao']) ? $_POST['AutorizacaoImagem']['str_nome_arquivo_autorizacao'] = $_FILES['AutorizacaoImagem']['name']['str_nome_arquivo_autorizacao'] : '');
			(isset($_POST['str_estado']) ? $_POST['AutorizacaoImagem']['str_estado'] = utf8_encode($_POST['str_estado']) : '');
			(isset($_POST['AutorizacaoImagem']['str_descricao']) ? $_POST['AutorizacaoImagem']['str_descricao'] = utf8_encode($_POST['AutorizacaoImagem']['str_descricao']) : '');
			(isset($_POST['AutorizacaoImagem']['str_cidade']) ? $_POST['AutorizacaoImagem']['str_cidade'] = utf8_encode($_POST['AutorizacaoImagem']['str_cidade']) : '');
			(isset($_POST['AutorizacaoImagem']['str_autorizado_por']) ? $_POST['AutorizacaoImagem']['str_autorizado_por'] = utf8_encode($_POST['AutorizacaoImagem']['str_autorizado_por']) : '');
			
			if(isset($_POST['ajax']) && $_POST['ajax']==='autorizacao-imagem-formBase-form')
		    {
		        echo CActiveForm::validate($objModelAutorizacaoImagem);
		        Yii::app()->end();
		    }
	    //Fim, validacao do formulario de subir autorizacao
	    
	    //Incio, acao pos envio deo formulario de  subir autorizacao
			if(isset($_POST['AutorizacaoImagem']))
		    {
		    	//Inicio, Salvando o retorno do formulario no attibutos da MODEL	
		       		$objModelAutorizacaoImagem->attributes=$_POST['AutorizacaoImagem'];
		        //Fim, Salvando o retorno do formulario no attibutos da MODEL
		        
		    	//Inicio, salvando as informocaoes provenientes de $_FILES
		    		$objUploadFileAutorizacaoAutor->setInformacaoDoArquivoAutorizacao($_FILES);
		    	//Fim, salvando as informocaoes provenientes de $_FILES
		    	
		    	//Inicio, verificando e/ou criando diretorio
		    		if($objUploadFileAutorizacaoAutor->setDiretorio($objModelAutorizacaoImagem->getAttribute('str_sigla_autor')))
		    		{
		    			$intCountAutorizacaoAutor = $objModelAutorizacaoImagem->count('str_sigla_autor=:intSiglaAutor',array(':intSiglaAutor'=>$objModelAutorizacaoImagem->getAttribute('str_sigla_autor')));
		    			
		    			//Inicio, complementando o nome do arquivo que vai para o servidor
		    				$objUploadFileAutorizacaoAutor->setComplementoNome($intCountAutorizacaoAutor);
		    			//Fim, complementando o nome do arquivo que vai para o servidor
		    			
		    			//inicio, set nome base do arquivo
		    				$objUploadFileAutorizacaoAutor->setNomeFileBase($objModelAutorizacaoImagem->getAttribute('str_sigla_autor'));
		    			//Fim, set nome base do arquivo	
		    			
		    			//Inicio, salvando o arquivo no servidor	
		    				if($objUploadFileAutorizacaoAutor->salvarArquivoNoServidor())
		    				{
		    					//Inicio, salvando no banco
			    					$objUploadFileAutorizacaoAutor->salvarPelaModel($objModelAutorizacaoImagem);
			    				//Fim, salvando o arquivo no servidor	
		    				}
						//Fim, salvando o arquivo no servidor
		    		}
		    	//fim, verificando e/ou criando diretorio	
		    	
				//Inicio, variavel que define a aba que vai ser mostrada, substituindo o valor default
		    		$strPostOrDefault = 'subirAutorizacao';
		    	//Fim, variavel que define a aba que vai ser mostrada, substituindo o valor default	
		    }
	    //Fim, acao pos envio deo formulario de  subir autorizacao

		$this->render('autorizacao',
			array(
				
					//Inicio, html Topo da pagina
					'strTituloPagina' 			=> $objHelperHtmlPaginaCabecalho->HtmlTituloPagina($this->arrBreadCrumb),
					//Fim, html Topo da pagina
					//Inicio, html breadcrumb
					'strBreadCrumb' 			=> $objHelperHtmlBreadCrumb->HtmlBreadCrumb(),
					//Fim, html breadcrumb
					'strPostOrDefault' 			=> $strPostOrDefault,
					'objModelAutorizacaoImagem' => $objModelAutorizacaoImagem,
					'objDropDownFotografo'		=> $objModelFotografo,
					'strMensagemDeErro'			=> $objUploadFileAutorizacaoAutor->strMensagemDeErro,
					'strMensagemDeSucesso'		=> $objUploadFileAutorizacaoAutor->strMensagemDeSucesso,
				
			)
		);
	}
}