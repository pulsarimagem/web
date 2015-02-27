<?php
$idLogin = -1;
$idLogin = isset($_GET['id_login'])?$_GET['id_login']:$idLogin;
$idLogin = isset($_POST['id_login'])?$_POST['id_login']:$idLogin;

$isDelall = (isset($_GET['delall'])?true:false);

$msg = "";

if (isset($_POST['MM_Del'])) {
	$arquivo = $_POST['arquivo'];
	mysql_select_db($database_pulsar, $pulsar);
	if(isset($_POST['cancela'])) {
		$query_arquivos = sprintf("SELECT * FROM ftp_arquivos WHERE id_ftp = %s AND nome = '$arquivo' ORDER BY nome", $idLogin);
		// echo $query_arquivos;
		$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
		$totalRows_arquivos = mysql_num_rows($arquivos);
		
		while($row_arquivos = mysql_fetch_assoc($arquivos)) {
			$deleteSQL = sprintf("DELETE FROM log_download2 WHERE arquivo = '%s' AND date(data_hora) = date(now()) AND id_login = %s AND usuario = '%s'",
					$arquivo,
					$idLogin,
					$row_login['login']
			);
			$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
			// echo $deleteSQL;
		}
	}
	$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/ftp/$idLogin/$arquivo";
	// 			echo $cmd."<br>";
	shell_exec($cmd);
	
// 	unlink($homeftp.$idLogin."/".$arquivo);
	$deleteSQL = sprintf("DELETE FROM ftp_arquivos WHERE nome = %s AND id_ftp = %s",
				GetSQLValueString($arquivo, "text"),
				GetSQLValueString($idLogin, "int")
	);
	$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
	$msg .= "Arquivo $arquivo removido com sucesso! ";
}

if($isDelall) {
	mysql_select_db($database_pulsar, $pulsar);
	$query_arquivos = sprintf("SELECT * FROM ftp_arquivos WHERE id_ftp = %s ORDER BY nome", $idLogin);
	// echo $query_arquivos;
	$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
	
	$totalRows_arquivos = mysql_num_rows($arquivos);
	while($row_arquivos = mysql_fetch_assoc($arquivos)) {
		$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/ftp/$idLogin/".$row_arquivos['nome'];
		// 			echo $cmd."<br>";
		shell_exec($cmd);
// 		unlink($homeftp.$idLogin."/".$row_arquivos['nome']);
		$deleteSQL = sprintf("DELETE FROM ftp_arquivos WHERE nome = %s AND id_ftp = %s",
				GetSQLValueString($row_arquivos['nome'], "text"),
				GetSQLValueString($idLogin, "int")
		);
		$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
// echo $deleteSQL;
		$msg .= "Todos os arquivo removidos com sucesso! ";
	}
}
?>
<?php

// REMOVER DIRETï¿½RIO ***

function ftp_rmdirr($ftp_stream, $directory) 
{ 
    // Sanity check 
    if (!is_resource($ftp_stream) || 
        get_resource_type($ftp_stream) !== 'FTP Buffer') { 
  
        return false; 
    } 
  
    // Init 
    $i             = 0; 
    $files         = array(); 
    $folders       = array(); 
    $statusnext    = false; 
    $currentfolder = $directory; 
  
    // Get raw file listing 
    $list = ftp_rawlist($ftp_stream, $directory, true); 
  
    // Iterate listing 
    foreach ($list as $current) { 
         
        // An empty element means the next element will be the new folder 
        if (empty($current)) { 
            $statusnext = true; 
            continue; 
        } 
  
        // Save the current folder 
        if ($statusnext === true) { 
            $currentfolder = substr($current, 0, -1); 
            $statusnext = false; 
            continue; 
        } 
  
        // Split the data into chunks 
        $split = preg_split('[ ]', $current, 9, PREG_SPLIT_NO_EMPTY); 
        $entry = $split[8]; 
        $isdir = ($split[0]{0} === 'd') ? true : false; 
  
        // Skip pointers 
        if ($entry === '.' || $entry === '..') { 
            continue; 
        } 
  
        // Build the file and folder list 
        if ($isdir === true) { 
            $folders[] = $currentfolder . '/' . $entry; 
        } else { 
            $files[] = $currentfolder . '/' . $entry; 
        } 
  
    } 
  
    // Delete all the files 
    foreach ($files as $file) { 
        ftp_delete($ftp_stream, $file); 
    } 
  
    // Delete all the directories 
    // Reverse sort the folders so the deepest directories are unset first 
    rsort($folders); 
    foreach ($folders as $folder) { 
        ftp_rmdir($ftp_stream, $folder); 
    } 
  
    // Delete the final folder and return its status 
    return ftp_rmdir($ftp_stream, $directory); 
} 

