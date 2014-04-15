<?php

/**
 * This is the model class for table "Fotos".
 *
 * The followings are the available columns in table 'Fotos':
 * @property integer $Id_Foto
 * @property string $tombo
 * @property integer $id_autor
 * @property string $data_foto
 * @property string $cidade
 * @property integer $id_estado
 * @property string $id_pais
 * @property string $orientacao
 * @property string $assunto_principal
 * @property integer $dim_a
 * @property integer $dim_b
 * @property integer $direito_img
 * @property string $extra
 * @property string $assunto_en
 */
class Fotos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Fotos the static model class
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
		return 'Fotos';
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
			array('id_autor, id_estado, dim_a, dim_b, direito_img', 'numerical', 'integerOnly'=>true),
			array('tombo', 'length', 'max'=>15),
			array('data_foto', 'length', 'max'=>10),
			array('cidade', 'length', 'max'=>50),
			array('id_pais', 'length', 'max'=>3),
			array('orientacao', 'length', 'max'=>1),
			array('assunto_principal', 'length', 'max'=>100),
			array('assunto_en', 'length', 'max'=>150),
			array('extra', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id_Foto, tombo, id_autor, data_foto, cidade, id_estado, id_pais, orientacao, assunto_principal, dim_a, dim_b, direito_img, extra, assunto_en', 'safe', 'on'=>'search'),
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
			'dim_a' => 'Dim A',
			'dim_b' => 'Dim B',
			'direito_img' => 'Direito Img',
			'extra' => 'Extra',
			'assunto_en' => 'Assunto En',
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
		$criteria->compare('dim_a',$this->dim_a);
		$criteria->compare('dim_b',$this->dim_b);
		$criteria->compare('direito_img',$this->direito_img);
		$criteria->compare('extra',$this->extra,true);
		$criteria->compare('assunto_en',$this->assunto_en,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}