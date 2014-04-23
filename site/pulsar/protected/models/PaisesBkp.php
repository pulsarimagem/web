<?php

/**
 * This is the model class for table "paises_bkp".
 *
 * The followings are the available columns in table 'paises_bkp':
 * @property string $id_pais
 * @property string $nome
 * @property integer $field3
 * @property string $nome_en
 */
class PaisesBkp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PaisesBkp the static model class
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
		return 'paises_bkp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome', 'required'),
			array('field3', 'numerical', 'integerOnly'=>true),
			array('id_pais', 'length', 'max'=>3),
			array('nome, nome_en', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_pais, nome, field3, nome_en', 'safe', 'on'=>'search'),
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
			'id_pais' => 'Id Pais',
			'nome' => 'Nome',
			'field3' => 'Field3',
			'nome_en' => 'Nome En',
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

		$criteria->compare('id_pais',$this->id_pais,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('field3',$this->field3);
		$criteria->compare('nome_en',$this->nome_en,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}