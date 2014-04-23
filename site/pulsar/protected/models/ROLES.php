<?php

/**
 * This is the model class for table "roles".
 *
 * The followings are the available columns in table 'roles':
 * @property integer $id
 * @property string $nome
 * @property integer $status
 * @property string $creation_date
 * @property integer $Regras
 * @property integer $Gerenciamento
 * @property integer $Dashboard
 * @property integer $Site
 * @property integer $PaginaInicial
 * @property integer $EdiçãoVideos
 * @property integer $Indexação
 * @property integer $MineraçãodeDados
 * @property integer $Autores
 * @property integer $Administrativo
 * @property integer $Estatisticas
 */
class ROLES extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ROLES the static model class
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
		return 'roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, creation_date', 'required'),
			array('status, Regras, Gerenciamento, Dashboard, Site, PaginaInicial, EdiçãoVideos, Indexação, MineraçãodeDados, Autores, Administrativo, Estatisticas', 'numerical', 'integerOnly'=>true),
			array('nome', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nome, status, creation_date, Regras, Gerenciamento, Dashboard, Site, PaginaInicial, EdiçãoVideos, Indexação, MineraçãodeDados, Autores, Administrativo, Estatisticas', 'safe', 'on'=>'search'),
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
			'nome' => 'Nome',
			'status' => 'Status',
			'creation_date' => 'Creation Date',
			'Regras' => 'Regras',
			'Gerenciamento' => 'Gerenciamento',
			'Dashboard' => 'Dashboard',
			'Site' => 'Site',
			'PaginaInicial' => 'Pagina Inicial',
			'EdiçãoVideos' => 'Edição Videos',
			'Indexação' => 'Indexação',
			'MineraçãodeDados' => 'Mineraçãode Dados',
			'Autores' => 'Autores',
			'Administrativo' => 'Administrativo',
			'Estatisticas' => 'Estatisticas',
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
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('creation_date',$this->creation_date,true);
		$criteria->compare('Regras',$this->Regras);
		$criteria->compare('Gerenciamento',$this->Gerenciamento);
		$criteria->compare('Dashboard',$this->Dashboard);
		$criteria->compare('Site',$this->Site);
		$criteria->compare('PaginaInicial',$this->PaginaInicial);
		$criteria->compare('EdiçãoVideos',$this->EdiçãoVideos);
		$criteria->compare('Indexação',$this->Indexação);
		$criteria->compare('MineraçãodeDados',$this->MineraçãodeDados);
		$criteria->compare('Autores',$this->Autores);
		$criteria->compare('Administrativo',$this->Administrativo);
		$criteria->compare('Estatisticas',$this->Estatisticas);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}