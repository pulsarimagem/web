<?php

/**
 * This is the model class for table "CONTATOS".
 *
 * The followings are the available columns in table 'CONTATOS':
 * @property integer $ID
 * @property integer $ID_CLIENTE
 * @property string $CONTATO
 * @property string $DPT
 * @property string $EMAIL
 * @property string $TEL_CONTATO
 * @property string $RAMAL
 * @property string $COMISSAO
 */
class CONTATOS extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CONTATOS the static model class
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
		return 'CONTATOS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_CLIENTE', 'numerical', 'integerOnly'=>true),
			array('CONTATO, DPT', 'length', 'max'=>50),
			array('EMAIL', 'length', 'max'=>100),
			array('TEL_CONTATO, RAMAL', 'length', 'max'=>20),
			array('COMISSAO', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, ID_CLIENTE, CONTATO, DPT, EMAIL, TEL_CONTATO, RAMAL, COMISSAO', 'safe', 'on'=>'search'),
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
			'ID_CLIENTE' => 'Id Cliente',
			'CONTATO' => 'Contato',
			'DPT' => 'Dpt',
			'EMAIL' => 'Email',
			'TEL_CONTATO' => 'Tel Contato',
			'RAMAL' => 'Ramal',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('ID_CLIENTE',$this->ID_CLIENTE);
		$criteria->compare('CONTATO',$this->CONTATO,true);
		$criteria->compare('DPT',$this->DPT,true);
		$criteria->compare('EMAIL',$this->EMAIL,true);
		$criteria->compare('TEL_CONTATO',$this->TEL_CONTATO,true);
		$criteria->compare('RAMAL',$this->RAMAL,true);
		$criteria->compare('COMISSAO',$this->COMISSAO,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}