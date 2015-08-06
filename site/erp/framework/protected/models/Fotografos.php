<?php

/**
 * This is the model class for table "fotografos".
 *
 * The followings are the available columns in table 'fotografos':
 * @property integer $id_fotografo
 * @property string $Nome_Fotografo
 * @property string $Iniciais_Fotografo
 * @property string $senha
 * @property integer $trocar_senha
 * @property string $email
 * @property integer $boo_ativo
 */
class Fotografos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Fotografos the static model class
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
		return 'fotografos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('trocar_senha, boo_ativo', 'numerical', 'integerOnly'=>true),
			array('Nome_Fotografo', 'length', 'max'=>50),
			array('Iniciais_Fotografo', 'length', 'max'=>5),
			array('senha, email', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_fotografo, Nome_Fotografo, Iniciais_Fotografo, senha, trocar_senha, email, boo_ativo', 'safe', 'on'=>'search'),
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
			'id_fotografo' => 'Id Fotografo',
			'Nome_Fotografo' => 'Nome Fotografo',
			'Iniciais_Fotografo' => 'Iniciais Fotografo',
			'senha' => 'Senha',
			'trocar_senha' => 'Trocar Senha',
			'email' => 'Email',
			'boo_ativo' => 'Boo Ativo',
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

		$criteria->compare('id_fotografo',$this->id_fotografo);
		$criteria->compare('Nome_Fotografo',$this->Nome_Fotografo,true);
		$criteria->compare('Iniciais_Fotografo',$this->Iniciais_Fotografo,true);
		$criteria->compare('senha',$this->senha,true);
		$criteria->compare('trocar_senha',$this->trocar_senha);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('boo_ativo',$this->boo_ativo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}