// REMOVER DIRETï¿½RIO ***

if (isset($_POST['diretorioxxx'])) {

			$ftproot = "/public_html/ftp/";
			$srcroot = $homeftp;        
			$srcrela = ltrim($_POST['diretorioxxx'],"0")."/";
/*
			$ftpc = ftp_connect("ftp.pulsarimagens.com.br");
			$ftpr = ftp_login($ftpc,"admpul","padm25sar");

			if ((!$ftpc) || (!$ftpr)) { echo "FTP connection not established!"; die(); }
			if (!chdir($srcroot)) { echo "Could not enter local source root directory."; die(); }
			if (!ftp_chdir($ftpc,$ftproot)) { echo "Could not enter FTP root directory."; die(); }

			ftp_rmdirr    ($ftpc,$ftproot.$srcrela);
		    // close the FTP connection
			ftp_close($ftpc);
*/
			if (rmdir($srcroot.$srcrela)) {

?><script language="JavaScript" type="text/JavaScript">
alert("Diretório removido com sucesso!!!");
</script><?php

			} else {
				echo "Erro ao apagar diretório!!!!"; die();
			}

			$deleteSQL = sprintf("DELETE FROM ftp WHERE id_login = %s",
                    $_POST['diretorioxxx']);
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
			$deleteSQL = sprintf("DELETE FROM ftp_arquivos WHERE id_ftp = %s",
                    $_POST['diretorioxxx']);
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
/*
			$deleteSQL = sprintf("DELETE FROM ftp_arquivos WHERE id_ftp = %s",
                    $_POST['diretorioxxx']);
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
*/			
		} ;



mysql_select_db($database_pulsar, $pulsar);
$query_ftps = "SELECT cadastro.login,   cadastro.id_cadastro,   cadastro.email, cadastro.nome, cadastro.temporario FROM ftp  INNER JOIN cadastro ON (ftp.id_login=cadastro.id_cadastro)";
$ftps = mysql_query($query_ftps, $pulsar) or die(mysql_error());
$row_ftps = mysql_fetch_assoc($ftps);
$totalRows_ftps = mysql_num_rows($ftps);

mysql_select_db($database_pulsar, $pulsar);
$query_emails = "SELECT * FROM usuarios";
$emails = mysql_query($query_emails, $pulsar) or die(mysql_error());
$row_emails = mysql_fetch_assoc($emails);
$totalRows_emails = mysql_num_rows($emails);

mysql_select_db($database_pulsar, $pulsar);
$query_to = sprintf("SELECT * FROM cadastro WHERE id_cadastro = %s", $idLogin);
$to = mysql_query($query_to, $pulsar) or die(mysql_error());
$row_to = mysql_fetch_assoc($to);
$totalRows_to = mysql_num_rows($to);

$titulo = "";
$titulo_error = false;
$action  = isset($_POST['action'])?$_POST['action']:"";





