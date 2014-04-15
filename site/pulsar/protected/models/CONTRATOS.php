<?php

/**
 * This is the model class for table "CONTRATOS".
 *
 * The followings are the available columns in table 'CONTRATOS':
 * @property integer $ID
 * @property integer $ID_CLIENTE
 * @property string $cnpj
 * @property integer $ID_CONTATO
 * @property string $DESCRICAO
 * @property string $DATA
 * @property string $VALOR_TOTAL
 * @property string $DATA_PAGTO
 * @property string $NOTA_FISCAL
 * @property string $FINALIZADO
 * @property string $BAIXADO
 * @property integer $ID_CONTRATO_DESC
 */
class CONTRATOS extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CONTRATOS the static model class
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
		return 'CONTRATOS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_CLIENTE, ID_CONTATO, ID_CONTRATO_DESC', 'numerical', 'integerOnly'=>true),
			array('cnpj', 'length', 'max'=>18),
			array('DESCRICAO', 'length', 'max'=>300),
			array('VALOR_TOTAL, DATA_PAGTO, NOTA_FISCAL', 'length', 'max'=>10),
			array('FINALIZADO, BAIXADO', 'length', 'max'=>5),
			array('DATA', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, ID_CLIENTE, cnpj, ID_CONTATO, DESCRICAO, DATA, VALOR_TOTAL, DATA_PAGTO, NOTA_FISCAL, FINALIZADO, BAIXADO, ID_CONTRATO_DESC', 'safe', 'on'=>'search'),
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
			'cnpj' => 'Cnpj',
			'ID_CONTATO' => 'Id Contato',
			'DESCRICAO' => 'Descricao',
			'DATA' => 'Data',
			'VALOR_TOTAL' => 'Valor Total',
			'DATA_PAGTO' => 'Data Pagto',
			'NOTA_FISCAL' => 'Nota Fiscal',
			'FINALIZADO' => 'Finalizado',
			'BAIXADO' => 'Baixado',
			'ID_CONTRATO_DESC' => 'Id Contrato Desc',
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
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('ID_CONTATO',$this->ID_CONTATO);
		$criteria->compare('DESCRICAO',$this->DESCRICAO,true);
		$criteria->compare('DATA',$this->DATA,true);
		$criteria->compare('VALOR_TOTAL',$this->VALOR_TOTAL,true);
		$criteria->compare('DATA_PAGTO',$this->DATA_PAGTO,true);
		$criteria->compare('NOTA_FISCAL',$this->NOTA_FISCAL,true);
		$criteria->compare('FINALIZADO',$this->FINALIZADO,true);
		$criteria->compare('BAIXADO',$this->BAIXADO,true);
		$criteria->compare('ID_CONTRATO_DESC',$this->ID_CONTRATO_DESC);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}