<?php

/**
 * This is the model class for table "tblClientes".
 *
 * The followings are the available columns in table 'tblClientes':
 * @property string $IDClientes
 * @property string $nomeCompleto
 * @property string $instituicao
 * @property string $CPF
 * @property string $CNPJ
 * @property string $endereco
 * @property string $cep
 * @property string $cidade
 * @property string $estado
 * @property string $pais
 * @property string $email
 * @property string $telefone
 * @property string $usuario
 * @property string $senha
 * @property string $qtdPedidos
 * @property string $dataCadastro
 * @property string $ultimoAcesso
 * @property string $cargo
 * @property string $totalDePesquisas
 * @property string $totalDeVisitas
 * @property integer $pessoaFisica
 */
class TblClientes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblClientes the static model class
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
		return 'tblClientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomeCompleto, endereco, cep, cidade, estado, pais, email, telefone, usuario, senha, dataCadastro, ultimoAcesso', 'required'),
			array('pessoaFisica', 'numerical', 'integerOnly'=>true),
			array('IDClientes, usuario, senha, qtdPedidos, totalDePesquisas, totalDeVisitas', 'length', 'max'=>20),
			array('nomeCompleto, instituicao, endereco', 'length', 'max'=>80),
			array('CPF', 'length', 'max'=>14),
			array('CNPJ', 'length', 'max'=>25),
			array('cep', 'length', 'max'=>10),
			array('cidade, pais', 'length', 'max'=>40),
			array('estado', 'length', 'max'=>2),
			array('email, dataCadastro, ultimoAcesso', 'length', 'max'=>50),
			array('telefone', 'length', 'max'=>15),
			array('cargo', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('IDClientes, nomeCompleto, instituicao, CPF, CNPJ, endereco, cep, cidade, estado, pais, email, telefone, usuario, senha, qtdPedidos, dataCadastro, ultimoAcesso, cargo, totalDePesquisas, totalDeVisitas, pessoaFisica', 'safe', 'on'=>'search'),
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
			'IDClientes' => 'Idclientes',
			'nomeCompleto' => 'Nome Completo',
			'instituicao' => 'Instituicao',
			'CPF' => 'Cpf',
			'CNPJ' => 'Cnpj',
			'endereco' => 'Endereco',
			'cep' => 'Cep',
			'cidade' => 'Cidade',
			'estado' => 'Estado',
			'pais' => 'Pais',
			'email' => 'Email',
			'telefone' => 'Telefone',
			'usuario' => 'Usuario',
			'senha' => 'Senha',
			'qtdPedidos' => 'Qtd Pedidos',
			'dataCadastro' => 'Data Cadastro',
			'ultimoAcesso' => 'Ultimo Acesso',
			'cargo' => 'Cargo',
			'totalDePesquisas' => 'Total De Pesquisas',
			'totalDeVisitas' => 'Total De Visitas',
			'pessoaFisica' => 'Pessoa Fisica',
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

		$criteria->compare('IDClientes',$this->IDClientes,true);
		$criteria->compare('nomeCompleto',$this->nomeCompleto,true);
		$criteria->compare('instituicao',$this->instituicao,true);
		$criteria->compare('CPF',$this->CPF,true);
		$criteria->compare('CNPJ',$this->CNPJ,true);
		$criteria->compare('endereco',$this->endereco,true);
		$criteria->compare('cep',$this->cep,true);
		$criteria->compare('cidade',$this->cidade,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('pais',$this->pais,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('telefone',$this->telefone,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('senha',$this->senha,true);
		$criteria->compare('qtdPedidos',$this->qtdPedidos,true);
		$criteria->compare('dataCadastro',$this->dataCadastro,true);
		$criteria->compare('ultimoAcesso',$this->ultimoAcesso,true);
		$criteria->compare('cargo',$this->cargo,true);
		$criteria->compare('totalDePesquisas',$this->totalDePesquisas,true);
		$criteria->compare('totalDeVisitas',$this->totalDeVisitas,true);
		$criteria->compare('pessoaFisica',$this->pessoaFisica);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}