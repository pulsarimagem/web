<?php

/**
 * This is the model class for table "fotos_homepage".
 *
 * The followings are the available columns in table 'fotos_homepage':
 * @property integer $id_foto
 * @property string $tombo
 * @property string $imagem
 */
class FotosHomepage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FotosHomepage the static model class
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
		return 'fotos_homepage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tombo', 'required'),
			array('tombo', 'length', 'max'=>15),
			array('imagem', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_foto, tombo, imagem', 'safe', 'on'=>'search'),
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
			'id_foto' => 'Id Foto',
			'tombo' => 'Tombo',
			'imagem' => 'Imagem',
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

		$criteria->compare('id_foto',$this->id_foto);
		$criteria->compare('tombo',$this->tombo,true);
		$criteria->compare('imagem',$this->imagem,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}