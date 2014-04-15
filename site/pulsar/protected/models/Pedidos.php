<?php

/**
 * This is the model class for table "pedidos".
 *
 * The followings are the available columns in table 'pedidos':
 * @property integer $id
 * @property integer $cpf
 * @property string $cod_pedido
 * @property string $valorpedido
 * @property string $data
 * @property string $tipopagamento
 * @property string $statustransacao
 * @property string $moeda
 */
class Pedidos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pedidos the static model class
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
		return 'pedidos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('valorpedido, tipopagamento', 'required'),
			array('cpf', 'numerical', 'integerOnly'=>true),
			array('cod_pedido', 'length', 'max'=>20),
			array('valorpedido, moeda', 'length', 'max'=>10),
			array('data, tipopagamento', 'length', 'max'=>50),
			array('statustransacao', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cpf, cod_pedido, valorpedido, data, tipopagamento, statustransacao, moeda', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'cpf' => 'Cpf',
			'cod_pedido' => 'Cod Pedido',
			'valorpedido' => 'Valorpedido',
			'data' => 'Data',
			'tipopagamento' => 'Tipopagamento',
			'statustransacao' => 'Statustransacao',
			'moeda' => 'Moeda',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('cpf',$this->cpf);
		$criteria->compare('cod_pedido',$this->cod_pedido,true);
		$criteria->compare('valorpedido',$this->valorpedido,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('tipopagamento',$this->tipopagamento,true);
		$criteria->compare('statustransacao',$this->statustransacao,true);
		$criteria->compare('moeda',$this->moeda,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}