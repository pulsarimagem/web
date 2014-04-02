<?php require_once('Connections/pulsar.php'); ?>
<?php
class elementoPesquisa {
	public $arrCampos = array("tombo"=>false,"pc"=>false,"assunto"=>false,"extra"=>false,"cidade"=>false,"estado"=>false,"id_estado"=>false,"pais"=>false,"id_temas"=>false,"temas"=>false,"id_autor"=>false);
	public $fracao = false;
	public $not = false;
	public $arrPalavras = array();
	public $searchVars = false;
	
	function setAll() {
		foreach($this->arrCampos as $campo=>$val) {
			$this->arrCampos[$campo] = true;
			$searchVars = true;
		}
		$this->arrCampos['tombo'] = false;
		$this->arrCampos['id_estado'] = false;
	}
}

class pesquisaPulsar {
	public $dbConn;
	public $db;
	public $pesquisas = array();
	public $cntPal = 0;
	public $query = "";
	public $idioma = "PT";
	public $lastTmp = "Fotos";
	public $totalRows_retorno = 0;
	public $order = "ORDER BY Fotos.Id_Foto DESC";
	public $isdebug = false;
	
	public $arrFiltros = array("direito_aut"=>true,"horizontal"=>true,"vertical"=>true,"foto"=>true,"video"=>true,"id_autor"=>true,"id_tema"=>true,"data"=>true,"dia"=>true,"mes"=>true,"ano"=>true);
		
	function executeQuery () {
		$this->query .= "SELECT count(*) as cnt FROM $this->lastTmp;";
		if($this->isdebug)
			echo "Query final: $this->query<br>";
		$queries = explode(";",$this->query);
		mysql_select_db($this->db, $this->dbConn);
		$timeBefore = microtime(true);
		do {
		
			$result = mysql_query($queries[key($queries)], $this->dbConn) or die(mysql_error());
		
		} while (next($queries));
		$cnt = mysql_fetch_assoc($result);
		$this->totalRows_retorno = $cnt['cnt'];
		if($this->isdebug)
			echo "Retorno: ".$cnt['cnt']."<br>";
		$timeAfter = microtime(true);
		$diff = $timeAfter - $timeBefore;
		if($this->isdebug)
			echo "<strong>Tempo total: </strong>".$diff."<br>";
		return $this->totalRows_retorno;
	}

