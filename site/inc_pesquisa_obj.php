<?php require_once('Connections/pulsar.php'); ?>
<?php
class elementoPesquisa {
	public $arrCampos = array("tombo"=>false,"pc"=>false,"assunto"=>false,"extra"=>false,"cidade"=>false,"estado"=>false,"id_estado"=>false,"pais"=>false,"id_temas"=>false,"temas"=>false,"id_autor"=>false,"email_id"=>false);
	public $fracao = false;
	public $pc = 0;
	public $not = false;
	public $arrPalavras = array();
	public $searchVars = false;
	public $avancada = false;
	
	function setAll() {
		foreach($this->arrCampos as $campo=>$val) {
			$this->arrCampos[$campo] = true;
			$this->searchVars = true;
		}
//		$this->arrCampos['tombo'] = false;
		$this->arrCampos['id_estado'] = false;
		$this->arrCampos['email_id'] = false;
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
								else if($campo == "cidade") {
									echo "<input type='hidden' name='local' value='".$palavra."'/>";
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
	public $dbSig;
	public $pesquisas = array();
	public $cntPal = 0;
	public $query = "";
	public $idioma = "en";//br";
	public $lastTmp = "Fotos";
	public $totalRows_retorno = 0;
	public $order = "ORDER BY Fotos.Id_Foto DESC";
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
	
	public $royaltfree_param = array("idade"=>false,"id_temas_ex"=>array(),"id_autores_ex"=>array(),"indice_vendas"=>false,"indice_anos"=>false);
	
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
			
			$this->query .= "DELETE FROM $this->lastTmp WHERE Id_Foto = 0; SELECT count(*) as cnt FROM $this->lastTmp;";
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
						if($selectTable != "Fotos")
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos.Id_Foto) AS cnt FROM $selectTable $selectJoin WHERE Fotos.tombo RLIKE '^[0-9]'";
						break;
					case "video":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos")
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos.Id_Foto) AS cnt FROM $selectTable $selectJoin WHERE Fotos.tombo RLIKE '^[A-Z]'";
						break;
					case "fullhd":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos") 
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos.Id_Foto) AS cnt FROM $selectTable $selectJoin LEFT JOIN videos_extra ON videos_extra.tombo = Fotos.tombo WHERE Fotos.tombo RLIKE '^[A-Z]' AND videos_extra.resolucao = '1920x1080'";
						break;
					case "hd":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos")
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos.Id_Foto) AS cnt FROM $selectTable $selectJoin LEFT JOIN videos_extra ON videos_extra.tombo = Fotos.tombo WHERE Fotos.tombo RLIKE '^[A-Z]' AND videos_extra.resolucao = '1280x720'";
						break;					
					case "sd":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos")
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos.Id_Foto) AS cnt FROM $selectTable $selectJoin LEFT JOIN videos_extra ON videos_extra.tombo = Fotos.tombo WHERE Fotos.tombo RLIKE '^[A-Z]' AND (videos_extra.resolucao = '768x576' OR videos_extra.resolucao = '720x480')";
						break;					
					case "h":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos")
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos.Id_Foto) AS cnt FROM $selectTable $selectJoin WHERE Fotos.tombo RLIKE '^[0-9]' AND dim_a > dim_b";
						break;	
					case "v":
						$selectTable = $this->lastTmp;
						$selectJoin = "";
						if($selectTable != "Fotos")
							$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
						$tmpQuery = "SELECT count(Fotos.Id_Foto) AS cnt FROM $selectTable $selectJoin WHERE Fotos.tombo RLIKE '^[0-9]' AND dim_a < dim_b";
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
		if($selectTable != "Fotos")
			$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
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
				$query_ordem = "ORDER BY Fotos.dim_a * Fotos.dim_b DESC, find_in_set(videos_extra.resolucao, '1920x1080,1280x720,720x480')";
			}
			else if($ordem == "relevancia") {
				$palavra_composta_arr = array();
				$palavraTmpPC = "";
				$minLen = 0;
				$maxLenAdd = 0;
				$maxPalavraLen = 0;
				foreach($this->pesquisas as $pesquisa) {
					foreach($pesquisa->arrPalavras as $palavra=>$idioma) {
						$raw_palavra = $palavra;
						$palavra = str_ireplace("a", "[aàâäãá]", $palavra);
						$palavra = str_ireplace("e", "[eèêëé]", $palavra);
						$palavra = str_ireplace("i", "[iìîïí]", $palavra);
						$palavra = str_ireplace("o", "[oòôöõó]", $palavra);
						$palavra = str_ireplace("u", "[uùûüú]", $palavra);
						$palavra = str_ireplace("c", "[cç]", $palavra);
						$palavra = str_ireplace("n", "[nñ]", $palavra);
						$palavra = str_ireplace("-", " ", $palavra);
						$palavra = str_ireplace(" ", "[- ]", $palavra);
							
	//					$palavra = $palavra."s?";
							
						if(!$pesquisa->fracao) {
							$palavra_composta_arr[] = "[[:<:]]".$palavra."[[:>:]][ -]*[[[:alpha:]]{0,2}]*[ -]*";
							$len = strlen($raw_palavra);
							$minLen += $len;
							$maxLenAdd += 4;
							if($len > $maxPalavraLen) {
								$maxPalavraLen = $len;
								$palavraTmpPC = $raw_palavra;
							}
						}
					}
				}
				if(count($palavra_composta_arr)>1 && count($palavra_composta_arr)<6) {
					
					$idioma = "";
					if($this->idioma != "br")
						$idioma = "_en";
						
					$palavra_composta = array();
					$this->pc_permute($palavra_composta, $palavra_composta_arr);
					$palavra_composta_imp_assunto = implode("') OR Fotos.assunto_principal RLIKE trim('", $palavra_composta);
					$palavra_composta_imp_extra = implode("') OR Fotos.extra RLIKE trim('", $palavra_composta);
					$palavra_composta_imp_cidade = str_ireplace("Fotos.assunto_principal", "Fotos.cidade", $palavra_composta_imp_assunto); 									
					$palavra_composta_imp_estado = str_ireplace("Fotos.assunto_principal", "Estados.Sigla", $palavra_composta_imp_assunto); 									
					$palavra_composta_imp_estado2 = str_ireplace("Fotos.assunto_principal", "Estados.Estado", $palavra_composta_imp_assunto); 									
					$palavra_composta_imp_pais = str_ireplace("Fotos.assunto_principal", "paises.nome$idioma", $palavra_composta_imp_assunto); 									
					$palavra_composta_imp_pc = str_ireplace("Fotos.assunto_principal", "pal_chave.Pal_Chave$idioma", $palavra_composta_imp_assunto); 									
// 					$palavra_imp_pc = implode("%' OR Pal_Chave LIKE '%", $palavra_arr);
					
					$selectTable = $this->lastTmp;
					$selectJoin = "";
					if($selectTable != "Fotos")
						$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
					
					
					$tmpTable = "pesq$this->cntPal";
					$relQuery = "DROP TEMPORARY TABLE IF EXISTS $tmpTable; CREATE TEMPORARY TABLE $tmpTable (id int(11) auto_increment PRIMARY KEY, Id_Foto int(11) NOT NULL UNIQUE DEFAULT 0) ENGINE = MEMORY; ";
					$this->cntPal++;			
					
					$this->lastTmp = $tmpTable;
					
					$maxLen = $minLen + $maxLenAdd;
					$tmpPc = "DROP TEMPORARY TABLE IF EXISTS tmpPc; CREATE TEMPORARY TABLE tmpPc SELECT Id_Foto from rel_fotos_pal_ch 
								LEFT JOIN (SELECT * from pal_chave 
											WHERE (length(Pal_Chave) > $minLen AND length(Pal_Chave) < $maxLen) 
											AND (Pal_Chave LIKE '%$palavraTmpPC%')) AS pal_chave ON rel_fotos_pal_ch.id_palavra_chave = pal_chave.Id
								WHERE pal_chave.Pal_Chave$idioma RLIKE trim('$palavra_composta_imp_pc'); CREATE INDEX id_foto ON tmpPc(Id_Foto)";
					
					$relQuery .= "$tmpPc; INSERT IGNORE INTO $tmpTable (Id_Foto) 
									SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
									
									LEFT JOIN paises ON (paises.id_pais=Fotos.id_pais)
									LEFT JOIN Estados ON (Estados.id_estado=Fotos.id_estado)
									LEFT JOIN tmpPc ON (Fotos.Id_Foto=tmpPc.id_foto)

									WHERE Fotos.assunto_principal RLIKE trim('$palavra_composta_imp_assunto')
									OR Fotos.extra RLIKE trim('$palavra_composta_imp_extra') 
									OR Fotos.cidade RLIKE trim('$palavra_composta_imp_cidade')
									OR Estados.Estado RLIKE trim('$palavra_composta_imp_estado2')
									OR paises.nome$idioma RLIKE trim('$palavra_composta_imp_pais')
									OR tmpPc.Id_Foto IS NOT NULL
									ORDER BY Fotos.data_foto DESC, Fotos.id_autor ASC, Fotos.tombo DESC;";
//									INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
//									OR pal_chave.Pal_Chave$idioma RLIKE trim('$palavra_composta_imp_pc')
//									INNER JOIN rel_fotos_pal_ch ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
						
					if($selectTable != "Fotos") {
						$relQuery .= "DELETE FROM $selectTable WHERE Id_Foto IN (SELECT Id_Foto FROM $tmpTable);";
						$relQuery .= "INSERT IGNORE INTO $tmpTable (Id_Foto) SELECT Fotos.Id_Foto FROM $selectTable $selectJoin ORDER BY Fotos.data_foto DESC, Fotos.id_autor ASC, Fotos.tombo DESC;";
						$relQuery .= "DELETE FROM $selectTable WHERE Id_Foto IN (SELECT Id_Foto FROM $tmpTable);";
					}
					else {
						echo "ERRO CRITICO! Envie o endereço para pulsar@pulsarimagens.com.br!!!";
					}
					
					if($this->isdebug)
						echo "Query Relevancia: <br>$relQuery<br>";
					
					$queries = explode(";",$relQuery);
					mysql_select_db($this->db, $this->dbConn);
					$timeBefore = microtime(true);
					do {
					
						$result = mysql_query($queries[key($queries)], $this->dbConn) or die(mysql_error());
						if($this->isdebug)
							echo "Colunas alteradas: ".mysql_affected_rows()."<br>";
					
					} while (next($queries));
					$timeAfter = microtime(true);
					$diff = $timeAfter - $timeBefore;
					if($this->isdebug)
						echo "<strong>Tempo relevancia: </strong>".$diff."<br>";
					
					
					$query_ordem = "ORDER BY id ASC";
				}
				else if(count($palavra_composta_arr)==1) {
					
					$idioma = "";
					if($this->idioma != "br")
						$idioma = "_en";
						
					$selectTable = $this->lastTmp;
					$selectJoin = "";
					if($selectTable != "Fotos")
						$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
					
					
					$tmpTable = "pesq$this->cntPal";
					$relQuery = "DROP TEMPORARY TABLE IF EXISTS $tmpTable; CREATE TEMPORARY TABLE $tmpTable (id int(11) auto_increment PRIMARY KEY, Id_Foto int(11) NOT NULL UNIQUE DEFAULT 0) ENGINE = MEMORY; ";
					$this->cntPal++;			
					
					$this->lastTmp = $tmpTable;
					
					$tmpPc = "DROP TEMPORARY TABLE IF EXISTS tmpPc; CREATE TEMPORARY TABLE tmpPc SELECT Id_Foto from rel_fotos_pal_ch 
								LEFT JOIN (SELECT * from pal_chave 
											WHERE (Pal_Chave RLIKE '$palavra')) AS pal_chave ON rel_fotos_pal_ch.id_palavra_chave = pal_chave.Id
								WHERE pal_chave.Pal_Chave$idioma RLIKE trim('$palavra'); CREATE INDEX id_foto ON tmpPc(Id_Foto)";
					
					$relQuery .= "$tmpPc; INSERT IGNORE INTO $tmpTable (Id_Foto) 
									SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
									
									LEFT JOIN paises ON (paises.id_pais=Fotos.id_pais)
									LEFT JOIN Estados ON (Estados.id_estado=Fotos.id_estado)
									LEFT JOIN tmpPc ON (Fotos.Id_Foto=tmpPc.id_foto)

									WHERE Fotos.assunto_principal RLIKE trim('$palavra')
									OR Fotos.extra RLIKE trim('$palavra') 
									OR Fotos.cidade RLIKE trim('$palavra')
									OR Estados.Sigla RLIKE trim('$palavra')
									OR Estados.Estado RLIKE trim('$palavra')
									OR paises.nome$idioma RLIKE trim('$palavra')
									OR tmpPc.Id_Foto IS NOT NULL
									ORDER BY Fotos.data_foto DESC, Fotos.id_autor ASC, Fotos.tombo DESC;";
//									INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
//									OR pal_chave.Pal_Chave$idioma RLIKE trim('$palavra_composta_imp_pc')
//									INNER JOIN rel_fotos_pal_ch ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
						
					if($selectTable != "Fotos") {
						$relQuery .= "DELETE FROM $selectTable WHERE Id_Foto IN (SELECT Id_Foto FROM $tmpTable);";
						$relQuery .= "INSERT IGNORE INTO $tmpTable (Id_Foto) SELECT Fotos.Id_Foto FROM $selectTable $selectJoin ORDER BY Fotos.data_foto DESC, Fotos.id_autor ASC, Fotos.tombo DESC;";
						$relQuery .= "DELETE FROM $selectTable WHERE Id_Foto IN (SELECT Id_Foto FROM $tmpTable);";
					}
					else {
						echo "ERRO CRITICO! Envie o endereço para pulsar@pulsarimagens.com.br!!!";
					}
					
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
					$query_ordem = "ORDER BY Fotos.data_foto DESC, Fotos.id_autor ASC, Fotos.tombo DESC";
				}
			}
			else if($ordem == "royalt-free") {
				
				$idioma = "";
				if($this->idioma != "br")
					$idioma = "_en";
				
				$selectTable = $this->lastTmp;
				$selectJoin = "";
				if($selectTable != "Fotos")
					$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
				
				$tmpTable = "pesq$this->cntPal";
				$relQuery = "DROP TEMPORARY TABLE IF EXISTS $tmpTable; CREATE TEMPORARY TABLE $tmpTable (id int(11) auto_increment PRIMARY KEY, Id_Foto int(11) NOT NULL UNIQUE DEFAULT 0) ENGINE = MEMORY; ";
				$this->cntPal++;
				$this->lastTmp = $tmpTable;
				
				$ano = 2013 - $this->royaltfree_param['idade'];
				$ano .= "0000";
				
				$relQuery_temas = "";
				if(count($this->royaltfree_param['id_temas_ex']) > 0) {
					$id_temas_ex = implode(",",$this->royaltfree_param['id_temas_ex']);
					$relQuery_temas = " AND rel_fotos_temas.id_foto NOT IN ($id_temas_ex) ";
				}
				
				$relQuery_autores = "";
				if(count($this->royaltfree_param['id_autores_ex']) > 0) {
					$id_autor_ex = implode(",",$this->royaltfree_param['id_autores_ex']);
					$relQuery_autores = " AND Fotos.id_autor NOT IN ($id_autor_ex) ";
				}
				
				$tmpVendas = "";
				$relQuery_vendas = "";
				if($this->royaltfree_param['indice_vendas'] !== false) { 
					$dataCorte = 2013 - $this->royaltfree_param['indice_anos'];
					$vendasCorte = $this->royaltfree_param['indice_vendas'];
					
					$tmpVendas = "DROP TEMPORARY TABLE IF EXISTS tmpVendas; CREATE TEMPORARY TABLE tmpVendas ";
					$tmpVendas .= "SELECT CODIGO FROM (
									SELECT CODIGO,count(CODIGO) AS vendas 
										FROM $this->dbSig.CROMOS 
										LEFT JOIN $this->dbSig.CONTRATOS ON (CROMOS.ID_CONTRATO = CONTRATOS.ID) 
										WHERE YEAR(CONTRATOS.DATA) > $dataCorte GROUP BY CODIGO
									) as tmp 
									WHERE vendas > $vendasCorte; CREATE INDEX tombo ON tmpVendas (CODIGO);";
					$selectJoin .= " LEFT JOIN tmpVendas ON (tmpVendas.CODIGO = Fotos.tombo) ";
					$relQuery_vendas = " AND tmpVendas.CODIGO IS NULL ";
				}
				
				$relQuery .= "$tmpVendas INSERT IGNORE INTO $tmpTable (Id_Foto) 
								SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
								INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
								WHERE Fotos.data_foto < '$ano'
								$relQuery_temas
								$relQuery_autores
								$relQuery_vendas
								ORDER BY Fotos.data_foto DESC, Fotos.id_autor ASC, Fotos.tombo DESC";
					
				if($this->isdebug)
					echo "Query Royalt-Free: <br>$relQuery<br>";
									
				$queries = explode(";",$relQuery);
				mysql_select_db($this->db, $this->dbConn);
				$timeBefore = microtime(true);
				do {
							
					$result = mysql_query($queries[key($queries)], $this->dbConn) or die(mysql_error());
									
				} while (next($queries));
				$timeAfter = microtime(true);
				$diff = $timeAfter - $timeBefore;
				if($this->isdebug)
					echo "<strong>Tempo Royalt-Free: </strong>".$diff."<br>";
				if($this->isdebug) {
					$sql = "SELECT COUNT(*) as cnt FROM $tmpTable";
					$result = mysql_query($sql, $this->dbConn) or die(mysql_error());
					$row = mysql_fetch_array($result);
					$cnt = $row['cnt'];
					echo "<strong>Itens retornados:</strong> $cnt<br>";
				}
				
				$query_ordem = "ORDER BY id ASC";
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
//							$this->posfilter_join = "LEFT JOIN videos_extra ON videos_extra.tombo = Fotos.tombo";
							if($this->posfilter_where != "")
								$this->posfilter_where .= " OR ";
							$this->posfilter_where .= "(Fotos.tombo RLIKE '^[A-Z]' AND videos_extra.resolucao = '1920x1080')";
							$this->add_where = "WHERE";
							break;
						case "hd":
