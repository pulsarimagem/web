<?php

/**
 * This is the model class for table "email".
 *
 * The followings are the available columns in table 'email':
 * @property integer $id_email
 * @property string $nome
 * @property string $email
 * @property string $destino
 * @property string $copia
 * @property string $texto
 * @property string $data_hora
 * @property string $assunto
 */
class Email extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Email the static model class
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
		return 'email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, email, destino, copia, assunto', 'length', 'max'=>50),
			array('texto, data_hora', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_email, nome, email, destino, copia, texto, data_hora, assunto', 'safe', 'on'=>'search'),
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
			'id_email' => 'Id Email',
			'nome' => 'Nome',
			'email' => 'Email',
			'destino' => 'Destino',
			'copia' => 'Copia',
			'texto' => 'Texto',
			'data_hora' => 'Data Hora',
			'assunto' => 'Assunto',
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

		$criteria->compare('id_email',$this->id_email);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('destino',$this->destino,true);
		$criteria->compare('copia',$this->copia,true);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('data_hora',$this->data_hora,true);
		$criteria->compare('assunto',$this->assunto,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}