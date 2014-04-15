<?php

/**
 * This is the model class for table "ftp_arquivos".
 *
 * The followings are the available columns in table 'ftp_arquivos':
 * @property integer $id_arquivo
 * @property string $nome
 * @property string $data_cria
 * @property integer $validade
 * @property string $observacoes
 * @property integer $id_ftp
 * @property double $tamanho
 * @property string $flag
 */
class FtpArquivos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FtpArquivos the static model class
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
		return 'ftp_arquivos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome', 'required'),
			array('validade, id_ftp', 'numerical', 'integerOnly'=>true),
			array('tamanho', 'numerical'),
			array('nome', 'length', 'max'=>50),
			array('observacoes', 'length', 'max'=>250),
			array('flag', 'length', 'max'=>2),
			array('data_cria', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_arquivo, nome, data_cria, validade, observacoes, id_ftp, tamanho, flag', 'safe', 'on'=>'search'),
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
			'id_arquivo' => 'Id Arquivo',
			'nome' => 'Nome',
			'data_cria' => 'Data Cria',
			'validade' => 'Validade',
			'observacoes' => 'Observacoes',
			'id_ftp' => 'Id Ftp',
			'tamanho' => 'Tamanho',
			'flag' => 'Flag',
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

		$criteria->compare('id_arquivo',$this->id_arquivo);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('data_cria',$this->data_cria,true);
		$criteria->compare('validade',$this->validade);
		$criteria->compare('observacoes',$this->observacoes,true);
		$criteria->compare('id_ftp',$this->id_ftp);
		$criteria->compare('tamanho',$this->tamanho);
		$criteria->compare('flag',$this->flag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}