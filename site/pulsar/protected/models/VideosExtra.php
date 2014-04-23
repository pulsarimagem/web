<?php

/**
 * This is the model class for table "videos_extra".
 *
 * The followings are the available columns in table 'videos_extra':
 * @property integer $Id_Foto
 * @property string $tombo
 * @property string $fps
 * @property string $resolucao
 * @property string $codec
 * @property integer $audio
 * @property string $duracao
 * @property string $aspect
 */
class VideosExtra extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VideosExtra the static model class
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
		return 'videos_extra';
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
			array('Id_Foto, audio', 'numerical', 'integerOnly'=>true),
			array('tombo', 'length', 'max'=>15),
			array('fps', 'length', 'max'=>5),
			array('resolucao', 'length', 'max'=>20),
			array('codec', 'length', 'max'=>40),
			array('aspect', 'length', 'max'=>10),
			array('duracao', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id_Foto, tombo, fps, resolucao, codec, audio, duracao, aspect', 'safe', 'on'=>'search'),
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
			'fps' => 'Fps',
			'resolucao' => 'Resolucao',
			'codec' => 'Codec',
			'audio' => 'Audio',
			'duracao' => 'Duracao',
			'aspect' => 'Aspect',
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
		$criteria->compare('fps',$this->fps,true);
		$criteria->compare('resolucao',$this->resolucao,true);
		$criteria->compare('codec',$this->codec,true);
		$criteria->compare('audio',$this->audio);
		$criteria->compare('duracao',$this->duracao,true);
		$criteria->compare('aspect',$this->aspect,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}