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
class Cadastro extends CActiveRecord
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
			array('senha, tim_data_ultimo_acesso', 'required'),
			array('limite, id_cliente_sig, id_contato_sig, int_ddd, int_ddi, int_inscricao_estadual, int_cnpj, int_cpf', 'numerical', 'integerOnly'=>true),
			array('nome, empresa, endereco, senha, str_razao_social, str_segundo_nome', 'length', 'max'=>100),
			array('cargo, cidade, telefone, str_primeiro_nome', 'length', 'max'=>50),
			array('cpf_cnpj', 'length', 'max'=>20),
			array('cep', 'length', 'max'=>9),
			array('estado, pais, download, idioma', 'length', 'max'=>2),
			array('email, login', 'length', 'max'=>80),
			array('tipo, temporario', 'length', 'max'=>1),
			array('data_cadastro', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_cadastro, nome, empresa, cargo, cpf_cnpj, endereco, cep, cidade, estado, pais, telefone, email, login, senha, tipo, data_cadastro, temporario, download, limite, idioma, id_cliente_sig, id_contato_sig, int_ddd, int_ddi, str_razao_social, int_inscricao_estadual, tim_data_ultimo_acesso, int_cnpj, int_cpf, str_primeiro_nome, str_segundo_nome', 'safe', 'on'=>'search'),
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
			'id_cadastro' => 'Id Cadastro',
			'nome' => 'Nome',
			'empresa' => 'Empresa',
			'cargo' => 'Cargo',
			'cpf_cnpj' => 'Cpf Cnpj',
			'endereco' => 'Endereco',
			'cep' => 'Cep',
			'cidade' => 'Cidade',
			'estado' => 'Estado',
			'pais' => 'Pais',
			'telefone' => 'Telefone',
			'email' => 'Email',
			'login' => 'Login',
			'senha' => 'Senha',
			'tipo' => 'Tipo',
			'data_cadastro' => 'Data Cadastro',
			'temporario' => 'Temporario',
			'download' => 'Download',
			'limite' => 'Limite',
			'idioma' => 'Idioma',
			'id_cliente_sig' => 'Id Cliente Sig',
			'id_contato_sig' => 'Id Contato Sig',
			'int_ddd' => 'Int Ddd',
			'int_ddi' => 'Int Ddi',
			'str_razao_social' => 'Str Razao Social',
			'int_inscricao_estadual' => 'Int Inscricao Estadual',
			'tim_data_ultimo_acesso' => 'Tim Data Ultimo Acesso',
			'int_cnpj' => 'Int Cnpj',
			'int_cpf' => 'Int Cpf',
			'str_primeiro_nome' => 'Str Primeiro Nome',
			'str_segundo_nome' => 'Str Segundo Nome',
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