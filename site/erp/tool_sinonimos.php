<?php
mysql_select_db($database_pulsar, $pulsar);
mysql_select_db($database_sig, $sig);

if(isset($_GET['palavras-chave'])) { 
	$palavras = $_GET['palavras-chave'];
	$palavrasArr = explode(";", $palavras);
	$totaisArr = array();
	
	$CodigoPalavrasArr = array();

	include("../inc_pesquisa_obj.php");
	
	foreach ($palavrasArr as $palavra) {
		if(strlen($palavra)>2) {
			$pesquisas = array();
			$engine = new pesquisaPulsar();
			$engine->dbConn = $pulsar;
			$engine->db = $database_pulsar;
			$engine->connect();
			$engine->idioma = "br";
			if($siteDebug)
				$engine->isdebug = true;
			
			$pesq = new elementoPesquisa();
			$pesq->arrPalavras[$palavra] = "br";
			$pesq->arrCampos['pc'] = true;;
			$pesquisas[] = $pesq;
			$engine->pesquisas = $pesquisas;
			$engine->isEnable = true;
			$engine->createQuery();
			$engine->filter();
			$engine->executeQuery();
			$ordem="recente";
			$engine->order($ordem);
			$result = $engine->getCodigos();
			while($row = mysql_fetch_array($result)) {
				if(!array_key_exists($row['tombo'], $CodigoPalavrasArr))
					$CodigoPalavrasArr[$row['tombo']] = array();
				$CodigoPalavrasArr[$row['tombo']][] = $palavra;				
			}
			$totaisArr[$palavra] = $engine->getTotal();
		}
	}
//	print_r($CodigoPalavrasArr);
}
?>