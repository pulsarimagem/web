<?php require_once('Connections/pulsar.php'); ?>
<?php
class elementoPesquisa {
	public $arrCampos = array("tombo"=>false,"pc"=>false,"assunto"=>false,"extra"=>false,"cidade"=>false,"estado"=>false,"id_estado"=>false,"pais"=>false,"id_temas"=>false,"temas"=>false,"id_autor"=>false);
	public $fracao = false;
	public $pc = 0;
	public $not = false;
	public $arrPalavras = array();
	public $searchVars = false;
	
	function setAll() {
		foreach($this->arrCampos as $campo=>$val) {
			$this->arrCampos[$campo] = true;
			$this->searchVars = true;
		}
//		$this->arrCampos['tombo'] = false;
		$this->arrCampos['id_estado'] = false;
	}
	
	function getInput($def_palavra = "", $lingua = "br") {
		foreach($this->arrPalavras as $palavra=>$idioma) {
			if($def_palavra == "" || ($def_palavra == $palavra)) {
				if($this->searchVars != true) {
					if($this->fracao == true ) {
						echo "<input type='hidden' name='fracao' value='".$palavra."'/>";
					}
					else if($this->not == true) {
						if($this->arrCampos["assunto"] == true) {
							echo "<input type='hidden' name='nao_palavra' value='".$palavra."'/>";
						}
					}
					else if($this->pc > 0) {
						echo "<input type='hidden' name='palavra$this->pc' value='".$palavra."'/>";
					}
					else {
						foreach($this->arrCampos as $campo=>$val) {
							if($val == true) {
								if($campo == "estado") {
									echo "<input type='hidden' name='$campo"."[]' value='".$palavra."'/>";
								}
								else {
									echo "<input type='hidden' name='$campo' value='".$palavra."'/>";
								}
							}
						}
					}
				}
				else {
					if($idioma==$lingua)
						echo "<input type='hidden' name='pc[]' value='".$palavra."'/>";
					else
						echo "<input type='hidden' name='t_pc[]' value='".$palavra."'/>";
				}
			}
		}
	}
}

class pesquisaPulsar {
	public $dbConn;
	public $db;
	public $pesquisas = array();
	public $cntPal = 0;
	public $query = "";
	public $idioma = "en";//br";
	public $lastTmp = "Fotos_tmp";
	public $totalRows_retorno = 0;
	public $order = "ORDER BY Fotos_tmp.Id_Foto DESC";
	public $isdebug = false;
	public $total = 0;
	public $isEnable = false;
	public $toTranslate = true;
	
	public $arrFiltros = array("direito_aut"=>true,"horizontal"=>true,"vertical"=>true,"foto"=>true,"video"=>true,"id_autor"=>true,"id_tema"=>true,"data"=>true,"dia"=>true,"mes"=>true,"ano"=>true);
	public $arrPosFiltros = array("foto"=>false,"video"=>false,"fullhd"=>false,"hd"=>false,"sd"=>false,"h"=>false,"v"=>false);
	public $arrPosFiltros_groups = array("fullhd"=>0,"hd"=>0,"sd"=>0,"h"=>0,"v"=>0);
	
	public $posfilter_join = "";
	public $posfilter_where = "";
	public $add_where = "";
	
	function connect() {
		mysql_select_db($this->db, $this->dbConn);		
	}
	
	function getInput($filtro) {
		if($this->arrFiltros[$filtro] !== true) {
			if($filtro == "direito_aut") {
				echo "<input type='hidden' name='direito_aut' value='".$this->arrFiltros[$filtro]."'/>";
			}
			else if($filtro == "id_tema") {
				echo "<input type='hidden' name='tema' value='".$this->arrFiltros[$filtro]."'/>";
			}
			else if($filtro == "id_autor") {
				$val = is_array($this->arrFiltros[$filtro])?$this->arrFiltros[$filtro][0]:$this->arrFiltros[$filtro];
				echo "<input type='hidden' name='id_autor[]' value='$val'/>";
			}
		}
	}
	
