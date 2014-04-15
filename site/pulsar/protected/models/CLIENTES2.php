<?php

/**
 * This is the model class for table "CLIENTES2".
 *
 * The followings are the available columns in table 'CLIENTES2':
 * @property string $CLICGC
 * @property string $CLITIPEND
 * @property string $CLISEQEND
 * @property string $CLIEND
 * @property string $CLIBAI
 * @property string $CLICEP
 * @property string $CLICID
 * @property string $ESTCOD
 */
class CLIENTES2 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CLIENTES2 the static model class
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
		return 'CLIENTES2';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CLICGC', 'required'),
			array('CLICGC', 'length', 'max'=>18),
			array('CLITIPEND, CLISEQEND', 'length', 'max'=>1),
			array('CLIEND', 'length', 'max'=>100),
			array('CLIBAI, CLICID', 'length', 'max'=>25),
			array('CLICEP', 'length', 'max'=>9),
			array('ESTCOD', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('CLICGC, CLITIPEND, CLISEQEND, CLIEND, CLIBAI, CLICEP, CLICID, ESTCOD', 'safe', 'on'=>'search'),
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
			'CLICGC' => 'Clicgc',
			'CLITIPEND' => 'Clitipend',
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

		$criteria->compare('CLICGC',$this->CLICGC,true);
		$criteria->compare('CLITIPEND',$this->CLITIPEND,true);
		$criteria->compare('CLISEQEND',$this->CLISEQEND,true);
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