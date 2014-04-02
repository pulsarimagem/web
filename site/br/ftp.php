<?php require_once('Connections/pulsar.php'); ?>
<?php include("../tool_auth.php");?>
<?php 
$download_ok = false;
$show_videos = false;
//if(isset($_GET['videos'])) {
//	$show_videos = true;
//}

if (isset($_POST['opcao']) && $_POST['opcao'] == "download") {
	mysql_select_db($database_pulsar, $pulsar);
	$query_tombos = "SELECT tombo FROM pasta_fotos WHERE id_foto_pasta IN (".implode(",",$_POST['chkbox']).")";
	$tombos = mysql_query($query_tombos, $pulsar) or die(mysql_error());
	$row_tombos = mysql_fetch_assoc($tombos);
	
	$file = $row_tombos['tombo'].".jpg";
 /*	
	Header( "Content-type: image"); 
	header("Content-Disposition: attachment; filename=\"$file\""); 
	readfile($homeurl."bancoImagens/".$file);
	exit(0);*/
	header("Location: details_download.php?tombo=".$row_tombos['tombo']);
}

if (isset($_POST['action'])) {
	$files =  $_POST['files'];
	$files_chk =  $_POST['chkbox'];
	$directory = $_POST['dir'];
	
	$files_arr = array();
	
	if(sizeof($files_chk) > 0) {
		$files = $files_chk;
	}
	foreach($files as $file) {
		$insertSQL = sprintf("INSERT INTO log_download (arquivo, data_hora, ip, id_login) VALUES ('%s','%s','%s',%s)",
			$file,
			date("Y-m-d h:i:s", strtotime('now')),
			GetHostByName($_SERVER['REMOTE_ADDR']),
			$directory
		);

		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
		
		$files_arr[] = $homeftp.$directory."/".$file;
//		$files_arr[] = "C:\\05RC542.jpg";
	}
	
	$zipname = "pulsar_ftp.zip";
	$zipfile = $homeftp.$directory."/".$zipname;
//	$zipfile = "C:\\teste.zip";
	
	create_zip($files_arr,$zipfile,true);
	Header("Content-type: application/zip"); 
	header("Content-Disposition: attachment; filename=\"$zipname\""); 
	readfile_chunked($zipfile);
	unlink($zipfile);
	$download_ok = true;
}


// Carregar pastas

$colname_pastas = "1";
if (isset($_SESSION['MM_Username'])) {
	$colname_pastas = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_pulsar, $pulsar);
$query_pastas = sprintf("SELECT ftp.id_ftp,   cadastro.login,   ftp.id_login,   ftp_arquivos.nome, ftp_arquivos.flag,  ftp_arquivos.data_cria,addDate(ftp_arquivos.data_cria,   ftp_arquivos.validade) as validade,   ftp_arquivos.observacoes,   ftp_arquivos.tamanho, ftp_arquivos.id_arquivo, ftp_arquivos.flag FROM cadastro  INNER JOIN ftp ON (cadastro.id_cadastro=ftp.id_login)  INNER JOIN ftp_arquivos ON (ftp_arquivos.id_ftp=ftp.id_login) WHERE ((cadastro.login LIKE '%s') AND (( TO_DAYS(ftp_arquivos.data_cria) - TO_DAYS(NOW()) + ftp_arquivos.validade )  >=0 )) ORDER BY ftp_arquivos.flag, ftp_arquivos.nome ", $colname_pastas);
$pastas = mysql_query($query_pastas, $pulsar) or die(mysql_error());
$row_pastas = mysql_fetch_assoc($pastas);
$totalRows_pastas = mysql_num_rows($pastas); 
$back_uri = $_SESSION['last_uri'];


function DoFormatNumber($theObject,$NumDigitsAfterDecimal,$DecimalSeparator,$GroupDigits) { 
	$currencyFormat=number_format($theObject,$NumDigitsAfterDecimal,$DecimalSeparator,$GroupDigits);
	return ($currencyFormat);
}

function makeStamp($theString) {
  if (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/", $theString, $strReg)) {
    $theStamp = mktime($strReg[4],$strReg[5],$strReg[6],$strReg[2],$strReg[3],$strReg[1]);
  } else if (preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/", $theString, $strReg)) {
    $theStamp = mktime(0,0,0,$strReg[2],$strReg[3],$strReg[1]);
  } else if (preg_match("/([0-9]{2}):([0-9]{2}):([0-9]{2})/", $theString, $strReg)) {
    $theStamp = mktime($strReg[1],$strReg[2],$strReg[3],0,0,0);
  }
  return $theStamp;
}

function makeDateTime($theString, $theFormat) {
  $theDate=date($theFormat, makeStamp($theString));
  return $theDate;
} 
if(!$download_ok) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
<script language="JavaScript" type="text/JavaScript">
function validate15(f) {
 if (document.form1.length<2) {
 	return false;
	}
  var chkbox = f.elements['chkbox[]'];
  var chkcounter = 0;
  if (typeof chkbox.length == 'undefined') {
    // there's only one checkbox on the form
    // normalize it to an array/collection
    chkbox = new Array(chkbox);
  }
  for (var i = 0; i < chkbox.length; i++) {
     if (chkbox[i].checked) {
    	 chkcounter += 1;
      }
   }
    if (chkcounter > 15) {
        alert('Aviso!\n\rRecomendamos baixar apenas 15 arquivos simultaneamente.');
        return false;
    } else {     
		return true;
	}
}
</script>
</head>
<body>