	function executeQuery () {
		if($this->isEnable) {
			$this->query .= "SELECT count(*) as cnt FROM $this->lastTmp;";
			if($this->isdebug)
				echo "Query final: <br>$this->query<br>";
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
		else {
			$this->totalRows_retorno = 0;
			return 0;
		}
	}

	function posfilter_groups() {
		if($this->isEnable) {
		
			if($this->isdebug)
				print_r("<strong>Pos Filter:</strong>");
			
			foreach($this->arrPosFiltros as $filtro=>$val) {
				switch($filtro) {
		
					case "foto":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp")
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos_tmp.Id_Foto) AS cnt FROM $selectTable $selectJoin WHERE Fotos_tmp.tombo RLIKE '^[0-9]'";
						break;
					case "video":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp")
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos_tmp.Id_Foto) AS cnt FROM $selectTable $selectJoin WHERE Fotos_tmp.tombo RLIKE '^[A-Z]'";
						break;
					case "fullhd":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp") 
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos_tmp.Id_Foto) AS cnt FROM $selectTable $selectJoin LEFT JOIN videos_extra ON videos_extra.tombo = Fotos_tmp.tombo WHERE Fotos_tmp.tombo RLIKE '^[A-Z]' AND videos_extra.resolucao = '1920x1080'";
						break;
					case "hd":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp")
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos_tmp.Id_Foto) AS cnt FROM $selectTable $selectJoin LEFT JOIN videos_extra ON videos_extra.tombo = Fotos_tmp.tombo WHERE Fotos_tmp.tombo RLIKE '^[A-Z]' AND videos_extra.resolucao = '1280x720'";
						break;					
					case "sd":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp")
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos_tmp.Id_Foto) AS cnt FROM $selectTable $selectJoin LEFT JOIN videos_extra ON videos_extra.tombo = Fotos_tmp.tombo WHERE Fotos_tmp.tombo RLIKE '^[A-Z]' AND (videos_extra.resolucao = '768x576' OR videos_extra.resolucao = '720x480')";
						break;					
					case "h":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp")
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos_tmp.Id_Foto) AS cnt FROM $selectTable $selectJoin WHERE Fotos_tmp.tombo RLIKE '^[0-9]' AND dim_a > dim_b";
						break;	
					case "v":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp")
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos_tmp.Id_Foto) AS cnt FROM $selectTable $selectJoin WHERE Fotos_tmp.tombo RLIKE '^[0-9]' AND dim_a < dim_b";
						break;					
									
				}
						
				if($this->isdebug)
					print_r($tmpQuery);
				
				$result = mysql_query($tmpQuery, $this->dbConn) or die(mysql_error());
				$row = mysql_fetch_array($result); 
				$val = $row['cnt'];
				$this->arrPosFiltros_groups[$filtro] = $val;
			}
			if($this->isdebug)
				echo "<br>";
			if($this->isdebug)
				print_r($this->arrPosFiltros);
			if($this->isdebug)
				echo "<br><br>";
			
			return $this->arrPosFiltros_groups;
		}
		else {
			return "";
		}
	}
	
	function posfilter_data() {
		if($this->isdebug)
			print_r("<strong>Pos Filter Data:</strong>");
		
		$selectTable = $this->lastTmp;
		$selectJoin = "";
		if($selectTable != "Fotos_tmp")
			$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
		$tmpQuery = "SELECT LEFT(data_foto,4) as ano, count(LEFT(data_foto,4)) AS cnt FROM $selectTable $selectJoin GROUP BY ano ORDER BY ano DESC";
		
		if($this->isdebug)
			echo "<br>$tmpQuery<br><br>";
			
		$result = mysql_query($tmpQuery, $this->dbConn) or die(mysql_error());
		
		return $result;
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
						if($selectTable != "Fotos_tmp") 
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin WHERE Fotos_tmp.direito_img != 1";
						$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						break;
					case "horizontal":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp") 
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin WHERE Fotos_tmp.orientacao != 'H'";
						$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						break;
					case "vertical":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp") 
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin WHERE Fotos_tmp.orientacao != 'V'";
						$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						break;
					case "foto":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp") 
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin WHERE Fotos_tmp.tombo RLIKE '^[a-zA-Z]'";
						$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						break;
					case "video":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp") 
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin WHERE Fotos_tmp.tombo NOT RLIKE '^[a-zA-Z]'";
						$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
						break;
					case "id_autor":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos_tmp") 
							$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
						$tmpTable = $this->createTmpTable();
						$this->lastTmp = $tmpTable;			
						$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin WHERE Fotos_tmp.id_autor IN (".implode(",",$val).")";
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
							if($selectTable != "Fotos_tmp")
								$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
							$tmpTable = $this->createTmpTable();
							$this->lastTmp = $tmpTable;

							$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin
							INNER JOIN rel_fotos_temas ON (Fotos_tmp.Id_Foto=rel_fotos_temas.id_foto)
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
							if($selectTable != "Fotos_tmp")
								$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
							$tmpTable = $this->createTmpTable();
							$this->lastTmp = $tmpTable;			
							$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin WHERE Fotos_tmp.data_foto $sinal '$data'";
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
				$query_ordem = "ORDER BY Fotos_tmp.Id_Foto DESC";
			}
			else if($ordem == "data") {
				$query_ordem = "ORDER BY Fotos_tmp.data_foto DESC";
			}
			else if($ordem == "vistas") {
				$query_ordem = "ORDER BY log_count_view.contador DESC";
			}
			else if($ordem == "maior") {
				$query_ordem = "ORDER BY Fotos_tmp.dim_a * Fotos_tmp.dim_b DESC, find_in_set(videos_extra.resolucao, '1920x1080,1280x720,720x480')";
			}
			else if($ordem == "relevancia") {
				$palavra_composta_arr = array();
				foreach($this->pesquisas as $pesquisa) {
					foreach($pesquisa->arrPalavras as $palavra=>$idioma) {
						$raw_palavra = $palavra;
						$palavra = str_ireplace("a", "[a�����]", $palavra);
						$palavra = str_ireplace("e", "[e����]", $palavra);
						$palavra = str_ireplace("i", "[i����]", $palavra);
						$palavra = str_ireplace("o", "[o�����]", $palavra);
						$palavra = str_ireplace("u", "[u����]", $palavra);
						$palavra = str_ireplace("c", "[c�]", $palavra);
						$palavra = str_ireplace("n", "[n�]", $palavra);
						$palavra = str_ireplace("-", " ", $palavra);
						$palavra = str_ireplace(" ", "[- ]", $palavra);
							
	//					$palavra = $palavra."s?";
							
						if(!$pesquisa->fracao) {
							$palavra_composta_arr[] = "[[:<:]]".$palavra."[[:>:]][ -]*[[[:alpha:]]{0,2}]*[ -]*";
						}
					}
				}
				if(count($palavra_composta_arr)>0 && count($palavra_composta_arr)<6) {
					
					$idioma = "";
					if($this->idioma != "br")
						$idioma = "_en";
						
					$palavra_composta = array();
					$this->pc_permute($palavra_composta, $palavra_composta_arr);
					$palavra_composta_imp_assunto = implode("') OR Fotos_tmp.assunto_principal RLIKE trim('", $palavra_composta);
					$palavra_composta_imp_cidade = str_ireplace("Fotos_tmp.assunto_principal", "Fotos_tmp.cidade", $palavra_composta_imp_assunto); 									
					$palavra_composta_imp_pais = str_ireplace("Fotos_tmp.assunto_principal", "paises.nome$idioma", $palavra_composta_imp_assunto); 									
					$palavra_composta_imp_pc = str_ireplace("Fotos_tmp.assunto_principal", "pal_chave.Pal_Chave$idioma", $palavra_composta_imp_assunto); 									
					
					$selectTable = $this->lastTmp;
					$selectJoin = "";
					if($selectTable != "Fotos_tmp")
						$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
					
					
					$tmpTable = "pesq$this->cntPal";
					$relQuery = "DROP TEMPORARY TABLE IF EXISTS $tmpTable; CREATE TEMPORARY TABLE $tmpTable (id int(11) auto_increment PRIMARY KEY, Id_Foto int(11) NOT NULL UNIQUE DEFAULT 0) ENGINE = MEMORY; ";
					$this->cntPal++;			
					
					$this->lastTmp = $tmpTable;
					$relQuery .= "INSERT IGNORE INTO $tmpTable (Id_Foto) 
									SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin
									
									INNER JOIN paises ON (paises.id_pais=Fotos_tmp.id_pais)
									 
									WHERE Fotos_tmp.assunto_principal RLIKE trim('$palavra_composta_imp_assunto') 
									OR Fotos_tmp.cidade RLIKE trim('$palavra_composta_imp_cidade')
									OR paises.nome$idioma RLIKE trim('$palavra_composta_imp_pais')
									ORDER BY Fotos_tmp.data_foto DESC,Fotos_tmp.Id_Foto DESC;";
//									INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
//									OR pal_chave.Pal_Chave$idioma RLIKE trim('$palavra_composta_imp_pc')
//									INNER JOIN rel_fotos_pal_ch ON (Fotos_tmp.Id_Foto=rel_fotos_pal_ch.id_foto)
						
					$relQuery .= "DELETE FROM $selectTable WHERE Id_Foto IN (SELECT Id_Foto FROM $tmpTable);";
					$relQuery .= "INSERT IGNORE INTO $tmpTable (Id_Foto) SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin ORDER BY Fotos_tmp.data_foto DESC,Fotos_tmp.Id_Foto DESC;";
					$relQuery .= "DELETE FROM $selectTable WHERE Id_Foto IN (SELECT Id_Foto FROM $tmpTable);";

					if($this->isdebug)
						echo "Query Relevancia: <br>$relQuery<br>";
					
					$queries = explode(";",$relQuery);
					mysql_select_db($this->db, $this->dbConn);
					$timeBefore = microtime(true);
					do {
					
						$result = mysql_query($queries[key($queries)], $this->dbConn) or die(mysql_error());
					
					} while (next($queries));
					$timeAfter = microtime(true);
					$diff = $timeAfter - $timeBefore;
					if($this->isdebug)
						echo "<strong>Tempo relevancia: </strong>".$diff."<br>";
					
					
					$query_ordem = "ORDER BY id ASC";
				}
				else {
					$query_ordem = "ORDER BY Fotos_tmp.Id_Foto DESC";
				}
			}
		}
		$this->order = $query_ordem;
		
	}
	function getRetorno ($startRow_retorno, $maxRows_retorno) {
		if($this->isEnable) {
			$query = "SELECT * FROM $this->lastTmp;";
			
			$this->posfilter_join = "";
			$this->posfilter_where = "";
			$this->add_where = "";

			foreach ($this->arrPosFiltros as $posFiltros=>$val) {
				if($val) {
					switch($posFiltros) {
						case "fullhd":
//							$this->posfilter_join = "LEFT JOIN videos_extra ON videos_extra.tombo = Fotos_tmp.tombo";
							if($this->posfilter_where != "")
								$this->posfilter_where .= " OR ";
							$this->posfilter_where .= "(Fotos_tmp.tombo RLIKE '^[A-Z]' AND videos_extra.resolucao = '1920x1080')";
							$this->add_where = "WHERE";
							break;
						case "hd":
//							$this->posfilter_join = "LEFT JOIN videos_extra ON videos_extra.tombo = Fotos_tmp.tombo";
							if($this->posfilter_where != "")
								$this->posfilter_where .= " OR ";
							$this->posfilter_where .= "(Fotos_tmp.tombo RLIKE '^[A-Z]' AND videos_extra.resolucao = '1280x720')";
							$this->add_where = "WHERE";
							break;					
						case "sd":
//							$this->posfilter_join = "LEFT JOIN videos_extra ON videos_extra.tombo = Fotos_tmp.tombo";
							if($this->posfilter_where != "")
								$this->posfilter_where .= " OR ";
							$this->posfilter_where .= "(Fotos_tmp.tombo RLIKE '^[A-Z]' AND (videos_extra.resolucao = '768x576' OR videos_extra.resolucao = '720x480'))";
							$this->add_where = "WHERE";
							break;					
						case "h":
							if($this->posfilter_where != "")
								$this->posfilter_where .= " OR ";
							$this->posfilter_where .= "(Fotos_tmp.tombo RLIKE '^[0-9]' AND Fotos_tmp.dim_a > Fotos_tmp.dim_b)";
							$this->add_where = "WHERE";
							break;	
						case "v":
							if($this->posfilter_where != "")
								$this->posfilter_where .= " OR ";
							$this->posfilter_where .= "(Fotos_tmp.tombo RLIKE '^[0-9]' AND Fotos_tmp.dim_a < Fotos_tmp.dim_b)";
							$this->add_where = "WHERE";
							break;	
					}
				}
			}
			
			if($this->posfilter_where != "")
				$this->posfilter_where .= " AND ";
			$this->posfilter_where .= "(Fotos_tmp.status>=-1 AND Fotos_tmp.status<=1)";
			$this->add_where = "WHERE";
			
			
			$idioma = "";
			if($this->idioma != "br")
				$idioma = "_en";				
			
			$query = "SELECT DISTINCT
					  tmp.Id_Foto,
					  Fotos_tmp.assunto_principal,
					  Fotos_tmp.cidade,
					  Estados.Sigla,
					  paises.nome$idioma as nome,
					  Fotos_tmp.orientacao,
					  Fotos_tmp.tombo,
					  Fotos_tmp.data_foto,
					  Fotos_tmp.dim_a,
					  Fotos_tmp.dim_b,
					  Fotos_extra.extra,
					  videos_extra.resolucao,
					  codigo_video.status
					  FROM $this->lastTmp as tmp 
					  LEFT JOIN Fotos_tmp ON tmp.Id_Foto = Fotos_tmp.Id_Foto
					  LEFT JOIN codigo_video ON codigo_video.codigo = Fotos_tmp.tombo
					  LEFT JOIN Fotos_extra ON Fotos_tmp.tombo = Fotos_extra.tombo
					  LEFT JOIN videos_extra ON Fotos_tmp.tombo = videos_extra.tombo
					  LEFT JOIN Estados ON Fotos_tmp.id_estado = Estados.id_estado
					  LEFT JOIN paises ON Fotos_tmp.id_pais = paises.id_pais
					  LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
					  $this->posfilter_join
					  $this->add_where
					  $this->posfilter_where	
					  GROUP BY tmp.Id_Foto
					  $this->order
					  LIMIT $startRow_retorno, $maxRows_retorno";
/*
//					  codigo_video.status
//					  LEFT JOIN codigo_video ON codigo_video.codigo = Fotos_tmp.tombo

 * 			
			if($this->idioma != "br") {
				$query = "SELECT DISTINCT
						  tmp.Id_Foto,
						  Fotos_tmp.assunto_principal,
						  Fotos_tmp.cidade,
						  Estados.Sigla,
						  paises.nome_en as nome,
						  Fotos_tmp.orientacao,
						  Fotos_tmp.tombo,
						  Fotos_tmp.data_foto,
						  Fotos_tmp.dim_a,
						  Fotos_tmp.dim_b,
						  Fotos_extra.extra
						  FROM $this->lastTmp as tmp 
						  LEFT JOIN Fotos_tmp ON tmp.Id_Foto = Fotos_tmp.Id_Foto
						  LEFT JOIN Fotos_extra ON Fotos_tmp.tombo = Fotos_extra.tombo
						  LEFT JOIN Estados ON Fotos_tmp.id_estado = Estados.id_estado
						  LEFT JOIN paises ON Fotos_tmp.id_pais = paises.id_pais
						  LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
						  $this->posfilter_join
						  $this->add_where
						  $this->posfilter_where	
						  GROUP BY tmp.Id_Foto
						  $this->order
						  LIMIT $startRow_retorno, $maxRows_retorno";
			}					  
*/			
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
		else {
			return 0;
		}
	}
	function getRetornoSuperString ($codigos) {
			$codigos_aspas = '"';
			$codigos_aspas .= str_replace(',', '","', $codigos);
			$codigos_aspas .= '"';
			
			$idioma = "";
			if($this->idioma != "br")
				$idioma = "_en";
			
			$query = "SELECT DISTINCT
			Fotos_tmp.Id_Foto,
			Fotos_tmp.assunto_principal,
			Fotos_tmp.cidade,
			Estados.Sigla,
			paises.nome$idioma as nome,
			Fotos_tmp.orientacao,
			Fotos_tmp.tombo,
			Fotos_tmp.data_foto,
			Fotos_tmp.dim_a,
			Fotos_tmp.dim_b,
			Fotos_extra.extra,
			videos_extra.resolucao
			FROM Fotos_tmp
			LEFT JOIN Fotos_extra ON Fotos_tmp.tombo = Fotos_extra.tombo
			LEFT JOIN videos_extra ON Fotos_tmp.tombo = videos_extra.tombo
			LEFT JOIN Estados ON Fotos_tmp.id_estado = Estados.id_estado
			LEFT JOIN paises ON Fotos_tmp.id_pais = paises.id_pais
			LEFT JOIN log_count_view ON Fotos_tmp.Id_Foto = log_count_view.Id_Foto
			WHERE Fotos_tmp.tombo IN ($codigos_aspas) AND (Fotos_tmp.status>=-1 AND Fotos_tmp.status<=1)
			ORDER BY find_in_set(Fotos_tmp.tombo, '$codigos')";
			//FIELD( category, 'First', 'Second' )
/*				
			if($this->idioma != "br") {
				$query = "SELECT DISTINCT
				tmp.Id_Foto,
				Fotos_tmp.assunto_principal,
				Fotos_tmp.cidade,
				Estados.Sigla,
				paises.nome_en as nome,
				Fotos_tmp.orientacao,
				Fotos_tmp.tombo,
				Fotos_tmp.data_foto,
				Fotos_tmp.dim_a,
				Fotos_tmp.dim_b,
				Fotos_extra.extra
				FROM $this->lastTmp as tmp
				LEFT JOIN Fotos_tmp ON tmp.Id_Foto = Fotos_tmp.Id_Foto
				LEFT JOIN Fotos_extra ON Fotos_tmp.tombo = Fotos_extra.tombo
				LEFT JOIN Estados ON Fotos_tmp.id_estado = Estados.id_estado
				LEFT JOIN paises ON Fotos_tmp.id_pais = paises.id_pais
				LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
				$this->posfilter_join
				$this->add_where
				$this->posfilter_where
				GROUP BY tmp.Id_Foto
				$this->order
				LIMIT $startRow_retorno, $maxRows_retorno";
			}
*/				
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
		if($this->isEnable) {
			mysql_query("SET group_concat_max_len=2000000", $this->dbConn) or die(mysql_error());
			$query = "SELECT group_concat(tmp2.tombo SEPARATOR '|') AS superstring
						FROM (SELECT tmp.Id_Foto,Fotos_tmp.tombo FROM $this->lastTmp as tmp
						LEFT JOIN Fotos_tmp ON tmp.Id_Foto = Fotos_tmp.Id_Foto
						LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
						LEFT JOIN videos_extra ON videos_extra.tombo = Fotos_tmp.tombo
						$this->posfilter_join
						$this->add_where
						$this->posfilter_where
						$this->order) as tmp2";
			if($this->isdebug)
				echo "Query Superstring: <br>$query<br>";
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
	}

	function getTotal() {
		if($this->isEnable) {
			$query = "SELECT count(tmp.Id_Foto) AS cnt FROM $this->lastTmp as tmp
			LEFT JOIN Fotos_tmp ON tmp.Id_Foto = Fotos_tmp.Id_Foto
			LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
			LEFT JOIN videos_extra ON videos_extra.tombo = Fotos_tmp.tombo
			$this->posfilter_join
			$this->add_where
			$this->posfilter_where
			$this->order";
			if($this->isdebug) {
				echo "Query Total: <br>$query<br>";
			}
	
			mysql_select_db($this->db, $this->dbConn);
			$timeBefore = microtime(true);
			$result = mysql_query($query, $this->dbConn) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$this->total = $row['cnt'];
			return $this->total;
		}
		else
			return 0;
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
	function preFilter() {
		$timeBefore = microtime(true);
		
		$pesquisaCount = array();
		$pesquisaPcCount = array();
		foreach($this->pesquisas as $pos=>$pesquisa) {
			if($this->idioma != "br" && $this->toTranslate) {
				$traduzidos = $this->translateEn($this->implode_key(" ", $pesquisa->arrPalavras));
				foreach($traduzidos as $traduzido) {
					if(strlen($traduzido) > 2) {
						$traduzido_arr = explode(" ", mb_strtolower($traduzido));
						foreach($traduzido_arr as $palavra_br) {
							if(strlen($palavra_br) > 2) {
								if(!isset($pesquisa->arrPalavras[$palavra_br]))
									$pesquisa->arrPalavras[$palavra_br] = "br";
							}
						}
					}
					else {
						$pesquisa->arrPalavras = array();
					}
				}
			}
			$pesquisaCount[$pos] = count($pesquisa->arrPalavras);
			$whereQuery = "";
			$addOr = false;
			if(count($pesquisa->arrPalavras ) > 0) {
				foreach($pesquisa->arrPalavras as $pc=>$idioma) {
					if($addOr)
						$whereQuery .= " OR ";

					$whereQuery .= "Pal_Chave LIKE '%$pc%' OR Pal_Chave_en LIKE '%$pc%'";
					$addOr = true;						
/*						
					if($idioma == "br") {
						$whereQuery .= "Pal_Chave LIKE '$pc'";
						$addOr = true;						
					}
					else {
						$whereQuery .= "Pal_Chave_$idioma LIKE '$pc'";
						$addOr = true;						
					}
*/					
				}
				//SELECT id_palavra_chave, Pal_Chave, count(id_palavra_chave)
				$query = "SELECT count(*) as cnt
				FROM rel_fotos_pal_ch
				LEFT JOIN pal_chave ON pal_chave.Id = rel_fotos_pal_ch.id_palavra_chave
				WHERE $whereQuery;";
//				GROUP BY id_palavra_chave;";
//				echo"<br><br>$query<br><br>";
				$result = mysql_query($query, $this->dbConn) or die(mysql_error());
				$row = mysql_fetch_array($result);
				$pesquisaPcCount[$pos] = $row['cnt'];
			}
			else {
				$pesquisaPcCount[$pos] = 0;
			}
		}
		
		if($this->isdebug) {
			echo "Pesquisas Original: <br>";
			print_r($this->pesquisas);
			echo "<br><br>";
			echo "Pesquisas Count: <br>";
			print_r($pesquisaCount);
			echo "<br>";
			echo "Pesquisas Pc Count: <br>";
			print_r($pesquisaPcCount);
			echo "<br>";
		}
		
		$newPesquisas = array();
		$newPesquisaPcCount = array();
		$newPesquisaCount = array();
		for($i = 0; $i < count($this->pesquisas); $i++) {
			$minSize = 9999;
			$minPos = -1; 
			foreach($this->pesquisas as $pos=>$pesquisa) {
				if($pesquisaCount[$pos] < $minSize) {
					$minSize = $pesquisaCount[$pos];
					$minPos = $pos;
				}				
			}
			$newPesquisas[$i] = $this->pesquisas[$minPos];
			$newPesquisaPcCount[$i] = $pesquisaPcCount[$minPos];
			$newPesquisaCount[$i] = count($this->pesquisas[$minPos]->arrPalavras);
			$pesquisaCount[$minPos] = 9999;
		}
		
//		$minSizePrev = $newPesquisaCount[0];//-1;
		$minLastPosEnd = -1;//0;//-1	;
		$minLastPosStart = 0;
		$newPesquisas2 = array();

		for($i = 0; $i < count($newPesquisas); $i++) {
			if(($minSizePrev != $newPesquisaCount[$i])) {
				
				$minLastPosEnd = $i-1;
				if($this->isdebug) {
					echo "MinSize: $minSizePrev   || PesquisaCount: $newPesquisaCount[$i]<br>";						
					echo "Start: $minLastPosStart  || End: $minLastPosEnd<br>";
				}
				
				if($minLastPosStart >= 0) {
					for($j = $minLastPosStart; $j <= $minLastPosEnd ; $j++ ) {
						$minCnt = 99999999;
						$minPos = -1;

						for($k = $minLastPosStart; $k <= $minLastPosEnd ; $k++ ) {
							if($newPesquisaPcCount[$k] < $minCnt) {
								$minCnt = $newPesquisaPcCount[$k];
								$minPos = $k;
							}
						}
						$newPesquisas2[$j] = $newPesquisas[$minPos];
						$newPesquisaPcCount[$minPos] = 99999999;
					}
				}

				$minSizePrev = $newPesquisaCount[$i];
				$minLastPosStart = $minLastPosEnd+1;
			}
			if($i == count($newPesquisas)-1) {
				$minLastPosEnd = $i;
				if($this->isdebug) {
					echo "Start: $minLastPosStart  || End: $minLastPosEnd<br>";
				}
				for($j = $minLastPosStart; $j <= $minLastPosEnd ; $j++ ) {
					$minCnt = 99999999;
					$minPos = -1;
					for($k = $minLastPosStart; $k <= $minLastPosEnd ; $k++ ) {
						if($newPesquisaPcCount[$k] < $minCnt) {
							$minCnt = $newPesquisaPcCount[$k];
							$minPos = $k;
						}
					}
					$newPesquisas2[$j] = $newPesquisas[$minPos];
					$newPesquisaPcCount[$minPos] = 99999999;
				}
			}
				
				
		}
		$this->pesquisas = $newPesquisas2;
		if($this->isdebug) {
			echo "Pesquisas Pre-Processada: <br>";
			print_r($this->pesquisas);
			echo "<br><br>";
		}
		$timeAfter = microtime(true);
		$diff = $timeAfter - $timeBefore;
		if($this->isdebug)
			echo "<strong>Tempo Pre-Filter: </strong>".$diff."<br>";
	}
	
	function createQuery() {
		$finish = false;
		$isInsert = true;
		
		$this->preFilter();
		
		foreach($this->pesquisas as $pesquisa) {
			if($this->isdebug)
				print_r($pesquisa);
			
			if(count($pesquisa->arrPalavras) > 0) {
				$arrPalavras = array(); //$pesquisa->arrPalavra;		
				$selectTable = "Fotos_tmp";
				$selectJoin = "";
				if($this->cntPal != 0) {
					$selectTable = $tmpTable;
					$selectJoin = " LEFT JOIN Fotos_tmp ON Fotos_tmp.Id_Foto = $selectTable.Id_Foto ";
				}
				$tmpTable = $this->createTmpTable();
				$this->lastTmp = $tmpTable;
			}
								
			foreach($pesquisa->arrCampos as $campo=>$val) {
				if($val !== false && $finish == false) {
					$operator = "RLIKE";
					if($pesquisa->not) {
						$operator = "NOT RLIKE";
					}
					
					foreach($pesquisa->arrPalavras as $palavra=>$idioma) {
						$raw_palavra = $palavra;
echo "Palavra raw: $palavra<br>";
//						CONSERTAR
						$palavra = preg_replace("/[a�����]/","a", $palavra);
echo "Palavra sem acento: $palavra<br>";
						

						$palavra = preg_replace("/s\b/", "", $palavra);
echo "Palavra s: $palavra<br>";
						$palavra = preg_replace("/a\b/", "^", $palavra);
echo "Palavra a: $palavra<br>";
						$palavra = preg_replace("/o\b/", "^", $palavra);
echo "Palavra o: $palavra<br>";
						
						$palavra = str_ireplace("a", "[a�����]", $palavra);
						$palavra = str_ireplace("e", "[e����]", $palavra);
						$palavra = str_ireplace("i", "[i����]", $palavra);
						$palavra = str_ireplace("o", "[o�����]", $palavra);
						$palavra = str_ireplace("u", "[u����]", $palavra);
						$palavra = str_ireplace("c", "[c�]", $palavra);
						$palavra = str_ireplace("n", "[n�]", $palavra);
						$palavra = str_ireplace("-", " ", $palavra);
						$palavra = str_ireplace(" ", "[- ]", $palavra);

						$palavra = str_ireplace("^", "[a�����o�����]", $palavra);
						$palavra = $palavra."s?";
							
						if(!$pesquisa->fracao) {
							$palavra = "[[:<:]]".$palavra."[[:>:]]";
						}
							
						switch($campo) {
							
							case "tombo":
								$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin WHERE Fotos_tmp.tombo $operator '$raw_palavra'";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								//$finish = true;
								break;
							case "pc":
								$coluna = "Pal_Chave"; // Rever join caso nao tenha a pc, retorna NULL
								$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin
												INNER JOIN rel_fotos_pal_ch ON (Fotos_tmp.Id_Foto=rel_fotos_pal_ch.id_foto)
												INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
												WHERE (pal_chave.$coluna $operator '$palavra')";
								$tmpQuery = "SELECT $selectTable.Id_Foto FROM rel_fotos_pal_ch
												LEFT JOIN $selectTable ON ($selectTable.Id_Foto=rel_fotos_pal_ch.id_foto)
												LEFT JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
												WHERE (pal_chave.$coluna $operator '$palavra')";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								if($this->idioma != "br") { 
									$coluna = "Pal_Chave_en";
									$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin
													INNER JOIN rel_fotos_pal_ch ON (Fotos_tmp.Id_Foto=rel_fotos_pal_ch.id_foto)
													INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
													WHERE (pal_chave.$coluna $operator '$palavra')";
									$tmpQuery = "SELECT $selectTable.Id_Foto FROM rel_fotos_pal_ch
													LEFT JOIN $selectTable ON ($selectTable.Id_Foto=rel_fotos_pal_ch.id_foto)
													LEFT JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
													WHERE (pal_chave.$coluna $operator '$palavra')";
									$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								}
								break;
							case "temas":
								$coluna = "Tema";
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
									$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin
													INNER JOIN rel_fotos_temas ON (Fotos_tmp.Id_Foto=rel_fotos_temas.id_foto)
													INNER JOIN temas ON (temas.Id=rel_fotos_temas.id_tema)
													WHERE ($novaTemas_query)";
									$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								}
								if($this->idioma != "br") {
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
										$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin
										INNER JOIN rel_fotos_temas ON (Fotos_tmp.Id_Foto=rel_fotos_temas.id_foto)
										INNER JOIN temas ON (temas.Id=rel_fotos_temas.id_tema)
										WHERE ($novaTemas_query)";
										$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
									}
								}
								break;
							case "assunto":
								$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin
												WHERE (Fotos_tmp.assunto_principal $operator '$palavra')";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "extra":
								$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin 
												WHERE (Fotos_tmp.extra $operator '$palavra')";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "cidade":
								$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin 
												WHERE (Fotos_tmp.cidade $operator '$palavra')";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "estado":
								$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin
												INNER JOIN Estados ON (Estados.id_estado=Fotos_tmp.id_estado)
												WHERE ((Estados.Estado $operator '$palavra')  OR  (Estados.Sigla $operator '$palavra'))";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "id_estado":
								$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin
												INNER JOIN Estados ON (Estados.id_estado=Fotos_tmp.id_estado)
												WHERE (Estados.id_estado = $raw_palavra)";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "pais":
								$coluna = "nome";
								$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin
												INNER JOIN paises ON (paises.id_pais=Fotos_tmp.id_pais)
												WHERE ((paises.$coluna $operator '$palavra')  OR  (paises.id_pais $operator '$palavra'))";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								if($this->idioma != "br") {
									$coluna = "nome_en";
									$tmpQuery = "SELECT Fotos_tmp.Id_Foto FROM $selectTable $selectJoin
													INNER JOIN paises ON (paises.id_pais=Fotos_tmp.id_pais)
													WHERE ((paises.$coluna $operator '$palavra')  OR  (paises.id_pais $operator '$palavra'))";
									$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								}
								break;
						}
					}
				}
			}
		}
