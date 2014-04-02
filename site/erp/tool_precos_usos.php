<?php
$tipo = isset($_GET["txttipo"])?mb_strtoupper($_GET["txttipo"]):"";
$tipos_arr = array(); 

foreach($idiomas as $idioma) {
	$tipos_arr[] = (isset($_GET["txttipo_".$idioma])?$_GET["txttipo_".$idioma]:"");
}
$tipos = implode("','", $tipos_arr);

$tabela = isset($_GET["tabela"])?$_GET["tabela"]:"USO_TIPO";
$campo = isset($_GET["campo"])?$_GET["campo"]:"tipo";
$campos = $campo."_".implode(",".$campo."_", $idiomas);
$campos_arr = explode(",",$campos);

if (isset($_GET["inclui"])) {
    $sql = "insert into $tabela($campos) values('" . $tipos . "')";
    mysql_query($sql, $sig) or die(mysql_error());
    $msg = "Incluido com sucesso!";
}

if (isset($_GET["edita"]) && $_GET["edita"] != "" ) {
    $id = $_GET["edita"];
//    $campos = implode(",".$campo, $idiomas);
    $sql = "select Id, $campos from $tabela where Id = " . $id;
    $objId =  mysql_query($sql, $sig) or die(mysql_error());

    $row_objId = mysql_fetch_array($objId);
}

if (isset($_GET["gravaedita"]) && $_GET["gravaedita"] != "" ) {
    $id = $_GET["gravaedita"];
    $sql = "update $tabela set ";
    $addAnd = false;
    $msg = "Alterado com sucesso!";
    
    foreach($idiomas as $idioma) {
		if($addAnd)
			$sql .= ", ";
    	$sql .= $campo."_".$idioma." = '" . $_GET["txttipo_".$idioma] . "'";
    	$addAnd = true; 
	}
	$sql .=	" where Id = " . $id;
    mysql_query($sql, $sig) or die(mysql_error());
}

if (isset($_GET["deleta"]) && $_GET["deleta"] != "" ) {
    $id = $_GET["deleta"];
    $sql = "delete from $tabela where Id = " . $id;
    mysql_query($sql, $sig) or die(mysql_error());
    $msg = "Excluido com sucesso!";
}

$sql = "select Id, $campos from $tabela";
$obj =  mysql_query($sql, $sig) or die(mysql_error());

?>