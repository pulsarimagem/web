<?php require_once('Connections/pulsar.php'); ?>
<?php
if(isset($_GET['reuso'])) {
	$id = $_GET['reuso'];
	$isReuso = true;
	if(isset($_GET['false'])) {
		$isReuso = false;
	}
	$reusoVal = $isReuso?"1":"-1";
/*	if(!$isReuso) {
		$query = "SELECT USO.valor FROM CROMOS LEFT JOIN USO ON CROMOS.ID_USO = USO.Id WHERE CROMOS.ID = $id"; 
		echo $query;
		$rs	= mysql_query($query, $sig) or die(mysql_error());
		$row_rs = mysql_fetch_array($rs);
		
		$query = "UPDATE CROMOS SET VALOR = '".str_replace(".",",",$row_rs['valor'])."' WHERE ID = $id";
		echo $query;
		$rs	= mysql_query($query, $sig) or die(mysql_error());
	} */
	$query = "UPDATE CROMOS SET reuso = reuso+$reusoVal WHERE ID = $id";
	echo $query;
	$rs	= mysql_query($query, $sig) or die(mysql_error());
}
if(isset($_GET['chkIndio'])) {
	$id = $_GET['chkIndio'];
	$isReuso = true;
	if(isset($_GET['false'])) {
		$isReuso = false;
	}
	$reusoVal = $isReuso?"10":"-10";
	/*	if(!$isReuso) {
		$query = "SELECT USO.valor FROM CROMOS LEFT JOIN USO ON CROMOS.ID_USO = USO.Id WHERE CROMOS.ID = $id";
	echo $query;
	$rs	= mysql_query($query, $sig) or die(mysql_error());
	$row_rs = mysql_fetch_array($rs);

	$query = "UPDATE CROMOS SET VALOR = '".str_replace(".",",",$row_rs['valor'])."' WHERE ID = $id";
	echo $query;
	$rs	= mysql_query($query, $sig) or die(mysql_error());
	} */
	$query = "UPDATE CROMOS SET reuso = reuso+$reusoVal WHERE ID = $id";
	echo $query;
	$rs	= mysql_query($query, $sig) or die(mysql_error());
}
if(isset($_POST['action'])) {
	if($_POST['action'] == "get_uso") {
		$id = $_POST['id_contrato'];
		$sql = "SELECT tipo FROM CONTRATOS_DESC WHERE ID = $id";
		$result = mysql_query($sql, $sig) or die(mysql_error());
		$row = mysql_fetch_array($result);
		
		$tipo_contrato = $row['tipo'];
		$sqlTipo = "select Id, tipo_br as tipo from USO_TIPO where Id in (select id_tipo from USO WHERE contrato like '$tipo_contrato') order by tipo";
		$objTipo = mysql_query($sqlTipo, $sig) or die(mysql_error());
		?>
		<option> -- selecione -- </option>
		<?php 
		while ($row_objTipo = mysql_fetch_assoc($objTipo)) { ?>
		    <optgroup label='<?php echo htmlentities($row_objTipo['tipo']) ?>'>
	    <?php
//	        $strSub = "select distinct subtipo, sub.Id from USO_SUBTIPO as sub, USO as uso where uso.id_subtipo = sub.Id and uso.id_tipo = " . $row_objTipo['Id']." AND uso.contrato like '$tipo_contrato'";
			$strSub = "select distinct subtipo_br as subtipo, sub.Id from USO_SUBTIPO as sub, USO as uso where uso.id_utilizacao = sub.Id and uso.id_tipo = " . $row_objTipo['Id'] ." AND uso.contrato like '$tipo_contrato'";
	        $objSub = mysql_query($strSub, $sig) or die(mysql_error());
	        
	        while ($row_objSub = mysql_fetch_assoc($objSub)) {
	    ?>
	        <optgroup label="<?php echo htmlentities($row_objSub['subtipo']) ?>">
	        
	        <?php
	        
//	        $strDesc = "select uso.Id, descr.descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor from USO_DESC as descr, USO as uso where uso.id_descricao = descr.Id and uso.id_subtipo = " . $row_objSub['Id']." AND uso.contrato like '$tipo_contrato'";
	        $strDesc = "select uso.Id, uso_formato.formato_br as formato, uso_distribuicao.distribuicao_br as distribuicao, uso_periodicidade.periodicidade_br as periodicidade, descr.descricao_br as descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor
									from USO as uso
									left join USO_DESC as descr on uso.id_tamanho = descr.Id
									left join uso_formato on uso.id_formato = uso_formato.id
									left join uso_distribuicao on uso.id_distribuicao = uso_distribuicao.id
									left join uso_periodicidade on uso.id_periodicidade = uso_periodicidade.id
									where uso.id_utilizacao = " . $row_objSub['Id']." AND uso.id_tipo = " . $row_objTipo['Id'] ." AND uso.contrato like '$tipo_contrato'";
	         
	        $objDesc =  mysql_query($strDesc, $sig) or die(mysql_error());
	        
	        	while ($row_objDesc = mysql_fetch_assoc($objDesc)) {
	        
	        ?>
		            <option <?php if ( isset($id_uso) && $row_objDesc['Id'] == $id_uso) echo"selected"; ?> value="<?php echo $row_objDesc['Id']?>"><?php echo $row_objDesc['Id']." - "?><?php echo htmlentities($row_objDesc['formato'])." ".htmlentities($row_objDesc['distribuicao'])." ".htmlentities($row_objDesc['periodicidade'])." ".htmlentities($row_objDesc['descricao']) ?> (R$ <?php echo $row_objDesc['valor']?>)</option>
	        <?php } ?>
	        </optgroup>
	    <?php } ?>
	    </optgroup>
	<?php }
	}
}
?>