	function filter() {
		$isInsert = true;
		$finish = false;
		
		if($this->isdebug)
			print_r($this->arrFiltros);
		if($this->isdebug)
			echo "<br><br>";
		foreach($this->arrFiltros as $filtro=>$val) {
			if($val !== true && $finish == false) {
		
				switch($filtro) {
		
					case "direito_aut":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos") 
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin WHERE Fotos.direito_img != 1";
						$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						break;
					case "horizontal":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos") 
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin WHERE Fotos.orientacao != 'H'";
						$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						break;
					case "vertical":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos") 
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin WHERE Fotos.orientacao != 'V'";
						$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						break;
					case "foto":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos") 
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin WHERE Fotos.tombo RLIKE '^[a-zA-Z]'";
						$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						break;
					case "video":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos") 
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin WHERE Fotos.tombo NOT RLIKE '^[a-zA-Z]'";
						$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						break;
					case "id_autor":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos") 
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin WHERE Fotos.id_autor IN (".implode(",",$val).")";
						$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						break;
					case "id_tema":
						$novaQuery_temas = "SELECT  id_tema  FROM    lista_temas WHERE id_pai = ( $val );";
						mysql_select_db($this->db, $this->dbConn);
						$novaTemas_retorno = mysql_query($novaQuery_temas, $this->dbConn) or die(mysql_error());
						$novaRow_retorno = mysql_fetch_assoc($novaTemas_retorno);
						$novaRow_num = mysql_num_rows($novaTemas_retorno);
							
						if($novaRow_num == 0) {
							$novaTemas_query = "temas.Id = 0";
						}
						else {
							$novaTemas_query = "temas.Id =".$novaRow_retorno['id_tema'];
						}
							
						while ($novaRow_retorno = mysql_fetch_assoc($novaTemas_retorno)) {
							$novaTemas_query .= " or temas.Id =".$novaRow_retorno['id_tema'];
						}
							
						if($novaRow_num != 0) {
							$selectTable = $this->lastTmp;
							$selectJoin = "";
							if($selectTable != "Fotos")
								$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
							$tmpTable = $this->createTmpTable();
							$this->lastTmp = $tmpTable;

							$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
							INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
							INNER JOIN temas ON (temas.Id=rel_fotos_temas.id_tema)
							WHERE ($novaTemas_query)";
							$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						}
						break;
					case "data":
						$sinal = "=";
						$data = "XXXXXXXX";
						
						if($this->arrFiltros['ano'] !== true) {
							$data = $this->arrFiltros['ano']."YYYY";
						}
						if($this->arrFiltros['mes'] !== true) {
							$data = substr($data,0,4).$this->arrFiltros['mes']."YY";
						}
						if($this->arrFiltros['dia'] !== true) {
							$data = substr($data,0,6).$this->arrFiltros['dia'];
						}
						
						if($data != "XXXXXXXX") {
							switch($val) {
								case "exata":
									$sinal = "RLIKE";
									$data = str_replace("X", ".", $data);
									$data = str_replace("Y", ".?", $data);
									break;
								case "antes":
									$sinal = "<";
									$data = str_replace("X", "0", $data);
									$data = str_replace("Y", "0", $data);
									break;
								case "depois":
									$sinal = ">";
									$data = str_replace("X", "0", $data);
									$data = str_replace("Y", "0", $data);
									break;
								default:
									$sinal = false;											
							}
							
							$selectTable = $this->lastTmp;
							$selectJoin = "";
							if($selectTable != "Fotos")
								$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
							$tmpTable = $this->createTmpTable();
							$this->lastTmp = $tmpTable;			
							$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin WHERE Fotos.data_foto $sinal '$data'";
							if($sinal!== false)
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						}
						break;
				}
			}
		}
	}
	
	function order($ordem) {
		if(isset($ordem)) {
			if($ordem == "recente") {
				$query_ordem = "ORDER BY Fotos.Id_Foto DESC";
			}
			else if($ordem == "data") {
				$query_ordem = "ORDER BY Fotos.data_foto DESC";
			}
			else if($ordem == "vistas") {
				$query_ordem = "ORDER BY log_count_view.contador DESC";
			}
			else if($ordem == "maior") {
				$query_ordem = "ORDER BY Fotos.dim_a * Fotos.dim_b DESC";
			}
		}
		$this->order = $query_ordem;
		
	}
	function getRetorno ($startRow_retorno, $maxRows_retorno) {
		$query = "SELECT * FROM $this->lastTmp;";
		
		$query = "SELECT DISTINCT
				  tmp.Id_Foto,
				  Fotos.assunto_principal,
				  Fotos.cidade,
				  Estados.Sigla,
				  paises.nome,
				  Fotos.orientacao,
				  Fotos.tombo,
				  Fotos.data_foto,
				  Fotos.dim_a,
				  Fotos.dim_b,
				  Fotos_extra.extra
				  FROM $this->lastTmp as tmp 
				  LEFT JOIN Fotos ON tmp.Id_Foto = Fotos.Id_Foto
				  LEFT JOIN Fotos_extra ON Fotos.tombo = Fotos_extra.tombo
				  LEFT JOIN Estados ON Fotos.id_estado = Estados.id_estado
				  LEFT JOIN paises ON Fotos.id_pais = paises.id_pais
				  LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
				  GROUP BY tmp.Id_Foto
				  $this->order
				  LIMIT $startRow_retorno, $maxRows_retorno";
		
		if($this->idioma != "PT") {
			$query = "SELECT DISTINCT
					  tmp.Id_Foto,
					  Fotos.assunto_principal,
					  Fotos.cidade,
					  Estados.Sigla,
					  paises.nome_en as nome,
					  Fotos.orientacao,
					  Fotos.tombo,
					  Fotos.data_foto,
					  Fotos.dim_a,
					  Fotos.dim_b,
					  Fotos_extra.extra
					  FROM $this->lastTmp as tmp 
					  LEFT JOIN Fotos ON tmp.Id_Foto = Fotos.Id_Foto
					  LEFT JOIN Fotos_extra ON Fotos.tombo = Fotos_extra.tombo
					  LEFT JOIN Estados ON Fotos.id_estado = Estados.id_estado
					  LEFT JOIN paises ON Fotos.id_pais = paises.id_pais
					  LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
					  GROUP BY tmp.Id_Foto
					  $this->order
					  LIMIT $startRow_retorno, $maxRows_retorno";
		}					  
		
		if($this->isdebug)
			echo "Query Retorno: $query<br>";
		mysql_select_db($this->db, $this->dbConn);
		$timeBefore = microtime(true);
		$result = mysql_query($query, $this->dbConn) or die(mysql_error());
		$cnt = mysql_num_rows($result);
		if($this->isdebug)
			echo "Retorno: ".$cnt."<br>";
		$timeAfter = microtime(true);
		$diff = $timeAfter - $timeBefore;
		if($this->isdebug)
			echo "<strong>Tempo retorno: </strong>".$diff."<br>";
		return $result;
	}

