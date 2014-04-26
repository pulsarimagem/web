<?php
/**
 * Classe responsavel por todas as inclusoes e/ou verificacoes em sessoes do portal
 * 
 * @author Fernando Machado Dib
 * create of date  02/04/2014
 * 
 * update
 * 
 * @author XXXXXXXXX XXXXXXX
 * @version 1.0
 * last update 00/00/0000
 *  
 */
class SessionComponents 
{
	/**
	 * 
	 * Metdo que realiza a verificacao de images secao
	 * 
	 * @return false ou o nome da imagem
	 */
	public function verifyIfRecordedHomeImage()
	{
		if(Yii::app()->user->getState('strHomeImage')=='')
			return false;
		else	
			return Yii::app()->user->getState('strHomeImage');
	}
	
	/**
	 * 
	 * Grava na secao o nome da imagem randomica da home
	 * @param $strTombo
	 */
	public function setHomeImage($strTombo)
	{
		Yii::app()->user->setState('strHomeImage',$strTombo);
	}
	
	public function setTheme()
	{
		Yii::app()->user->setState('intTheme');
	}
	
	public function setLanguageForDataBase($strPtBrOrEn)
	{
		Yii::app()->user->setState('strLanDataBase',$strPtBrOrEn);
	}
	
	public function setBreadcrumb($themes)
	{
		if(count($themes) >= 1)
		{
			$arrBreadcumb =	Yii::app()->user->getState('breadcrumb');
			foreach ($themes as $intKey => $strValue)
			{
				$arrBreadcumb[$strValue['id']] = $strValue['tema'];
			}
			Yii::app()->user->setState('breadcrumb',$arrBreadcumb);
		}else{
			Yii::app()->user->setState('breadcrumb',array('0'=>Yii::t('zii', 'Themes')));
		}
	}
	
	public function setFormType($strFormType)
	{
		Yii::app()->user->setState('strFormType',$strFormType);
	}
	
	public function userSessionLoginRegister($strFirstName, $strIdUser)
	{
		Yii::app()->user->setState('login',$strFirstName);
		Yii::app()->user->setState('id',$strIdUser);
		Yii::app()->user->setState('logado',true);
	}
	
	public function setArrResults($arrResult)
	{
		Yii::app()->user->setState('arrResult',$arrResult);
	}
	
	public function arraySeparateImagesAndVideosResults ($arrResults, $intViewPage = 50)
	{
		$countVideo = 1;
		$intViewPageVideo = $intViewPage;
		$countVideoViewPage = 1;
		
		$countImage = 0;
		$intViewPageImage = $intViewPage;
		$countImageViewPage = 1;
		
		
		$arrVideo = false;
		$arrImage = false;
		
		if(count($arrResults)>0)
		{
			foreach ($arrResults as $arrValue)
			{
				if (ctype_alpha(substr($arrValue['tombo'], 0,2))) 
				{
					if($countVideo > $intViewPageVideo)
					{
						$countVideoViewPage++;
						$arrVideo[$countVideoViewPage][$countVideo] = $arrValue;
						$intViewPageVideo += $intViewPage;
						
					}
					else 
					{
						$arrVideo[$countVideoViewPage][$countVideo] = $arrValue;
					}
					$countVideo++;
				}
				else 
				{
					if($countImage > $intViewPageImage)
					{
						$countImageViewPage++;
						$arrImage[$countImageViewPage][$countImage] = $arrValue;
						$intViewPageImage += $intViewPage;
						
					}
					else 
					{
						$arrImage[$countImageViewPage][$countImage] = $arrValue;
					}
					$countImage++;
				}
			}
			Yii::app()->user->setState('arrVideo',$arrVideo);
			Yii::app()->user->setState('arrImage',$arrImage);
			Yii::app()->user->setState('intVideoPage',$countVideoViewPage);
			Yii::app()->user->setState('intImagePage',$countImageViewPage);
			Yii::app()->user->setState('intViewPage',$intViewPage);
			Yii::app()->user->setState('countImage',$countImage);
			Yii::app()->user->setState('countVideo',$countVideo);
		}
		else 
		{
			Yii::app()->user->setState('arrVideo',false);
			Yii::app()->user->setState('arrImage',false);
			Yii::app()->user->setState('intViewPage',0);
			Yii::app()->user->setState('countImage',0);
			Yii::app()->user->setState('countVideo',0);
		}		
		
		
	}
	
	public function setAmountDisplayedPerPage($intViewPage)
	{
		Yii::app()->user->setState('intViewPage',$intViewPage);
	}
	
	public function setPagination($intPage)
	{
		Yii::app()->user->setState('intPage',$intPage);
	}
	
	public function setTypeView($strTypeView)
	{
		Yii::app()->user->setState('strTypeView',$strTypeView);
	}
}