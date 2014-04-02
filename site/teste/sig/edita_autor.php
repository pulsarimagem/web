<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AUTORES/EDIÇÃO .::SIG - SISTEMA DE INFORMAÇÕES GERENCIAIS PULSAR IMAGENS::.</title>
<link href="atributos/global.css" type="text/css" rel="stylesheet" media="screen" />
<link href="atributos/tablecloth.css" type="text/css" rel="stylesheet" media="screen" />
<LINK href="css/style.css" type=text/css rel=STYLESHEET />
<?php include("scripts.php"); ?>
<script language="javascript">
	function txtBoxFormat(objeto, sMask, evtKeyPress) {
		var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;
		
		if(document.all) { // Internet Explorer
		nTecla = evtKeyPress.keyCode;
		} else if(document.layers) { // Nestcape
		nTecla = evtKeyPress.which;
		} else {
		nTecla = evtKeyPress.which;
		if (nTecla == 8) {
        return true;
		}
	}

    sValue = objeto.value;

    // Limpa todos os caracteres de formatação que
    // já estiverem no campo.
    sValue = sValue.toString().replace( "-", "" );
    sValue = sValue.toString().replace( "-", "" );
    sValue = sValue.toString().replace( ".", "" );
    sValue = sValue.toString().replace( ".", "" );
    sValue = sValue.toString().replace( "/", "" );
    sValue = sValue.toString().replace( "/", "" );
    sValue = sValue.toString().replace( ":", "" );
    sValue = sValue.toString().replace( ":", "" );
    sValue = sValue.toString().replace( "(", "" );
    sValue = sValue.toString().replace( "(", "" );
    sValue = sValue.toString().replace( ")", "" );
    sValue = sValue.toString().replace( ")", "" );
    sValue = sValue.toString().replace( " ", "" );
    sValue = sValue.toString().replace( " ", "" );
    fldLen = sValue.length;
    mskLen = sMask.length;

    i = 0;
    nCount = 0;
    sCod = "";
    mskLen = fldLen;

    while (i <= mskLen) {
      bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/") || (sMask.charAt(i) == ":"))
      bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))

      if (bolMask) {
        sCod += sMask.charAt(i);
        mskLen++; }
      else {
        sCod += sValue.charAt(nCount);
        nCount++;
      }

      i++;
    }

    objeto.value = sCod;

    if (nTecla != 8) { // backspace
      if (sMask.charAt(i-1) == "9") { // apenas números...
        return ((nTecla > 47) && (nTecla < 58)); } 
      else { // qualquer caracter...
        return true;
      } 
    }
    else {
      return true;
    }
  }
	function mascaraData(campoDesde){             
		var data = campoDesde.value;              
	
		if (data.length == 2){                  
			data = data + '/';                  
			document.forms[0].desde.value = data;      
			return true;                            
		}              
	
		if (data.length == 5){                  
			data = data + '/';                  
			document.forms[0].desde.value = data;                  
			return true;              
		}         
	}
	function MM_formtCep(e,src,mask) {	
		if(window.event) { _TXT = e.keyCode; } 
		else if(e.which) { _TXT = e.which; }
			if(_TXT > 47 && _TXT < 58) { 
				var i = src.value.length; var saida = mask.substring(0,1); var texto = mask.substring(i)
				if (texto.substring(0,1) != saida) { src.value += texto.substring(0,1); } 
				return true; } 
				else { if (_TXT != 8) { return false; } 
				else { return true; }
		}
	}
	
	function valida()
	{
		// criei uma variavel auxiliar que se encarrega de receber o status da
    	// validação
    	var passou = true;

		if(form.nome.value == "")
		{
			alert("Informe o nome do autor...");
			form.nome.focus();
			passou = false; // se der erro, a var passou recebe false
			return false;
		}
		
		if(form.sigla.value == "")
		{
			alert("Informe a sigla do autor...");
			form.sigla.focus();
			passou = false;
			return false;
		}
		
		// se a var passou n estiver recebendo false
    	// então realiza o submit do form
    	if (passou != false)
		{
			form.action="tool_autor_gravar.php";
			form.ENCTYPE = "";
			form.method="post";
		}
		
		return true;
	}
</script>
<style>
#border{
	border-style:solid;
	border-width:thin;
	border-color:#999999;
	padding:5px 5px 5px 5px;
	font-family:Georgia, Times New Roman, Times, serif
	}