//							$this->posfilter_join = "LEFT JOIN videos_extra ON videos_extra.tombo = Fotos.tombo";
							if($this->posfilter_where != "")
								$this->posfilter_where .= " OR ";
							$this->posfilter_where .= "(Fotos.tombo RLIKE '^[A-Z]' AND videos_extra.resolucao = '1280x720')";
							$this->add_where = "WHERE";
							break;					
						case "sd":
//							$this->posfilter_join = "LEFT JOIN videos_extra ON videos_extra.tombo = Fotos.tombo";
							if($this->posfilter_where != "")
								$this->posfilter_where .= " OR ";
							$this->posfilter_where .= "(Fotos.tombo RLIKE '^[A-Z]' AND (videos_extra.resolucao = '768x576' OR videos_extra.resolucao = '720x480'))";
							$this->add_where = "WHERE";
							break;					
						case "h":
							if($this->posfilter_where != "")
								$this->posfilter_where .= " OR ";
							$this->posfilter_where .= "(Fotos.tombo RLIKE '^[0-9]' AND Fotos.dim_a > Fotos.dim_b)";
							$this->add_where = "WHERE";
							break;	
						case "v":
							if($this->posfilter_where != "")
								$this->posfilter_where .= " OR ";
							$this->posfilter_where .= "(Fotos.tombo RLIKE '^[0-9]' AND Fotos.dim_a < Fotos.dim_b)";
							$this->add_where = "WHERE";
							break;	
					}
				}
			}
			
			$idioma = "";
			if($this->idioma != "br")
				$idioma = "_en";				
			
			$query = "SELECT DISTINCT
					  tmp.Id_Foto,
					  Fotos.assunto_principal,
					  Fotos.cidade,
					  Estados.Sigla,
					  paises.nome$idioma as nome,
					  Fotos.orientacao,
					  Fotos.tombo,
					  Fotos.data_foto,
					  Fotos.dim_a,
					  Fotos.dim_b,
					  Fotos_extra.extra,
					  videos_extra.resolucao
					  FROM $this->lastTmp as tmp 
					  LEFT JOIN Fotos ON tmp.Id_Foto = Fotos.Id_Foto
					  LEFT JOIN Fotos_extra ON Fotos.tombo = Fotos_extra.tombo
					  LEFT JOIN videos_extra ON Fotos.tombo = videos_extra.tombo
					  LEFT JOIN Estados ON Fotos.id_estado = Estados.id_estado
					  LEFT JOIN paises ON Fotos.id_pais = paises.id_pais
					  LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
					  $this->posfilter_join
					  $this->add_where
					  $this->posfilter_where	
					  GROUP BY tmp.Id_Foto
					  $this->order
					  LIMIT $startRow_retorno, $maxRows_retorno";
