<?php require_once('Connections/pulsar.php'); ?>
<?php 
include("tool_auth.php");

mysql_select_db($database_pulsar, $pulsar);
$query_mes_download = sprintf("SELECT MONTH(log_download2.data_hora) as mes, YEAR(log_download2.data_hora) as ano from log_download2 WHERE log_download2.id_login = %s GROUP BY mes,ano ORDER BY log_download2.data_hora DESC;", $row_top_login['id_cadastro']);
$mes_download = mysql_query($query_mes_download, $pulsar) or die(mysql_error());
$row_mes_download = mysql_fetch_assoc($mes_download);
$totalRows_mes_download = mysql_num_rows($mes_download);

$mes = $row_mes_download['mes'];
$ano = $row_mes_download['ano'];
if(isset($_GET['mes_ano'])) {
	$mes_ano = explode("/",$_GET['mes_ano']);
	$mes = $mes_ano[0];
	$ano = $mes_ano[1];
}

mysql_select_db($database_pulsar, $pulsar);
$query_fotos_download = sprintf("SELECT downloads.usuario, downloads.id_login, downloads.tombo, downloads.data_hora, downloads.circulacao, downloads.tiragem, downloads.projeto, downloads.formato, downloads.uso, downloads.obs, downloads.ip, fotografos.Nome_Fotografo, fotografos.Iniciais_Fotografo, Fotos.data_foto, Fotos.cidade, Estados.Estado, Estados.Sigla, Fotos.assunto_principal, paises.nome as pais from Fotos INNER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo) INNER JOIN (SELECT *, left(arquivo,length(arquivo)-4) as tombo from log_download2 WHERE log_download2.id_login = %s AND MONTH(log_download2.data_hora) = %s AND YEAR(log_download2.data_hora) = %s ORDER BY log_download2.data_hora DESC) as downloads ON (downloads.tombo=Fotos.tombo) LEFT OUTER JOIN Estados ON (Fotos.id_estado=Estados.id_estado) LEFT JOIN paises ON (paises.id_pais=Fotos.id_pais);", $row_top_login['id_cadastro'], $mes, $ano);
$fotos_download = mysql_query($query_fotos_download, $pulsar) or die(mysql_error());
$row_fotos_download = mysql_fetch_assoc($fotos_download);
$totalRows_fotos_download = mysql_num_rows($fotos_download);

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<?php include("scripts.php");?>
</head>
<body>
<div class="main">
	<div class="grid-right">
		<div class="primeirapagina">
			<div class="minhasimagens">
				<h2>
					Histórico de download
					<div class="clear"></div>
				</h2>
			</div>
            <div class="minhasimages-pastas">
            
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <td colspan="2">Relatorio Mensal de Download de Imagens</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
							<td width="120"><strong>Mês/Ano:</strong></td>
                            <td><?php echo $mes; ?>/<?php echo $ano; ?></td>
                        </tr>
                        <tr>
							<td><strong>Cliente:</strong></td>
                            <td><?php echo $row_top_login['nome']." / ".$row_top_login['empresa']; ?></td>
                        </tr>
                        <tr>
							<td><strong>Total de Downloads:</strong></td>
                            <td><?php echo $totalRows_fotos_download; ?></td>
                        </tr>
                    </tbody>
                </table>
            
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 22px;">
                    <thead>
                        
                        <tr>
	                        <td width="152">&nbsp;</td>
                            <td>Sobre</td>
                        </tr>
                    </thead>
                    <tbody>
<?php do {?>                    
                        <tr>
							<td width="152"><p align="center"><img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_fotos_download['tombo']; ?>p.jpg" /></p></td>
                            <td class="sobre">
                                Assunto: <strong><?php echo $row_fotos_download['assunto_principal']; ?></strong><br/>
                                Codigo: <strong><?php echo $row_fotos_download['tombo']; ?></strong><br/>
                                Autor: <strong><?php echo $row_fotos_download['Nome_Fotografo']; ?></strong><br/>
                                Data do Download: <strong><?php echo makeDateTime($row_fotos_download['data_hora'], 'd/m/y'); ?></strong><br/>
                                Usuário: <strong><?php echo $row_fotos_download['usuario']; ?></strong><br/>
                                Circulação: <strong><?php echo $row_fotos_download['circulacao']; ?></strong><br/>
<!--                                 Tiragem: <strong><?php echo $row_fotos_download['tiragem']; ?></strong><br/> -->
                                Titulos: <strong><?php echo $row_fotos_download['projeto']; ?></strong><br/>
                                Tamanho: <strong><?php echo $row_fotos_download['formato']; ?></strong><br/>
                                Uso: <strong><?php echo $row_fotos_download['uso']; ?></strong><br/>
                                Observação: <strong><?php echo $row_fotos_download['obs']; ?></strong><br/>                            </td>
                        </tr>
<?php } while($row_fotos_download = mysql_fetch_assoc($fotos_download));?>                        
                    </tbody>
                </table>
          </div>
		</div>
	</div>
	<div class="clear"></div>
</div>

</body>
</html>
