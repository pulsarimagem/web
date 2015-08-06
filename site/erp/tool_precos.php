<?php
$sql_create = "CREATE TABLE `uso_formato` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`formato_br` varchar(255) NOT NULL,
`formato_en` varchar(255) NOT NULL,
`creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)";
if(!mysql_num_rows( mysql_query("SHOW TABLES LIKE 'uso_formato'")))
{
	mysql_query($sql_create, $sig) or die(mysql_error());
//	$sql_insert = "INSERT INTO users (username,password,fullname,email,id_owner) values ('root','globalsys123','Root','root@aatracksys.com',0)";
//	mysql_query($sql_insert, $gtp) or die(mysql_error());
}
$sql_create = "CREATE TABLE `uso_distribuicao` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`distribuicao_br` varchar(255) NOT NULL,
`distribuicao_en` varchar(255) NOT NULL,
`creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`status` int(1) NOT NULL DEFAULT 1,		
PRIMARY KEY (`id`),
KEY `id` (`id`)
)";
if(!mysql_num_rows( mysql_query("SHOW TABLES LIKE 'uso_distribuicao'")))
{
	mysql_query($sql_create, $sig) or die(mysql_error());
}
$sql_create = "CREATE TABLE `uso_periodicidade` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`periodicidade_br` varchar(255) NOT NULL,
`periodicidade_en` varchar(255) NOT NULL,
`creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`status` int(1) NOT NULL DEFAULT 1,		
PRIMARY KEY (`id`),
KEY `id` (`id`)
)";
if(!mysql_num_rows( mysql_query("SHOW TABLES LIKE 'uso_periodicidade'")))
{
	mysql_query($sql_create, $sig) or die(mysql_error());
}
$sql_create = "CREATE TABLE `uso_descricao` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`descricao_br` text NOT NULL,
`descricao_en` text NOT NULL,
`creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`status` int(1) NOT NULL DEFAULT 1,		
PRIMARY KEY (`id`),
KEY `id` (`id`)
)";
if(!mysql_num_rows( mysql_query("SHOW TABLES LIKE 'uso_descricao'")))
{
	mysql_query($sql_create, $sig) or die(mysql_error());
}
?>
<?php

$sqlTipo = "select Id, tipo_br as tipo from USO_TIPO order by tipo";
$objTipo = mysql_query($sqlTipo, $sig) or die(mysql_error());

$sqlUtilizacao = "select Id, subtipo_br as subtipo from USO_SUBTIPO order by subtipo";
$objUtilizacao = mysql_query($sqlUtilizacao, $sig) or die(mysql_error());

$sqlFormato = "select id, formato_br as formato from uso_formato order by formato_br";
$formato = mysql_query($sqlFormato, $sig) or die(mysql_error());

$sqlDistribuicao = "select id, distribuicao_br as distribuicao from uso_distribuicao order by distribuicao";
$distribuicao = mysql_query($sqlDistribuicao, $sig) or die(mysql_error());

$sqlPeriodicidade = "select id, periodicidade_br as periodicidade from uso_periodicidade order by periodicidade";
$periodicidade = mysql_query($sqlPeriodicidade, $sig) or die(mysql_error());

$sqlTamanho = "select Id, descricao_br as descricao from USO_DESC order by descricao";
$objTamanho = mysql_query($sqlTamanho, $sig) or die(mysql_error());

$sqlDescricao = "select id, descricao_br as descricao from uso_descricao order by descricao";
$descricao = mysql_query($sqlDescricao, $sig) or die(mysql_error());


If (isset($_GET["inclui"])) {
	if($_POST["ddltipo"] != "") {
	    If ( $_POST["txtvalor"] != "" ) {        
	       $sqlInclui = "insert into USO(id_tipo,id_utilizacao,id_formato,id_distribuicao,id_periodicidade,id_tamanho,id_descricao,valor,contrato)values(" . $_POST["ddltipo"] . "," . $_POST["ddlutilizacao"] . "," . $_POST["ddlformato"] . "," . $_POST["ddldistribuicao"] . "," . $_POST["ddlperiodicidade"] . "," . $_POST["ddltamanho"] . "," . $_POST["ddldescricao"] . "," . str_replace(",",".",$_POST["txtvalor"]) . ",'".$_POST["contrato"]."')";
	       mysql_query($sqlInclui, $sig) or die(mysql_error());
	       $mens = "Uso criado com sucesso!";
	    } else {
			$mens = "Erro! Valor não inserido!";	
	    }
	}
	else {
		$mens = "Erro! Tipo não selecionado!";	
	}
}

