<?php

/**
 * This is the model class for table "codigo_video".
 *
 * The followings are the available columns in table 'codigo_video':
 * @property string $autor
 * @property integer $ano
 * @property integer $contador
 * @property string $codigo
 * @property string $arquivo
 * @property string $data
 * @property integer $status
 */
class CodigoVideo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CodigoVideo the static model class
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
		return 'codigo_video';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('autor, ano, data', 'required'),
			array('ano, contador, status', 'numerical', 'integerOnly'=>true),
			array('autor', 'length', 'max'=>5),
			array('codigo', 'length', 'max'=>11),
			array('arquivo', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('autor, ano, contador, codigo, arquivo, data, status', 'safe', 'on'=>'search'),
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
			'autor' => 'Autor',
			'ano' => 'Ano',
			'contador' => 'Contador',
			'codigo' => 'Codigo',
			'arquivo' => 'Arquivo',
			'data' => 'Data',
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

		$criteria->compare('autor',$this->autor,true);
		$criteria->compare('ano',$this->ano);
		$criteria->compare('contador',$this->contador);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('arquivo',$this->arquivo,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}