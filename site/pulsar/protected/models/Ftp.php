<?php

/**
 * This is the model class for table "ftp".
 *
 * The followings are the available columns in table 'ftp':
 * @property integer $id_ftp
 * @property integer $id_login
 * @property string $data_cria
 */
class Ftp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ftp the static model class
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
		return 'ftp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_login', 'numerical', 'integerOnly'=>true),
			array('data_cria', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_ftp, id_login, data_cria', 'safe', 'on'=>'search'),
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
			'id_ftp' => 'Id Ftp',
			'id_login' => 'Id Login',
			'data_cria' => 'Data Cria',
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

		$criteria->compare('id_ftp',$this->id_ftp);
		$criteria->compare('id_login',$this->id_login);
		$criteria->compare('data_cria',$this->data_cria,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}