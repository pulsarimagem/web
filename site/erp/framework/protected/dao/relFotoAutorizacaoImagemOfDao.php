<?php
class relFotoAutorizacaoImagemOfDao
{
	public function deleteRelFotoAutorizacaoByIdAutorizacaoIsNullAndFlagAutorizacao0 ($intIdFoto)
	{
		Yii::app()->db->createCommand(
			'
				DELETE FROM 
					rel_foto_autorizacao_imagem 
				WHERE 
					int_id_foto = '.$intIdFoto.'
				AND 
					int_id_autorizacao IS NULL 
				AND 
					int_flag_autorizacao = 0
			'
		)->execute();
	}
	
	public function insertRelFotoAutorizacao ($intIdFoto, $intIdAutorizacao, $intFlagAutorizacao = 1)
	{
		return Yii::app()->db->createCommand(
			'
				INSERT INTO rel_foto_autorizacao_imagem
				( 
					int_id_foto, 
					int_id_autorizacao, 
					int_flag_autorizacao
				)
				VALUES
				(
					'.$intIdFoto.', 
					'.$intIdAutorizacao.', 
					'.$intFlagAutorizacao.'
				);
			'
		)->execute();
	}
}