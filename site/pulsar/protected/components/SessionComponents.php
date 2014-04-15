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
			Yii::app()->user->setState('breadcrumb',array('0'=>'Temas'));
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
	}
}