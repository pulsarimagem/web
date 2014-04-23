<?php

/**
 * This is the model class for table "CLIENTES".
 *
 * The followings are the available columns in table 'CLIENTES':
 * @property integer $ID
 * @property string $CNPJ
 * @property string $RAZAO
 * @property string $FANTASIA
 * @property string $INSCRICAO
 * @property string $ENDERECO
 * @property string $BAIRRO
 * @property string $CEP
 * @property string $CIDADE
 * @property string $ESTADO
 * @property string $TELEFONE
 * @property string $FAX
 * @property string $ENDERECO_COB
 * @property string $BAIRRO_COB
 * @property string $CEP_COB
 * @property string $CIDADE_COB
 * @property string $ESTADO_COB
 * @property string $DESDE
 * @property string $OBS
 * @property string $STATUS
 */
class CLIENTES extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CLIENTES the static model class
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
		return 'CLIENTES';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CNPJ, INSCRICAO, TELEFONE, FAX, DESDE', 'length', 'max'=>20),
			array('RAZAO, FANTASIA, ENDERECO, ENDERECO_COB', 'length', 'max'=>100),
			array('BAIRRO, CIDADE, ESTADO, BAIRRO_COB, CIDADE_COB, ESTADO_COB', 'length', 'max'=>50),
			array('CEP, CEP_COB, STATUS', 'length', 'max'=>10),
			array('OBS', 'length', 'max'=>1000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, CNPJ, RAZAO, FANTASIA, INSCRICAO, ENDERECO, BAIRRO, CEP, CIDADE, ESTADO, TELEFONE, FAX, ENDERECO_COB, BAIRRO_COB, CEP_COB, CIDADE_COB, ESTADO_COB, DESDE, OBS, STATUS', 'safe', 'on'=>'search'),
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
			'CNPJ' => 'Cnpj',
			'RAZAO' => 'Razao',
			'FANTASIA' => 'Fantasia',
			'INSCRICAO' => 'Inscricao',
			'ENDERECO' => 'Endereco',
			'BAIRRO' => 'Bairro',
			'CEP' => 'Cep',
			'CIDADE' => 'Cidade',
			'ESTADO' => 'Estado',
			'TELEFONE' => 'Telefone',
			'FAX' => 'Fax',
			'ENDERECO_COB' => 'Endereco Cob',
			'BAIRRO_COB' => 'Bairro Cob',
			'CEP_COB' => 'Cep Cob',
			'CIDADE_COB' => 'Cidade Cob',
			'ESTADO_COB' => 'Estado Cob',
			'DESDE' => 'Desde',
			'OBS' => 'Obs',
			'STATUS' => 'Status',
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
		$criteria->compare('CNPJ',$this->CNPJ,true);
		$criteria->compare('RAZAO',$this->RAZAO,true);
		$criteria->compare('FANTASIA',$this->FANTASIA,true);
		$criteria->compare('INSCRICAO',$this->INSCRICAO,true);
		$criteria->compare('ENDERECO',$this->ENDERECO,true);
		$criteria->compare('BAIRRO',$this->BAIRRO,true);
		$criteria->compare('CEP',$this->CEP,true);
		$criteria->compare('CIDADE',$this->CIDADE,true);
		$criteria->compare('ESTADO',$this->ESTADO,true);
		$criteria->compare('TELEFONE',$this->TELEFONE,true);
		$criteria->compare('FAX',$this->FAX,true);
		$criteria->compare('ENDERECO_COB',$this->ENDERECO_COB,true);
		$criteria->compare('BAIRRO_COB',$this->BAIRRO_COB,true);
		$criteria->compare('CEP_COB',$this->CEP_COB,true);
		$criteria->compare('CIDADE_COB',$this->CIDADE_COB,true);
		$criteria->compare('ESTADO_COB',$this->ESTADO_COB,true);
		$criteria->compare('DESDE',$this->DESDE,true);
		$criteria->compare('OBS',$this->OBS,true);
		$criteria->compare('STATUS',$this->STATUS,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}