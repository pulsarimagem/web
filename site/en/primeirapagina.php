<?php require_once('Connections/pulsar.php'); ?>
<?php include("../tool_auth.php");?>
<?php 
$_SESSION['last_search'] = $_SERVER['REQUEST_URI'];

$show_welcome = false;
$show_fotos = false;
$show_pastas = true;

if (isset($_SESSION['show_welcome']) && $_SESSION['show_welcome'] == true) {
	$show_welcome = true;
	$_SESSION['show_welcome'] = false;
}

if (isset($_GET['id_pasta'])) {
	$show_fotos = true;
	$show_pastas = false;
}

$show_moveimg = false;
if ((isset($_POST['opcao']) && $_POST['opcao'] == "copiar")||(isset($_POST['nova_pasta'])&&$_POST['nova_pasta']!="")) {
	$show_moveimg = true;
	
	mysql_select_db($database_pulsar, $pulsar);
	$query_tombos = "SELECT tombo,id_foto_pasta FROM pasta_fotos WHERE id_foto_pasta IN (".implode(",",$_POST['chkbox']).")";
	$tombos = mysql_query($query_tombos, $pulsar) or die(mysql_error());
	$row_tombos = mysql_fetch_assoc($tombos);
	$totalRow_tombos = mysql_num_rows($tombos);
}

if (isset($_POST['opcao']) && $_POST['opcao'] == "download") {
	mysql_select_db($database_pulsar, $pulsar);
	$query_tombos = "SELECT tombo FROM pasta_fotos WHERE id_foto_pasta IN (".implode(",",$_POST['chkbox']).")";
	$tombos = mysql_query($query_tombos, $pulsar) or die(mysql_error());
	$row_tombos = mysql_fetch_assoc($tombos);
	$totalRow_tombos = mysql_num_rows($tombos);
	
	$file = $row_tombos['tombo'].".jpg";
/*	
	Header( "Content-type: image"); 
	header("Content-Disposition: attachment; filename=\"$file\""); 
	readfile($homeurl."bancoImagens/".$file);
	exit(0);*/
	if($totalRow_tombos > 1) {
		$location_url = "details_download.php?tombos[]=".$row_tombos['tombo'];
		while ($row_tombos = mysql_fetch_assoc($tombos)) {
			$location_url .= "&tombos[]=".$row_tombos['tombo'];
		};
		
		header("Location: ".$location_url);		
	}
	else {
		header("Location: details_download.php?tombo=".$row_tombos['tombo']);
	}
}

if($show_moveimg) {
	$_GET['moveimg'] = " ";
}

if($show_welcome) {
	$nome = "Noname";
	$colname_welcome = "1";
	if (isset($_SESSION['MM_Username'])) {
	  $colname_welcome = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
	}
	mysql_select_db($database_pulsar, $pulsar);
	$query_welcome = sprintf("SELECT nome FROM cadastro WHERE login='%s'", $colname_welcome);
	$nome_welcome = mysql_query($query_welcome, $pulsar) or die(mysql_error());
	$row_nome_welcome = mysql_fetch_assoc($nome_welcome);
	$totalRows_nome_welcome = mysql_num_rows($nome_welcome);
	
	if($totalRows_nome_welcome) {
		$nome = $row_nome_welcome['nome'];
	}
}

// Carregar pastas
if((isset($_GET['moveimg'])) || (isset($_POST['nova_pasta']) && ($_POST['nova_pasta'] != ""))) {
	if (isset($_POST['nova_pasta'])&&($_POST['nova_pasta']!="")) {
		$insertSQL = sprintf("INSERT INTO pastas (id_cadastro, nome_pasta, data_cria, data_mod) VALUES (%s, '%s', now(),now())", $row_top_login['id_cadastro'], $_POST['nova_pasta']);
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	}
	$show_addimg = true;
	$colname_pastas = "1";
	if (isset($_SESSION['MM_Username'])) {
		$colname_pastas = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
	}
	mysql_select_db($database_pulsar, $pulsar);
	$query_pastas = sprintf("SELECT pastas.id_pasta,   pastas.nome_pasta 	FROM cadastro  INNER JOIN pastas ON (cadastro.id_cadastro=pastas.id_cadastro) WHERE (cadastro.login LIKE '%s') GROUP BY pastas.id_pasta ORDER BY pastas.nome_pasta", $colname_pastas);
	$pastas = mysql_query($query_pastas, $pulsar) or die(mysql_error());
	$row_pastas = mysql_fetch_assoc($pastas);
	$totalRows_pastas = mysql_num_rows($pastas);
	$back_uri = $_SESSION['last_uri'];
}

