<?php

/**
 * This is the model class for table "ensaios".
 *
 * The followings are the available columns in table 'ensaios':
 * @property integer $id_ensaio
 * @property string $titulo
 * @property string $texto
 * @property string $titulo_en
 * @property string $texto_en
 */
class Ensaios extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ensaios the static model class
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
		return 'ensaios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('titulo, titulo_en', 'length', 'max'=>128),
			array('texto, texto_en', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_ensaio, titulo, texto, titulo_en, texto_en', 'safe', 'on'=>'search'),
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
			'id_ensaio' => 'Id Ensaio',
			'titulo' => 'Titulo',
			'texto' => 'Texto',
			'titulo_en' => 'Titulo En',
			'texto_en' => 'Texto En',
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

		$criteria->compare('id_ensaio',$this->id_ensaio);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('titulo_en',$this->titulo_en,true);
		$criteria->compare('texto_en',$this->texto_en,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}