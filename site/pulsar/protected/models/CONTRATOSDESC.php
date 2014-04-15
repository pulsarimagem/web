<?php

/**
 * This is the model class for table "CONTRATOS_DESC".
 *
 * The followings are the available columns in table 'CONTRATOS_DESC':
 * @property integer $Id
 * @property string $titulo
 * @property string $condicoes
 * @property integer $padrao
 * @property integer $assinatura
 * @property string $tipo
 */
class CONTRATOSDESC extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CONTRATOSDESC the static model class
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
		return 'CONTRATOS_DESC';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('padrao, assinatura', 'numerical', 'integerOnly'=>true),
			array('titulo', 'length', 'max'=>255),
			array('tipo', 'length', 'max'=>1),
			array('condicoes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, titulo, condicoes, padrao, assinatura, tipo', 'safe', 'on'=>'search'),
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
			'Id' => 'ID',
			'titulo' => 'Titulo',
			'condicoes' => 'Condicoes',
			'padrao' => 'Padrao',
			'assinatura' => 'Assinatura',
			'tipo' => 'Tipo',
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('condicoes',$this->condicoes,true);
		$criteria->compare('padrao',$this->padrao);
		$criteria->compare('assinatura',$this->assinatura);
		$criteria->compare('tipo',$this->tipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}