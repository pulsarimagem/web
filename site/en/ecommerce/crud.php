<?php
    class Crud{
        protected $db;
        public $tabela;
        public function __construct(){
       
            $this->db = new PDO('mysql:host=localhost;dbname=pulsar','pulsar','v41qv412012'); 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }
        
        public function insert( Array $dados){
    
            $campos = implode(",",array_keys($dados));
            $vl = "'".implode("','",array_values($dados))."'";
            return $this->db->query("INSERT INTO `{$this->tabela}` ({$campos}) VALUES ({$vl})");
             
        }
        
        public function read($campo = null, $where = null, $limit = null, $offset = null, $orderby = null){ 
            
            $campo = ($campo !=null ? "{$campo}" : "*");
			$where = ($where !=null ? "WHERE {$where}" : "");
            $limit = ($limit !=null ? "LIMIT {$limit}" : "");
            $offset = ($offset !=null ? "OFFSET {$offset}" : "");
            $orderby = ($orderby !=null ? "ORDER BY {$orderby}" : "");
            $data = $this->db->query("SELECT {$campo} FROM `{$this->tabela}` {$where} {$orderby} {$limit} {$offset}");
            $data->setFetchMode(PDO::FETCH_ASSOC);
            $result = $data->fetchAll();
            return $result ;
        }
        
        public function update( Array $dados, $where = null){
            foreach($dados as $indice => $valor){
                $campos[] = "{$indice} = '{$valor}'";
                
            }
            
            $where = ($where !=null ? "WHERE {$where}" : "");
            $campos = implode(", ",$campos);
            return $this->db->query("UPDATE `{$this->tabela}` SET {$campos} {$where}");
        }
        
		public function readJoinCarrinho($campo = null, $where = null, $limit = null, $offset = null, $orderby = null){
			
			$campo = ($campo !=null ? "{$campo}" : "*");
			$where = ($where !=null ? "WHERE {$where}" : "");
            $limit = ($limit !=null ? "LIMIT {$limit}" : "");
            $offset = ($offset !=null ? "OFFSET {$offset}" : "");
            $orderby = ($orderby !=null ? "ORDER BY {$orderby}" : "");
			$join = "LEFT OUTER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo)
 					LEFT OUTER JOIN Estados ON (Fotos.id_estado=Estados.id_estado)
 					LEFT OUTER JOIN paises ON (paises.id_pais=Fotos.id_pais)";
            $data = $this->db->query("SELECT {$campo} FROM `{$this->tabela}` {$join} {$where} {$orderby} {$limit} {$offset}");
            $data->setFetchMode(PDO::FETCH_ASSOC);
            $result = $data->fetchAll();
            return $result ;
		
		}
		
        public function delete( $where = null){
            return $this->db->query("DELETE FROM `{$this->tabela}` WHERE {$where}");
        }
    }