</style>
<?php include("part_top.php")?>
</head>
<body>
<?php
//'resgatando parâmetros enviados pela url
$isNovo =  isset($_GET['novo'])?true:false;
if(!$isNovo) {
	$id = $_GET['id'];
//'consultando informações do autor na base de dados
	$sql = "SELECT * FROM AUTORES_OFC WHERE id ='" .$id. "'"; 
	$objRS	= mysql_query($sql, $sig) or die(mysql_error());
	$row_objRS = mysql_fetch_assoc($objRS);
}
else {
?>
<script type="text/JavaScript">
jQuery(document).ready(function() {
	$('.fixo').hide();
	$('.editavel').show();
});
</script>
<?php 
}
?>
<!--mensagem-->
<font face="Times New Roman, Times, serif"><h3><?php echo $_GET['mens']?></h3></font>
<!--visualizando informações do cliente-->
<form name="form" onsubmit="return valida();">
<input type="hidden" name="id" value="<?php echo $isNovo?"":$row_objRS["ID"]?>" >
<table width="90%">
	<tr><td colspan="7"><a href="javascript:history.back();"><b>Clique aqui</b></a> para voltar para a página anterior. <a href="<?php echo $_SESSION['menu_url']?>"><b>Clique aqui</b></a> para realizar nova consulta</td></tr>
	<tr><th colspan="7"><center><font face="Times New Roman"><b>Edição de autores</b></font></center></th></tr>
	<tr></tr>
	<tr><td id="border" colspan="6"><center><font face="Times New Roman" color="#000000"><b><?php echo  $isNovo?"Novo Autor":$row_objRS["NOME"] ?></b></font><img src="images/edit.gif" class="editBtn" border="0" alt="editar cadastro" />&nbsp;<a href="#?id=<?php echo $isNovo?"":$row_objRS["ID"]?>"><img src="images/del.gif" border="0"  alt="excluir cadastro" /></center></td></tr>
	<tr></tr>
	<tr>
		<td id="border">Nome:</td>
		<td id="border" colspan="3" class="fixo"><?php echo $isNovo?"":$row_objRS["NOME"]?></td>
		<td id="border" colspan="3" class="editavel"><input type="text" name="nome" size="70" maxlength="100" value="<?php echo $isNovo?"":$row_objRS["NOME"]?>"/></td>
		<td id="border">Sigla:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["SIGLA"]?></td>
		<td id="border" class="editavel"><input type="text" name="sigla" size="4" maxlength="3" value="<?php echo $isNovo?"":$row_objRS["SIGLA"]?>"/></td>
	</tr>
	<tr>
		<td id="border">Nome completo:</td>
		<td id="border" colspan="3" class="fixo"><?php echo $row_objRS["NOME_COMPLETO"]?></td>
		<td id="border" colspan="3" class="editavel"><input type="text" name="nome_completo" size="70" maxlength="100" value="<?php echo $isNovo?"":$row_objRS["NOME_COMPLETO"]?>"/></td>
		<td id="border">CPF:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["CPF"]?>&nbsp;</td>
		<td id="border" class="editavel"><input type="text" name="cpf" size="15" maxlength="14" onkeypress="return txtBoxFormat(this,'999.999.999-99', event);" value="<?php echo $isNovo?"":$row_objRS["CPF"]?>" />&nbsp;</td>
	</tr>
		<td id="border">CNPJ:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["CNPJ"]?>&nbsp;</td>
		<td id="border" class="editavel"><input type="text" name="cnpj" size="20" maxlength="18" value="<?php echo $isNovo?"":$row_objRS["CNPJ"]?>" onkeypress="return txtBoxFormat(this,'99.999.999/9999-99', event);"/>&nbsp;</td>
		<td id="border">Zip Code:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["ZIPCODE"]?>&nbsp;</td>
		<td id="border" class="editavel"><input type="text" name="zip" size="15" maxlength="10" value="<?php echo $isNovo?"":$row_objRS["ZIPCODE"]?>"/>&nbsp;</td>
		<td id="border">Comissão:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["COMISSAO"]?>&nbsp;%</td>
		<td id="border" class="editavel"><input type="text" name="com" size="4" maxlength="2" value="<?php echo $isNovo?"":$row_objRS["COMISSAO"]?>"/>&nbsp;%</td>
	</tr>
	<tr>
		<td id="border">E-mail:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["EMAIL"]?>&nbsp;</td>
		<td id="border" class="editavel"><input type="text" name="email" size="40" maxlength="100" value="<?php echo $isNovo?"":$row_objRS["EMAIL"]?>"/>&nbsp;</td>
		<td id="border">Telefone:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["TELEFONE"]?>&nbsp;</td>
		<td id="border" class="editavel"><input type="text" size="15" name="tel" maxlength="13" onkeypress="return txtBoxFormat(this, '(99)9999-9999', event);" value="<?php echo $isNovo?"":$row_objRS["TELEFONE"]?>"/>&nbsp;</td>
		<td id="border">Celular:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["CELULAR"]?>&nbsp;</td>	
		<td id="border" class="editavel"><input type="text" size="15" name="cel" maxlength="13" onkeypress="return txtBoxFormat(this, '(99)9999-9999', event);" value="<?php echo $isNovo?"":$row_objRS["CELULAR"]?>"/>&nbsp;</td>	
	</tr>
	<tr>
		<td id="border">Endereço:</td>
		<td id="border" colspan="3" class="fixo"><?php echo $row_objRS["ENDERECO"]?>&nbsp;</td>
		<td id="border" colspan="3" class="editavel"><input type="text" name="edc" size="70" maxlength="100" value="<?php echo $isNovo?"":$row_objRS["ENDERECO"]?>"/>&nbsp;</td>
		<td id="border">Bairro:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["BAIRRO"]?>&nbsp;</td>
		<td id="border" class="editavel"><input type="text" name="bairro" size="15" maxlength="30" value="<?php echo $isNovo?"":$row_objRS["BAIRRO"]?>"/>&nbsp;</td>
	</tr>  
	<tr>
		<td id="border">CEP:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["CEP"]?>&nbsp;</td>
		<td id="border" class="editavel"><input type="text" name="cep" maxlength="9" size="12" onkeypress="return txtBoxFormat(this,'99999-999', event);" value="<?php echo $isNovo?"":$row_objRS["CEP"]?>"/>&nbsp;</td>
		<td id="border">Cidade:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["CIDADE"]?>&nbsp;</td>
		<td id="border" class="editavel"><input type="text" name="cid" size="15" value="<?php echo $isNovo?"":$row_objRS["CIDADE"]?>"/>&nbsp;</td>
		<td id="border">Estado:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["ESTADO"]?>&nbsp;</td>
		<td id="border" class="editavel">
			<select name="est">