if($action == "copiarFoto") {
	include("../toolkit/inc_IPTC4.php");
	
	$tombos = $_POST['tombo'];
	$tombos = str_replace(",",";",$tombos);
	$tombos_arr = explode(";",$tombos);
	
	foreach ($tombos_arr as $tombo) {
		if(strlen($tombo) > 2) {
			$tombo = trim(strtoupper_br($tombo));
			$file = $tombo.'.jpg';
			$dest_file = "/tmp/$tombo.jpg";
			
			$cmd = "aws --profile pulsar s3 cp s3://pulsar-media/fotos/orig/$tombo.jpg $dest_file";
// 			echo $cmd."<br>";
			shell_exec($cmd);
			
			if (file_exists($dest_file)) {
				$fp = fopen($dest_file, "r");
				$s_array=fstat($fp);
				$tamanho = $s_array["size"];
				coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
				$cmd = "aws --profile pulsar s3 cp $dest_file s3://pulsar-media/ftp/".$_POST['diretorio']."/$tombo.jpg --acl public-read";
				shell_exec($cmd);
				$isOk = true;
			}
			
// 			$source_file = '/var/fotos_alta/'.$file;
// 			$dest_file = $homeftp.$_POST['diretorio'].'/'.$file;
// 			if (!file_exists($homeftp.$_POST['diretorio'])) {
// 				mkdir($homeftp.$_POST['diretorio'],0770);
// 			}
			
// 			if (!copy($source_file, $dest_file)) {
// 				$file = $tombo.'.JPG';
// 				$source_file = '/var/fotos_alta/'.$file;
// 				$dest_file = $homeftp.$_POST['diretorio'].'/'.$file;
// 				if (!copy($source_file, $dest_file)) {
// 					$isOk = false;
// 				} else {
// 					$isOk = true;
// 					$fp = fopen($dest_file, "r");
// 					$s_array=fstat($fp);
// 					$tamanho = $s_array["size"];
// 					fclose($fp);
// 				}
// 			} else {
// 				$isOk = true;
// 				$fp = fopen($dest_file, "r");
// 				$s_array=fstat($fp);
// 				$tamanho = $s_array["size"];
// 				fclose($fp);
// 			}
			
			if($isOk) {
// 				coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
				
				unlink($dest_file);
				
				$insertSQL = sprintf("INSERT INTO ftp_arquivos (id_ftp, data_cria,nome,tamanho,validade,observacoes) VALUES (%s,%s,%s,%s,%s,%s)",
						GetSQLValueString($_POST['diretorio'], "int"),
						GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"),
						GetSQLValueString($file, "text"),
						GetSQLValueString($tamanho, "long"),
						GetSQLValueString($_POST["validade"], "int"),
						GetSQLValueString($_POST["observacoes"], "text")
				);
				
				mysql_select_db($database_pulsar, $pulsar);
				$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
				
				$insertSQL = sprintf("INSERT INTO log_download2 (arquivo, data_hora, ip, id_login, usuario, projeto, formato, uso, obs) VALUES ('%s','%s','%s',%s,'%s','%s','%s','%s','%s')",
						$file,
						date("Y-m-d h:i:s", strtotime('now')),
						"FTP",
						$_POST['diretorio'],
						$row_login['login'],
						$_POST['titulo'],
						$_POST['tamanho'],
						$_POST['uso'],
						$_POST['observacoes']
				);
				mysql_select_db($database_pulsar, $pulsar);
			// 		echo $insertSQL;
				$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
				$msg .= "Arquivo $tombo incluído com sucesso! ";
			}
			else {
				$error .= "Arquivo $tombo não encontrado!!! ";
			}
		}
	}
}

