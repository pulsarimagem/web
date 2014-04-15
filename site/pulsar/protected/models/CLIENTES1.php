<?php

/**
 * This is the model class for table "CLIENTES1".
 *
 * The followings are the available columns in table 'CLIENTES1':
 * @property string $CLICGC
 * @property string $CLINOM
 * @property string $CLINOMFAN
 * @property string $CLIINSEST
 * @property string $CLIOBS
 * @property string $CLIDTAINI
 * @property string $CLIESP
 * @property string $CLIUSERID
 * @property string $CLIDTAATU
 * @property string $CLIDTAVAL
 * @property string $CLITIP
 * @property string $CLICONPAG
 * @property string $CLIEMAIL
 */
class CLIENTES1 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CLIENTES1 the static model class
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
		return 'CLIENTES1';
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
			array('CLINOM, CLINOMFAN', 'length', 'max'=>80),
			array('CLIINSEST', 'length', 'max'=>15),
			array('CLIOBS', 'length', 'max'=>100),
			array('CLIDTAINI, CLIDTAATU, CLIDTAVAL', 'length', 'max'=>10),
			array('CLIESP, CLITIP', 'length', 'max'=>1),
			array('CLIUSERID', 'length', 'max'=>12),
			array('CLICONPAG', 'length', 'max'=>25),
			array('CLIEMAIL', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('CLICGC, CLINOM, CLINOMFAN, CLIINSEST, CLIOBS, CLIDTAINI, CLIESP, CLIUSERID, CLIDTAATU, CLIDTAVAL, CLITIP, CLICONPAG, CLIEMAIL', 'safe', 'on'=>'search'),
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
			'CLINOM' => 'Clinom',
			'CLINOMFAN' => 'Clinomfan',
			'CLIINSEST' => 'Cliinsest',
			'CLIOBS' => 'Cliobs',
			'CLIDTAINI' => 'Clidtaini',
			'CLIESP' => 'Cliesp',
			'CLIUSERID' => 'Cliuserid',
			'CLIDTAATU' => 'Clidtaatu',
			'CLIDTAVAL' => 'Clidtaval',
			'CLITIP' => 'Clitip',
			'CLICONPAG' => 'Cliconpag',
			'CLIEMAIL' => 'Cliemail',
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
		$criteria->compare('CLINOM',$this->CLINOM,true);
		$criteria->compare('CLINOMFAN',$this->CLINOMFAN,true);
		$criteria->compare('CLIINSEST',$this->CLIINSEST,true);
		$criteria->compare('CLIOBS',$this->CLIOBS,true);
		$criteria->compare('CLIDTAINI',$this->CLIDTAINI,true);
		$criteria->compare('CLIESP',$this->CLIESP,true);
		$criteria->compare('CLIUSERID',$this->CLIUSERID,true);
		$criteria->compare('CLIDTAATU',$this->CLIDTAATU,true);
		$criteria->compare('CLIDTAVAL',$this->CLIDTAVAL,true);
		$criteria->compare('CLITIP',$this->CLITIP,true);
		$criteria->compare('CLICONPAG',$this->CLICONPAG,true);
		$criteria->compare('CLIEMAIL',$this->CLIEMAIL,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}