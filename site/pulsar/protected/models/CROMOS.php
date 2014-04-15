<?php

/**
 * This is the model class for table "CROMOS".
 *
 * The followings are the available columns in table 'CROMOS':
 * @property integer $ID
 * @property integer $ID_CONTRATO
 * @property integer $ID_USO
 * @property string $CODIGO
 * @property string $ASSUNTO
 * @property string $AUTOR
 * @property string $VALOR
 * @property string $DESCONTO
 * @property string $VALOR_FINAL
 * @property string $finalizado
 */
class CROMOS extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CROMOS the static model class
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
		return 'CROMOS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_CONTRATO', 'required'),
			array('ID_CONTRATO, ID_USO', 'numerical', 'integerOnly'=>true),
			array('CODIGO', 'length', 'max'=>20),
			array('ASSUNTO, AUTOR', 'length', 'max'=>100),
			array('VALOR, DESCONTO, VALOR_FINAL', 'length', 'max'=>10),
			array('finalizado', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, ID_CONTRATO, ID_USO, CODIGO, ASSUNTO, AUTOR, VALOR, DESCONTO, VALOR_FINAL, finalizado', 'safe', 'on'=>'search'),
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
			'ID_CONTRATO' => 'Id Contrato',
			'ID_USO' => 'Id Uso',
			'CODIGO' => 'Codigo',
			'ASSUNTO' => 'Assunto',
			'AUTOR' => 'Autor',
			'VALOR' => 'Valor',
			'DESCONTO' => 'Desconto',
			'VALOR_FINAL' => 'Valor Final',
			'finalizado' => 'Finalizado',
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
		$criteria->compare('ID_CONTRATO',$this->ID_CONTRATO);
		$criteria->compare('ID_USO',$this->ID_USO);
		$criteria->compare('CODIGO',$this->CODIGO,true);
		$criteria->compare('ASSUNTO',$this->ASSUNTO,true);
		$criteria->compare('AUTOR',$this->AUTOR,true);
		$criteria->compare('VALOR',$this->VALOR,true);
		$criteria->compare('DESCONTO',$this->DESCONTO,true);
		$criteria->compare('VALOR_FINAL',$this->VALOR_FINAL,true);
		$criteria->compare('finalizado',$this->finalizado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}