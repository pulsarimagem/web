<?php

/**
 * This is the model class for table "cotacao".
 *
 * The followings are the available columns in table 'cotacao':
 * @property integer $id_cotacao
 * @property string $tombo
 * @property integer $id_cadastro
 * @property string $data
 * @property integer $id_pasta
 */
class Cotacao extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cotacao the static model class
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
		return 'cotacao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tombo', 'required'),
			array('id_cadastro, id_pasta', 'numerical', 'integerOnly'=>true),
			array('tombo', 'length', 'max'=>20),
			array('data', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_cotacao, tombo, id_cadastro, data, id_pasta', 'safe', 'on'=>'search'),
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
			'id_cotacao' => 'Id Cotacao',
			'tombo' => 'Tombo',
			'id_cadastro' => 'Id Cadastro',
			'data' => 'Data',
			'id_pasta' => 'Id Pasta',
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

		$criteria->compare('id_cotacao',$this->id_cotacao);
		$criteria->compare('tombo',$this->tombo,true);
		$criteria->compare('id_cadastro',$this->id_cadastro);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('id_pasta',$this->id_pasta);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}