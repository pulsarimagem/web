<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php
header('Content-Type: text/html; charset=ISO-8859-1');

$action = $_POST['action'];


if($action == "savePage") {
	$page_num = $_POST['page_num'];
	$_SESSION['page_num_details_nav'] = $page_num;
	$_SESSION['page_num_details_li'] = $page_num;
}
else if ($action == "sendHistory") {
	$updateSQL = "UPDATE cotacao_2 SET atendida = 1, data_hora_atendida = '".date("Y-m-d H:i:s", strtotime('now'))."' WHERE id_cotacao2 = ".$_POST['id'];
	mysql_select_db($database_pulsar, $pulsar);
	$Result1 = mysql_query($updateSQL, $pulsar) or die(mysql_error());
}
else if($action == "utilizacao") {
	$idioma = $_POST['idioma'];
	$contrato = $_POST['contrato'];
	$id_tipo = $_POST['id_tipo'];
	$utilizacao = isset($_POST['id_utilizacao'])?$_POST['id_utilizacao']:"";
	$queryUtilizacao = "select uso.id_utilizacao, uso_subtipo.subtipo_$idioma as utilizacao 
						from USO as uso
						left join USO_SUBTIPO as uso_subtipo on uso_subtipo.Id = uso.id_utilizacao
						WHERE uso.id_tipo = $id_tipo AND uso.contrato = '$contrato' AND uso.status > 0
						GROUP BY utilizacao ORDER BY utilizacao";

	echo $queryUtilizacao;
	
	$rsUtilizacao = mysql_query($queryUtilizacao, $sig) or die('<option value="">--- Tipo de projeto inválido ---</option>');
	$totalUtilizacao = mysql_num_rows($rsUtilizacao);
			if($totalUtilizacao > 0) {
			?>
							<option value=""></option>
<?php 	
	}
	else if($totalUtilizacao == 0) {
?>
							<option value="">--- Tipo de projeto inválido ---</option>
<?php		
	}
	while($rowUtilizacao = mysql_fetch_array($rsUtilizacao)) {
		if($rowUtilizacao['utilizacao']!="ocultar") {
?>
		                  	<option value="<?php echo $rowUtilizacao['id_utilizacao']?>"<?php if ($utilizacao == $rowUtilizacao['id_utilizacao']) echo " selected";?>><?php echo ($rowUtilizacao['utilizacao']==""?"Nenhum":$rowUtilizacao['utilizacao'])?></option>
<?php 		
		}
	}	
}

else if($action == "formato") {
	$idioma = $_POST['idioma'];
	$contrato = $_POST['contrato'];
	$id_tipo = $_POST['id_tipo'];
	$id_utilizacao = $_POST['id_utilizacao'];
	$formato = isset($_POST['id_formato'])?$_POST['id_formato']:"";
	$queryFormato = "select uso.id_formato, uso_formato.formato_$idioma as formato
						from USO as uso
						left join uso_formato on uso_formato.id = uso.id_formato
						WHERE uso.id_tipo = $id_tipo AND uso.id_utilizacao = $id_utilizacao AND uso.contrato = '$contrato' AND uso.status > 0
						GROUP BY formato ORDER BY formato";

	$rsFormato = mysql_query($queryFormato, $sig) or die('<option value="">--- Utilização inválido ---</option>');
			$totalFormato = mysql_num_rows($rsFormato);
			if($totalFormato > 0) {
			?>
							<option value=""></option>
<?php 	
	}
	else if($totalFormato == 0) {
?>
							<option value="">--- Utilização inválida ---<?php echo $queryFormato?></option>
<?php		
	}
	while($rowFormato = mysql_fetch_array($rsFormato)) {
		if($rowFormato['formato']!="ocultar") {
?>
		                  	<option value="<?php echo $rowFormato['id_formato']?>"<?php if ($formato == $rowFormato['id_formato']) echo " selected";?>><?php echo ($rowFormato['formato']==""?"Nenhum":$rowFormato['formato'])?></option>
<?php 		
		}
	}	
}