//		if($this->isdebug)
//			echo "<br>Created query: <br>$this->query<br>"; 
	}
	
	function permutations($arr,$n) {
		$res = array();
		foreach ($arr as $w)
		{
			if ($n==1) $res[] = $w;
			else
			{
				$perms = $this->permutations($arr,$n-1);
				foreach ($perms as $p)
				{
					if($w != $p)
						$res[] = $w.$p;
				}
			}
		}
		return $res;
	}
	
	function pc_permute(&$res, $items, $perms = array( )) {
		if (empty($items)) {
			$res[] = implode("",$perms);
		}  else {
			for ($i = count($items) - 1; $i >= 0; --$i) {
				$newitems = $items;
				$newperms = $perms;
				list($foo) = array_splice($newitems, $i, 1);
				array_unshift($newperms, $foo);
				$this->pc_permute($res,$newitems, $newperms);
			}
		}
	}
	
	function translateEn($palavra, $idioma = "pt") {
		$return = array();
		if($palavra != '' && $idioma != ''){
			$data = file_get_contents("http://translate.google.com/translate_a/t?client=t&text=".urlencode($palavra)."&hl=en&sl=en&tl=".$idioma."&ie=ISO-8859-1&oe=ISO-8859-1&multires=1&otf=1&ssel=0&tsel=0&sc=1");
			$data = explode('"',$data);
			$data2 = file_get_contents("http://translate.google.com/translate_a/t?client=p&text=".urlencode($palavra)."&hl=en&sl=en&tl=".$idioma."&ie=ISO-8859-1&oe=ISO-8859-1&multires=1&otf=1&ssel=0&tsel=0&sc=1");
//			echo "<br>***<br>";
//			echo $data2;
			$dados = json_decode(utf8_encode($data2));
//			echo "<br>****<br>";
//			print_r($dados);

			if($this->isdebug) {
				echo "Array google translator: ";
				print_r($dados);
				echo "<br>";
			}

//			$return[] = $data[1];
			if($dados->sentences[0]->trans == "") {
				$return[] = $palavra;	
			}
			else {
				$return[] = utf8_decode($dados->sentences[0]->trans);
					
				if(isset($dados->dict)) {
					foreach($dados->dict as $dict) {
						if($dict->pos == "adjective" || $dict->pos == "noun") {
							foreach($dict->entry as $entry) {
								if($entry->score > 0.01)
									$return[] = utf8_decode($entry->word);
							}
						}
					}						
				}
			}
			return $return;
		}
	}

	public function implode_key($glue = "", $pieces = array())
	{
		$keys = array_keys($pieces);
		return implode($glue, $keys);
	}
}

?>