<?php

/**
 * This is the model class for table "AUTORES_OFC".
 *
 * The followings are the available columns in table 'AUTORES_OFC':
 * @property integer $ID
 * @property string $NOME
 * @property string $NOME_COMPLETO
 * @property string $SIGLA
 * @property string $CPF
 * @property string $CNPJ
 * @property string $ENDERECO
 * @property string $BAIRRO
 * @property string $CIDADE
 * @property string $ESTADO
 * @property string $CEP
 * @property string $ZIPCODE
 * @property string $TELEFONE
 * @property string $CELULAR
 * @property string $EMAIL
 * @property string $COMISSAO
 * @property string $OBS
 * @property string $BANCO
 * @property string $AGENCIA
 * @property string $CONTA
 * @property string $STATUS
 */
class AUTORESOFC extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AUTORESOFC the static model class
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
		return 'AUTORES_OFC';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NOME, NOME_COMPLETO, ENDERECO, EMAIL', 'length', 'max'=>100),
			array('SIGLA, CEP, AGENCIA, STATUS', 'length', 'max'=>10),
			array('CPF, CNPJ', 'length', 'max'=>20),
			array('BAIRRO, CIDADE, BANCO', 'length', 'max'=>50),
			array('ESTADO, COMISSAO', 'length', 'max'=>2),
			array('ZIPCODE, TELEFONE, CELULAR, CONTA', 'length', 'max'=>15),
			array('OBS', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, NOME, NOME_COMPLETO, SIGLA, CPF, CNPJ, ENDERECO, BAIRRO, CIDADE, ESTADO, CEP, ZIPCODE, TELEFONE, CELULAR, EMAIL, COMISSAO, OBS, BANCO, AGENCIA, CONTA, STATUS', 'safe', 'on'=>'search'),
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
			'NOME' => 'Nome',
			'NOME_COMPLETO' => 'Nome Completo',
			'SIGLA' => 'Sigla',
			'CPF' => 'Cpf',
			'CNPJ' => 'Cnpj',
			'ENDERECO' => 'Endereco',
			'BAIRRO' => 'Bairro',
			'CIDADE' => 'Cidade',
			'ESTADO' => 'Estado',
			'CEP' => 'Cep',
			'ZIPCODE' => 'Zipcode',
			'TELEFONE' => 'Telefone',
			'CELULAR' => 'Celular',
			'EMAIL' => 'Email',
			'COMISSAO' => 'Comissao',
			'OBS' => 'Obs',
			'BANCO' => 'Banco',
			'AGENCIA' => 'Agencia',
			'CONTA' => 'Conta',
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
		$criteria->compare('NOME',$this->NOME,true);
		$criteria->compare('NOME_COMPLETO',$this->NOME_COMPLETO,true);
		$criteria->compare('SIGLA',$this->SIGLA,true);
		$criteria->compare('CPF',$this->CPF,true);
		$criteria->compare('CNPJ',$this->CNPJ,true);
		$criteria->compare('ENDERECO',$this->ENDERECO,true);
		$criteria->compare('BAIRRO',$this->BAIRRO,true);
		$criteria->compare('CIDADE',$this->CIDADE,true);
		$criteria->compare('ESTADO',$this->ESTADO,true);
		$criteria->compare('CEP',$this->CEP,true);
		$criteria->compare('ZIPCODE',$this->ZIPCODE,true);
		$criteria->compare('TELEFONE',$this->TELEFONE,true);
		$criteria->compare('CELULAR',$this->CELULAR,true);
		$criteria->compare('EMAIL',$this->EMAIL,true);
		$criteria->compare('COMISSAO',$this->COMISSAO,true);
		$criteria->compare('OBS',$this->OBS,true);
		$criteria->compare('BANCO',$this->BANCO,true);
		$criteria->compare('AGENCIA',$this->AGENCIA,true);
		$criteria->compare('CONTA',$this->CONTA,true);
		$criteria->compare('STATUS',$this->STATUS,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}