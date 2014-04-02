<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.::SIG - SISTEMA DE INFORMAÇÕES GERENCIAIS PULSAR IMAGENS::.</title>
<link href="atributos/global.css" type="text/css" rel="stylesheet" media="screen" />
<link href="atributos/tablecloth.css" type="text/css" rel="stylesheet" media="screen" />
<LINK href="css/style.css" type=text/css rel=STYLESHEET />
<script language="javascript">
	function valida(){
	    if(document.getElementById("txttipo").value == ""){
	        alert("Digite o Tipo");
	        return false;
	    }else{
	        return true;
	    }
	}
	
	function confirma(){
	    if(confirm("Deseja realmente excluir este Tipo?"))
        {
            return true;
        }else{
            return false;
        }
    }
</script>
<?php include("scripts.php")?>
<?php include("part_top.php")?>
</head>

<body>

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
}

$sql = "select Id, $campos from $tabela";
$obj =  mysql_query($sql, $sig) or die(mysql_error());



?>

<!-- MENU -->
<table width="50%">
	<tr>
	    <th colspan="6"><center><font face="Times New Roman"><a href="adm_uso_tipo.php">Tipos</a></font></center></th>
	    <th colspan="6"><center><font face="Times New Roman"><a href="adm_uso_tipo.php?tabela=USO_SUBTIPO&campo=subtipo">Utilização</a></font></center></th>
	    <th colspan="6"><center><font face="Times New Roman"><a href="adm_uso_tipo.php?tabela=uso_formato&campo=formato">Formato</a></font></center></th>
	    <th colspan="6"><center><font face="Times New Roman"><a href="adm_uso_tipo.php?tabela=uso_distribuicao&campo=distribuicao">Distribuição</a></font></center></th>
	    <th colspan="6"><center><font face="Times New Roman"><a href="adm_uso_tipo.php?tabela=USO_DESC&campo=descricao">Tamanho</a></font></center></th>
	    <th colspan="6"><center><font face="Times New Roman"><a href="adm_uso_tipo.php?tabela=uso_periodicidade&campo=periodicidade">Periodicidade</a></font></center></th>
	    <th colspan="6"><center><font face="Times New Roman"><a href="adm_uso_tipo.php?tabela=uso_descricao&campo=descricao">Descrição</a></font></center></th>
	</tr>
</table>
<!--mensagem-->
<font color="#000000"><h2><?php echo isset($_GET["mens"])?$_GET["mens"]:"" ?></h2></font>
<form onsubmit="return valida();" id="formTipo" action='adm_uso_tipo.php?<?php if (isset($_GET["edita"]) && $_GET["edita"] != "" ) { ?>gravaedita=<?php echo $_GET["edita"] ?><?php } else { ?>inclui=true<?php } ?>' enctype="" method="get">
    <center>
    <table width="50%">
	    <tr>
	        <td colspan="3" style="font-weight:bold;">Incluir <?php echo $campo?></td>
	    </tr>
	    <tr>
	        <td><?php echo $campo?></td>
	        <?php if (isset($_GET["edita"]) && $_GET["edita"] != "" ) { ?>
	        <td><input type="text" id="txttipo_br" name="txttipo_br" maxlength="200" size="50" value='<?php echo $row_objId[$campo."_br"]?>' /></td>
			<td><input type="text" id="txttipo_en" name="txttipo_en" maxlength="200" size="50" value='<?php echo $row_objId[$campo."_en"]?>' /></td>
	        <td><input type="submit" id="envia" value="Alterar Tipo" /></td>
	        <?php } else { ?>
	        <td><input type="text" id="txttipo_br" name="txttipo_br" maxlength="200" size="50"/></td>
		    <td><input type="text" id="txttipo_en" name="txttipo_en" maxlength="200" size="50"/></td>
	        <td><input type="submit" id="envia" value="Gravar <?php echo $campo?>" /></td>
	        <?php } ?>
	    </tr>
   	</table>
    <table width="50%">
        <tr>
            <td style="font-weight:bold;" align="center">Tipos Incluídos</td>
            <td style="font-weight:bold;" align="center">Tipos Incluídos (en)</td>
            <td style="font-weight:bold;" align="center">Editar</td>
            <td style="font-weight:bold;" align="center">Excluir</td>
        </tr>
        <?php while ($row_obj = mysql_fetch_array($obj)) { ?>
        <tr>
           <td><?php echo $row_obj[$campo."_br"]?></td>
           <td><?php echo $row_obj[$campo."_en"]?></td>
           <td><a href='adm_uso_tipo.php?tabela=<?php echo $tabela?>&campo=<?php echo $campo?>&edita=<?php echo $row_obj["Id"]?>'><img src="images/edit.png" border="0" alt="Editar" /></a></td>
           <td><a href='adm_uso_tipo.php?tabela=<?php echo $tabela?>&campo=<?php echo $campo?>&deleta=<?php echo $row_obj["Id"]?>' onclick="return confirma();"><img src="images/delete.png" border="0" alt="Excluir" /></a></td>
        </tr>
        <?php } ?>
        </table>
    </center>

    <input type="hidden" name="tabela" value="<?php echo $tabela?>"/>
    <input type="hidden" name="campo" value="<?php echo $campo?>"/>
<?php if (isset($_GET["edita"]) && $_GET["edita"] != "" ) { ?>
	<input type="hidden" name="gravaedita" value="<?php echo $_GET["edita"] ?>"/>
<?php } else { ?>
	<input type="hidden" name="inclui" value="true"/>
<?php } ?>
</form>
</body>
</html>

<?php //'fechar e eliminar todos os obejtos recordset e de conexão?>







