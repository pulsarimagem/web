<?php

/**
 * This is the model class for table "uso_periodicidade".
 *
 * The followings are the available columns in table 'uso_periodicidade':
 * @property string $id
 * @property string $periodicidade_br
 * @property string $periodicidade_en
 * @property string $creation_date
 * @property integer $status
 */
class USOPERIODICIDADE extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return USOPERIODICIDADE the static model class
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
		return 'uso_periodicidade';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periodicidade_br, periodicidade_en, creation_date', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('periodicidade_br, periodicidade_en', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, periodicidade_br, periodicidade_en, creation_date, status', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'periodicidade_br' => 'Periodicidade Br',
			'periodicidade_en' => 'Periodicidade En',
			'creation_date' => 'Creation Date',
			'status' => 'Status',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('periodicidade_br',$this->periodicidade_br,true);
		$criteria->compare('periodicidade_en',$this->periodicidade_en,true);
		$criteria->compare('creation_date',$this->creation_date,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}