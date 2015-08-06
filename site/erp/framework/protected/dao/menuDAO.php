<?php
class menuDAO
{
	/**
	 * 
	 * Recupera informacoes a partir do nome do usuario para o inicio da montagem do menu, retorna o tipo de menu a que o 
	 * usuario de visualizar
	 * @return $arrRes[0]
	 */
	public function getTypeMenu()
	{
		$arrRes = yii::app()->dbSig->createCommand('
			SELECT 
				*,
				U.nome as login 
			FROM 
				USUARIOS AS U 
			LEFT JOIN 
				roles AS R on R.id = U.role 
			WHERE 
				U.usuario = "'.Yii::app()->user->getState('strNomeUsuario').'"
			AND
				U.status = "A"	
		')->queryAll();
		
		return $arrRes['0'];
	}
	
	/**
	 * 
	 * Recupera os parametros do banco para montagem com as permissoes do menus
	 * @param $intTypeMenu
	 * @return $arrRes[0]
	 */
	public function getRoleMenu($intTypeMenu)
	{
		$arrRes = yii::app()->dbSig->createCommand('
			SELECT 
				* 
			FROM 
				roles 
			WHERE 
				id = '.$intTypeMenu.'
		')->queryAll();
		
		return $arrRes[0];
	}
}