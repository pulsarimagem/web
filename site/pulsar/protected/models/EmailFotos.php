<?php

/**
 * This is the model class for table "email_fotos".
 *
 * The followings are the available columns in table 'email_fotos':
 * @property integer $id_email_foto
 * @property string $tombo
 * @property integer $id_email
 */
class EmailFotos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailFotos the static model class
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
		return 'email_fotos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_email', 'numerical', 'integerOnly'=>true),
			array('tombo', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_email_foto, tombo, id_email', 'safe', 'on'=>'search'),
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
			'id_email_foto' => 'Id Email Foto',
			'tombo' => 'Tombo',
			'id_email' => 'Id Email',
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

		$criteria->compare('id_email_foto',$this->id_email_foto);
		$criteria->compare('tombo',$this->tombo,true);
		$criteria->compare('id_email',$this->id_email);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}