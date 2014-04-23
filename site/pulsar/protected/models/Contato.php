<?php

/**
 * This is the model class for table "contato".
 *
 * The followings are the available columns in table 'contato':
 * @property string $id_contato
 * @property string $nome
 * @property string $email
 * @property string $setor
 * @property string $mensagem
 * @property string $telefone
 */
class Contato extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Contato the static model class
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
		return 'contato';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, email, setor', 'length', 'max'=>100),
			array('telefone', 'length', 'max'=>50),
			array('mensagem', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_contato, nome, email, setor, mensagem, telefone', 'safe', 'on'=>'search'),
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
			'id_contato' => 'Id Contato',
			'nome' => 'Nome',
			'email' => 'Email',
			'setor' => 'Setor',
			'mensagem' => 'Mensagem',
			'telefone' => 'Telefone',
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

		$criteria->compare('id_contato',$this->id_contato,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('setor',$this->setor,true);
		$criteria->compare('mensagem',$this->mensagem,true);
		$criteria->compare('telefone',$this->telefone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}