else if($action == "copiarVideo") {

	$videos = $_POST['tombo'];
	$videos = str_replace(",",";",$videos);
	$videos_arr = explode(";",$videos);
	
	foreach ($videos_arr as $file) {
		if(strlen($file) > 2) {
			$queryTamanho = "SELECT descricao_br as tamanho from $database_sig.USO_DESC WHERE Id = ".$_POST['tamanho'];
			$rsTamanho = mysql_query($queryTamanho, $pulsar) or die(mysql_error());
			$rowTamanho = mysql_fetch_assoc($rsTamanho);
			
			$flag_tamanho = ($rowTamanho['tamanho'] == "SD"?"S":"H");
			
		
		// 	$file = $_POST['tombo'];
			
			$insertSQL = sprintf("INSERT INTO ftp_arquivos (id_ftp, data_cria,nome,tamanho,validade,observacoes,flag) VALUES (%s,%s,%s,%s,%s,%s,%s)",
					GetSQLValueString($_POST['diretorio'], "int"),
					GetSQLValueString(date("Y-m-d h:i:s", strtotime('now')), "date"),
					GetSQLValueString($file, "text"),
					GetSQLValueString(0, "long"),
					GetSQLValueString($_POST["validade"], "int"),
					GetSQLValueString($_POST["observacoes"], "text"),
					GetSQLValueString("V$flag_tamanho", "text")
			);
			
			mysql_select_db($database_pulsar, $pulsar);
			$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
			
			$insertSQL = sprintf("INSERT INTO log_download2 (arquivo, data_hora, ip, id_login, usuario, projeto, formato, uso, obs) VALUES ('%s','%s','%s',%s,'%s','%s','%s','%s','%s')",
					$file,
					date("Y-m-d h:i:s", strtotime('now')),
					"FTP",
					$_POST['diretorio'],
					$row_login['login'],
					$_POST['titulo'],
					$_POST['tamanho'],
					$_POST['uso'],
					$_POST['observacoes']
			);
			mysql_select_db($database_pulsar, $pulsar);
		// 		echo $insertSQL;
			$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());
			$msg .= "Arquivo $file incluído com sucesso! ";
		}
	}	
}
else if($action == "enviarEmail") {

$to      = $_POST['to'] . "\n";
$subject = $_POST['subject'];
// if (1==2) {
// 	$subject = $subject."<br><strong>Atenção: utilize o login e senha abaixo.<br><br>Login:"."<br>Senha:"."</stong><br>";
// }
$subject = $subject."\n";
$message = '
<html>
<head>
<title>:: Pulsar Imagens ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body topmargin="0">
<table width="534" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1" background="http://www.pulsarimagens.com.br/images/mail_pontilhado_03.gif"><img src="images/spacer.gif" width="1" align="absmiddle"> </td>
    <td width="532"><table width="530" border="0" align="center" cellpadding="0" cellspacing="0" class="borda_tabela">
      <tr>
        <td colspan="3">
          <table width="520"  border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td background="http://www.pulsarimagens.com.br/images/mail_barra_logo.gif"><a href="http://www.pulsarimagens.com.br/" target="_blank"><img src="http://www.pulsarimagens.com.br/images/header_03.gif" width="225" height="61" border="0"></a></td>
            </tr>
            <tr>
              <td width="540" height="10"><img src="http://www.pulsarimagens.com.br/images/mail_barra_escura.gif" width="100%" height="10"></td>
            </tr>
          </table>
          <br>
          <div align="center">
            <table width="500" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="left">
                  <font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="1">
                      <br>
                        '.stripslashes( $_POST['FCKeditor1'] ).'</font><br><br>
                         <font face="Verdana, Arial, Helvetica, sans-serif" color="#999999" size="1">www.pulsarimagens.com.br<br>
pulsar@pulsarimagens.com.br
</font></div></td>
              </tr>
            </table>
          </div>
          <br>
          <table width="530" align="center" cellpadding="00" cellspacing="0">
            <tr>
              <td width="430" height="41" background="http://www.pulsarimagens.com.br/images/mail_copyright_44.gif" >
			
			    <table width="400" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="200" nowrap><font face="Verdana, Arial, Helvetica, sans-serif" color="#ffffff" size="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato: 55 (11) 3875-0101 </font></td>
                  <td width="200"><font face="Verdana, Arial, Helvetica, sans-serif" color="#ffffff" size="1"><a href="mailto:pulsar@pulsarimagens.com.br"><img src="http://www.pulsarimagens.com.br/images/mail_endereco.gif" width="176" height="20" border="0"></a></font></td>
                </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="1" background="http://www.pulsarimagens.com.br/images/mail_pontilhado_03.gif"><img src="images/spacer.gif" width="1" align="absmiddle"></td>
  </tr>
</table>
<br>
</body>
</html>

';
$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: Pulsar Imagens <".($_POST["responder"]).">\n";
//$headers .= "Bcc: ".($_POST["responder"])."\n";
//$headers .= "Bcc: FTP <ftp@pulsarimagens.com.br>\n";
$headers .= "Return-Path: ".($_POST["responder"])."\n";

// echo $message;

mail($to,$subject,$message,$headers);
$msg = "Email enviado com sucesso!";
}
?>
<?php 

