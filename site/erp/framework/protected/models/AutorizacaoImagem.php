<?php

/**
 * This is the model class for table "autorizacao_imagem".
 *
 * The followings are the available columns in table 'autorizacao_imagem':
 * @property integer $id_autorizacao_imagem
 * @property string $str_sigla_autor
 * @property string $str_descricao
 * @property string $str_nome_arquivo_autorizacao
 * @property string $str_autorizado_por
 * @property string $str_codigo_foto
 * @property string $dat_data
 * @property string $str_cidade
 * @property string $str_estado
 */
class AutorizacaoImagem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AutorizacaoImagem the static model class
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
		return 'autorizacao_imagem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('str_sigla_autor, str_nome_arquivo_autorizacao', 'required'),
			array('str_sigla_autor', 'length', 'max'=>3),
			array('str_nome_arquivo_autorizacao, str_autorizado_por', 'length', 'max'=>255),
			array('str_codigo_foto', 'length', 'max'=>10),
			array('dat_data', 'length', 'max'=>7),
			array('str_cidade', 'length', 'max'=>150),
			array('str_estado', 'length', 'max'=>20),
			array('str_descricao', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_autorizacao_imagem, str_sigla_autor, str_descricao, str_nome_arquivo_autorizacao, str_autorizado_por, str_codigo_foto, dat_data, str_cidade, str_estado', 'safe', 'on'=>'search'),
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
			'id_autorizacao_imagem' => utf8_decode('Código da autorização'),
			'str_sigla_autor' => utf8_decode('Sigla autor'),
			'str_descricao' => utf8_decode('Descrição'),
			'str_nome_arquivo_autorizacao' => utf8_decode('Nome do arquivo'),
			'str_autorizado_por' => utf8_decode('Autorizado por'),
			'str_codigo_foto' => utf8_decode('Str Código da foto'),
			'dat_data' => utf8_decode('Data'),
			'str_cidade' => utf8_decode('Cidade'),
			'str_estado' => utf8_decode('Estado'),
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

		$criteria->compare('id_autorizacao_imagem',$this->id_autorizacao_imagem);
		$criteria->compare('str_sigla_autor',$this->str_sigla_autor,true);
		$criteria->compare('str_descricao',$this->str_descricao,true);
		$criteria->compare('str_nome_arquivo_autorizacao',$this->str_nome_arquivo_autorizacao,true);
		$criteria->compare('str_autorizado_por',$this->str_autorizado_por,true);
		$criteria->compare('str_codigo_foto',$this->str_codigo_foto,true);
		$criteria->compare('dat_data',$this->dat_data,true);
		$criteria->compare('str_cidade',$this->str_cidade,true);
		$criteria->compare('str_estado',$this->str_estado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}