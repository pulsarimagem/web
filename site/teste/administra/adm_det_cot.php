<?php require_once('Connections/pulsar.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "administra.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
$colname_login = "0";
if (isset($_SESSION['MM_Username'])) {
  $colname_login = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_login = sprintf("SELECT * FROM usuarios WHERE login like '%s'", $colname_login);
$login = mysql_query($query_login, $pulsar) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);
$totalRows_login = mysql_num_rows($login);

?>
<?php include("FCKeditor/fckeditor.php"); ?>
<?php
$colname_cliente = "1";
if (isset($_GET['id_cotacao2'])) {
  $colname_cliente = (get_magic_quotes_gpc()) ? $_GET['id_cotacao2'] : addslashes($_GET['id_cotacao2']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_cliente = sprintf("SELECT    cadastro.nome,   cadastro.empresa,   cadastro.email,   cadastro.telefone,   cadastro.cidade,   cadastro.estado,   cotacao_2.id_cotacao2,   cotacao_2.distribuicao,   cotacao_2.descricao_uso FROM  cotacao_2  INNER JOIN cadastro ON (cotacao_2.id_cadastro=cadastro.id_cadastro) WHERE id_cotacao2 = %s GROUP BY   cotacao_2.id_cotacao2,   cotacao_2.id_cadastro,   cotacao_2.distribuicao,   cotacao_2.descricao_uso,   cotacao_2.data_hora,   cotacao_2.atendida,   cadastro.nome,   cadastro.empresa ", $colname_cliente);
$cliente = mysql_query($query_cliente, $pulsar) or die(mysql_error());
$row_cliente = mysql_fetch_assoc($cliente);
$totalRows_cliente = mysql_num_rows($cliente);

$colname_fotos = "1";
if (isset($_GET['id_cotacao2'])) {
  $colname_fotos = (get_magic_quotes_gpc()) ? $_GET['id_cotacao2'] : addslashes($_GET['id_cotacao2']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_fotos = sprintf("SELECT    cotacao_cromos.tombo,   pastas.nome_pasta FROM  cotacao_cromos  LEFT OUTER JOIN pastas ON (cotacao_cromos.id_pasta=pastas.id_pasta) WHERE   (cotacao_cromos.id_cotacao2 = %s) ", $colname_fotos);
$fotos = mysql_query($query_fotos, $pulsar) or die(mysql_error());
$row_fotos = mysql_fetch_assoc($fotos);
$totalRows_fotos = mysql_num_rows($fotos);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0080)http://www.pulsarimagens.com.br/adm_det_cot.php?id_cadastro=00000000000000000020 -->
<HTML><HEAD><TITLE>Cotacao - detalhe</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<STYLE type=text/css>
.style1 {
	FONT-WEIGHT: bold; COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}
.style4 {
	FONT-SIZE: 12px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}
.style6 {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}
</STYLE>

<META content="MSHTML 6.00.2800.1491" name=GENERATOR>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=5 width="100%" bgColor=#ff9900 border=0>
  <TBODY>
    <TR>
      <TD class="style1">pulsarimagens.com.br<BR>
        cota&ccedil;&atilde;o</TD>
      <TD class=style1>
        <DIV align=right>
          <INPUT onClick="MM_goToURL('parent','adm_cotacao.php');return document.MM_returnValue" type=button value="Menu Cota&ccedil;&atilde;o" name=Button>
      </DIV></TD>
    </TR>
  </TBODY>
</TABLE>
<BR>
<TABLE borderColor=#666666 cellSpacing=0 cellPadding=3 width=650 border=1>
  <TBODY>
  <TR borderColor=#666666>
    <TD width="138" class="style6">Cliente:</TD>
    <TD width="494" class="style4"><?php echo $row_cliente['nome']; ?></TD>
  </TR>
  <TR borderColor=#666666>
    <TD class="style6">Empresa:</TD>
    <TD class="style4"><?php echo $row_cliente['empresa']; ?>&nbsp;</TD>
  </TR>
  <TR borderColor=#666666>
    <TD class="style6">Email:</TD>
    <TD class="style4"><?php echo $row_cliente['email']; ?></TD>
  </TR>
  <TR borderColor=#666666>
    <TD class="style6">Telefone:</TD>
    <TD class="style4"><?php echo $row_cliente['telefone']; ?></TD>
  </TR>
  <TR borderColor=#666666>
    <TD class="style6">Cidade:</TD>
    <TD class="style4"><?php echo $row_cliente['cidade']; ?></TD>
  </TR>
  <TR borderColor=#666666>
    <TD class="style6">Estado:</TD>
    <TD class="style4"><?php echo $row_cliente['estado']; ?></TD>
  </TR>
  <TR borderColor=#666666>
    <TD class="style6">Distribui&ccedil;&atilde;o:</TD>
    <TD><p class="style4"><?php echo $row_cliente['distribuicao']; ?></p>      </TD>
  </TR>
  <TR borderColor=#666666>
    <TD class="style6">Descri&ccedil;&atilde;o do uso :</TD>
    <TD class="style4"><?php echo $row_cliente['descricao_uso']; ?></TD>
  </TR>
  </TBODY></TABLE>
<BR>
<TABLE borderColor=#666666 cellSpacing=0 cellPadding=2 width=500 border=1>
  <TBODY>
  <TR class=style6>
    <TD width="221">
      <DIV align=center><STRONG>Foto</STRONG></DIV></TD>
    <TD width="265">
      <DIV align=center><STRONG>Pasta</STRONG></DIV></TD>
    </TR>
  <?php do { ?>
  <TR class=style4>
      <TD><div align="center"><?php echo $row_fotos['tombo']; ?><br>
          <IMG src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $row_fotos['tombo']; ?>p.jpg" 
      align=middle></div></TD>
      <TD><div align="center"><?php echo $row_fotos['nome_pasta']; ?>&nbsp;</div></TD>
  </TR>
  <?php } while ($row_fotos = mysql_fetch_assoc($fotos)); ?>
  </TBODY></TABLE>
<br>

<span class="style6">Responder:</span>
<form name="form1" method="post" action="adm_det_cot2.php">
<table width="700" border="1" cellpadding="3" cellspacing="0" bordercolor="#666666">
  <tr>
    <td class="style4">Responder para:</td>
    <td><input name="responder" type="text" id="responder" value="digite o e-mail para resposta" size="30">
    @pulsarimagens.com.br
      <input name="to" type="hidden" id="to" value="<?php echo $row_cliente['email']; ?>">
      <input name="id_cotacao2" type="hidden" id="id_cotacao2" value="<?php echo $_GET['id_cotacao2']; ?>">
</td>
  </tr>
  <tr>
    <td width="187" class="style4">Assunto da mensagem:</td>
    <td width="495"><input name="subject" type="text" id="subject" size="30">
    </td>
  </tr>
  <tr>
    <td class="style4">Mensagem:</td>
    <td><?php
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath = './FCKeditor/';
$oFCKeditor->Value = '';
$oFCKeditor->Create() ;
	?><br>
      <font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="1">Pulsar Imagens<br>
        </font> <font face="Verdana, Arial, Helvetica, sans-serif" color="#999999" size="1">www.pulsarimagens.com.br<br>
      pulsar@pulsarimagens.com.br</font></td></tr>
  <tr>
    <td colspan="2"><div align="center">      
      <p><br>
          <input type="submit" name="Submit" value="Enviar">    
          <br>
          <br>
      </p>
    </div></td>
  </tr>
</table>
</form>
</BODY>
</HTML>
<?php
mysql_free_result($cliente);

mysql_free_result($fotos);
?>