$idEditaTipo = 0;
$idEditaUtilizacao= 0;
$idEditaFormato = 0;
$idEditaDistribuicao = 0;
$idEditaPeriodicidade = 0;
$idEditaTamanho = 0;
$idEditaDescricao = 0;
$idEditaContrato = "F";

If (isset($_GET["edita"])) {
    $id = $_GET["edita"];
    $sqlEdita =	"select 
	    			Id, contrato, id_tipo, id_utilizacao, id_formato, id_distribuicao, id_periodicidade, id_tamanho, id_descricao, valor  
    			from 
    				USO as uso
    			where 
					uso.Id = " . $id . ""; 
    
//    "select uso.Id, uso.contrato, tipo.Id as id_tipo, sub.Id as id_subtipo, descr.Id as id_desc,valor from USO as uso, USO_TIPO as tipo, USO_SUBTIPO as sub, USO_DESC as descr where uso.id_tipo = tipo.Id and uso.Id = " . $id . " and uso.id_subtipo = sub.Id and uso.id_descricao = descr.Id order by tipo, subtipo,descricao,valor ";
    $objEdita = mysql_query($sqlEdita, $sig) or die(mysql_error()); 
	$row_objEdita = mysql_fetch_array($objEdita); 
    $idEditaTipo = $row_objEdita["id_tipo"];
    $idEditaUtilizacao= $row_objEdita["id_utilizacao"];
    $idEditaFormato = $row_objEdita["id_formato"];
    $idEditaDistribuicao = $row_objEdita["id_distribuicao"];
    $idEditaPeriodicidade = $row_objEdita["id_periodicidade"];
    $idEditaTamanho = $row_objEdita["id_tamanho"];
    $idEditaDescricao = $row_objEdita["id_descricao"];
    $idEditaContrato = $row_objEdita["contrato"];
}

If (isset($_GET["gravaedita"]) && $_GET["gravaedita"] != "" ) {
    $sqlGrava = "update USO set id_tipo = " . $_POST["ddltipo"] . " , id_utilizacao = " . $_POST["ddlutilizacao"] . " , id_formato = " . $_POST["ddlformato"] . " , id_distribuicao = " . $_POST["ddldistribuicao"] . " , id_periodicidade = " . $_POST["ddlperiodicidade"] . " , id_tamanho = " . $_POST["ddltamanho"] . " , id_descricao = " . $_POST["ddldescricao"] . " , valor = " . str_replace(",",".",$_POST["txtvalor"]) . ", contrato = '".$_POST["contrato"]."' where Id = " . $_GET["gravaedita"];
    mysql_query($sqlGrava, $sig) or die(mysql_error());
}

If (isset($_GET["delete"]) && $_GET["delete"] != "" ) {
    $sqlDel = "update USO set status = 0 where Id = " . $_GET["delete"];
    mysql_query($sqlDel, $sig) or die(mysql_error());
}

$sqlTotal = "select 
    			uso.Id, uso.contrato, tipo_br as tipo, utilizacao.subtipo_br as utilizacao, formato_br as formato, distribuicao_br as distribuicao, periodicidade_br as periodicidade, tamanho.descricao_br as tamanho, valor, uso_descricao.descricao_br as descricao 
    		from 
    			USO as uso
    		left join USO_TIPO as tipo on uso.id_tipo = tipo.Id  
    		left join USO_SUBTIPO as utilizacao on uso.id_utilizacao = utilizacao.Id
    		left join uso_formato on uso.id_formato = uso_formato.id 
    		left join uso_distribuicao on uso.id_distribuicao = uso_distribuicao.id 
    		left join uso_periodicidade on uso.id_periodicidade = uso_periodicidade.id 
    		left join USO_DESC as tamanho on uso.id_tamanho = tamanho.Id
    		left join uso_descricao on uso.id_descricao = uso_descricao.id
    		where uso.status != 0
    		order by contrato, tipo, utilizacao,formato,valor";

$objTotal = mysql_query($sqlTotal, $sig) or die(mysql_error());


?>
