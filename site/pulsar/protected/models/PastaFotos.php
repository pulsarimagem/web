<?php

/**
 * This is the model class for table "pasta_fotos".
 *
 * The followings are the available columns in table 'pasta_fotos':
 * @property integer $id_foto_pasta
 * @property integer $id_pasta
 * @property string $tombo
 */
class PastaFotos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PastaFotos the static model class
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
		return 'pasta_fotos';
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
			array('id_pasta', 'numerical', 'integerOnly'=>true),
			array('tombo', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_foto_pasta, id_pasta, tombo', 'safe', 'on'=>'search'),
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
			'id_foto_pasta' => 'Id Foto Pasta',
			'id_pasta' => 'Id Pasta',
			'tombo' => 'Tombo',
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

		$criteria->compare('id_foto_pasta',$this->id_foto_pasta);
		$criteria->compare('id_pasta',$this->id_pasta);
		$criteria->compare('tombo',$this->tombo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}