<?php
			$sql = "SELECT ID, SIGLA FROM ESTADOS";
			$result = mysql_query($sql, $sig);
		
			while ($row = mysql_fetch_array($result)) { ?>
				<option value="<?php echo $row["SIGLA"] ?>" <?php if (!$isNovo && ($row_objRS["ESTADO"] == $row["SIGLA"])) { ?> selected="selected" <?php } ?>><?php echo  $row["SIGLA"] ?></option>
<?php 
			}
?>
			</select>
		</td>
	</tr>
    <tr>
		<td id="border">Banco:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["BANCO"]?>&nbsp;</td>
		<td id="border" class="editavel">
			<select name="bco">
				<option value="">---NENHUM BANCO SELECIONADO---</option>
<?php
			$sql = "SELECT ID, NUMERO, NOME FROM TA_BANCOS ORDER BY NOME ";
			$result = mysql_query($sql, $sig);

			while ($row = mysql_fetch_array($result)) { ?>
				<option value="<?php echo  $row["NUMERO"] ?>&nbsp;<?php echo  $row["NOME"] ?>" <?php If (!$isNovo && ($row_objRS["BANCO"]==$row["NUMERO"]."&nbsp;".$row["NOME"])) { ?> selected="selected" <?php } ?>><?php echo  $row["NUMERO"] ?>&nbsp;<?php echo  $row["NOME"] ?></option>
<?php
			}
?>
			</select>				
		</td>
		<td id="border">Agência:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["AGENCIA"]?>&nbsp;</td>
		<td id="border" class="editavel"><input type="text" name="ag" size="15" value="<?php echo $isNovo?"":$row_objRS["AGENCIA"]?>"/>&nbsp;</td>
		<td id="border">Conta:</td>
		<td id="border" class="fixo"><?php echo $row_objRS["CONTA"]?>&nbsp;</td>
		<td id="border" class="editavel"><input type="text" name="cc" size="10" maxlength="15" value="<?php echo $isNovo?"":$row_objRS["CONTA"]?>"/>&nbsp;</td>
	</tr>
	<tr>
		<td id="border">Comentários:</td>
		<td id="border" colspan="5" class="fixo"><TEXTAREA NAME="obs" ROWS="3" COLS="95" readonly="readonly"><?php echo $row_objRS["OBS"]?></TEXTAREA>&nbsp;</td>
		<td id="border" colspan="5" class="editavel"><TEXTAREA NAME="obs" ROWS="3" COLS="95"><?php echo $isNovo?"":$row_objRS["OBS"]?></TEXTAREA>&nbsp;</td>
	</tr>
</table>
<!--botões e links-->
<table width="90%">
	<tr><td>
	<input type="submit" value="Editar >>" /><div align="right"><a href="javascript:history.back();"><b>Clique aqui</b></a> para voltar para a página anterior. <a href="<?php echo $_SESSION['menu_url']?>"><b>Clique aqui</b></a> para realizar nova consulta.</div>
<?php if($isNovo) { ?>
	<input type="hidden" name="novo" value="true"/>
<?php } ?>
	</td></tr>
</table>
</body>
</html>
