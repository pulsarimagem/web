<?php

/**
 * This is the model class for table "pesquisa_pc".
 *
 * The followings are the available columns in table 'pesquisa_pc':
 * @property integer $Id_pc
 * @property string $palavra
 * @property integer $retorno
 * @property string $datahora
 * @property string $tombo
 */
class PesquisaPc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesquisaPc the static model class
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
		return 'pesquisa_pc';
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
			array('palavra', 'length', 'max'=>255),
			array('tombo', 'length', 'max'=>15),
			array('datahora', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id_pc, palavra, retorno, datahora, tombo', 'safe', 'on'=>'search'),
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
			'Id_pc' => 'Id Pc',
			'palavra' => 'Palavra',
			'retorno' => 'Retorno',
			'datahora' => 'Datahora',
			'tombo' => 'Tombo',
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

		$criteria->compare('Id_pc',$this->Id_pc);
		$criteria->compare('palavra',$this->palavra,true);
		$criteria->compare('retorno',$this->retorno);
		$criteria->compare('datahora',$this->datahora,true);
		$criteria->compare('tombo',$this->tombo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}