/*
//					  codigo_video.status
//					  LEFT JOIN codigo_video ON codigo_video.codigo = Fotos.tombo

 * 			
			if($this->idioma != "br") {
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
			Fotos.Id_Foto,
			Fotos.assunto_principal,
			Fotos.assunto_en,
			Fotos.cidade,
			Estados.Sigla,
			paises.nome$idioma as nome,
			Fotos.orientacao,
			Fotos.tombo,
			Fotos.data_foto,
			Fotos.dim_a,
			Fotos.dim_b,
			Fotos.direito_img,
			Fotos_extra.extra,
			videos_extra.resolucao
			FROM Fotos
			LEFT JOIN Fotos_extra ON Fotos.tombo = Fotos_extra.tombo
			LEFT JOIN videos_extra ON Fotos.tombo = videos_extra.tombo
			LEFT JOIN Estados ON Fotos.id_estado = Estados.id_estado
			LEFT JOIN paises ON Fotos.id_pais = paises.id_pais
			LEFT JOIN log_count_view ON Fotos.Id_Foto = log_count_view.Id_Foto
			WHERE Fotos.tombo IN ($codigos_aspas)
			ORDER BY find_in_set(Fotos.tombo, '$codigos')";
			//FIELD( category, 'First', 'Second' )
/*				
			if($this->idioma != "br") {
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
						FROM (SELECT tmp.Id_Foto,Fotos.tombo FROM $this->lastTmp as tmp
						LEFT JOIN Fotos ON tmp.Id_Foto = Fotos.Id_Foto
						LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
						LEFT JOIN videos_extra ON videos_extra.tombo = Fotos.tombo
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

	function getCodigos() {
		if($this->isEnable) {
			mysql_query("SET group_concat_max_len=2000000", $this->dbConn) or die(mysql_error());
			$query = "SELECT tmp2.tombo 
			FROM (SELECT tmp.Id_Foto,Fotos.tombo FROM $this->lastTmp as tmp
			LEFT JOIN Fotos ON tmp.Id_Foto = Fotos.Id_Foto
			LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
			LEFT JOIN videos_extra ON videos_extra.tombo = Fotos.tombo
			$this->posfilter_join
			$this->add_where
			$this->posfilter_where
			$this->order) as tmp2";
			if($this->isdebug)
				echo "Query getCodigos: <br>$query<br>";
			mysql_select_db($this->db, $this->dbConn);
			$timeBefore = microtime(true);
			$result = mysql_query($query, $this->dbConn) or die(mysql_error());

			if($this->isdebug) {
				$timeAfter = microtime(true);
				$diff = $timeAfter - $timeBefore;
			}
			if($this->isdebug)
				echo "<strong>Tempo GetCodigos: </strong>".$diff."<br>";
			return $result;
		}
	}
	
	function getTotal() {
		if($this->isEnable) {
			$query = "SELECT count(tmp.Id_Foto) AS cnt FROM $this->lastTmp as tmp
			LEFT JOIN Fotos ON tmp.Id_Foto = Fotos.Id_Foto
			LEFT JOIN log_count_view ON tmp.Id_Foto = log_count_view.Id_Foto
			LEFT JOIN videos_extra ON videos_extra.tombo = Fotos.tombo
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
			if($tmpTable != "Fotos") {
				$tmpQuery = "DELETE FROM $tmpTable WHERE tmp.Id_Foto NOT IN ($tmpQuery)";			}
			else {
				echo "ERRO CRITICO! Envie o endereço para pulsar@pulsarimagens.com.br!!!";
			}
			
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
		
		$minSizePrev = isset($newPesquisaCount[0])?$newPesquisaCount[0]:0;//-1;
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
				$selectTable = "Fotos";
				$selectJoin = "";
				if($this->cntPal != 0) {
					$selectTable = $tmpTable;
					$selectJoin = " LEFT JOIN Fotos ON Fotos.Id_Foto = $selectTable.Id_Foto ";
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
						
						$palavra = preg_replace("/[àâäãá]/","a", $palavra);
						$palavra = preg_replace("/[èêëé]/","e", $palavra);
						$palavra = preg_replace("/[ìîïí]/","i", $palavra);
						$palavra = preg_replace("/[òôöõó]/","o", $palavra);
						$palavra = preg_replace("/[ùûüú]/","u", $palavra);
						$palavra = preg_replace("/[ç]/","c", $palavra);
						$palavra = preg_replace("/[ñ]/","n", $palavra);
						
						$palavra = preg_replace("/s\b/", "~", $palavra);
						$palavra = preg_replace("/[ao]\b/", "^", $palavra);
// 						$palavra = preg_replace("/o\b/", "^", $palavra);
// echo "*** $palavra ***";
						$rawPalavraCutted = str_ireplace("~", "", $palavra);
						$rawPalavraCutted = str_ireplace("^", "", $rawPalavraCutted );
						
						$palavra = str_ireplace("a", "[aàâäãá]", $palavra);
						$palavra = str_ireplace("e", "[eèêëé]", $palavra);
						$palavra = str_ireplace("i", "[iìîïí]", $palavra);
						$palavra = str_ireplace("o", "[oòôöõó]", $palavra);
						$palavra = str_ireplace("u", "[uùûüú]", $palavra);
						$palavra = str_ireplace("c", "[cç]", $palavra);
						$palavra = str_ireplace("n", "[nñ]", $palavra);
						$palavra = str_ireplace("-", " ", $palavra);
						$palavra = str_ireplace(" ", "[- ]", $palavra);

						$palavra = str_ireplace("^~", "^", $palavra);
						$palavra = str_ireplace("^", "[aàâäãáoòôöõó]~", $palavra);
						$palavra = str_ireplace("~", "s?", $palavra);
							
						if(!$pesquisa->fracao) {
							$palavra = "[[:<:]]".$palavra."[[:>:]]";
						}
							
						switch($campo) {
							
							case "tombo":
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin WHERE Fotos.tombo $operator '$raw_palavra'";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								//$finish = true;
								break;
							case "pc":
								$coluna = "Pal_Chave";
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
												INNER JOIN rel_fotos_pal_ch ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
												INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
												WHERE (pal_chave.$coluna $operator '$palavra') AND $selectTable.Id_Foto != 0";
								if($pesquisa->not) {
									$tmpQuery = "SELECT Id_Foto FROM (SELECT $selectTable.Id_Foto, group_concat(pal_chave.$coluna separator ' , ') as Pal_Chaves FROM rel_fotos_pal_ch
													STRAIGHT_JOIN $selectTable ON ($selectTable.Id_Foto=rel_fotos_pal_ch.id_foto)
													LEFT JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE $selectTable.Id_Foto != 0 GROUP BY $selectTable.Id_Foto) as tmp
													WHERE (Pal_Chaves $operator '$palavra')";
								}
								else {
									$tmpQuery = "SELECT $selectTable.Id_Foto FROM rel_fotos_pal_ch
													STRAIGHT_JOIN $selectTable ON ($selectTable.Id_Foto=rel_fotos_pal_ch.id_foto)
													LEFT JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
													WHERE (pal_chave.$coluna $operator '$palavra') AND $selectTable.Id_Foto != 0";
								}
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								if($this->idioma != "br") { 
									$coluna = "Pal_Chave_en";
									$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
													INNER JOIN rel_fotos_pal_ch ON (Fotos.Id_Foto=rel_fotos_pal_ch.id_foto)
													INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
													WHERE (pal_chave.$coluna $operator '$palavra') AND $selectTable.Id_Foto != 0";
									$tmpQuery = "SELECT $selectTable.Id_Foto FROM rel_fotos_pal_ch
													STRAIGHT_JOIN $selectTable ON ($selectTable.Id_Foto=rel_fotos_pal_ch.id_foto)
													LEFT JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave)
													WHERE (pal_chave.$coluna $operator '$palavra') AND $selectTable.Id_Foto != 0";
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
									$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
													INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
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
										$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
										INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto)
										INNER JOIN temas ON (temas.Id=rel_fotos_temas.id_tema)
										WHERE ($novaTemas_query)";
										$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
									}
								}
								break;
							case "assunto":
								$thisTable = ($selectTable == "Fotos")?"(SELECT Id_Foto,assunto_principal FROM Fotos WHERE convert(assunto_principal USING utf8) LIKE '%".$rawPalavraCutted."%') as Fotos":$selectTable;
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $thisTable $selectJoin
												WHERE (Fotos.assunto_principal $operator '$palavra')";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "extra":
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin 
												WHERE (Fotos.extra $operator '$palavra')";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "cidade":
								if($pesquisa->avancada) {
									$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
													WHERE (convert(Fotos.cidade USING utf8) ".str_replace("RLIKE", "LIKE", $operator)." '$raw_palavra')";
								} else {
									$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin 
													WHERE (Fotos.cidade $operator '$palavra')";
								}
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "estado":
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
												RIGHT JOIN (
													SELECT * FROM Estados 
													WHERE ((Estados.Estado $operator '$palavra')  OR  (Estados.Sigla $operator '$palavra'))
												) as Estados ON (Estados.id_estado=Fotos.id_estado)";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "id_estado":
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
												INNER JOIN Estados ON (Estados.id_estado=Fotos.id_estado)
												WHERE (Estados.id_estado = $raw_palavra)";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								break;
							case "pais":
								$coluna = "nome";
								$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
												RIGHT JOIN (
													SELECT * from paises WHERE ((paises.$coluna $operator '$palavra')  OR  (paises.id_pais $operator '$palavra'))
												) as paises ON (paises.id_pais=Fotos.id_pais)";
								$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								if($this->idioma != "br") {
									$coluna = "nome_en";
									$tmpQuery = "SELECT Fotos.Id_Foto FROM $selectTable $selectJoin
													INNER JOIN paises ON (paises.id_pais=Fotos.id_pais)
													WHERE ((paises.$coluna $operator '$palavra')  OR  (paises.id_pais $operator '$palavra'))";
									$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
								}
								break;
							case "email_id":
									$tmpQuery = "SELECT Fotos.Id_Foto FROM email_fotos
									INNER JOIN Fotos ON (email_fotos.tombo=Fotos.tombo)
									WHERE (id_email = $raw_palavra)";
									$this->createQueryLine($tmpQuery, $tmpTable, $isInsert);
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