<?php
class HomeController extends Controller
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
		//array da busca por temas
		$objSearchByThemes = new SearchByThemes();
		$arrSearchByThemes = $objSearchByThemes->searchThemesById();
		//verifica se existe alguma imagem na secao e depois realizar a consulta com ou sem condicional
		$arrImageRandon = $objImageOfDao->randonPhotoExcludingSessionLimit(array('imageSession'=>$objSession->verifyIfRecordedHomeImage()));
		//Grava a imagem na secao
		$objSession->setHomeImage($arrImageRandon['0']['tombo']);
		//array contendo as imagens e informacoes para o carrosel de ultimas adicionadas
		$arrAddedLastCarousel = $objImageOfDao->addedLastCarousel();
		//array contendo as imagens e informacoes para o carrosel de ultimas pesquisadas
		$arrlatestCarouselSearch = $objImageOfDao->latestCarouselSearch();
		//abrindo secao contendo breadcrumb
		$objSession->setBreadcrumb(null);
		$arrSearchBreadcrumb = Yii::app()->user->getState('breadcrumb');
		//renderiza a pagina
		$this->render(
			'index',
			array(
				'strImageRandon' => $arrImageRandon['0']['tombo'], 
				'arrAddedLastCarousel'=>$arrAddedLastCarousel, 
				'arrlatestCarouselSearch'=>$arrlatestCarouselSearch,
				'arrSearchByThemes'=>$arrSearchByThemes,
				'arrSearchBreadcrumb'=>$arrSearchBreadcrumb,
				'strUrlStockPhotos'=>$this->strUrlStockPhotos,
				'strUrlCloud'=>$this->strUrlCloud
			)
		);
	}
}