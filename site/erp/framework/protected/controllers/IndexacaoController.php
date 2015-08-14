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
			$objDropDownListing				= new DropDownListing();
			$objFotografosOfDao				= new fotografosOfDao();
		//Fim, instancia de classe
		
		//Inicio, variavel que define a aba que vai ser mostrada
			$strPostOrDefault = 'default';
		//Fim, variavel que define a aba que vai ser mostrada
		
		//Inicio, retornos variados para a view
		$arrReturnView = array(
			'strMensagemDeErro'	=> 'Não foi possível identificar o autor',
			'intIdAutor' 		=> ''
			
		);
		//Fim, retornos variados para a view	
		
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
	    
		//Incio, acao get envio de formulario para visualizar fotos que estao pendentes
			if(isset($_GET['listarPendente']))
		    {
		    	$strPostOrDefault = 'listarPendentes';
		    	if(count($_GET['listarPendente']) > 0)
		    	{
		    		$arrReturnView['arrReturnDB']		= $objFotografosOfDao->fotografoAurorizacaoPendenteListing($_GET['idFotografo']);
		    		$arrReturnView['arrAutorizacao']	= $objFotografosOfDao->fotografosAutorizacao($_GET['idFotografo']);
		    		$arrReturnView['strMensagemDeErro']	= false;
		    		$arrReturnView['intIdAutor']		= $_GET['idFotografo'];

		    	}
		    }    
	    //Fim, acao get envio de formulario para visualizar fotos que estao pendentes
		
		//Inicio, salvando atualizacao de codigo de foto com LIU
			if(isset($_GET['idCodigo']) && isset($_GET['idAutorizacao']))
			{
				$objHelperRelFotoAutorizacaoImagem = new HelperRelFotoAutorizacaoImagem();
				$objHelperRelFotoAutorizacaoImagem->setArrIdCodigo($_GET['idCodigo']);
				$objHelperRelFotoAutorizacaoImagem->setArrIdAutorizacao($_GET['idAutorizacao']);
				
				$objHelperRelFotoAutorizacaoImagem->save();
					
				$strPostOrDefault = 'atualizarFotoAutorizacao';
				
				//Incio, acao get envio de formulario para visualizar fotos que estao pendentes
					if(isset($_GET['listarPendente']))
				    {
				    	if(count($_GET['listarPendente']) > 0)
				    	{
				    		$arrReturnView['arrReturnDB']		= $objFotografosOfDao->fotografoAurorizacaoPendenteListing($_GET['idFotografo']);
				    		$arrReturnView['arrAutorizacao']	= $objFotografosOfDao->fotografosAutorizacao($_GET['idFotografo']);
				    		$arrReturnView['strMensagemDeErro']	= false;
				    		$arrReturnView['intIdAutor']		= $_GET['idFotografo'];
		
				    	}
				    }    
			    //Fim, acao get envio de formulario para visualizar fotos que estao pendentes
			    
				$arrReturnView['strSucessoAutorizacao']	= 'As Autoriza&ccedil;&otilde;es foram salvas com sucesso!';    
			}	
		//Fim, salvando atualizacao de codigo de foto com LIU	
		
		//Inicio, dropdown de autores com fotos pendentes de autorizacao
			$arrReturnFotografosAutorizacaoPendente = $objDropDownListing->dropAutorAutorizacao();
		//Inicio, dropdown de autores com fotos pendentes de autorizacao		

		$this->render('autorizacao',
			array(
				
					//Inicio, html Topo da pagina
					'strTituloPagina' 							=> $objHelperHtmlPaginaCabecalho->HtmlTituloPagina($this->arrBreadCrumb),
					//Fim, html Topo da pagina
					//Inicio, html breadcrumb
					'strBreadCrumb' 							=> $objHelperHtmlBreadCrumb->HtmlBreadCrumb(),
					//Fim, html breadcrumb
					'strPostOrDefault' 							=> $strPostOrDefault,
					'objModelAutorizacaoImagem' 				=> $objModelAutorizacaoImagem,
					'objDropDownFotografo'						=> $objModelFotografo,
					'strMensagemDeErro'							=> $objUploadFileAutorizacaoAutor->strMensagemDeErro,
					'strMensagemDeSucesso'						=> $objUploadFileAutorizacaoAutor->strMensagemDeSucesso,
					'arrReturnFotografosAutorizacaoPendente'	=> $arrReturnFotografosAutorizacaoPendente,
					'arrReturnView'								=> $arrReturnView,		
				
			)
		);
	}
}