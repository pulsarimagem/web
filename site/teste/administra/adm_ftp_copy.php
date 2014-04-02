<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php 

$titulo_error = false;
$tamanho_error = false;
$uso_error = false;
$titulo = "";
$uso = "";
$tamanho = "";


$sql3="
select * from log_download2 where id_login = ".$_GET['id']." order by id_log desc";

mysql_select_db($database_pulsar, $pulsar);
$formulario = mysql_query($sql3, $pulsar) or die(mysql_error());
$row_formulario = mysql_fetch_assoc($formulario);
$totalRows_formulario = mysql_num_rows($formulario);

$query_usos = "SELECT USO_TIPO.tipo, USO_SUBTIPO.subtipo, USO_SUBTIPO.Id
FROM USO_SUBTIPO
LEFT JOIN USO ON USO.id_subtipo = USO_SUBTIPO.Id
LEFT JOIN USO_TIPO ON USO_TIPO.Id = USO.id_tipo
WHERE USO.contrato = 'F'
GROUP BY subtipo ORDER BY tipo,subtipo";

mysql_select_db($database_sig, $sig);
$usos = mysql_query($query_usos, $sig) or die(mysql_error());

$add_script = "
<script language=\"JavaScript\" type=\"text/JavaScript\">
function copiar() {

	document.getElementById('usuario').value = document.getElementById('usuario_ant').value;
	document.getElementById('titulo').value = document.getElementById('titulo_ant').value;
	document.getElementById('uso').value = document.getElementById('uso_ant').value;
		var dataString = 'action=tamanho&contrato=F&id_uso='+ document.getElementById('uso_ant').value;
		$.ajax({
			type: \"POST\",
			url: \"../tool_ajax.php\",
			data: dataString,
			cache: false,
			success: function(html) {
				$(\".tamanho\").html(html);
				document.getElementById('formato').value = document.getElementById('formato_ant').value;
			} 
		});
	};
</script>
"
?>

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
<script src="jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
	$(".uso").change(function()	{
		var id=$(this).val();
		var dataString = 'action=tamanho&contrato=F&id_uso='+ id;

		$.ajax({
			type: "POST",
			url: "../tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$(".tamanho").html(html);
			} 
		});
	});
});
</script>
<?php echo $add_script?>
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
    
                        <label>* Título do livro/projeto:</label>
	                    <input id="titulo" name="titulo" type="text" class="titulo<?php if($titulo_error) echo " error"?>" value="<?php echo $titulo?>" size="" />
	                    <input id="titulo_ant" name="titulo_ant" type="hidden" value="<?php echo $row_formulario['projeto']; ?>"/>
	                    
	                    <label>* Uso</label>
	                    <select id="uso" name="uso" class="uso<?php if($uso_error) echo " error"?>">
		                  	<option value="">--- Escolha um Uso ---</option>
<?php 
$last_tipo = "";
while($row_usos = mysql_fetch_array($usos)) { 
	if($row_usos['tipo']!=$last_tipo) {
		$last_tipo = $row_usos['tipo'];
?>
							<option>--- <?php echo $last_tipo?> ---</option>
<?php 
	}		
		
?>
		                  	<option value="<?php echo $row_usos['Id']?>"<?php if ($uso == $row_usos['Id']) echo " selected";?>><?php echo $row_usos['subtipo']?></option>
<?php 
} 
?>		                  	
	                    </select>
						<input id="uso_ant" name="uso_ant" type="hidden" value="<?php echo $row_formulario['uso']; ?>"/>
	                    
	                    <label>* Tamanho</label>
	                    <select id="formato" name="tamanho" class="tamanho<?php if($tamanho_error) echo " error"?>">
		                    <option value="">--- Escolha um uso primeiro ---</option>
	                    </select>
	                    <input id="formato_ant" name="formato_ant" type="hidden" value="<?php echo $row_formulario['formato']; ?>"/>
		                    
    
    
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