// Codigo adicionar a minhas imagens

if(isset($_POST['action']) && ($_POST['action'] == "Copiar")) {

	foreach($_POST['tombo'] as $pasta_tombo) {
		
		// que pastas já tem esta foto
		$quem_fecha="sim";
		mysql_select_db($database_pulsar, $pulsar);
		$query_jatem = sprintf("
		SELECT 
		  pasta_fotos.tombo,
		  pastas.nome_pasta
		FROM
		 pasta_fotos
		 INNER JOIN pastas ON (pasta_fotos.id_pasta=pastas.id_pasta)
		WHERE
		  pasta_fotos.tombo = '%s'
		AND
		 (pasta_fotos.id_pasta in (%s))
		ORDER BY 
		 pastas.nome_pasta
		", $pasta_tombo, implode(',',$_POST['id_pastas']));
		$jatem = mysql_query($query_jatem, $pulsar) or die(mysql_error());
		$row_jatem = mysql_fetch_assoc($jatem);
		$totalRows_jatem = mysql_num_rows($jatem);
		$quem_jatem = "";
		if ($totalRows_jatem > 0) { // Show if recordset not empty
			do {
				//		$quem_jatem = "&quot;".$row_jatem['nome_pasta']."&quot;, ";
				$quem_jatem .= $row_jatem['nome_pasta'].", ";
			} while ($row_jatem = mysql_fetch_assoc($jatem));
			$quem_jatem = substr($quem_jatem,0,-2) . ".";
		} // Show if recordset not empty
	
		// inclui a imagem nas pastas
	
		$stringglue = ",'".$pasta_tombo."'),(";
		$insertSQL = "INSERT IGNORE INTO pasta_fotos (id_pasta, tombo) VALUES (".implode($stringglue,$_POST['id_pastas']).",'".$pasta_tombo."')";
	
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
		 
		$insertSQL = "UPDATE pastas SET data_mod = '".date("Y-m-d", strtotime('now'))."' WHERE id_pasta IN (".implode(",",$_POST['id_pastas']).")";
	
		$Result2 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
	
		/*
		 $updateGoTo = "Cgerenciador.php?jatem=".$quem_jatem;
		 if (isset($_SERVER['QUERY_STRING'])) {
		 $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		 $updateGoTo .= $_SERVER['QUERY_STRING'];
		 }
		 */
	}
}

mysql_select_db($database_pulsar, $pulsar);
$query_fotos_download = sprintf("SELECT downloads.id_login, downloads.tombo, fotografos.Nome_Fotografo, fotografos.Iniciais_Fotografo, Fotos.data_foto, Fotos.cidade, Estados.Estado, Estados.Sigla, Fotos.assunto_principal, paises.nome as pais from Fotos INNER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo) INNER JOIN (SELECT log_download2.id_login, log_download2.arquivo, left(arquivo,length(arquivo)-4) as tombo from log_download2 WHERE log_download2.id_login = %s ORDER BY log_download2.data_hora DESC LIMIT 50) as downloads ON (downloads.tombo=Fotos.tombo) LEFT OUTER JOIN Estados ON (Fotos.id_estado=Estados.id_estado) LEFT JOIN paises ON (paises.id_pais=Fotos.id_pais)
		;", $row_top_login['id_cadastro']);
//limit 4;", $row_top_login['id_cadastro']);
$fotos_download = mysql_query($query_fotos_download, $pulsar) or die(mysql_error());
$row_fotos_download = mysql_fetch_assoc($fotos_download);
$totalRows_fotos_download = mysql_num_rows($fotos_download);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body onLoad="document.forms.form1.rename.focus();">
<?php include("../tool_tooltip.php")?>

<?php if($show_moveimg) {?> 
<div class="overflow"></div>
<form name="form1" method="post" action="primeirapagina.php?id_pasta=<?php echo $_GET['id_pasta']?>">
	<div class="adicionarimagem" style="margin: -225px 0 0 -200px;">
		<a href="<?php echo $back_uri;?>" class="close">x</a>
	    <h2>Copy to another folder</h2>
	    <div class="imagens">
	    <img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_tombos['tombo']; ?>p.jpg" style="max-width:150px; max-height:150px; -moz-box-shadow: 4px 4px 0px #888; -webkit-box-shadow: 4px 4px 0px #888; box-shadow: 4px 4px 0px #888;"/>
<?php do { ?>	    
	    <input name="tombo[]" type="hidden" value="<?php echo $row_tombos['tombo'];?>"/>
	    <input name="chkbox[]" type="hidden" value="<?php echo $row_tombos['id_foto_pasta'];?>"/>
<?php } while($row_tombos = mysql_fetch_assoc($tombos)); ?>
		</div>
	    <h3>Select folder(s):</h3>
	    <ul>
<?php do { ?>    
	        <li><input name="id_pastas[]" type="checkbox" value="<?php echo $row_pastas['id_pasta']; ?>" /> <label><?php echo $row_pastas['nome_pasta']; ?></label><div class="clear"></div></li>
<?php } while ($row_pastas = mysql_fetch_assoc($pastas));?>
	        <li><input name="nova" id="chkNovaPasta" type="checkbox" value=""/> <label class="blue">Create new folder</label><div class="clear"></div></li>
	        <li id='novapasta' ><input name="nova_pasta" type="text" class="digite" /><input name="action_nova_pasta" type="submit" class="ok" value="ok" /><div class="clear"></div></li>
	    </ul>
		<input type="hidden" name="opcao" value=""/>
	    <input name="id_pasta" type="hidden" value="<?php echo $_GET['id_pasta'];?>"/>
	    <p class="button"><input name="action" type="submit" class="button" value="Copy" /></p>
	</div>
</form>
<?php } ?>

<?php include("part_topbar.php")?>

<div class="main size960">

		<div class="primeirapagina">
<?php if($show_welcome) {?>
			<h2 class="titulo-pagina">Welcome, <strong><?php echo $nome; ?></strong></h2>
			<p class="p">This is your area inside our website. Here you can save your favorites media and organize them into folders, share your collection via e-mail or add to your shopping cart.</p>
<?php } ?>
<?php if($show_pastas) include("part_minhasimagens_pastas.php")?>
			
<?php if($show_fotos) include("part_minhasimagens_imagens.php")?>

<?php //include("part_minhasimagens_home.php")?>
			
		</div>

</div>

<?php include("part_footer.php")?>

</body>
</html>
<?php 
/*
							<tr>
								<td class="check"><input name="" type="checkbox" value="" /></td>
								<td class="image"><span><img src="http://local.opg.co/dummyimage/77x52" width="77" height="52" /></span></td>
								<td class="form">Campos</td>
								<td><p align="center">1</p></td>
								<td><p align="center">10/10/2010</p></td>
								<td><p align="center">10/10/2010</p></td>
							</tr>
							
							<tr class="select">
								<td class="check"><input name="" type="checkbox" value="" /></td>
								<td class="image"><span><img src="http://local.opg.co/dummyimage/77x52" width="77" height="52" /></span></td>
								<td class="form">
									<input name="" type="text" class="text" />
									<input name="" type="button" class="button" value="Ok" />
								</td>
								<td><p align="center">1</p></td>
								<td><p align="center">10/10/2010</p></td>
								<td><p align="center">10/10/2010</p></td>
							</tr>
 */
?>