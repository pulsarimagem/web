<?php

/**
 * This is the model class for table "cotacao_cromos".
 *
 * The followings are the available columns in table 'cotacao_cromos':
 * @property integer $id_cromo
 * @property string $tombo
 * @property integer $id_pasta
 * @property integer $id_cotacao2
 */
class CotacaoCromos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CotacaoCromos the static model class
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
		return 'cotacao_cromos';
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
			array('id_pasta, id_cotacao2', 'numerical', 'integerOnly'=>true),
			array('tombo', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_cromo, tombo, id_pasta, id_cotacao2', 'safe', 'on'=>'search'),
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
			'id_cromo' => 'Id Cromo',
			'tombo' => 'Tombo',
			'id_pasta' => 'Id Pasta',
			'id_cotacao2' => 'Id Cotacao2',
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

		$criteria->compare('id_cromo',$this->id_cromo);
		$criteria->compare('tombo',$this->tombo,true);
		$criteria->compare('id_pasta',$this->id_pasta);
		$criteria->compare('id_cotacao2',$this->id_cotacao2);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}