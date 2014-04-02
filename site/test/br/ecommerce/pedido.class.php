<?php
	require_once('crud.php');
	class Pedido extends Crud{
	 
	 public $cpf;
	 public $codpedido;
	 public $valorpedido;
	 public $tabela;
	 
	 /// grava o pedido 
	 public function gravaPedido($valor){
		 
		 $this->insert($valor);
		 
		 }
		 
	/// grava itens do pedido 
	 public function gravaItenPedido($valor){
		 $this->insert($valor);
		 
		 }
		 
	/// grava itens do pedido 
	 public function atualizaTransacao($valor,$where = null){
		 $this->update($valor, $where);
		 
		 }
	
	 
	 }


?>