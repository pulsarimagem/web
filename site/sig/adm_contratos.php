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

function soNums(e,args) 
{         
    // Função que permite apenas teclas numéricas e  
    // todos os caracteres que estiverem na lista 
    // de argumentos. 
    // Deve ser chamada no evento onKeyPress desta forma 
    //  onKeyPress ="return (soNums(event,'(/){,}.'));" 
    // caso queira apenas permitir caracters 

        if (document.all){var evt=event.keyCode;} // caso seja IE 
        else{var evt = e.charCode;}    // do contrário deve ser Mozilla 
        var chr= String.fromCharCode(evt);    // pegando a tecla digitada 
        // Se o código for menor que 20 é porque deve ser caracteres de controle 
        // ex.: <ENTER>, <TAB>, <BACKSPACE> portanto devemos permitir 
        // as teclas numéricas vão de 48 a 57 
        if (evt <20 || (evt >47 && evt<58) || (args.indexOf(chr)>-1 ) ){return true;} 
        return false; 
}
function confirma(){
    if(confirm("Deseja realmente excluir este Contrato?"))
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
$mens = "";
if (isset($_POST['inclui']) ) {    
//print_r($_POST);
//echo "<br>";
	$sqlInsere = "insert into CONTRATOS_DESC(titulo,condicoes,padrao,assinatura, indio, status, tipo) values('" . $_POST['txtTitulo'] . "' , '" . str_ireplace("'", "''", $_POST['FCKeditor1']) . "' ," . $_POST['padrao'] . " ," . $_POST['assinatura'] . " ," . $_POST['indio'] . " ," . $_POST['status'] . ",'" . $_POST['tipo'] . "')";
//echo $sqlInsere;
	mysql_query($sqlInsere, $sig) or die(mysql_error());
    $mens = "Incluído com Sucesso!";
}

if (isset($_GET['edita'])) {
    $sqlPorId = "select Id, titulo, condicoes, padrao, assinatura, indio, status, tipo, num_contratos from CONTRATOS_DESC LEFT JOIN (select ID_CONTRATO_DESC as id_contrato, count(ID_CONTRATO_DESC) as num_contratos from CONTRATOS group by ID_CONTRATO_DESC) as count on CONTRATOS_DESC.Id = count.id_contrato where Id = " . $_GET['edita'];
//    Set objId = connect.execute($sqlPorId)
    $objId = mysql_query($sqlPorId, $sig) or die(mysql_error());
    $row_objId = mysql_fetch_assoc($objId);    
}

if (isset($_GET['delete'])) {
    $sqlDelete = "update CONTRATOS_DESC set status = 0 where Id = " . $_GET['delete'];
    mysql_query($sqlDelete, $sig) or die(mysql_error());
    $mens = "Desabilitado com Sucesso!";
}

if (isset($_POST['gravaedita'])) {
//print_r($_POST);
//echo "<br>";
	$sqlEdita = " update CONTRATOS_DESC set titulo = '" . $_POST['txtTitulo'] . "' , condicoes = '" . str_ireplace("'", "''", $_POST['FCKeditor1']) . "' , padrao = " . $_POST['padrao'] . " , assinatura =  " . $_POST['assinatura'] . ", indio = ".$_POST['indio'].", status = ".$_POST['status'].", tipo = '".$_POST['tipo']."' where Id = " . $_POST['gravaedita'];
//echo $sqlEdita;
    mysql_query($sqlEdita, $sig) or die(mysql_error());
    $mens = "Alterado com Sucesso!";
}

$sqlTodos = "select Id, titulo, condicoes, padrao, assinatura, indio, status, tipo, num_contratos from CONTRATOS_DESC LEFT JOIN (select ID_CONTRATO_DESC as id_contrato, count(ID_CONTRATO_DESC) as num_contratos from CONTRATOS group by ID_CONTRATO_DESC) as count on CONTRATOS_DESC.Id = count.id_contrato where status = 1 order by titulo asc";
$objTodos = mysql_query($sqlTodos, $sig) or die(mysql_error());


?>

<!--mensagem-->
<font color="#000000"><h2><?php echo $mens ?></h2></font>
<form id="frmPreco" action="adm_contratos.php?<?php if (isset($_GET['edita'])) { ?>gravaedita=<?php echo  $_GET['edita'] ?><?php } Else { ?>inclui=true<?php } ?>" enctype="" method="post">
<?php 
if (isset($_GET['edita'])) {
?>
<input type="hidden" name="gravaedita" value="<?php echo  $_GET['edita'] ?>"/>
<?php 
}
else {
?>
<input type="hidden" name="inclui" value="true"/>
<?php 	
}
?>

	<table width="50%">
        <tr>
            <td colspan="2" style="font-weight:bold;">
                Contratos Incluídos
            </td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Título</td>
            <td style="font-weight:bold;">Padrão</td>
            <td style="font-weight:bold;">Assinatura Digital</td>
            <td style="font-weight:bold;">Tipo</td>
            <td style="font-weight:bold;">Indio</td>
            <td style="font-weight:bold;">Habilitado</td>
            <td style="font-weight:bold;">Número de LRs</td>
            <td style="font-weight:bold;">Editar</td>
            <td style="font-weight:bold;">Excluir</td>
        </tr>
        <?php while ($row_objTodos = mysql_fetch_assoc($objTodos)) { ?>
            <tr>
                <td><?php echo $row_objTodos['titulo'] ?></td>
                <td><?php if (ord($row_objTodos['padrao']) == 0 || ord($row_objTodos['padrao']) == 48) { echo "Não"; } else { echo "Sim"; } ?></td>
                <td><?php if (ord($row_objTodos['assinatura']) == 0 || ord($row_objTodos['assinatura']) == 48) { echo "Não"; } else { echo "Sim"; } ?></td>                
                <td><?php echo $row_objTodos['tipo'] == "V"?"Video":"Foto"; ?></td>
                <td><?php if (ord($row_objTodos['indio']) == 0 || ord($row_objTodos['indio']) == 48) { echo "Não"; } else { echo "Sim"; } ?></td>
                <td><?php if (ord($row_objTodos['status']) == 0 || ord($row_objTodos['status']) == 48) { echo "Não"; } else { echo "Sim"; } ?></td>                
                <td><?php echo $row_objTodos['num_contratos']?></td>                
                <td><a href="adm_contratos.php?edita=<?php echo $row_objTodos['Id'] ?>"><img src="images/edit.png" border="0" /></a></td>
                <td><a href="adm_contratos.php?delete=<?php echo $row_objTodos['Id'] ?>" onclick="return confirma();"><img src="images/delete.png" border="0" /></a></td>
            </tr>        
        <?php } ?>
    </table>
    <table width="50%">
        <tr>
            <td style="font-weight:bold;">Título</td>
            <?php if (isset($_GET['edita'])) { ?>
                <td><input type="text" name="txtTitulo" size="50" value='<?php echo $row_objId['titulo'] ?>' /></td>
            <?php } else { ?>
                <td><input type="text" name="txtTitulo" size="50" /></td>
            <?php } ?>
        </tr>
        <tr>
            <td style="font-weight:bold;" valign="top">Condições</td>
            <td>
            <?php
//            ' Automatically calculates the editor base path based on the _samples directory.
//            ' This is usefull only for these samples. A real application should use something like this:
//            ' oFCKeditor.BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
            if (isset($_GET['edita'])) {
                $valor = $row_objId['condicoes'];
            } else {
                $valor = "";
            }

            include("fckeditor/fckeditor.php");
            
            $oFCKeditor = new FCKeditor('FCKeditor1') ;
            $oFCKeditor->BasePath = './fckeditor/';
            $oFCKeditor->Value = $valor;
            $oFCKeditor->Width = '650';
            $oFCKeditor->Height = '550';
            $oFCKeditor->ToolbarSet = 'Default';
            $oFCKeditor->Create();
            
		    ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Padrão?</td>
            <td>
            <?php if (isset($_GET['edita'])) { ?>
                <input type="radio" name="padrao" <?php if (ord($row_objId['padrao']) == 0 || ord($row_objId['padrao']) == 48) { echo "checked"; } ?> value="0"/>Não
                <input type="radio" name="padrao" <?php if (ord($row_objId['padrao']) == 1 || ord($row_objId['padrao']) == 49) { echo "checked"; } ?> value="1"/>Sim
            <?php } Else { ?>
                <input type="radio" name="padrao" value="0"/>Não
                <input type="radio" name="padrao" value="1" checked/>Sim
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Incluir Assinatura Digital?</td>
            <td>
            <?php if (isset($_GET['edita'])) { ?>
                <input type="radio" name="assinatura" <?php if (ord($row_objId['assinatura']) == 0 || ord($row_objId['assinatura']) == 48) { echo "checked"; } ?> value="0"/>Não
                <input type="radio" name="assinatura" <?php if (ord($row_objId['assinatura']) == 1 || ord($row_objId['assinatura']) == 49) { echo "checked"; } ?> value="1"/>Sim
            <?php } Else { ?>
                <input type="radio" name="assinatura" value="0"/>Não
                <input type="radio" name="assinatura" value="1" checked/>Sim
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Indio?</td>
            <td>
            <?php if (isset($_GET['edita'])) { ?>
                <input type="radio" name="indio" <?php if (ord($row_objId['indio']) == 0 || ord($row_objId['indio']) == 48) { echo "checked"; } ?> value="0"/>Não
                <input type="radio" name="indio" <?php if (ord($row_objId['indio']) == 1 || ord($row_objId['indio']) == 49) { echo "checked"; } ?> value="1"/>Sim
            <?php } Else { ?>
                <input type="radio" name="indio" value="0" checked/>Não
                <input type="radio" name="indio" value="1"/>Sim
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Tipo</td>
            <td>
            <?php if (isset($_GET['edita'])) { ?>
                <input type="radio" name="tipo" <?php echo $row_objId['tipo'] == "F"?"checked":""; ?> value="F"/>Foto
                <input type="radio" name="tipo" <?php echo $row_objId['tipo'] == "V"?"checked":""; ?> value="V"/>Video
            <?php } Else { ?>
                <input type="radio" name="tipo" value="F" checked/>Foto
                <input type="radio" name="tipo" value="V"/>Video
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Habilitado?</td>
            <td>
            <?php if (isset($_GET['edita'])) { ?>
                <input type="radio" name="status" <?php if (ord($row_objId['status']) == 0 || ord($row_objId['status']) == 48) { echo "checked"; } ?> value="0"/>Não
                <input type="radio" name="status" <?php if (ord($row_objId['status']) == 1 || ord($row_objId['status']) == 49) { echo "checked"; } ?> value="1"/>Sim
            <?php } Else { ?>
                <input type="radio" name="status" value="0"/>Não
                <input type="radio" name="status" value="1" checked/>Sim
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Gravar" <?php if($row_objId['num_contratos']>0) echo "class=\"block_edit\""?>/></td>
        </tr>
    </table>
</form>
</body>
</html>
<?//fechar e eliminar todos os obejtos recordset e de conexão?>