<?php include("part_topbar.php")?>

<div class="main size960">

<?php //include("part_grid_left.php")?>

	<div class="grid-center">
		<div class="primeirapagina">
			<div class="minhasimagens">
				<h2>Meu FTP</h2>
				<form name="form1" method="post" action="ftp.php" onsubmit="return validate15(document.form1);">
					<input type="hidden" name="action" value="submit"/>
					<input type="hidden" name="opcao" value=""/>
					<input type="hidden" name="q_pasta" value=""/>
					<input name="dir" type="hidden" value="<?php echo $row_pastas['id_login']; ?>" />
<?php if($totalRows_pastas == 0) {?>				
					<div class="error-msg">
						Você não possui nenhum arquivo no FTP
					</div>
<?php } else {?>				
					<div class="minhasimages-pastas">
<?php 
	$foto_header = false;
	$video_header = false;
	$show_videos = false;
	do {

		if (strpos($row_pastas['flag'],"V")!== false)
			$show_videos = true;
		else 
			$show_videos = false;

		if(!$show_videos && !$foto_header) {
			$foto_header=true; 
?>					
					Fotos
                    <div class="clear"></div></br>
					<input name="action" type="image" src="./images/bt-downloadAll.png" class="button" value="Baixar todos os arquivos" />
						<br/>
						<br/>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<td width="14"><!-- <input name="checkbox1" type="checkbox" value="checkbox" onClick="MM_callJS('checkAll(document.form1);')"/> --></td>
									<td width="83">&nbsp;</td>
									<td>Nome do Arquivo <span>&nbsp;</span></td>
									<td>Tamanho <span>&nbsp;</span></td>
									<td>Disponível até <span>&nbsp;</span></td>
									<td>Observação <span>&nbsp;</span></td>
								</tr>
							</thead>
							<tbody>
<?php 		
		}
		if($show_videos && !$video_header) {
			if($foto_header) {
?>
							</tbody>
						</table>
						<br/>
						<input name="action" type="image" src="./images/bt-downloadAll.png" class="button" value="Baixar todos os arquivos" />

<?php 
			} 
			$video_header=true;
?>					
						
                        <div class="clear"></div><br/>
						Videos</br>
                        <div class="clear"></div>
						<br/>
						<br/>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<td width="14"><!-- <input name="checkbox1" type="checkbox" value="checkbox" onClick="MM_callJS('checkAll(document.form1);')"/> --></td>
									<td width="83">&nbsp;</td>
									<td>Nome do Arquivo <span>&nbsp;</span></td>
									<td>Tamanho <span>&nbsp;</span></td>
									<td>Disponível até <span>&nbsp;</span></td>
									<td>Observação <span>&nbsp;</span></td>
								</tr>
							</thead>
							<tbody>
<?php } ?>							
								<tr>
 									<td class="check"><?php if(!$show_videos) { ?><input name="chkbox[]" type="checkbox" value="<?php echo $row_pastas['nome']; ?>" /><?php } ?></td>  
<?php if (isset($row_pastas['tombo'])) {?>
									<td class="image"><span><img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_pastas['tombo']; ?>p.jpg" title="<?php echo $row_pastas['tombo']; ?>" style="max-width:77px; max-height:77px;" /></span></td>
<?php } else if ($show_videos){?>
									<td class="image"><span><img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_pastas['nome']; ?>p.jpg" style="max-width:77px; max-height:77px;" /></span></td>
<?php } else {
		$row_pastas['nome'] = str_replace(".JPG",".jpg",$row_pastas['nome']);
?>
									<td class="image"><span><img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_pastas['nome']; ?>" style="max-width:77px; max-height:77px;" /></span></td>
<?php } ?>
									<td class="form">
<?php if($show_videos) { ?>									
										<a href="<?php echo $cloud_server?>download_videos.php?u=<?php echo $row_top_login['login']?>&p=<?php echo $row_top_login['senha']?>&c=<?php echo $row_pastas['nome']; ?>&s=<?php echo strstr($row_pastas['flag'],'H')?"hd":"sd"?>" class="link"><?php echo $row_pastas['nome']; ?></a>
<?php } else { ?>
										<a href="../tool_downloader2.php?f=<?php echo $row_pastas['nome']; ?>&d=<?php echo $row_pastas['id_login']; ?>" class="link"><?php echo $row_pastas['nome']; ?></a>
<?php } ?>
									</td>
									<td><p align="center"><?php echo ($show_videos?($row_pastas['flag']=="VS"?"SD":"HD"):DoFormatNumber($row_pastas['tamanho']/1024, 0, ',', '.')."kb"); ?></p></td>
									<td><p align="center"><?php echo makeDateTime($row_pastas['validade'], 'd/m/Y'); ?></p></td>
									<td><p align="center"><?php echo $row_pastas['observacoes']; ?></p></td>
								</tr>
								<input name="files[]" type="hidden" value="<?php echo $row_pastas['nome']; ?>" />
<?php } while ($row_pastas = mysql_fetch_assoc($pastas));?>							
<?php if ($foto_header && !$video_header) { ?>
							</tbody>
						</table>
						<br/>
						<input name="action" type="image" src="./images/bt-downloadAll.png" class="button" value="Baixar todos os arquivos" />
<?php } ?>
<?php if ((!$foto_header && $video_header) || ($foto_header && $video_header)) { ?>
							</tbody>
						</table>
						<br/>
<?php } ?>
					</div>
<?php }?>
				</form>
			</div>			
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
<?php 
}
?>