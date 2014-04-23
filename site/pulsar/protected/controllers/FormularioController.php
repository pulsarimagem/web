<?php
class FormularioController extends Controller
{
	public function actionCadastro()
	{	
		//para preencher drop "PAIS"
		$objModelPais = new Paises();
		$objPais = $objModelPais->findAll(array('order'=>'nome'));
		
		foreach ($objPais as $arrTemp)
			$arrPais[$arrTemp['id_pais']] = $arrTemp['nome'];
		
		//para preencher drop "Estado"
		$objModelEstado = new Estados();
		$objEstado = $objModelEstado->findAll(array('order'=>'Estado'));
		
		foreach ($objEstado as $arrTemp)
			$arrEstado[$arrTemp['id_estado']] = $arrTemp['Estado'];
		
		//SELECAO GEOGRAFICA POR IP	
		if(Yii::app()->user->getState('strFormType')=='ext') // Exterior
		{
			$objModelCadastroBPF = null;
			$strFormPFB = null;
			$objModelCadastroBPJ = null;
			$strFormBPJ = null;
			$objModelCadastroEXT = new CadastroExterior();
			$strFormEXT = 'cadastro-cadastroExterior-form';
		}
		else //Brasil
		{
			$objModelCadastroEXT = null;
			$strFormEXT = null;
			
			$objModelCadastroBPF = new CadastroBPF();
			$strFormPFB = 'cadastro-cadastroPFB-form';
			
			$objModelCadastroBPJ = new CadastroBPJ();
			$strFormBPJ = 'cadastro-cadastroPJB-form';
			
		}
		
		//validacao ajax para o formulario
		$this->performAjaxValidation($objModelCadastroEXT, $objModelCadastroBPF, $objModelCadastroBPJ, $strFormEXT, $strFormPFB, $strFormBPJ);
		
		//Salvando Formulário
		if($_POST)
		{
			$this->receiveDataPostAndSaveDB($_POST);
		}
		else
		{
			//renderiza a pagina
			$this->render(
				'cadastro',
				array(
					//'strTypeForm'=>$strTypeForm,
					'objModelCadastroEXT'=>$objModelCadastroEXT,
					'objModelCadastroBPF'=>$objModelCadastroBPF,
					'objModelCadastroBPJ'=>$objModelCadastroBPJ,
					'arrPais'=>$arrPais,
					'arrEstado'=>$arrEstado,
					'strFormEXT' => $strFormEXT
				)
			);
		}	
	}
	
