<?php

/**
 * This is the model class for table "pesquisa_pa".
 *
 * The followings are the available columns in table 'pesquisa_pa':
 * @property integer $Id_pa
 * @property string $fracao
 * @property string $palavra1
 * @property string $palavra2
 * @property string $palavra3
 * @property string $palavranao
 * @property string $cidade
 * @property string $estado
 * @property string $autor
 * @property string $orientacao
 * @property integer $retorno
 * @property string $datahora
 */
class PesquisaPa extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesquisaPa the static model class
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
		return 'pesquisa_pa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('retorno', 'numerical', 'integerOnly'=>true),
			array('fracao, palavra1, palavra2, palavra3, palavranao, cidade, autor', 'length', 'max'=>255),
			array('estado, orientacao', 'length', 'max'=>2),
			array('datahora', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id_pa, fracao, palavra1, palavra2, palavra3, palavranao, cidade, estado, autor, orientacao, retorno, datahora', 'safe', 'on'=>'search'),
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
			'Id_pa' => 'Id Pa',
			'fracao' => 'Fracao',
			'palavra1' => 'Palavra1',
			'palavra2' => 'Palavra2',
			'palavra3' => 'Palavra3',
			'palavranao' => 'Palavranao',
			'cidade' => 'Cidade',
			'estado' => 'Estado',
			'autor' => 'Autor',
			'orientacao' => 'Orientacao',
			'retorno' => 'Retorno',
			'datahora' => 'Datahora',
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

		$criteria->compare('Id_pa',$this->Id_pa);
		$criteria->compare('fracao',$this->fracao,true);
		$criteria->compare('palavra1',$this->palavra1,true);
		$criteria->compare('palavra2',$this->palavra2,true);
		$criteria->compare('palavra3',$this->palavra3,true);
		$criteria->compare('palavranao',$this->palavranao,true);
		$criteria->compare('cidade',$this->cidade,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('autor',$this->autor,true);
		$criteria->compare('orientacao',$this->orientacao,true);
		$criteria->compare('retorno',$this->retorno);
		$criteria->compare('datahora',$this->datahora,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}