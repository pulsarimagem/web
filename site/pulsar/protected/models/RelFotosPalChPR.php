<?php

/**
 * This is the model class for table "rel_fotos_pal_ch_PR".
 *
 * The followings are the available columns in table 'rel_fotos_pal_ch_PR':
 * @property integer $id_rel
 * @property integer $id_foto
 * @property integer $id_palavra_chave
 */
class RelFotosPalChPR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RelFotosPalChPR the static model class
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
		return 'rel_fotos_pal_ch_PR';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_foto, id_palavra_chave', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_rel, id_foto, id_palavra_chave', 'safe', 'on'=>'search'),
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
			'id_rel' => 'Id Rel',
			'id_foto' => 'Id Foto',
			'id_palavra_chave' => 'Id Palavra Chave',
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

		$criteria->compare('id_rel',$this->id_rel);
		$criteria->compare('id_foto',$this->id_foto);
		$criteria->compare('id_palavra_chave',$this->id_palavra_chave);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}