else if($action == "distribuicao") {
	$idioma = $_POST['idioma'];
	$contrato = $_POST['contrato'];
	$id_tipo = $_POST['id_tipo'];
	$id_utilizacao = $_POST['id_utilizacao'];
	$id_formato = $_POST['id_formato'];
	$distribuicao = isset($_POST['id_distribuicao'])?$_POST['id_distribuicao']:"";
	$queryDistribuicao = "select uso.id_distribuicao, uso_distribuicao.distribuicao_$idioma as distribuicao
							from USO as uso
							left join uso_distribuicao on uso_distribuicao.id = uso.id_distribuicao
							WHERE uso.id_tipo = $id_tipo AND uso.id_utilizacao = $id_utilizacao AND uso.id_formato = $id_formato AND uso.contrato = '$contrato' AND uso.status > 0
							GROUP BY distribuicao ORDER BY distribuicao";

	$rsDistribuicao = mysql_query($queryDistribuicao, $sig) or die('<option value="">--- Formato inválido ---</option>');
			$totalDistribuicao = mysql_num_rows($rsDistribuicao);
			if($totalDistribuicao > 0) {
			?>
							<option value=""></option>
<?php 	
	}
	else if($totalDistribuicao == 0) {
?>
							<option value="">--- Formato inválido ---<?php echo $queryFormato?></option>
<?php		
	}
	while($rowDistribuicao = mysql_fetch_array($rsDistribuicao)) {
		if($rowDistribuicao['distribuicao']!="ocultar") {
?>
		                  	<option value="<?php echo $rowDistribuicao['id_distribuicao']?>"<?php if ($distribuicao == $rowDistribuicao['id_distribuicao']) echo " selected";?>><?php echo ($rowDistribuicao['distribuicao']==""?"Nenhum":$rowDistribuicao['distribuicao'])?></option>
<?php 		
		}
	}	
}


else if($action == "periodicidade") {
	$idioma = $_POST['idioma'];
	$contrato = $_POST['contrato'];
	$id_tipo = $_POST['id_tipo'];
	$id_utilizacao = $_POST['id_utilizacao'];
	$id_formato = $_POST['id_formato'];
	$id_distribuicao = $_POST['id_distribuicao'];
	$periodicidade = isset($_POST['id_periodicidade'])?$_POST['id_periodicidade']:"";
	$queryPeriodicidade = "select uso.id_periodicidade, uso_periodicidade.periodicidade_$idioma as periodicidade
							from USO as uso
							left join uso_periodicidade on uso_periodicidade.id = uso.id_periodicidade
							WHERE uso.id_tipo = $id_tipo AND uso.id_utilizacao = $id_utilizacao AND uso.id_formato = $id_formato AND uso.id_distribuicao = $id_distribuicao AND uso.contrato = '$contrato' AND uso.status > 0
							GROUP BY periodicidade ORDER BY periodicidade";

	$rsPeriodicidade = mysql_query($queryPeriodicidade, $sig) or die('<option value="">--- Distribuição inválida ---</option>'.$queryPeriodicidade);
			$totalPeriodicidade = mysql_num_rows($rsPeriodicidade);
			if($totalPeriodicidade > 0) {
			?>
							<option value=""></option>
<?php 	
	}
	else if($totalPeriodicidade == 0) {
?>
							<option value="">--- Distribuição inválido ---</option>
<?php		
	}
	while($rowPeriodicidade = mysql_fetch_array($rsPeriodicidade)) {
		if($rowPeriodicidade['periodicidade']!="ocultar") {
?>
		                  	<option value="<?php echo $rowPeriodicidade['id_periodicidade']?>"<?php if ($periodicidade == $rowPeriodicidade['id_periodicidade']) echo " selected";?>><?php echo ($rowPeriodicidade['periodicidade']==""?"Nenhum":$rowPeriodicidade['periodicidade'])?></option>
<?php 	
		}	
	}	
}

