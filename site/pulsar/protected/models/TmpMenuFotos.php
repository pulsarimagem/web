<?php

/**
 * This is the model class for table "tmp_menu_fotos".
 *
 * The followings are the available columns in table 'tmp_menu_fotos':
 * @property string $Id
 * @property string $Tema
 * @property integer $Pai
 * @property string $Tema_en
 * @property integer $id_pai
 */
class TmpMenuFotos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TmpMenuFotos the static model class
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
		return 'tmp_menu_fotos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Tema, Tema_en', 'required'),
			array('Pai, id_pai', 'numerical', 'integerOnly'=>true),
			array('Id', 'length', 'max'=>6),
			array('Tema, Tema_en', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Tema, Pai, Tema_en, id_pai', 'safe', 'on'=>'search'),
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
			'Id' => 'ID',
			'Tema' => 'Tema',
			'Pai' => 'Pai',
			'Tema_en' => 'Tema En',
			'id_pai' => 'Id Pai',
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

		$criteria->compare('Id',$this->Id,true);
		$criteria->compare('Tema',$this->Tema,true);
		$criteria->compare('Pai',$this->Pai);
		$criteria->compare('Tema_en',$this->Tema_en,true);
		$criteria->compare('id_pai',$this->id_pai);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}