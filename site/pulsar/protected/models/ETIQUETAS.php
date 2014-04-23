<?php

/**
 * This is the model class for table "ETIQUETAS".
 *
 * The followings are the available columns in table 'ETIQUETAS':
 * @property integer $ID
 * @property integer $ID_AUTOR
 * @property string $SIGLA_AUTOR
 */
class ETIQUETAS extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ETIQUETAS the static model class
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
		return 'ETIQUETAS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_AUTOR', 'numerical', 'integerOnly'=>true),
			array('SIGLA_AUTOR', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, ID_AUTOR, SIGLA_AUTOR', 'safe', 'on'=>'search'),
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
			'ID' => 'ID',
			'ID_AUTOR' => 'Id Autor',
			'SIGLA_AUTOR' => 'Sigla Autor',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('ID_AUTOR',$this->ID_AUTOR);
		$criteria->compare('SIGLA_AUTOR',$this->SIGLA_AUTOR,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}