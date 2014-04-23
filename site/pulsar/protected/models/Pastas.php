<?php

/**
 * This is the model class for table "pastas".
 *
 * The followings are the available columns in table 'pastas':
 * @property integer $id_pasta
 * @property integer $id_cadastro
 * @property string $nome_pasta
 * @property string $data_cria
 * @property string $data_mod
 */
class Pastas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pastas the static model class
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
		return 'pastas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cadastro', 'numerical', 'integerOnly'=>true),
			array('nome_pasta', 'length', 'max'=>250),
			array('data_cria, data_mod', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_pasta, id_cadastro, nome_pasta, data_cria, data_mod', 'safe', 'on'=>'search'),
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
			'id_pasta' => 'Id Pasta',
			'id_cadastro' => 'Id Cadastro',
			'nome_pasta' => 'Nome Pasta',
			'data_cria' => 'Data Cria',
			'data_mod' => 'Data Mod',
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

		$criteria->compare('id_pasta',$this->id_pasta);
		$criteria->compare('id_cadastro',$this->id_cadastro);
		$criteria->compare('nome_pasta',$this->nome_pasta,true);
		$criteria->compare('data_cria',$this->data_cria,true);
		$criteria->compare('data_mod',$this->data_mod,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}