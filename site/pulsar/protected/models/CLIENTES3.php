<?php

/**
 * This is the model class for table "CLIENTES3".
 *
 * The followings are the available columns in table 'CLIENTES3':
 * @property string $CLICGC
 * @property string $CLISEQCON
 * @property string $CLICON
 * @property string $CLIDPT
 * @property string $CLIDDD
 * @property string $CLITEL
 * @property string $CLIRAM
 * @property string $CLIFAX
 * @property string $CLITEL1
 * @property string $CLIFAXRAM
 * @property string $CLICOM
 * @property integer $CLICOMCOM
 * @property string $EMAILCON
 * @property string $COMISSAO
 */
class CLIENTES3 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CLIENTES3 the static model class
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
		return 'CLIENTES3';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CLICGC, CLICON', 'required'),
			array('CLICOMCOM', 'numerical', 'integerOnly'=>true),
			array('CLICGC', 'length', 'max'=>18),
			array('CLISEQCON', 'length', 'max'=>2),
			array('CLICON', 'length', 'max'=>30),
			array('CLIDPT', 'length', 'max'=>25),
			array('CLIDDD, CLIFAXRAM', 'length', 'max'=>4),
			array('CLITEL, CLIFAX', 'length', 'max'=>14),
			array('CLIRAM', 'length', 'max'=>5),
			array('CLITEL1, CLICOM', 'length', 'max'=>15),
			array('EMAILCON', 'length', 'max'=>100),
			array('COMISSAO', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('CLICGC, CLISEQCON, CLICON, CLIDPT, CLIDDD, CLITEL, CLIRAM, CLIFAX, CLITEL1, CLIFAXRAM, CLICOM, CLICOMCOM, EMAILCON, COMISSAO', 'safe', 'on'=>'search'),
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
			'CLISEQCON' => 'Cliseqcon',
			'CLICON' => 'Clicon',
			'CLIDPT' => 'Clidpt',
			'CLIDDD' => 'Cliddd',
			'CLITEL' => 'Clitel',
			'CLIRAM' => 'Cliram',
			'CLIFAX' => 'Clifax',
			'CLITEL1' => 'Clitel1',
			'CLIFAXRAM' => 'Clifaxram',
			'CLICOM' => 'Clicom',
			'CLICOMCOM' => 'Clicomcom',
			'EMAILCON' => 'Emailcon',
			'COMISSAO' => 'Comissao',
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
		$criteria->compare('CLISEQCON',$this->CLISEQCON,true);
		$criteria->compare('CLICON',$this->CLICON,true);
		$criteria->compare('CLIDPT',$this->CLIDPT,true);
		$criteria->compare('CLIDDD',$this->CLIDDD,true);
		$criteria->compare('CLITEL',$this->CLITEL,true);
		$criteria->compare('CLIRAM',$this->CLIRAM,true);
		$criteria->compare('CLIFAX',$this->CLIFAX,true);
		$criteria->compare('CLITEL1',$this->CLITEL1,true);
		$criteria->compare('CLIFAXRAM',$this->CLIFAXRAM,true);
		$criteria->compare('CLICOM',$this->CLICOM,true);
		$criteria->compare('CLICOMCOM',$this->CLICOMCOM);
		$criteria->compare('EMAILCON',$this->EMAILCON,true);
		$criteria->compare('COMISSAO',$this->COMISSAO,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}