<?php

/**
 * This is the model class for table "uso_distribuicao".
 *
 * The followings are the available columns in table 'uso_distribuicao':
 * @property string $id
 * @property string $distribuicao_br
 * @property string $distribuicao_en
 * @property string $creation_date
 * @property integer $status
 */
class USODISTRIBUICAO extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return USODISTRIBUICAO the static model class
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
		return 'uso_distribuicao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('distribuicao_br, distribuicao_en, creation_date', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('distribuicao_br, distribuicao_en', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, distribuicao_br, distribuicao_en, creation_date, status', 'safe', 'on'=>'search'),
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
			'distribuicao_br' => 'Distribuicao Br',
			'distribuicao_en' => 'Distribuicao En',
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
		$criteria->compare('distribuicao_br',$this->distribuicao_br,true);
		$criteria->compare('distribuicao_en',$this->distribuicao_en,true);
		$criteria->compare('creation_date',$this->creation_date,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}