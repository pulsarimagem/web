<?php

/**
 * This is the model class for table "rel_foto_autorizacao_imagem".
 *
 * The followings are the available columns in table 'rel_foto_autorizacao_imagem':
 * @property integer $id_rel_foto_autorizacao_imagem
 * @property integer $int_id_foto
 * @property integer $int_id_autorizacao
 * @property integer $int_flag_autorizacao
 */
class RelFotoAutorizacaoImagem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RelFotoAutorizacaoImagem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rel_foto_autorizacao_imagem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('int_id_foto, int_id_autorizacao, int_flag_autorizacao', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_rel_foto_autorizacao_imagem, int_id_foto, int_id_autorizacao, int_flag_autorizacao', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_rel_foto_autorizacao_imagem' 	=> Yii::t('zii','Id Rel Foto Autorizacao Imagem'),
			'int_id_foto' 						=> Yii::t('zii','Int Id Foto'),
			'int_id_autorizacao' 				=> Yii::t('zii','Int Id Autorizacao'),
			'int_flag_autorizacao' 				=> Yii::t('zii','Int Flag Autorizacao'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_rel_foto_autorizacao_imagem',$this->id_rel_foto_autorizacao_imagem);
		$criteria->compare('int_id_foto',$this->int_id_foto);
		$criteria->compare('int_id_autorizacao',$this->int_id_autorizacao);
		$criteria->compare('int_flag_autorizacao',$this->int_flag_autorizacao);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}