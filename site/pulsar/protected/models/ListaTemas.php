<?php

/**
 * This is the model class for table "lista_temas".
 *
 * The followings are the available columns in table 'lista_temas':
 * @property integer $id_lista
 * @property integer $id_tema
 * @property integer $id_pai
 */
class ListaTemas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ListaTemas the static model class
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
		return 'lista_temas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tema, id_pai', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_lista, id_tema, id_pai', 'safe', 'on'=>'search'),
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
			'id_lista' => 'Id Lista',
			'id_tema' => 'Id Tema',
			'id_pai' => 'Id Pai',
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

		$criteria->compare('id_lista',$this->id_lista);
		$criteria->compare('id_tema',$this->id_tema);
		$criteria->compare('id_pai',$this->id_pai);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}