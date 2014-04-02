<?php require_once('Connections/pulsar.php'); ?>
<?php
$colname_campo = "-1";
$colname_pesquisa = "login";
if (isset($_GET['campo'])) {
  $colname_campo = (get_magic_quotes_gpc()) ? $_GET['campo'] : addslashes($_GET['campo']);
}
if (isset($_GET['campo'])) {
  $colname_pesquisa = (get_magic_quotes_gpc()) ? $_GET['pesquisa'] : addslashes($_GET['pesquisa']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_pesquisa = sprintf("SELECT * FROM cadastro WHERE %s like '%%%s%%' AND %s not like 'Temporário%%'", $colname_pesquisa, $colname_campo, $colname_pesquisa);
$pesquisa = mysql_query($query_pesquisa, $pulsar) or die(mysql_error());
$row_pesquisa = mysql_fetch_assoc($pesquisa);
$totalRows_pesquisa = mysql_num_rows($pesquisa);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pesquisa Login</title>
<style type="text/css">
<!--
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.style5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.style7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
-->
</style>
</head>

<body>
<span class="style7">Pesquisa de Login - Digite um nome ou parte de um nome para a consulta:</span>
<form id="form1" name="form1" method="get" action="">
  <input name="campo" type="text" id="campo" size="50"  value="<?php echo $_GET['campo']; ?>"/>
  <select name="pesquisa" id="pesquisa">
    <option value="nome" <?php if (!(strcmp("nome", $_GET['pesquisa']))) {echo "selected=\"selected\"";} ?>>Nome</option>
    <option value="login" <?php if (!(strcmp("login", $_GET['pesquisa']))) {echo "selected=\"selected\"";} ?>>Login</option>
    <option value="empresa" <?php if (!(strcmp("empresa", $_GET['pesquisa']))) {echo "selected=\"selected\"";} ?>>Empresa</option>
    <option value="email" <?php if (!(strcmp("email", $_GET['pesquisa']))) {echo "selected=\"selected\"";} ?>>Email</option>
  </select>
  <input type="submit" name="Submit" value="pesquisar" />
</form>
<?php if (($totalRows_pesquisa > 0)) { // Show if recordset not empty ?>
  <table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#CCCCCC" class="style5">Login</td>
      <td bgcolor="#CCCCCC" class="style5">Nome</td>
      <td bgcolor="#CCCCCC" class="style5">Empresa</td>
      <td bgcolor="#CCCCCC" class="style5">Email</td>
    </tr>
    <?php do { ?>
      <tr>
        <td class="style3"><a href="adm_down_inc.php?login=<?php echo $row_pesquisa['login']; ?>"><?php echo $row_pesquisa['login']; ?></a></td>
        <td class="style3"><?php echo $row_pesquisa['nome']; ?></td>
        <td class="style3"><?php echo $row_pesquisa['empresa']; ?>&nbsp;</td>
        <td class="style3"><?php echo $row_pesquisa['email']; ?></td>
      </tr>
      <?php } while ($row_pesquisa = mysql_fetch_assoc($pesquisa)); ?>
  </table>
  <form action="adm_down_tmp.php" method="post" name="form9" target="_self" id="form9">
  <input name="Submit" type="submit" id="button" value="Criar Tempor&aacute;rio" />
  </form>
  <?php } else {
  if (isset($_GET['campo'])) {?>
  Cliente n&atilde;o cadastrado!!! Deseja criar cadastro temporário? <br />
<br />
<form action="adm_down_tmp.php" method="post" name="form9" target="_self" id="form9">
  <input name="Submit" type="submit" id="button" value="Criar Tempor&aacute;rio" />
</form>
  <?php }} ?>
</body>
</html>
<?php
mysql_free_result($pesquisa);
?>
