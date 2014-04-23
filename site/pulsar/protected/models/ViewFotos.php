<?php

/**
 * This is the model class for table "viewFotos".
 *
 * The followings are the available columns in table 'viewFotos':
 * @property string $Tombo
 * @property string $Nome_Fotografo
 * @property string $Iniciais_Fotografo
 * @property string $Data_Foto
 * @property string $Cidade
 * @property string $Sigla
 * @property string $Estado
 * @property string $Pais
 * @property string $Assunto_Principal
 */
class ViewFotos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ViewFotos the static model class
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
		return 'viewFotos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Tombo', 'required'),
			array('Tombo', 'length', 'max'=>15),
			array('Nome_Fotografo, Cidade, Pais', 'length', 'max'=>50),
			array('Iniciais_Fotografo', 'length', 'max'=>5),
			array('Data_Foto', 'length', 'max'=>10),
			array('Sigla', 'length', 'max'=>2),
			array('Estado', 'length', 'max'=>25),
			array('Assunto_Principal', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Tombo, Nome_Fotografo, Iniciais_Fotografo, Data_Foto, Cidade, Sigla, Estado, Pais, Assunto_Principal', 'safe', 'on'=>'search'),
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
			'Tombo' => 'Tombo',
			'Nome_Fotografo' => 'Nome Fotografo',
			'Iniciais_Fotografo' => 'Iniciais Fotografo',
			'Data_Foto' => 'Data Foto',
			'Cidade' => 'Cidade',
			'Sigla' => 'Sigla',
			'Estado' => 'Estado',
			'Pais' => 'Pais',
			'Assunto_Principal' => 'Assunto Principal',
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

		$criteria->compare('Tombo',$this->Tombo,true);
		$criteria->compare('Nome_Fotografo',$this->Nome_Fotografo,true);
		$criteria->compare('Iniciais_Fotografo',$this->Iniciais_Fotografo,true);
		$criteria->compare('Data_Foto',$this->Data_Foto,true);
		$criteria->compare('Cidade',$this->Cidade,true);
		$criteria->compare('Sigla',$this->Sigla,true);
		$criteria->compare('Estado',$this->Estado,true);
		$criteria->compare('Pais',$this->Pais,true);
		$criteria->compare('Assunto_Principal',$this->Assunto_Principal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}