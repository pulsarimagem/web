<?php

/**
 * This is the model class for table "Fotos_PR".
 *
 * The followings are the available columns in table 'Fotos_PR':
 * @property integer $Id_Foto
 * @property string $tombo
 * @property integer $id_autor
 * @property string $data_foto
 * @property string $cidade
 * @property integer $id_estado
 * @property string $id_pais
 * @property string $orientacao
 * @property string $assunto_principal
 */
class FotosPR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FotosPR the static model class
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
		return 'Fotos_PR';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tombo', 'required'),
			array('id_autor, id_estado', 'numerical', 'integerOnly'=>true),
			array('tombo', 'length', 'max'=>15),
			array('data_foto', 'length', 'max'=>10),
			array('cidade', 'length', 'max'=>50),
			array('id_pais', 'length', 'max'=>3),
			array('orientacao', 'length', 'max'=>1),
			array('assunto_principal', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id_Foto, tombo, id_autor, data_foto, cidade, id_estado, id_pais, orientacao, assunto_principal', 'safe', 'on'=>'search'),
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
			'Id_Foto' => 'Id Foto',
			'tombo' => 'Tombo',
			'id_autor' => 'Id Autor',
			'data_foto' => 'Data Foto',
			'cidade' => 'Cidade',
			'id_estado' => 'Id Estado',
			'id_pais' => 'Id Pais',
			'orientacao' => 'Orientacao',
			'assunto_principal' => 'Assunto Principal',
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

		$criteria->compare('Id_Foto',$this->Id_Foto);
		$criteria->compare('tombo',$this->tombo,true);
		$criteria->compare('id_autor',$this->id_autor);
		$criteria->compare('data_foto',$this->data_foto,true);
		$criteria->compare('cidade',$this->cidade,true);
		$criteria->compare('id_estado',$this->id_estado);
		$criteria->compare('id_pais',$this->id_pais,true);
		$criteria->compare('orientacao',$this->orientacao,true);
		$criteria->compare('assunto_principal',$this->assunto_principal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}