<?php
$isEdit = false;

function getTemaPai($idTema, $pulsar, $database_pulsar) {
	$sql = "SELECT Pai FROM temas WHERE Id = $idTema";
	$rs = mysql_query($sql, $pulsar) or die(mysql_error());
	$row = mysql_fetch_array($rs);
	$pai = $row['Pai'];
	if($pai != 0)
		$pai .= ",".getTemaPai($row['Pai'], $pulsar, $database_pulsar);
	return $pai;
}

function getTemaFilho($idTema, $pulsar, $database_pulsar) {
	$sql = "SELECT Id FROM temas WHERE Pai In ($idTema)";
	$rs = mysql_query($sql, $pulsar) or die(mysql_error());
	$total = mysql_num_rows($rs);
	$filho = "";
	if($total != 0) {
		while($row = mysql_fetch_array($rs)) {
			if($filho != "") {
				$filho .= ",";
			}
			$filho .= $row['Id'];	
		}
		$tmpfilho = getTemaFilho($filho, $pulsar, $database_pulsar);
		$filho .= ($tmpfilho==""?"":",$tmpfilho");
	}
	return $filho;
}

mysql_select_db($database_pulsar, $pulsar);

$busca = isset($_GET['busca'])?$_GET['busca']:false;
$action = isset($_GET['action'])?$_GET['action']:false;

$whereBusca = "";

if($busca) {
	$idsBuscaArr = array();
	$sqlBusca = "SELECT Id FROM super_temas WHERE Tema_total LIKE '%$busca%' OR Tema_total_en LIKE '%$busca%'";
	$rsBusca = mysql_query($sqlBusca, $pulsar) or die(mysql_error());
	$totalBusca = mysql_num_rows($rsBusca);
	if($totalBusca>0 ) {
		while($rowBusca = mysql_fetch_array($rsBusca)) {
			$idsBuscaArr[] = $rowBusca['Id'].",".getTemaPai($rowBusca['Id'], $pulsar, $database_pulsar);
		}
		$idsBusca = implode(",", $idsBuscaArr);
		$whereBusca = "temas.Id IN ($idsBusca) AND";
	}
	else {
		$error = "Nenhum tema com essas palavras encontrado";
	}
}
if($action == "criar") {
	$tema = $_GET['tema'];
	$temaEn = $_GET['tema_en'];
	$pai = $_GET['tema_pai'];
	$sql = "SELECT * FROM temas WHERE Tema = '$tema' AND tema_en = '$temaEn'";
	$rs = mysql_query($sql, $pulsar) or die(mysql_error());
	$total = mysql_num_rows($rs);
	if($total == 0) {
		$sql = "INSERT INTO temas (Tema, Tema_en, Pai) VALUES ('$tema', '$temaEn', $pai)";
		$rs = mysql_query($sql, $pulsar) or die(mysql_error());
	// echo $sql;
		$newTemaId = mysql_insert_id();
		if($pai == 0) {
			$sql = "INSERT INTO super_temas (Id, Tema_total, Tema_total_en) VALUES ($newTemaId, '$tema', '$temaEn')";
	// echo $sql;
			$rs = mysql_query($sql, $pulsar) or die(mysql_error());
			$sql = "INSERT INTO lista_temas (id_tema, id_pai) VALUES ($newTemaId, $pai)";
			// echo $sql;
			$rs = mysql_query($sql, $pulsar) or die(mysql_error());
			$sql = "INSERT INTO lista_temas (id_tema, id_pai) VALUES ($newTemaId, $newTemaId)";
			// echo $sql;
			$rs = mysql_query($sql, $pulsar) or die(mysql_error());
				
		}
		else {
			$sql = "SELECT Tema_total, Tema_total_en FROM super_temas WHERE Id = $pai";
	// echo $sql;
			$rs = mysql_query($sql, $pulsar) or die(mysql_error());
			$row = mysql_fetch_array($rs);
			$temaTotal = $row['Tema_total']." - $tema";
			$temaTotalEn = $row['Tema_total_en']." - $temaEn";
			$sql = "INSERT INTO super_temas (Id, Tema_total, Tema_total_en) VALUES ($newTemaId, '$temaTotal', '$temaTotalEn')";
	// echo $sql;
			$rs = mysql_query($sql, $pulsar) or die(mysql_error());
			
			$sql = "SELECT id_pai FROM lista_temas WHERE id_tema = $pai";
	// echo $sql;
			$rs = mysql_query($sql, $pulsar) or die(mysql_error());
			while($row = mysql_fetch_array($rs)) {
				$sql2 = "INSERT INTO lista_temas (id_tema, id_pai) VALUES ($newTemaId, ".$row["id_pai"].")";
				// echo $sql;
				$rs2 = mysql_query($sql2, $pulsar) or die(mysql_error());
			}
			$sql = "INSERT INTO lista_temas (id_tema, id_pai) VALUES ($newTemaId, $newTemaId)";
			// echo $sql;
			$rs = mysql_query($sql, $pulsar) or die(mysql_error());
		}
		$msg = "Tema criado com sucesso!";
	}
	else 
		$error = "Tema já existe!";
}
else if($action == "edit") {
	$idTema = $_GET['id_tema'];
	$sqlEdit = "SELECT Id, Pai, Tema, Tema_en FROM temas WHERE Id = $idTema";
	$rsEdit = mysql_query($sqlEdit, $pulsar) or die(mysql_error());
	$rowEdit = mysql_fetch_array($rsEdit);
	$isEdit = true;
}
else if($action == "del") {
	$idTema = $_GET['id_tema'];
	$filhos = getTemaFilho($idTema, $pulsar, $database_pulsar);
	$ids = $idTema.($filhos!=""?",$filhos":""); 
	$sqlDel = "DELETE FROM temas WHERE Id IN ($ids)";
	$rsDel = mysql_query($sqlDel, $pulsar) or die(mysql_error());
	$sqlDel = "DELETE FROM super_temas WHERE Id IN ($ids)";
	$rsDel = mysql_query($sqlDel, $pulsar) or die(mysql_error());
	$sqlDel = "DELETE FROM lista_temas WHERE id_tema IN ($ids)";
	$rsDel = mysql_query($sqlDel, $pulsar) or die(mysql_error());
	$msg = "Tema excluído com sucesso!";
}
else if($action == "alterar") {
	$idTema = $_GET['id_tema'];
	$tema = $_GET['tema'];
	$temaEn = $_GET['tema_en'];
	$pai = $_GET['tema_pai'];
	
	$sqlUpdate = "UPDATE temas SET Pai = $pai, Tema = '$tema', Tema_en = '$temaEn' WHERE Id = $idTema";
// 	echo $sqlUpdate;
	$rsUpdate = mysql_query($sqlUpdate, $pulsar) or die(mysql_error());
	if($pai == 0) {
		$sql = "UPDATE super_temas SET Tema_total = '$tema', Tema_total_en = '$temaEn' WHERE Id = $idTema";
		// echo $sql;
		$rs = mysql_query($sql, $pulsar) or die(mysql_error());
	}
	else {
		$sql = "SELECT Tema_total, Tema_total_en FROM super_temas WHERE Id = $pai";
		// echo $sql;
		$rs = mysql_query($sql, $pulsar) or die(mysql_error());
		$row = mysql_fetch_array($rs);
		$temaTotal = $row['Tema_total']." - $tema";
		$temaTotalEn = $row['Tema_total_en']." - $temaEn";
		$sql = "UPDATE super_temas SET Tema_total = '$temaTotal', Tema_total_en = '$temaTotalEn' WHERE Id = $idTema";
		// echo $sql;
		$rs = mysql_query($sql, $pulsar) or die(mysql_error());
	}
	$msg = "Tema alterado com sucesso!";
}

