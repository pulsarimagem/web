<?php

/**
 * This is the model class for table "CLIENTES2_OFC".
 *
 * The followings are the available columns in table 'CLIENTES2_OFC':
 * @property integer $ID
 * @property string $CLICGC
 * @property integer $CLISEQEND
 * @property string $CLIEND
 * @property string $CLIBAI
 * @property string $CLICEP
 * @property string $CLICID
 * @property string $ESTCOD
 */
class CLIENTES2OFC extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CLIENTES2OFC the static model class
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
		return 'CLIENTES2_OFC';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CLISEQEND', 'numerical', 'integerOnly'=>true),
			array('CLICGC', 'length', 'max'=>20),
			array('CLIEND', 'length', 'max'=>100),
			array('CLIBAI, CLICID', 'length', 'max'=>50),
			array('CLICEP, ESTCOD', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, CLICGC, CLISEQEND, CLIEND, CLIBAI, CLICEP, CLICID, ESTCOD', 'safe', 'on'=>'search'),
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
			'CLICGC' => 'Clicgc',
			'CLISEQEND' => 'Cliseqend',
			'CLIEND' => 'Cliend',
			'CLIBAI' => 'Clibai',
			'CLICEP' => 'Clicep',
			'CLICID' => 'Clicid',
			'ESTCOD' => 'Estcod',
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
		$criteria->compare('CLICGC',$this->CLICGC,true);
		$criteria->compare('CLISEQEND',$this->CLISEQEND);
		$criteria->compare('CLIEND',$this->CLIEND,true);
		$criteria->compare('CLIBAI',$this->CLIBAI,true);
		$criteria->compare('CLICEP',$this->CLICEP,true);
		$criteria->compare('CLICID',$this->CLICID,true);
		$criteria->compare('ESTCOD',$this->ESTCOD,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}