<?php
class AjaxController extends Controller
{
	/**
	 * Esta é a ação 'AJAX' o padrão que é chamado
	 * renderiza parcialmente sem carregar header e footer.
	 * 
	 */
	public function actionAjaxSearchByThemes()
	{
		$objSearchByThemes = new SearchByThemes();
		$arrSearchByThemes = $objSearchByThemes->searchThemesById($_POST["dad"]);
		
		$objImageOfDao = new ImageOfDao();
		$arrBreadcrumb = $objImageOfDao->searchBreadcrumbThemesById($_POST["dad"]);
		$arrSearchBreadcrumb = Yii::app()->user->getState('breadcrumb');
		$this->renderPartial('AjaxSearchByThemes', array('arrSearchByThemes'=>$arrSearchByThemes,'strMensagem'=>$this->strMesageThemesHome, 'arrSearchBreadcrumb'=>$arrSearchBreadcrumb, 'intCountArrayBreadcumb'=>count($arrSearchBreadcrumb)));
	}
}