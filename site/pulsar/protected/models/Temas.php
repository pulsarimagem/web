<?php

/**
 * This is the model class for table "temas".
 *
 * The followings are the available columns in table 'temas':
 * @property string $Id
 * @property string $Tema
 * @property integer $Pai
 * @property string $Tema_en
 */
class Temas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Temas the static model class
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
		return 'temas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Tema, Tema_en', 'required'),
			array('Pai', 'numerical', 'integerOnly'=>true),
			array('Tema, Tema_en', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Tema, Pai, Tema_en', 'safe', 'on'=>'search'),
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
			'Tema' => 'Tema',
			'Pai' => 'Pai',
			'Tema_en' => 'Tema En',
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

		$criteria->compare('Id',$this->Id,true);
		$criteria->compare('Tema',$this->Tema,true);
		$criteria->compare('Pai',$this->Pai);
		$criteria->compare('Tema_en',$this->Tema_en,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}