<?php

/**
 * This is the model class for table "log_count_view".
 *
 * The followings are the available columns in table 'log_count_view':
 * @property integer $Id_Foto
 * @property string $tombo
 * @property string $contador
 */
class LogCountView extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogCountView the static model class
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
		return 'log_count_view';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Id_Foto', 'numerical', 'integerOnly'=>true),
			array('tombo', 'length', 'max'=>15),
			array('contador', 'length', 'max'=>21),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id_Foto, tombo, contador', 'safe', 'on'=>'search'),
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
			'Id_Foto' => 'Id Foto',
			'tombo' => 'Tombo',
			'contador' => 'Contador',
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

		$criteria->compare('Id_Foto',$this->Id_Foto);
		$criteria->compare('tombo',$this->tombo,true);
		$criteria->compare('contador',$this->contador,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}