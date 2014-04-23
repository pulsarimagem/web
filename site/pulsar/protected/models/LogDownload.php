<?php

/**
 * This is the model class for table "log_download".
 *
 * The followings are the available columns in table 'log_download':
 * @property integer $id_log
 * @property string $arquivo
 * @property string $data_hora
 * @property string $ip
 * @property integer $id_login
 */
class LogDownload extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogDownload the static model class
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
		return 'log_download';
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
			array('arquivo', 'length', 'max'=>50),
			array('ip', 'length', 'max'=>15),
			array('data_hora', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_log, arquivo, data_hora, ip, id_login', 'safe', 'on'=>'search'),
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
			'id_log' => 'Id Log',
			'arquivo' => 'Arquivo',
			'data_hora' => 'Data Hora',
			'ip' => 'Ip',
			'id_login' => 'Id Login',
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

		$criteria->compare('id_log',$this->id_log);
		$criteria->compare('arquivo',$this->arquivo,true);
		$criteria->compare('data_hora',$this->data_hora,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('id_login',$this->id_login);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}