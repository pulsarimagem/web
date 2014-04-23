<?php

/**
 * This is the model class for table "USO".
 *
 * The followings are the available columns in table 'USO':
 * @property integer $Id
 * @property integer $id_tipo
 * @property integer $id_subtipo
 * @property integer $id_descricao
 * @property string $valor
 * @property string $contrato
 */
class USO extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return USO the static model class
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
		return 'USO';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipo, id_subtipo, id_descricao', 'numerical', 'integerOnly'=>true),
			array('valor', 'length', 'max'=>12),
			array('contrato', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, id_tipo, id_subtipo, id_descricao, valor, contrato', 'safe', 'on'=>'search'),
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
			'id_tipo' => 'Id Tipo',
			'id_subtipo' => 'Id Subtipo',
			'id_descricao' => 'Id Descricao',
			'valor' => 'Valor',
			'contrato' => 'Contrato',
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
		$criteria->compare('id_tipo',$this->id_tipo);
		$criteria->compare('id_subtipo',$this->id_subtipo);
		$criteria->compare('id_descricao',$this->id_descricao);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('contrato',$this->contrato,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}