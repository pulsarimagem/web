<?php

/**
 * This is the model class for table "cotacao_2".
 *
 * The followings are the available columns in table 'cotacao_2':
 * @property integer $id_cotacao2
 * @property integer $id_cadastro
 * @property string $distribuicao
 * @property string $descricao_uso
 * @property string $data_hora
 * @property integer $atendida
 * @property string $data_hora_atendida
 * @property string $mensagem
 * @property string $respondida_por
 */
class Cotacao2 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cotacao2 the static model class
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
		return 'cotacao_2';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cadastro, atendida', 'numerical', 'integerOnly'=>true),
			array('distribuicao', 'length', 'max'=>2),
			array('respondida_por', 'length', 'max'=>50),
			array('descricao_uso, data_hora, data_hora_atendida, mensagem', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_cotacao2, id_cadastro, distribuicao, descricao_uso, data_hora, atendida, data_hora_atendida, mensagem, respondida_por', 'safe', 'on'=>'search'),
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
			'id_cotacao2' => 'Id Cotacao2',
			'id_cadastro' => 'Id Cadastro',
			'distribuicao' => 'Distribuicao',
			'descricao_uso' => 'Descricao Uso',
			'data_hora' => 'Data Hora',
			'atendida' => 'Atendida',
			'data_hora_atendida' => 'Data Hora Atendida',
			'mensagem' => 'Mensagem',
			'respondida_por' => 'Respondida Por',
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

		$criteria->compare('id_cotacao2',$this->id_cotacao2);
		$criteria->compare('id_cadastro',$this->id_cadastro);
		$criteria->compare('distribuicao',$this->distribuicao,true);
		$criteria->compare('descricao_uso',$this->descricao_uso,true);
		$criteria->compare('data_hora',$this->data_hora,true);
		$criteria->compare('atendida',$this->atendida);
		$criteria->compare('data_hora_atendida',$this->data_hora_atendida,true);
		$criteria->compare('mensagem',$this->mensagem,true);
		$criteria->compare('respondida_por',$this->respondida_por,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}