<?php

/**
 * This is the model class for table "pesquisa_tema".
 *
 * The followings are the available columns in table 'pesquisa_tema':
 * @property integer $id_tm
 * @property integer $tema
 * @property integer $retorno
 * @property string $datahora
 */
class PesquisaTema extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesquisaTema the static model class
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
		return 'pesquisa_tema';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tema, retorno', 'numerical', 'integerOnly'=>true),
			array('datahora', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_tm, tema, retorno, datahora', 'safe', 'on'=>'search'),
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
			'id_tm' => 'Id Tm',
			'tema' => 'Tema',
			'retorno' => 'Retorno',
			'datahora' => 'Datahora',
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

		$criteria->compare('id_tm',$this->id_tm);
		$criteria->compare('tema',$this->tema);
		$criteria->compare('retorno',$this->retorno);
		$criteria->compare('datahora',$this->datahora,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}