else if($action == "tamanho") {
	$idioma = $_POST['idioma'];
	$contrato = $_POST['contrato'];
	$id_tipo = $_POST['id_tipo'];
	$id_utilizacao = $_POST['id_utilizacao'];
	$id_formato = $_POST['id_formato'];
	$id_distribuicao = $_POST['id_distribuicao'];
	$id_periodicidade = $_POST['id_periodicidade'];
	$tamanho = isset($_POST['id_tamanho'])?$_POST['id_tamanho']:"";
	$queryTamanho = "select uso.id_tamanho, uso_desc.descricao_$idioma as tamanho
	from USO as uso
	left join USO_DESC as uso_desc on uso_desc.Id = uso.id_tamanho
	WHERE uso.id_tipo = $id_tipo AND uso.id_utilizacao = $id_utilizacao AND uso.id_formato = $id_formato AND uso.id_distribuicao = $id_distribuicao AND uso.id_periodicidade = $id_periodicidade AND uso.contrato = '$contrato' AND uso.status > 0
	GROUP BY tamanho ORDER BY tamanho";

	$rsTamanho = mysql_query($queryTamanho, $sig) or die('<option value="">--- Periodicidade inválida ---</option>'.$queryTamanho);
	$totalTamanho = mysql_num_rows($rsTamanho);
	if($totalTamanho > 0) {
	?>
							<option value=""></option>
<?php 	
	}
	else if($totalTamanho == 0) {
?>
							<option value="">--- Periodicidade inválida ---</option>
<?php		
	}
	while($rowTamanho = mysql_fetch_array($rsTamanho)) {
		if($rowTamanho['tamanho']!="ocultar") {
?>
		                  	<option value="<?php echo $rowTamanho['id_tamanho']?>"<?php if ($tamanho == $rowTamanho['id_tamanho']) echo " selected";?>><?php echo ($rowTamanho['tamanho']==""?"Nenhum":$rowTamanho['tamanho'])?></option>
<?php 		
		}
	}	
}

else if($action == "uso") {
	$idioma = $_POST['idioma'];
	$contrato = $_POST['contrato'];
	if(isset($_POST['id_uso'])&&$_POST['id_uso']!= "") {
		$id_uso = $_POST['id_uso'];
		$queryUso = "select uso.Id as id_uso, uso_descricao.descricao_$idioma as descricao
		from USO as uso
		left join uso_descricao on uso_descricao.Id = uso.id_descricao
		WHERE uso.Id = $id_uso AND uso.status > 0
		GROUP BY descricao ORDER BY descricao";
	}
	else {
		$id_tipo = $_POST['id_tipo'];
		$id_utilizacao = $_POST['id_utilizacao'];
		$id_formato = $_POST['id_formato'];
		$id_distribuicao = $_POST['id_distribuicao'];
		$id_periodicidade = $_POST['id_periodicidade'];
		$id_tamanho = $_POST['id_tamanho'];
		$queryUso = "select uso.Id as id_uso, uso.valor, uso_descricao.descricao_$idioma as descricao  
							from USO as uso
							left join uso_descricao on uso_descricao.Id = uso.id_descricao
							WHERE uso.id_tipo = $id_tipo AND uso.id_utilizacao = $id_utilizacao AND uso.id_formato = $id_formato AND uso.id_distribuicao = $id_distribuicao AND uso.id_periodicidade = $id_periodicidade AND uso.id_tamanho = $id_tamanho AND uso.contrato = '$contrato' AND uso.status > 0
							GROUP BY descricao ORDER BY descricao";
	}						

	$rsUso = mysql_query($queryUso, $sig) or die(mysql_error()." - ".$queryUso);
	$totalUso = mysql_num_rows($rsUso);
	$rowUso = mysql_fetch_array($rsUso);
	if($idioma != "br") {
		$rowUso["valor"] = convertPounds($rowUso["valor"]);
	}
	$reply = array();
	if($totalUso < 1) {
		$reply["valor"] = "-1.00";
		$reply["descricao"] = "Uso inválido!";
		$reply["id_uso"] = "-1";		
	}
	else if($totalUso == 1) {
		$reply = $rowUso;
	} else {
		$reply["valor"] = "-1.00";
		$reply["descricao"] = "Uso múltiplo!!!";
		$reply["id_uso"] = "-2";
	}
	echo json_encode($reply);
}
?>