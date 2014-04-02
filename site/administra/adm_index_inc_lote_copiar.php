<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<?php
if (isset($_POST['copiar'])) {
?>
<script>

self.opener.location = 'adm_index_inc_lote.php?tombo_prefix=<?php echo $_POST['tombo_prefix']; ?>&tombo_inicio=<?php echo $_POST['tombo_inicio']; ?>&tombo_final=<?php echo $_POST['tombo_final']; ?>&copiar=<?php echo $_POST['copiar']; ?>';

window.close();

</script>
<?php
}
?>
<body onload="document.forms[0].copiar.focus();">
<form id="form1" name="form1" method="post" action="">
  Tombo a ser copiado:
  <label>
  <input name="copiar" type="text" id="copiar" />
  </label>
  <label>
  <input type="submit" name="Submit" value="Copiar"/>
  </label>
  <input name="tombo_prefix" type="hidden" id="tombo_prefix" value="<?php echo $_GET['tombo_prefix']; ?>"/>
  <input name="tombo_inicio" type="hidden" id="tombo_prefix" value="<?php echo $_GET['tombo_inicio']; ?>"/>
  <input name="tombo_final" type="hidden" id="tombo_prefix" value="<?php echo $_GET['tombo_final']; ?>"/>
</form>
</body>
</html>