$queryTemas = "SELECT * FROM super_temas ORDER BY Tema_total ASC";
$rsTemas = mysql_query($queryTemas, $pulsar) or die(mysql_error());


// mysql_select_db($database_pulsar, $pulsar);
// $query_nivel1 = "SELECT * FROM temas WHERE Pai = 0 ORDER BY Tema ASC";
// $nivel1 = mysql_query($query_nivel1, $pulsar) or die(mysql_error());

// $colname_nivel2 = "-1";
// if (isset($_GET['nivel1'])) {
// 	$colname_nivel2 = (get_magic_quotes_gpc()) ? $_GET['nivel1'] : addslashes($_GET['nivel1']);
// }
// mysql_select_db($database_pulsar, $pulsar);
// $query_nivel2 = sprintf("SELECT * FROM temas WHERE Pai = %s ORDER BY Tema ASC", $colname_nivel2);
// $nivel2 = mysql_query($query_nivel2, $pulsar) or die(mysql_error());
// $row_nivel2 = mysql_fetch_assoc($nivel2);
// $totalRows_nivel2 = mysql_num_rows($nivel2);

// $colname_nivel3 = "-1";
// if (isset($_GET['nivel2'])) {
// 	$colname_nivel3 = (get_magic_quotes_gpc()) ? $_GET['nivel2'] : addslashes($_GET['nivel2']);
// }
// mysql_select_db($database_pulsar, $pulsar);
// $query_nivel3 = sprintf("SELECT * FROM temas WHERE Pai = %s ORDER BY Tema ASC", $colname_nivel3);
// $nivel3 = mysql_query($query_nivel3, $pulsar) or die(mysql_error());
// $row_nivel3 = mysql_fetch_assoc($nivel3);
// $totalRows_nivel3 = mysql_num_rows($nivel3);

// $colname_nivel4 = "-1";
// if (isset($_GET['nivel3'])) {
// 	$colname_nivel4 = (get_magic_quotes_gpc()) ? $_GET['nivel3'] : addslashes($_GET['nivel3']);
// }
// mysql_select_db($database_pulsar, $pulsar);
// $query_nivel4 = sprintf("SELECT * FROM temas WHERE Pai = %s ORDER BY Tema ASC", $colname_nivel4);
// $nivel4 = mysql_query($query_nivel4, $pulsar) or die(mysql_error());
// $row_nivel4 = mysql_fetch_assoc($nivel4);
// $totalRows_nivel4 = mysql_num_rows($nivel4);

?>