	private function receiveDataPostAndSaveDB($arrPost)
	{
		
		$objSessionComponents = new SessionComponents();
		foreach ($arrPost as $strKey => $strValue)
		{
			if($strKey == 'CadastroBPJ')
			{
				$objModelCadastroBPJ = new CadastroBPJ();
				$objModelCadastroBPJ->empresa = $strValue['empresa'];
				$objModelCadastroBPJ->nome = $strValue['str_primeiro_nome'].' '.$strValue['str_segundo_nome'];
				$objModelCadastroBPJ->cargo = $strValue['cargo'];
				$objModelCadastroBPJ->cpf_cnpj = str_replace(array('.','/','-'),'',$strValue['int_cnpj']);
				$objModelCadastroBPJ->endereco = $strValue['endereco'].', '.$strValue['str_numero'].', '.$strValue['str_complemento'];
				$objModelCadastroBPJ->cep = $strValue['cep'];
				$objModelCadastroBPJ->cidade = $strValue['cidade'];
				$objModelCadastroBPJ->estado = $strValue['estado'];
				$objModelCadastroBPJ->pais = $strValue['pais'];
				$objModelCadastroBPJ->telefone = str_replace(array('-',),'',$strValue['telefone']);
				$objModelCadastroBPJ->email = $strValue['email'];
				$objModelCadastroBPJ->login = $strValue['email'];
				$objModelCadastroBPJ->senha = $strValue['senha'];
				$objModelCadastroBPJ->tipo = 'J';
				$objModelCadastroBPJ->data_cadastro = date('Y'.'-'.'m'.'-'.'d'.' '.'H'.':'.'i'.':'.'s');
				$objModelCadastroBPJ->download = 'N';
				$objModelCadastroBPJ->limite = '0';
				$objModelCadastroBPJ->idioma = (Yii::app()->getLanguage()=='en' ? 'en' : 'br');
				$objModelCadastroBPJ->int_ddd = str_replace(array('(',')'),'',$strValue['int_ddd']);
				$objModelCadastroBPJ->int_ddi = str_replace(array('(',')'),'',$strValue['int_ddi']);
				$objModelCadastroBPJ->str_razao_social = ($strValue['str_razao_social']=='' ? 'Isento' : $strValue['str_razao_social'] );
				$objModelCadastroBPJ->int_inscricao_estadual = $strValue['int_inscricao_estadual'];
				$objModelCadastroBPJ->int_cnpj = str_replace(array('.','/','-'),'',$strValue['int_cnpj']);
				$objModelCadastroBPJ->str_primeiro_nome = $strValue['str_primeiro_nome'];
				$objModelCadastroBPJ->str_segundo_nome = $strValue['str_segundo_nome'];
				$objModelCadastroBPJ->email_confirma = $strValue['email_confirma'];
				$objModelCadastroBPJ->senha_confirma = $strValue['senha_confirma'];
				$objModelCadastroBPJ->int_newsletter = $strValue['int_newsletter'];
				$objModelCadastroBPJ->int_tipo_newsletter = $strValue['int_tipo_newsletter'];
				$objModelCadastroBPJ->int_termo_condicao = $strValue['int_termo_condicao'];
				$objModelCadastroBPJ->str_numero = $strValue['str_numero'];
				$objModelCadastroBPJ->str_complemento = $strValue['str_complemento'];
				
				if($objModelCadastroBPJ->save())
                {
                	$objSessionComponents->userSessionLoginRegister($strValue['str_primeiro_nome'], $objModelCadastroBPJ->id_cadastro);
                	$this->redirect(array('home/index'));
                }
                else
                	$this->redirect(array('error/error'));
			}
			elseif($strKey == 'CadastroBPF') 
			{
				$objModelCadastroBPF = new CadastroBPF();
				$objModelCadastroBPF->nome = $strValue['str_primeiro_nome'].' '.$strValue['str_segundo_nome'];
				$objModelCadastroBPF->cpf_cnpj = str_replace(array('.','-'),'',$strValue['int_cpf']);
				$objModelCadastroBPF->endereco = $strValue['endereco'].', '.$strValue['str_numero'].', '.$strValue['str_complemento'];
				$objModelCadastroBPF->cep = $strValue['cep'];
				$objModelCadastroBPF->cidade = $strValue['cidade'];
				$objModelCadastroBPF->estado = $strValue['estado'];
				$objModelCadastroBPF->pais = $strValue['pais'];
				$objModelCadastroBPF->telefone = str_replace(array('-',),'',$strValue['telefone']);
				$objModelCadastroBPF->email = $strValue['email'];
				$objModelCadastroBPF->login = $strValue['email'];
				$objModelCadastroBPF->senha = $strValue['senha'];
				$objModelCadastroBPF->tipo = 'F';
				$objModelCadastroBPF->data_cadastro = date('Y'.'-'.'m'.'-'.'d'.' '.'H'.':'.'i'.':'.'s');
				$objModelCadastroBPF->download = 'N';
				$objModelCadastroBPF->limite = '0';
				$objModelCadastroBPF->idioma = (Yii::app()->getLanguage()=='en' ? 'en' : 'br');
				$objModelCadastroBPF->int_ddd = str_replace(array('(',')'),'',$strValue['int_ddd']);
				$objModelCadastroBPF->int_ddi = str_replace(array('(',')'),'',$strValue['int_ddi']);
				$objModelCadastroBPF->int_cpf = str_replace(array('.','-'),'',$strValue['int_cpf']);
				$objModelCadastroBPF->str_primeiro_nome = $strValue['str_primeiro_nome'];
				$objModelCadastroBPF->str_segundo_nome = $strValue['str_segundo_nome'];
				$objModelCadastroBPF->email_confirma = $strValue['email_confirma'];
				$objModelCadastroBPF->senha_confirma = $strValue['senha_confirma'];
				$objModelCadastroBPF->int_newsletter = $strValue['int_newsletter'];
				$objModelCadastroBPF->int_tipo_newsletter = $strValue['int_tipo_newsletter'];
				$objModelCadastroBPF->int_termo_condicao = $strValue['int_termo_condicao'];
				$objModelCadastroBPF->str_numero = $strValue['str_numero'];
				$objModelCadastroBPF->str_complemento = $strValue['str_complemento'];
				
				if($objModelCadastroBPF->save())
                {
                	$objSessionComponents->userSessionLoginRegister($strValue['str_primeiro_nome'], $objModelCadastroBPF->id_cadastro);
                	$this->redirect(array('home/index'));
                }
                else
                	$this->redirect(array('error/error'));
			}
			else 
			{
				$objModelCadastroEXT = new CadastroExterior();
				$objModelCadastroEXT->nome = $strValue['str_primeiro_nome'].' '.$strValue['str_segundo_nome'];
				$objModelCadastroEXT->endereco = $strValue['endereco'];
				$objModelCadastroEXT->cep = $strValue['cep'];
				$objModelCadastroEXT->cidade = $strValue['cidade'];
				$objModelCadastroEXT->pais = $strValue['pais'];
				$objModelCadastroEXT->telefone = str_replace(array('-',),'',$strValue['telefone']);
				$objModelCadastroEXT->email = $strValue['email'];
				$objModelCadastroEXT->login = $strValue['email'];
				$objModelCadastroEXT->senha = $strValue['senha'];
				$objModelCadastroEXT->tipo = 'F';
				$objModelCadastroEXT->data_cadastro = date('Y'.'-'.'m'.'-'.'d'.' '.'H'.':'.'i'.':'.'s');
				$objModelCadastroEXT->download = 'N';
				$objModelCadastroEXT->limite = '0';
				$objModelCadastroEXT->idioma = (Yii::app()->getLanguage()=='en' ? 'en' : 'br');
				$objModelCadastroEXT->int_ddi = str_replace(array('(',')'),'',$strValue['int_ddi']);
				$objModelCadastroEXT->str_primeiro_nome = $strValue['str_primeiro_nome'];
				$objModelCadastroEXT->str_segundo_nome = $strValue['str_segundo_nome'];
				$objModelCadastroEXT->email_confirma = $strValue['email_confirma'];
				$objModelCadastroEXT->senha_confirma = $strValue['senha_confirma'];
				$objModelCadastroEXT->int_newsletter = $strValue['int_newsletter'];
				$objModelCadastroEXT->int_tipo_newsletter = $strValue['int_tipo_newsletter'];
				$objModelCadastroEXT->int_termo_condicao = $strValue['int_termo_condicao'];
				
				if($objModelCadastroEXT->save())
                {
                	$objSessionComponents->userSessionLoginRegister($strValue['str_primeiro_nome'], $objModelCadastroEXT->id_cadastro);
                	$this->redirect(array('home/index'));
                }
                else
                	print_r($objModelCadastroEXT->getErrors());
			}
		}
		
	}
}