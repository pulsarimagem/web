<?php

/**
 * This is the model class for table "fotos_ensaio".
 *
 * The followings are the available columns in table 'fotos_ensaio':
 * @property integer $id_foto_ensaio
 * @property integer $id_ensaio
 * @property integer $id_foto
 */
class FotosEnsaio extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FotosEnsaio the static model class
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
		return 'fotos_ensaio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ensaio, id_foto', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_foto_ensaio, id_ensaio, id_foto', 'safe', 'on'=>'search'),
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
			'id_foto_ensaio' => 'Id Foto Ensaio',
			'id_ensaio' => 'Id Ensaio',
			'id_foto' => 'Id Foto',
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

		$criteria->compare('id_foto_ensaio',$this->id_foto_ensaio);
		$criteria->compare('id_ensaio',$this->id_ensaio);
		$criteria->compare('id_foto',$this->id_foto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}