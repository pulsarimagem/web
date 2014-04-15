<?php

/**
 * This is the model class for table "itenspedido".
 *
 * The followings are the available columns in table 'itenspedido':
 * @property integer $id
 * @property string $cod_pedido
 * @property integer $id_produto
 * @property string $tombo
 * @property string $produto
 * @property integer $quantidade
 * @property integer $uso
 * @property string $valor
 * @property string $moeda
 */
class Itenspedido extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Itenspedido the static model class
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
		return 'itenspedido';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_produto, quantidade, uso', 'numerical', 'integerOnly'=>true),
			array('cod_pedido', 'length', 'max'=>20),
			array('tombo', 'length', 'max'=>15),
			array('produto', 'length', 'max'=>100),
			array('valor, moeda', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cod_pedido, id_produto, tombo, produto, quantidade, uso, valor, moeda', 'safe', 'on'=>'search'),
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
			'cod_pedido' => 'Cod Pedido',
			'id_produto' => 'Id Produto',
			'tombo' => 'Tombo',
			'produto' => 'Produto',
			'quantidade' => 'Quantidade',
			'uso' => 'Uso',
			'valor' => 'Valor',
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
		$criteria->compare('cod_pedido',$this->cod_pedido,true);
		$criteria->compare('id_produto',$this->id_produto);
		$criteria->compare('tombo',$this->tombo,true);
		$criteria->compare('produto',$this->produto,true);
		$criteria->compare('quantidade',$this->quantidade);
		$criteria->compare('uso',$this->uso);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('moeda',$this->moeda,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}