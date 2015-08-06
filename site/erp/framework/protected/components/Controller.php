<?php
/**
 * Controlador é a classe de controlador de base personalizada.
 * Todas as classes do controlador para esta aplicação deve estender-se a partir dessa classe base.
 */
class Controller extends CController
{
	/**
	 * @var string o layout padrão para a exibição do controlador. O padrão é '/ / layouts/column1',
	 * ou seja, usando um layout de coluna única. Veja 'protected/views/layouts/column1.php.
	 */
	public $layout = '//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */

	public $arrMenu = 1;
	
	public $booLogged = false;
	
	public $intTypeMenu = 0;
	
	public $arrRole = null;
	
	public $strUrlManagerMenuFramework;
	
	public $strUrlManagerMenuOld;
	
	public $arrBreadCrumb;
	
	public $arrBreadCrumbControllerView;
	
	public function init()
	{
		$objMenuDAO = new menuDAO();
		//Inicio, gravando dados da sessao do erp fora do framework
		session_start();
		if(isset($_SESSION['role']) && isset($_SESSION['MM_Username_erp']))
		{
			Yii::app()->user->setState('intPermissaoUsuario',$_SESSION['role']);
			Yii::app()->user->setState('strNomeUsuario',$_SESSION['MM_Username_erp']);
		}
		else
		{
			if($_SERVER['HTTP_HOST'] == 'localhost:8888')
			{
				$this->redirect('http://localhost:8888/erp_dev/login.php');
			}
			else 
			{
				$this->redirect('http://erp.pulsarimagens.com.br/login.php');
			}
		}	
		//Inicio, gravando dados da sessao do erp fora do framework
		
		//Inicio, configuracao de servidor
		if($_SERVER['HTTP_HOST'] == 'localhost:8888')
		{
			$this->strUrlManagerMenuFramework = 'http://localhost:8888/erp_dev/framework/';
			$this->strUrlManagerMenuOld = 'http://localhost:8888/erp_dev/';
		}
		elseif($_SERVER['HTTP_HOST'] == 'erp.pulsarimagens.com.br') 
		{
			$this->strUrlManagerMenuFramework = 'http://erp.pulsarimagens.com.br/erp/framework/';
			$this->strUrlManagerMenuOld = 'http://erp.pulsarimagens.com.br/erp/';
		}
		//Fim, configuracao de servidor
		
		//Inicio, configuracao de usuario
		if (Yii::app()->user->getState('strNomeUsuario') ) 
		{
			$this->arrRole = $objMenuDAO->getTypeMenu();
			
			if(count($this->arrRole) > 0)
			{
				$this->intTypeMenu = $this->arrRole['role'];
				$this->booLogged = true;
			}
			else
			{
				$this->intTypeMenu = 0;
				$this->booLogged = false;
			}
		}
		//Fim, configuracao de usuario
		
		//Inicio, parametros para o menu
		$objParamMenu = $objMenuDAO->getRoleMenu($this->intTypeMenu);
		$objMenu = new erpMenu();
		$this->arrMenu = $objMenu->createMenu($objParamMenu); 
		//Fim, parametros para o menu
		
		//Inicio, padronizacao de paramentros para breadcrumb
		$this->getParamBreadcrumb();
		//Fim, padronizacao de paramentros para breadcrumb
	}
	
	public function getParamBreadcrumb()
	{
		$this->arrBreadCrumb = array(
			'0'=>utf8_decode(Yii::app()->request->getParam('principal')), 
			'1'=>utf8_decode(Yii::app()->request->getParam('pagina'))
		);
		
		$this->arrBreadCrumbControllerView = array(
			'0'=>$this->getlinkBreadCrumb(Yii::app()->request->getParam('principal')), 
			'1'=>$this->getlinkBreadCrumb(Yii::app()->request->getParam('pagina'))
		);
		
	}
	
	private function getlinkBreadCrumb($strParam)
	{
		$arrBreadCrumb = explode(' ',$strParam);
		
		$intCountWords = count($arrBreadCrumb);
		$strUrlBreadCrumb = '#';
		for ($intCount = 0; $intCount < $intCountWords; $intCount++)
		{
			$strUrlBreadCrumb = str_replace('#', '', $strUrlBreadCrumb);
			$strUrlBreadCrumb .= ucfirst($arrBreadCrumb[$intCount]);
		}
		
		return $strUrlBreadCrumb;
	}
}