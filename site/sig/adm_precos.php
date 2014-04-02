<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_preco.php"); ?>
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
	    if(confirm("Deseja realmente excluir este Preço?"))
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

<!--mensagem-->
<font color="#000000"><h2><?php echo isset($_GET["mens"])?$_GET["mens"]:"" ?></h2></font>
<form id="frmPreco" action="adm_precos.php?<?php If ( isset($_GET["edita"]) ) { ?>gravaedita=<?php echo $_GET["edita"] ?><?php } else { ?>inclui=true<?php } ?>" enctype="" method="post">
  <table width="50%">
    <tr>
        <td colspan="6" style="font-weight:bold;">
            Incluir Novo Preço 
        </td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Contrato</td>
    	<td style="font-weight:bold;">Tipo do Projeto</td>
        <td style="font-weight:bold;">Utilização</td>
        <td style="font-weight:bold;">Formato</td>
        <td style="font-weight:bold;">Distribuição</td>
        <td style="font-weight:bold;">Periodicidade</td>
        <td style="font-weight:bold;">Tamanho</td>
        <td style="font-weight:bold;">Preço</td>
        <td style="font-weight:bold;">Descrição</td>
	</tr>
    <tr>
        <td>
            <select name="contrato">
            	<option <?php If ( $idEditaContrato == "F") echo "selected=\"selected\"";?> value='F'>Foto</option>
            	<option <?php If ( $idEditaContrato == "V") echo "selected=\"selected\"";?> value='V'>Video</option>
            </select>
        </td>
    	<td>
            <select name="ddltipo">
            <?php while ($row_objTipo = mysql_fetch_array($objTipo)) {?>
                <?php If ( $idEditaTipo == $row_objTipo["Id"] ) { ?>
                    <option selected="selected" value='<?php echo $row_objTipo["Id"] ?>'><?php echo $row_objTipo["tipo"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $row_objTipo["Id"] ?>'><?php echo $row_objTipo["tipo"] ?></option>
                <?php } ?>
            <?php } ?>
            </select>
        </td>
        <td>
            <select name="ddlutilizacao">
            	<option value='0'>Nenhum</option>
            <?php while ($row_objUtilizacao = mysql_fetch_array($objUtilizacao)) { ?>
                <?php If ( $idEditaUtilizacao == $row_objUtilizacao["Id"] ) { ?>
                    <option selected="selected" value='<?php echo $row_objUtilizacao["Id"] ?>'><?php echo $row_objUtilizacao["subtipo"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $row_objUtilizacao["Id"] ?>'><?php echo $row_objUtilizacao["subtipo"] ?></option>
                <?php } ?>
            <?php } ?>
            </select>
        </td>
        <td>
           	<select name="ddlformato">
           		<option value='0'>Nenhum</option>
            <?php while ($rowFormato = mysql_fetch_array($formato)) {?>
                <?php If ( $idEditaFormato == $rowFormato["id"] ) { ?>
                    <option selected="selected" value='<?php echo $rowFormato["id"] ?>'><?php echo $rowFormato["formato"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $rowFormato["id"] ?>'><?php echo $rowFormato["formato"] ?></option>
                <?php } ?>
            <?php } ?>
            </select>
        </td>
        <td>
        	<select name="ddldistribuicao">
           		<option value='0'>Nenhum</option>
        	<?php while ($rowDistribuicao = mysql_fetch_array($distribuicao)) {?>
            	<?php If ( $idEditaDistribuicao == $rowDistribuicao["id"] ) { ?>
                    <option selected="selected" value='<?php echo $rowDistribuicao["id"] ?>'><?php echo $rowDistribuicao["distribuicao"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $rowDistribuicao["id"] ?>'><?php echo $rowDistribuicao["distribuicao"] ?></option>
                <?php } ?>
            <?php } ?>
            </select>
        </td>
        <td>
        	<select name="ddlperiodicidade">
           		<option value='0'>Nenhum</option>
        	<?php while ($rowPeriodicidade = mysql_fetch_array($periodicidade)) {?>
                <?php If ( $idEditaPeriodicidade == $rowPeriodicidade["id"] ) { ?>
                    <option selected="selected" value='<?php echo $rowPeriodicidade["id"] ?>'><?php echo $rowPeriodicidade["periodicidade"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $rowPeriodicidade["id"] ?>'><?php echo $rowPeriodicidade["periodicidade"] ?></option>
                <?php } ?>
            <?php } ?>
            </select>
        </td>
        <td>
        	<select name="ddltamanho">
           		<option value='0'>Nenhum</option>
        	<?php while ($row_objTamanho = mysql_fetch_array($objTamanho)) {?>
                <?php If ( $idEditaTamanho == $row_objTamanho["Id"] ) { ?>
                    <option selected="selected" value='<?php echo $row_objTamanho["Id"] ?>'><?php echo $row_objTamanho["descricao"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $row_objTamanho["Id"] ?>'><?php echo $row_objTamanho["descricao"] ?></option>
                <?php } ?>
            <?php } ?>
            </select>
        </td>
        <td>
            <?php If (isset($_GET["edita"]) ) { ?>
                <input type="text" name="txtvalor" id="txtvalor" value='<?php echo $row_objEdita["valor"] ?>' size="15" onKeyPress="return (soNums(event,','));" />
            <?php } else { ?>
                <input type="text" name="txtvalor" id="txtvalor" size="15" onKeyPress="return (soNums(event,','));" />
            <?php } ?>
        </td>
        <td>
        	<select name="ddldescricao">
           		<option value='0'>Nenhum</option>
        	<?php while ($rowDescricao = mysql_fetch_array($descricao)) {?>
                <?php If ( $idEditaDescricao == $rowDescricao["id"] ) { ?>
                    <option selected="selected" value='<?php echo $rowDescricao["id"] ?>'><?php echo $rowDescricao["descricao"] ?></option>
                <?php } else { ?>
                    <option value='<?php echo $rowDescricao["id"] ?>'><?php echo $rowDescricao["descricao"] ?></option>
                <?php } ?>
            <?php } ?>
            </select>
        </td>
        <td>
            <input type="submit" name="envia" value="OK" />
        </td>
    </tr>
  </table>

  <table width="50%">
    <tr>
        <td colspan="6" style="font-weight:bold;">
            Preços Incluídos   
        </td>
    </tr>
    <tr >
        <td style="font-weight:bold;">Tipo Contrato</td>
        <td style="font-weight:bold;">Tipo do Projeto</td>
        <td style="font-weight:bold;">Utilização</td>
        <td style="font-weight:bold;">Formato</td>
        <td style="font-weight:bold;">Distribução</td>
        <td style="font-weight:bold;">Periodicidade</td>
        <td style="font-weight:bold;">Tamanho</td>
        <td style="font-weight:bold;" nowrap="nowrap">Valor</td>
        <td style="font-weight:bold;">Descrição</td>
        <td style="font-weight:bold;">Editar</td>
        <td style="font-weight:bold;">Excluir</td>
    </tr>
    <?php while ($row_objTotal = mysql_fetch_array($objTotal)) {?>
        <tr>
            <td><?php echo $row_objTotal["contrato"]=="V"?"Video":"Foto" ?></td>
        	<td><?php echo $row_objTotal["tipo"] ?></td>
            <td><?php echo $row_objTotal["utilizacao"] ?></td>
            <td><?php echo $row_objTotal["formato"] ?></td>
            <td><?php echo $row_objTotal["distribuicao"] ?></td>
            <td><?php echo $row_objTotal["periodicidade"] ?></td>
            <td><?php echo $row_objTotal["tamanho"] ?></td>
            <?php If ( $row_objTotal["valor"] != "0" ) { ?>
                <td  nowrap="nowrap"><?php echo formatcurrency($row_objTotal["valor"]) ?></td>
            <?php } else { ?>
                <td>N/D</td>
            <?php } ?>
            <td><?php echo $row_objTotal["descricao"] ?></td>
            <td><a href='adm_precos.php?edita=<?php echo $row_objTotal["Id"] ?>'><img src="images/edit.png" border="0" /></a></td>
            <td><a href='adm_precos.php?delete=<?php echo $row_objTotal["Id"] ?>' onclick="return confirma();"><img src="images/delete.png" border="0" /></a></td>
        </tr>                
    <?php } ?>
    </table>

</form>
</body>
</html>

<?php //'fechar e eliminar todos os obejtos recordset e de conexão?>







