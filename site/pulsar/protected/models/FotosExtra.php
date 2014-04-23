<?php

/**
 * This is the model class for table "Fotos_extra".
 *
 * The followings are the available columns in table 'Fotos_extra':
 * @property integer $Id_fotos
 * @property string $tombo
 * @property string $extra
 */
class FotosExtra extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FotosExtra the static model class
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
		return 'Fotos_extra';
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
			array('tombo', 'length', 'max'=>15),
			array('extra', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id_fotos, tombo, extra', 'safe', 'on'=>'search'),
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
			'Id_fotos' => 'Id Fotos',
			'tombo' => 'Tombo',
			'extra' => 'Extra',
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

		$criteria->compare('Id_fotos',$this->Id_fotos);
		$criteria->compare('tombo',$this->tombo,true);
		$criteria->compare('extra',$this->extra,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}