mysql_select_db($database_pulsar, $pulsar);
$query_diretorios = "SELECT ftp.id_ftp,   cadastro.login, cadastro.empresa,   ftp.id_login, cadastro.nome, cadastro.email FROM cadastro  INNER JOIN ftp ON (cadastro.id_cadastro=ftp.id_login) ORDER BY cadastro.nome";
$diretorios = mysql_query($query_diretorios, $pulsar) or die(mysql_error());
$totalRows_diretorios = mysql_num_rows($diretorios);

$sql3="select * from log_download2 where id_login = ".$idLogin." order by id_log desc";

mysql_select_db($database_pulsar, $pulsar);
$formulario = mysql_query($sql3, $pulsar) or die(mysql_error());
$row_formulario = mysql_fetch_assoc($formulario);
$totalRows_formulario = mysql_num_rows($formulario);

$queryLastImage = "select * from log_download2 where id_login = ".$idLogin." AND arquivo RLIKE '^[0-9]' order by id_log desc limit 1";
$rsLastImage = mysql_query($queryLastImage, $sig) or die(mysql_error());
$totalLastImage = mysql_num_rows($rsLastImage);
$rowLastImage = mysql_fetch_array($rsLastImage);

if($totalLastImage > 0 && $rowLastImage['uso'] != "") {
	$queryLastImageUso = "select Id, id_tipo, id_utilizacao, id_tamanho, id_formato, id_distribuicao, id_periodicidade, id_descricao from USO where id = ".$rowLastImage['uso'];
	mysql_select_db($database_sig, $sig);
	$rsLastImageUso = mysql_query($queryLastImageUso, $sig) or die(mysql_error());
	$rowLastImageUso = mysql_fetch_assoc($rsLastImageUso);
	$totalLastImageUso = mysql_num_rows($rsLastImageUso);
}

mysql_select_db($database_pulsar, $pulsar);
$queryLastVideo = "select * from log_download2 where id_login = ".$idLogin." AND arquivo NOT RLIKE '^[0-9]' order by id_log desc limit 1";
$rsLastVideo = mysql_query($queryLastVideo, $sig) or die(mysql_error());
$totalLastVideo = mysql_num_rows($rsLastVideo);
$rowLastVideo = mysql_fetch_array($rsLastVideo);

if($totalLastVideo > 0) {
	$queryLastVideoUso = "select Id, id_tipo, id_utilizacao, id_tamanho, id_formato, id_distribuicao, id_periodicidade, id_descricao from USO where id = ".$rowLastVideo['uso'];
	mysql_select_db($database_sig, $sig);
	$rsLastVideoUso = mysql_query($queryLastVideoUso, $sig) or die(mysql_error());
	$rowLastVideoUso = mysql_fetch_assoc($rsLastVideoUso);
	$totalLastVideoUso = mysql_num_rows($rsLastVideoUso);
}

$colname_arquivos = "-1";
if ($idLogin!=-1) {
  $colname_arquivos = (get_magic_quotes_gpc()) ? $idLogin : addslashes($idLogin);
}
mysql_select_db($database_pulsar, $pulsar);
$query_arquivos = sprintf("SELECT * FROM ftp_arquivos WHERE id_ftp = %s ORDER BY nome", $colname_arquivos);

// echo $query_arquivos; 
$arquivos = mysql_query($query_arquivos, $pulsar) or die(mysql_error());
$row_arquivos = mysql_fetch_assoc($arquivos);
$totalRows_arquivos = mysql_num_rows($arquivos);
?>