<?php
class DropDownListing 
{
	public function dropEstado()
	{
		$objModelEstado = new Estados();
		
		return $objModelEstado->findAll('1 ORDER BY Estado ASC');	
	}
	
	public function dropPais()
	{
		$objDaoPais = new paisesOfDao();
		
		return $objDaoPais->paisFotoDropDown();
	}
	
	public function dropAutor()
	{
		$objDaoFotografos = new fotografosOfDao();
		
		return $objDaoFotografos->fotografoFotoDropDown();
	}
	
	public function dropDia()
	{
		for ($intCont = 0; $intCont<=31; $intCont++)
		{
			if($intCont == 0)
				$arrReturn['0'] = '';
			elseif($intCont < 10 && $intCont !=0)
				$arrReturn['0'.$intCont] = '0'.$intCont;
			else	 
				$arrReturn[$intCont] = $intCont;	
		}	
		
		return $arrReturn;
	}
	
	public function dropMes()
	{
		$arrReturn['0'] = '';
		$arrReturn['01'] = Yii::t('zii', 'January');
		$arrReturn['02'] = Yii::t('zii', 'February');
		$arrReturn['03'] = Yii::t('zii', 'March');
		$arrReturn['04'] = Yii::t('zii', 'April');
		$arrReturn['05'] = Yii::t('zii', 'May');
		$arrReturn['06'] = Yii::t('zii', 'June');
		$arrReturn['07'] = Yii::t('zii', 'July');
		$arrReturn['08'] = Yii::t('zii', 'August');
		$arrReturn['09'] = Yii::t('zii', 'September');
		$arrReturn['10'] = Yii::t('zii', 'October');
		$arrReturn['11'] = Yii::t('zii', 'November');
		$arrReturn['12'] = Yii::t('zii', 'December');
		
		return $arrReturn;
	}
	
	public function dropAno($booSession = true)
	{
		
		if($booSession)
		{
			$arrReturn['0'] = Yii::t('zii', '(No date)');
			foreach (Yii::app()->user->getState('arrResult') as $arrAno)
			{
				$strAno = substr($arrAno['data_foto'], 0,4);
				if(!(in_array($strAno, $arrReturn)))
				{
					$arrReturn[$strAno] = $strAno;		
				}
			}
		}		
		else 
		{
			$arrReturn['0'] = '';
			for ($intCont = date('Y'); $intCont>='1978'; $intCont--)
			{
				$arrReturn[$intCont] = $intCont;
			}
		}
		return $arrReturn;
	}

	public function dropAutorAutorizacao()
	{
		$objFotografosOfDao	= new fotografosOfDao();
		
		$arrReturnFotografosAutorizacaoPendente = $objFotografosOfDao->fotografoAurorizacaoPendente(); 
		
		if(count($arrReturnFotografosAutorizacaoPendente)> 0)
		{
			$arrReturn = array();
			foreach ($arrReturnFotografosAutorizacaoPendente as $arrValue)
			{
				$arrReturn[$arrValue['id_fotografo']] = $arrValue['fotografo'];	
			}
			
			return $arrReturn;
		}
		else
		{
			return array('0'=>'Nenhum autor tem foto com autorização pendente');
		}
	}
}