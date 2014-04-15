<?php

/**
 * This is the model class for table "cadastro".
 *
 * The followings are the available columns in table 'cadastro':
 * @property string $id_cadastro
 * @property string $nome
 * @property string $empresa
 * @property string $cargo
 * @property string $cpf_cnpj
 * @property string $endereco
 * @property string $cep
 * @property string $cidade
 * @property string $estado
 * @property string $pais
 * @property string $telefone
 * @property string $email
 * @property string $login
 * @property string $senha
 * @property string $tipo
 * @property string $data_cadastro
 * @property string $temporario
 * @property string $download
 * @property integer $limite
 * @property string $idioma
 * @property integer $id_cliente_sig
 * @property integer $id_contato_sig
 * @property integer $int_ddd
 * @property integer $int_ddi
 * @property string $str_razao_social
 * @property integer $int_inscricao_estadual
 * @property string $tim_data_ultimo_acesso
 * @property integer $int_cnpj
 * @property integer $int_cpf
 * @property string $str_primeiro_nome
 * @property string $str_segundo_nome
 */
class CadastroExterior extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cadastro the static model class
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
		return 'cadastro';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules($intTypeRules = null)
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('senha, senha_confirma, int_ddd, int_ddi, nome, endereco, senha, str_segundo_nome, cidade, telefone, str_primeiro_nome, cep, email, email_confirma, int_tipo_newsletter, int_termo_condicao', 'required'),
			array('senha_confirma','compare','compareAttribute'=>'senha'),
			array('email_confirma','compare','compareAttribute'=>'email'),
			array('int_newsletter, int_tipo_newsletter, int_termo_condicao', 'numerical', 'integerOnly'=>true),
			array('nome, endereco, senha, senha_confirma, str_segundo_nome', 'length', 'max'=>100),
			array('cidade, telefone, str_primeiro_nome, str_complemento', 'length', 'max'=>50),
			array('cep', 'length', 'max'=>9),
			array('int_tipo_newsletter, str_numero', 'length', 'max'=>10),
			array('pais, download, idioma, int_newsletter, int_termo_condicao', 'length', 'max'=>2),
			array('email, email_confirma','email'),
			array('data_cadastro', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_cadastro, nome, empresa, cargo, endereco, cep, cidade, estado, pais, telefone, email, email_confirma, login, senha, senha_confirma, tipo, data_cadastro, temporario, download, limite, idioma, id_cliente_sig, id_contato_sig, int_ddi, tim_data_ultimo_acesso, str_primeiro_nome, str_segundo_nome, int_newsletter, int_tipo_newsletter, int_termo_condicao', 'safe', 'on'=>'search'),
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
			'int_ddi' => Yii::t('zii', 'DDI'),
			'nome' => Yii::t('zii', 'Name'),
			'endereco' => Yii::t('zii', 'Address'),
			'senha' => Yii::t('zii', 'Password'), 
			'senha_confirma' => Yii::t('zii', 'Password confirmation'),
			'str_segundo_nome' => Yii::t('zii', 'Last name'),
			'cidade' => Yii::t('zii', 'City'),
			'telefone' => Yii::t('zii', 'Phone'),
			'str_primeiro_nome' => Yii::t('zii', 'First name'),
			'cep' => Yii::t('zii', 'Postal code'),
			'pais' => Yii::t('zii', 'Country'),
			'email' => Yii::t('zii', 'Email'),
			'email_confirma' => Yii::t('zii', 'Confirm email'),
			'login' => Yii::t('zii', 'Login'),
			'id_cadastro' => Yii::t('zii', 'Id reistration'),
			'data_cadastro' => Yii::t('zii', 'Date registration'),
			'tim_data_ultimo_acesso' => Yii::t('zii', 'Date of last access'),
			'int_newsletter' => Yii::t('zii', 'Newsletter'), 
			'int_tipo_newsletter' => Yii::t('zii', 'Type of newsletter'), 
			'int_termo_condicao' => Yii::t('zii', 'Yes, I declare that I have read and agree to the terms and conditions'),
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

		$criteria->compare('id_cadastro',$this->id_cadastro,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('empresa',$this->empresa,true);
		$criteria->compare('cargo',$this->cargo,true);
		$criteria->compare('cpf_cnpj',$this->cpf_cnpj,true);
		$criteria->compare('endereco',$this->endereco,true);
		$criteria->compare('cep',$this->cep,true);
		$criteria->compare('cidade',$this->cidade,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('pais',$this->pais,true);
		$criteria->compare('telefone',$this->telefone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('senha',$this->senha,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('data_cadastro',$this->data_cadastro,true);
		$criteria->compare('temporario',$this->temporario,true);
		$criteria->compare('download',$this->download,true);
		$criteria->compare('limite',$this->limite);
		$criteria->compare('idioma',$this->idioma,true);
		$criteria->compare('id_cliente_sig',$this->id_cliente_sig);
		$criteria->compare('id_contato_sig',$this->id_contato_sig);
		$criteria->compare('int_ddd',$this->int_ddd);
		$criteria->compare('int_ddi',$this->int_ddi);
		$criteria->compare('str_razao_social',$this->str_razao_social,true);
		$criteria->compare('int_inscricao_estadual',$this->int_inscricao_estadual);
		$criteria->compare('tim_data_ultimo_acesso',$this->tim_data_ultimo_acesso,true);
		$criteria->compare('int_cnpj',$this->int_cnpj);
		$criteria->compare('int_cpf',$this->int_cpf);
		$criteria->compare('str_primeiro_nome',$this->str_primeiro_nome,true);
		$criteria->compare('str_segundo_nome',$this->str_segundo_nome,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}