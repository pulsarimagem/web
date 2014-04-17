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
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array O breadcrumbs atual. O valor dessa propriedade será
	 * ser atribuído a {@ link de CBreadcrumbs :: Links}. Por favor, consulte {@ link de CBreadcrumbs :: Links}
	 * para mais detalhes sobre como especificar esta propriedade.
	 */
	public $breadcrumbs=array();
	
	/**
	 * @see protected/yii-1.1.13/framework/CController::init()
	 * Variavel de controle para que execute somente 1 vez
	 * 
	 */
	public $strMesageThemesHome = 'Fim de níveis';
	
	public $strUrlStockPhotos = 'http://www.pulsarimagens.com.br/bancoImagens/';
	
	public $strUrlCloud = 'http://177.71.182.64/Videos/thumbs/';
	
	public function init()
	{
		//pelo ip de acesso, alterar a linguagem de acordo com o pais de origem, 
		//somente o brasil e o localhost terão a tradução para português os demais serão em inglês
		
		$objIpdetails = new Ipdetails(Yii::app()->request->userHostAddress);
		$objSession = new SessionComponents();
		/*
		$objIpdetails->scan();
		// descomentar para subir ao servidor
		if($objIpdetails->get_countrycode() == "" || $objIpdetails->get_countrycode() == "BR")
		{
		*/
			//Yii::app()->setLanguage('pt_br');
			//$objSession->setFormType('pt_br');
			$objSession->setFormType('ext');
			Yii::app()->setLanguage('en');
		/*
		}
		else 
		{
			Yii::app()->setLanguage('en');
			$objSession->setFormType('ext');
		}
		*/
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param  the model to be validated
	 */
	protected function performAjaxValidation($objModel, $strNameForm)
	{	
		if(isset($_POST['ajax']) && $_POST['ajax']===$strNameForm)
		{
			echo CActiveForm::validate($objModel);
			Yii::app()->end();
		}
	}
}