<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_preco.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.::SIG - SISTEMA DE INFORMAÇÕES GERENCIAIS PULSAR IMAGENS::.</title>
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
</head>

<body>

<!--mensagem-->
<font color="#000000"><h2><?php echo isset($_GET["mens"])?$_GET["mens"]:"" ?></h2></font>
  <table width="50%">
    <tr>
        <td colspan="6" style="font-weight:bold;">
            Preços Incluídos   
        </td>
    </tr>
    <tr >
        <td style="font-weight:bold;">Id</td>
    	<td style="font-weight:bold;">Tipo Contrato</td>
        <td style="font-weight:bold;">Tipo do Projeto</td>
        <td style="font-weight:bold;">Utilização</td>
        <td style="font-weight:bold;">Formato</td>
        <td style="font-weight:bold;">Distribução</td>
        <td style="font-weight:bold;">Periodicidade</td>
        <td style="font-weight:bold;">Tamanho</td>
        <td style="font-weight:bold;" nowrap="nowrap">Valor</td>
        <td style="font-weight:bold;">Descrição</td>
    </tr>
    <?php while ($row_objTotal = mysql_fetch_array($objTotal)) {?>
        <tr>
            <td><?php echo $row_objTotal["Id"] ?></td>
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
        </tr>                
    <?php } ?>
    </table>
</body>
</html>

<?php //'fechar e eliminar todos os obejtos recordset e de conexão?>







