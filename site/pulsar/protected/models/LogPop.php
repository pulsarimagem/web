<?php

/**
 * This is the model class for table "log_pop".
 *
 * The followings are the available columns in table 'log_pop':
 * @property integer $Id_pop
 * @property string $tombo
 * @property string $datahora
 * @property string $ip
 */
class LogPop extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogPop the static model class
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
		return 'log_pop';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tombo, ip', 'length', 'max'=>15),
			array('datahora', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id_pop, tombo, datahora, ip', 'safe', 'on'=>'search'),
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
			'Id_pop' => 'Id Pop',
			'tombo' => 'Tombo',
			'datahora' => 'Datahora',
			'ip' => 'Ip',
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

		$criteria->compare('Id_pop',$this->Id_pop);
		$criteria->compare('tombo',$this->tombo,true);
		$criteria->compare('datahora',$this->datahora,true);
		$criteria->compare('ip',$this->ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}