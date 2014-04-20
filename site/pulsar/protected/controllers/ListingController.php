<?php
class ListingController extends Controller
{
	/**
	 * Esta é a ação 'index' o padrão que é chamado
	 * quando uma ação não é explicitamente solicitado pelos usuários.
	 * 
	 */
	public function actionIndex()
	{
		//instancias das models
		$objSession = new SessionComponents();
		$objImageOfDao = new ImageOfDao(); 
		$objListingOfDao = new ListingOfDao();
		
		//buscador
		$arrWordSearch = explode(' ','Batata doce agreste');
		
		$objListingOfDao->setWordTranslation($arrWordSearch);
		
		
		//array da busca por temas
		$objSearchByThemes = new SearchByThemes();
		$arrSearchByThemes = $objSearchByThemes->searchThemesById();
		//abrindo secao contendo breadcrumb
		$objSession->setBreadcrumb(null);
		$arrSearchBreadcrumb = Yii::app()->user->getState('breadcrumb');
		//renderiza a pagina
		$this->render(
			'index',
			array(
				'arrSearchByThemes'=>$arrSearchByThemes,
				'arrSearchBreadcrumb'=>$arrSearchBreadcrumb,
				'strUrlStockPhotos'=>$this->strUrlStockPhotos,
				'strUrlCloud'=>$this->strUrlCloud
			)
		);
	}
}