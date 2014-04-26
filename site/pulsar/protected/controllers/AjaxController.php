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
	
	/**
	 * 
	 * Controller Ajax ao alterar a quantidade de itens visualizados no menu direito de display
	 */
	public function actionAjaxlistingArray()
	{
		$strMessageError = Yii::t('zii', $this->errorSearch);
		$objSession = new SessionComponents();
		$objListingOfDao = new ListingOfDao();
		if(Yii::app()->user->getState('arrImage'))
			$arrImage = Yii::app()->user->getState('arrImage');
		else
			$arrImage = false;	
		if(Yii::app()->user->getState('arrVideo'))
			$arrVideo = Yii::app()->user->getState('arrVideo');
		else
			$arrVideo = false;	
		if($_POST)
		{
			$objSession->setPagination($_POST['page']);
			if($_POST['idChange']=='50' || $_POST['idChange']=='100'|| $_POST['idChange']=='150')
			{
				$objSession->setAmountDisplayedPerPage($_POST['idChange']);
			}
			$objSession->setTypeView($_POST['type']);
			Yii::app()->user->getState('strTypeView');
			$objSession->arraySeparateImagesAndVideosResults(Yii::app()->user->getState('arrResult'),Yii::app()->user->getState('intViewPage'));
			$this->renderPartial(
				'ajaxListingArray',
				array(
					'strUrlStockPhotos'=>$this->strUrlStockPhotos,
					'strUrlCloud'=>$this->strUrlCloud,
					'strMessageError'=>$strMessageError,
					'arrImage'=>$arrImage,
					'arrVideo'=>$arrVideo,
					'intPage'=> Yii::app()->user->getState('intPage'),
					'intChange' => Yii::app()->user->getState('intViewPage'),
					'intVideoPage'=> Yii::app()->user->getState('intVideoPage'),
					'intImagePage'=> Yii::app()->user->getState('intImagePage'),
					'strType'=> Yii::app()->user->getState('strTypeView'),
					
				)
			);	
		}
	}
	
	/**
	 * 
	 * Controller Ajax ao alterar a quantidade de itens visualizados no menu direito de display
	 */
	public function actionAjaxlistingArrayVideos()
	{
		$strMessageError = Yii::t('zii', $this->errorSearch);
		$objSession = new SessionComponents();
		$objListingOfDao = new ListingOfDao();
		if(Yii::app()->user->getState('arrImage'))
			$arrImage = Yii::app()->user->getState('arrImage');
		else
			$arrImage = false;	
		if(Yii::app()->user->getState('arrVideo'))
			$arrVideo = Yii::app()->user->getState('arrVideo');
		else
			$arrVideo = false;	
		if($_POST)
		{
			$objSession->setPagination($_POST['page']);
			if($_POST['idChange']=='50' || $_POST['idChange']=='100'|| $_POST['idChange']=='150')
			{
				$objSession->setAmountDisplayedPerPage($_POST['idChange']);
			}
			$objSession->setTypeView('video');
			Yii::app()->user->getState('strTypeView');
			$objSession->arraySeparateImagesAndVideosResults(Yii::app()->user->getState('arrResult'),Yii::app()->user->getState('intViewPage'));
			$this->renderPartial(
				'ajaxListingArrayVideos',
				array(
					'strUrlStockPhotos'=>$this->strUrlStockPhotos,
					'strUrlCloud'=>$this->strUrlCloud,
					'strMessageError'=>$strMessageError,
					'arrImage'=>$arrImage,
					'arrVideo'=>$arrVideo,
					'intPage'=> Yii::app()->user->getState('intPage'),
					'intChange' => Yii::app()->user->getState('intViewPage'),
					'intVideoPage'=> Yii::app()->user->getState('intVideoPage'),
					'intImagePage'=> Yii::app()->user->getState('intImagePage'),
					'strType'=> Yii::app()->user->getState('strTypeView'),
					
				)
			);	
		}
	}
}