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
		$strMessageError = Yii::t('zii', $this->errorSearch);
		
		//instancias das models
		$objSession = new SessionComponents();
		$objImageOfDao = new ImageOfDao(); 
		$objListingOfDao = new ListingOfDao();
		$objRegularExpression = new RegularExpression();
		if($_POST)
		{
			//verifica e/ou elimina palavras com dois ou menos carateres e valida se o array tem ate 3 posicoes
			$arrWord = $objRegularExpression->validatingArraySize($_POST['buscador']);
			
			if($arrWord)
			{
				//prepara as palavras que estao no array com os diferentes tipos de acentos
				$arrWordRergular = $objRegularExpression->setWordTranslation($arrWord);	
				//realiza a consulta para ver se encontra alguma da palavras nos temas
				$objListingOfDao->searchWordByThemes($arrWordRergular, $arrWord);
				//realiza a busca final e traz os resultados no array para colocarmos na view
				$objListingOfDao->searchByWordAndThemes();
				//Salva busca original na sessao
				$objSession->setArrResults($objListingOfDao->arrResult);
				//separa em array de imagens e videos e também faz ajustes para paginação
				$objSession->arraySeparateImagesAndVideosResults($objListingOfDao->arrResult);
				//arrays de imagens e videos que vão para view
				if(Yii::app()->user->getState('arrImage'))
					$arrImage = Yii::app()->user->getState('arrImage');
				else
					$arrImage = false;	
				if(Yii::app()->user->getState('arrVideo'))
					$arrVideo = Yii::app()->user->getState('arrVideo');
				else
					$arrVideo = false;
			}
			else
				$strMessageError;
		}
		//array da busca por temas
		$objSearchByThemes = new SearchByThemes();
		$arrSearchByThemes = $objSearchByThemes->searchThemesById();
		//abrindo secao contendo breadcrumb
		$objSession->setBreadcrumb(null);
		$arrSearchBreadcrumb = Yii::app()->user->getState('breadcrumb');
		$objSession->setPagination(1);
		$objSession->setAmountDisplayedPerPage(50);
		$objSession->setTypeView('image');
		//renderiza a pagina
		$this->render(
			'index',
			array(
				'arrSearchByThemes'=>$arrSearchByThemes,
				'arrSearchBreadcrumb'=>$arrSearchBreadcrumb,
				'strUrlStockPhotos'=>$this->strUrlStockPhotos,
				'strUrlCloud'=>$this->strUrlCloud,
				'strMessageError'=>$strMessageError,
				'arrImage' => $arrImage,
				'arrVideo' => $arrVideo,
				'intPage'=> Yii::app()->user->getState('intPage'),
				'intChange' => Yii::app()->user->getState('intViewPage'),
				'intVideoPage'=> Yii::app()->user->getState('intVideoPage'),
				'intImagePage'=> Yii::app()->user->getState('intImagePage'),
				'strType'=> Yii::app()->user->getState('strTypeView'),
			)
		);
	}
}