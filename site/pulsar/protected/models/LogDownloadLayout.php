<?php

/**
 * This is the model class for table "log_download_layout".
 *
 * The followings are the available columns in table 'log_download_layout':
 * @property integer $id_log
 * @property string $arquivo
 * @property string $data_hora
 * @property string $ip
 * @property integer $id_login
 * @property string $usuario
 * @property string $projeto
 * @property string $obs
 * @property integer $faturado
 * @property integer $faturado_quem
 * @property string $faturado_qdo
 * @property string $faturado_obs
 */
class LogDownloadLayout extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogDownloadLayout the static model class
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
		return 'log_download_layout';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_login, faturado, faturado_quem', 'numerical', 'integerOnly'=>true),
			array('arquivo', 'length', 'max'=>50),
			array('ip', 'length', 'max'=>15),
			array('usuario, projeto', 'length', 'max'=>128),
			array('faturado_obs', 'length', 'max'=>255),
			array('data_hora, obs, faturado_qdo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_log, arquivo, data_hora, ip, id_login, usuario, projeto, obs, faturado, faturado_quem, faturado_qdo, faturado_obs', 'safe', 'on'=>'search'),
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
			'usuario' => 'Usuario',
			'projeto' => 'Projeto',
			'obs' => 'Obs',
			'faturado' => 'Faturado',
			'faturado_quem' => 'Faturado Quem',
			'faturado_qdo' => 'Faturado Qdo',
			'faturado_obs' => 'Faturado Obs',
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
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('projeto',$this->projeto,true);
		$criteria->compare('obs',$this->obs,true);
		$criteria->compare('faturado',$this->faturado);
		$criteria->compare('faturado_quem',$this->faturado_quem);
		$criteria->compare('faturado_qdo',$this->faturado_qdo,true);
		$criteria->compare('faturado_obs',$this->faturado_obs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}