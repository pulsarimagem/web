<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property integer $id_user
 * @property string $login
 * @property string $senha
 * @property integer $index_inc
 * @property integer $index_alt
 * @property integer $index_del
 * @property integer $temas
 * @property integer $pal_chave
 * @property integer $home
 * @property integer $ensaios
 * @property integer $cotacao
 * @property integer $cad_clientes
 * @property integer $cad_usuarios
 * @property integer $fotografos
 * @property integer $ftp
 * @property integer $enviar_msg
 * @property integer $rel_download
 * @property integer $relatorios
 * @property string $email
 * @property integer $download
 * @property integer $fotos_idx
 */
class Usuarios extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
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
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, senha', 'required'),
			array('index_inc, index_alt, index_del, temas, pal_chave, home, ensaios, cotacao, cad_clientes, cad_usuarios, fotografos, ftp, enviar_msg, rel_download, relatorios, download, fotos_idx', 'numerical', 'integerOnly'=>true),
			array('login, senha', 'length', 'max'=>15),
			array('email', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_user, login, senha, index_inc, index_alt, index_del, temas, pal_chave, home, ensaios, cotacao, cad_clientes, cad_usuarios, fotografos, ftp, enviar_msg, rel_download, relatorios, email, download, fotos_idx', 'safe', 'on'=>'search'),
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
			'id_user' => 'Id User',
			'login' => 'Login',
			'senha' => 'Senha',
			'index_inc' => 'Index Inc',
			'index_alt' => 'Index Alt',
			'index_del' => 'Index Del',
			'temas' => 'Temas',
			'pal_chave' => 'Pal Chave',
			'home' => 'Home',
			'ensaios' => 'Ensaios',
			'cotacao' => 'Cotacao',
			'cad_clientes' => 'Cad Clientes',
			'cad_usuarios' => 'Cad Usuarios',
			'fotografos' => 'Fotografos',
			'ftp' => 'Ftp',
			'enviar_msg' => 'Enviar Msg',
			'rel_download' => 'Rel Download',
			'relatorios' => 'Relatorios',
			'email' => 'Email',
			'download' => 'Download',
			'fotos_idx' => 'Fotos Idx',
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

		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('senha',$this->senha,true);
		$criteria->compare('index_inc',$this->index_inc);
		$criteria->compare('index_alt',$this->index_alt);
		$criteria->compare('index_del',$this->index_del);
		$criteria->compare('temas',$this->temas);
		$criteria->compare('pal_chave',$this->pal_chave);
		$criteria->compare('home',$this->home);
		$criteria->compare('ensaios',$this->ensaios);
		$criteria->compare('cotacao',$this->cotacao);
		$criteria->compare('cad_clientes',$this->cad_clientes);
		$criteria->compare('cad_usuarios',$this->cad_usuarios);
		$criteria->compare('fotografos',$this->fotografos);
		$criteria->compare('ftp',$this->ftp);
		$criteria->compare('enviar_msg',$this->enviar_msg);
		$criteria->compare('rel_download',$this->rel_download);
		$criteria->compare('relatorios',$this->relatorios);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('download',$this->download);
		$criteria->compare('fotos_idx',$this->fotos_idx);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}