	function getSuperString() {
		$query = "SELECT group_concat(tmp2.tombo SEPARATOR '|') AS superstring
					FROM (SELECT tmp.Id_Foto,Fotos.tombo FROM $this->lastTmp as tmp
					LEFT JOIN Fotos ON tmp.Id_Foto = Fotos.Id_Foto
					LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
					$this->order) as tmp2";
		if($this->isdebug)
			echo "Query Superstring: $query<br>";
		mysql_select_db($this->db, $this->dbConn);
		$timeBefore = microtime(true);
		$result = mysql_query($query, $this->dbConn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$superstring = $row['superstring'];
		if($this->isdebug)
			echo "Superstring: ".$superstring."<br>";
		$timeAfter = microtime(true);
		$diff = $timeAfter - $timeBefore;
		if($this->isdebug)
			echo "<strong>Tempo Superstring: </strong>".$diff."<br>";
		return $superstring;
	}
	
	function createQueryLine($tmpQuery, $tmpTable, $isInsert) {
		if($isInsert) {
			$tmpQuery = "INSERT IGNORE INTO $tmpTable $tmpQuery";
		}
		else {
			$tmpQuery = "DELETE FROM $tmpTable WHERE tmp.Id_Foto NOT IN ($tmpQuery)";
		}
		$this->query .= $tmpQuery.";";
		return $tmpQuery;
	}
	
	function createTmpTable() {
		$tmpTable = "pesq$this->cntPal";
		$createQuery = "DROP TEMPORARY TABLE IF EXISTS $tmpTable; CREATE TEMPORARY TABLE $tmpTable (Id_Foto int(11) PRIMARY KEY NOT NULL DEFAULT 0) ENGINE = MEMORY; ";
		$this->query .= $createQuery;
		$this->cntPal++;
		return $tmpTable;
	}
	
	function createQuery() {
		$finish = false;
		$isInsert = true;
		
		foreach($this->pesquisas as $pesquisa) {
			if($this->isdebug)
				print_r($pesquisa);
			$arrPalavras = array(); //$pesquisa->arrPalavra;		
			$selectTable = "Fotos";
			$selectJoin = "";
			if($this->cntPal != 0) {
				$selectTable = $tmpTable;
				$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
			}
			$tmpTable = $this->createTmpTable();
			$this->lastTmp = $tmpTable;

			
			foreach($pesquisa->arrPalavras as $palavra) {
				$palavra = str_ireplace("a", "[aàâäãá]", $palavra);
				$palavra = str_ireplace("e", "[eèêëé]", $palavra);
				$palavra = str_ireplace("i", "[iìîïí]", $palavra);
				$palavra = str_ireplace("o", "[oòôöõó]", $palavra);
				$palavra = str_ireplace("u", "[uùûüú]", $palavra);
				$palavra = str_ireplace("c", "[cç]", $palavra);
				$palavra = str_ireplace("n", "[nñ]", $palavra);
				$palavra = str_ireplace("-", " ", $palavra);
				$palavra = str_ireplace(" ", "[- ]", $palavra);
			
				$palavra = $palavra."s?";
			
				if(!$pesquisa->fracao) {
					$palavra = "[[:<:]]".$palavra."[[:>:]]";
				}
				$arrPalavras[] = $palavra;
			}
				
			
			foreach($pesquisa->arrCampos as $campo=>$val) {
				if($val !== false && $finish == false) {
					$operator = "RLIKE";
					if($pesquisa->not) {
						$operator = "NOT RLIKE";
					}
					
					foreach($arrPalavras as $palavra) {
							
						switch($campo) {
							
							case "tombo":
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin WHERE Fotos.tombo $operator '$palavra'";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								$finish = true;
								break;
							case "pc":
								$coluna = "Pal_Chave";
								if($this->idioma != "PT")
									$coluna = "Pal_Chave_en";
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
												INNER JOIN rel_fotos_pal_ch ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
												INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
												WHERE (pal_chave.$coluna $operator '$palavra')";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "temas":
								$coluna = "Tema";
								if($this->idioma != "PT")
									$coluna = "Tema_en";
								$novaQuery_temas = "SELECT  id_tema  FROM    lista_temas WHERE id_pai IN ( SELECT Id FROM temas WHERE ($coluna $operator '$palavra'));";
								if($this->isdebug) {
									echo "Query temas: $novaQuery_temas<br>";
								}
								mysql_select_db($this->db, $this->dbConn);
								$novaTemas_retorno = mysql_query($novaQuery_temas, $this->dbConn) or die(mysql_error());
								$novaRow_retorno = mysql_fetch_assoc($novaTemas_retorno);
								$novaRow_num = mysql_num_rows($novaTemas_retorno);
								
								if($novaRow_num == 0) {
									$novaTemas_query = "temas.Id = 0";
								}
								else {
									$novaTemas_query = "temas.Id =".$novaRow_retorno['id_tema'];
								}
								
								while ($novaRow_retorno = mysql_fetch_assoc($novaTemas_retorno)) {
									$novaTemas_query .= " or temas.Id =".$novaRow_retorno['id_tema'];
								}
								
								if($novaRow_num != 0) {
									$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
													INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
													INNER JOIN temas ON (temas.Id=rel_fotos_temas.id_tema)
													WHERE ($novaTemas_query)";
									$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								}
								break;
							case "assunto":
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
												WHERE (Fotos.assunto_principal $operator '$palavra')";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "extra":
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin 
												WHERE (Fotos.extra $operator '$palavra')";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "cidade":
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin 
												WHERE (Fotos.cidade $operator '$palavra')";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "estado":
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
												INNER JOIN Estados ON (Estados.id_estado=Fotos.id_estado)
												WHERE ((Estados.Estado $operator '$palavra')  OR  (Estados.Sigla $operator '$palavra'))";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "id_estado":
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
												INNER JOIN Estados ON (Estados.id_estado=Fotos.id_estado)
												WHERE (Estados.id_estado = $pesquisa->palavra)";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "pais":
								$coluna = "nome";
								if($this->idioma != "PT")
									$coluna = "nome_en";
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
												INNER JOIN paises ON (paises.id_pais=Fotos.id_pais)
												WHERE ((paises.$coluna $operator '$palavra')  OR  (paises.id_pais $operator '$palavra'))";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
						}
					}
				}
			}
		}
		if($this->isdebug)
			echo "Created query: $this->query<br>"; 
	}
}

?>