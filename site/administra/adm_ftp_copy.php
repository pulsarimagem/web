<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style14 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
-->
</style>
</head>

<body onload="document.form1.tombo.focus()">
<form id="form1" name="form1" method="post" action="adm_ftp_copy2.php">
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><span class="style14">Tombo:</span></td>
      <td><input name="tombo" type="text" id="tombo" size="60" /></td>
    </tr>
    <tr>
      <td><span class="style14">Validade: </span></td>
      <td><span class="style14">
        <input name="validade" type="text" id="validade" size="7" />
dias</span></td>
    </tr>
    <tr>
      <td><span class="style14">Observa&ccedil;&otilde;es: </span></td>
      <td><input name="observacoes" type="text" id="observacoes" size="60" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="diretorio" type="hidden" id="diretorio" value="<?php echo $_GET['id']?>" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center" class="style14">
        <input type="submit" name="Submit" value="Copiar" />
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>
