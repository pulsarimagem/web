<?php require_once('Connections/pulsar.php'); ?>
<?php require_once('Connections/sig.php'); ?>
<?php include("tool_auth.php"); ?>
<?php 

$de = $_GET['de'];
$ate = $_GET['ate'];
$sigla_autor = strtoupper($row_top_login['Iniciais_Fotografo']);
//$sigla_autor = strtoupper($_GET['sigla_autor']);

//formatando a data para consulta no banco mysql

$data_de = explode("/", $de); 
$de_ano	  = $data_de[2];
$de_mes	  = $data_de[1];
$de_dia	  = $data_de[0];
$de_mysql = $de_ano."/".$de_mes."/".$de_dia;

$data_ate = explode("/", $ate); 
$ate_ano  = $data_ate[2];
$ate_mes  = $data_ate[1];
$ate_dia  = $data_ate[0];
$ate_mysql= $ate_ano."/".$ate_mes."/".$ate_dia;
 
//consultando aliquota de imposto
$strSQL = "SELECT REFERENCIA FROM TA_ALIQUOTA WHERE DESCRICAO = 'IMPOSTOS'";
mysql_select_db($database_sig, $sig);
$objRsImposto = mysql_query($strSQL, $sig) or die(mysql_error());
$row_objRsImposto = mysql_fetch_assoc($objRsImposto);
$totalRows_objRsImposto = mysql_num_rows($objRsImposto);

$total_indio = 0;
 
//consultando contratos baixados no período solicitado 
$strSQL = " SELECT ID, DATA, DATA_PAGTO, ID_CLIENTE, ID_CONTATO, VALOR_TOTAL, ID_CONTRATO_DESC FROM CONTRATOS WHERE CAST(CONCAT(SUBSTR(DATA_PAGTO,7,4),'-',SUBSTR(DATA_PAGTO,4,2),'-',SUBSTR(DATA_PAGTO,1,2)) as DATE) BETWEEN '".$de_mysql."' AND '".$ate_mysql."' AND BAIXADO = 'S' ";
mysql_select_db($database_sig, $sig);
$objRsContratos = mysql_query($strSQL, $sig) or die(mysql_error());
//$row_objRsContratos = mysql_fetch_assoc($objRsContratos);
$totalRows_objRsContratos = mysql_num_rows($objRsContratos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Imagens - Administração de Usuários</title>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>
<body id="relatorio_comissoes">
<div class="main">
<?php include("part_header.php");?> 
    <div class="colA">
		<h2>Relatório de Comissões</h2>
<?php
//consultando informações para um único autor

	If($totalRows_objRsContratos == 0) {
?>
		<table>
			<tr>
				<th colspan="2"><center>Relatório de Comissão de Autores</center></th>
			</tr>
			
			<tr></tr>
			
			<tr>
				<td id="border" colspan="2">Nenhum registro encontrado com as informações digitadas.</td>
			</tr>
			
			<tr>
				<td id="border" width="15%">de:</td>
				<td id="border"><b><?php echo $de;?>&nbsp;</b></td>
			</tr>

			<tr>
				<td id="border" width="15%">até:</td>
				<td id="border"><b><?php echo $ate;?>&nbsp;</b></td>
			</tr>
			
			<tr>
				<td id="border" width="15%">Autor:</td>
				<td id="border"><b><?php echo $sigla_autor;?>&nbsp;</b></td>
			</tr>
			
			<tr>
				<td colspan="2"><a href="consulta_comissoes.php"><b>Clique aqui</b></a> para realizar nova consulta.</td>
			</tr>
		</table>
	
<?php
	}
	Else {
	    	        	
		//consultando cromos vendidos do autor selecionado nos contratos baixados no período solicitado
		$strSQL = "SELECT * FROM CONTRATOS A, CROMOS B WHERE CAST(CONCAT(SUBSTR(A.DATA_PAGTO,7,4),'-',SUBSTR(A.DATA_PAGTO,4,2),'-',SUBSTR(A.DATA_PAGTO,1,2)) as DATE) BETWEEN '".$de_mysql."' AND '".$ate_mysql."' AND A.BAIXADO = 'S' AND A.ID = B.ID_CONTRATO AND B.AUTOR = '".$sigla_autor."'";
		mysql_select_db($database_sig, $sig);
		$objRsCromo = mysql_query($strSQL, $sig) or die(mysql_error());
		$row_objRsCromo = mysql_fetch_assoc($objRsCromo);
		$totalRows_objRsCromo = mysql_num_rows($objRsCromo);
		
		if($totalRows_objRsContratos == 0) {
?>
		<table>
			<tr>
				<th colspan="2"><center>Relatório de Comissão de Autores</center></th>
			</tr>
			
			<tr></tr>
			
			<tr>
				<td id="border" colspan="2">Nenhum registro encontrado com as informações digitadas. </td>
			</tr>
			
			<tr>
				<td id="border" width="15%">de:</td>
				<td id="border"><b><?php echo $de;?>&nbsp;</b></td>
			</tr>

			<tr>
				<td id="border" width="15%">até:</td>
				<td id="border"><b><?php echo $ate;?>&nbsp;</b></td>
			</tr>
			
			<tr>
				<td id="border" width="15%">Autor:</td>
				<td id="border"><b><?php echo $sigla_autor;?>&nbsp;</b></td>
			</tr>
			
			<tr>
				<td colspan="2"><a href="consulta_comissoes.php"><b>Clique aqui</b></a> para realizar nova consulta.</td>
			</tr>
		</table>
	<?php 
		} 
		else {
	?> 	
			
		<table width="100%">
			<thead>
			<tr>
				<td colspan="4" align="center"><center>Relatório de Comissão de Autores</center></td>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>Autor</td>
				<?php
				$strSQL="SELECT nome FROM AUTORES_OFC WHERE sigla='".$sigla_autor."' ORDER BY NOME ";
				mysql_select_db($database_sig, $sig);
				$objRsAutor = mysql_query($strSQL, $sig) or die(mysql_error());
				$row_objRsAutor = mysql_fetch_assoc($objRsAutor);
				$totalRows_objRsAutor = mysql_num_rows($objRsAutor);
				?>
				<td><b><?php echo $row_objRsAutor["nome"];?></b></td>
				<td>Sigla</td>
				<td><b><?php echo $sigla_autor;?></b></td>
			</tr>
			<tr>
				<td colspan="4"><center><b>Período Solicitado</b></center></td>
			</tr>
			<tr>
				<td><p>De</td>
				<td><b><?php echo $de;?></b></td>
				<td><p>Até</td>
				<td><b><?php echo $ate;?></b></td>		
			</tr>
			</tbody>
		</table>
			
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <td>CONTRATO</td>
                <td>CLIENTE</td>
<!--                  <td>COMPRADOR</td>-->	
                <td>CÓDIGO</td>
                <td>ASSUNTO</td>
                <td>VALOR</td>
                <td>COMISSÃO</td>
            </tr>
            </thead>
            <tbody>
			<?php
			$count_cromo = 0;
			$COMISSAO_AUTOR_TOTAL = 0;
			While($row_objRsContratos = mysql_fetch_assoc($objRsContratos)) {
			
				$indio = false;
				$isOld = false;
				
				If(isIndio($row_objRsContratos["ID_CONTRATO_DESC"], $sig)) {
					$indio = true;
				}
				$strSQL = "SELECT * FROM CROMOS WHERE ID_CONTRATO = ".$row_objRsContratos["ID"]." AND AUTOR = '".$sigla_autor."'";
				mysql_select_db($database_sig, $sig);
				$OBJCROMOS = mysql_query($strSQL, $sig) or die(mysql_error());
				$totalRows_OBJCROMOS = mysql_num_rows($OBJCROMOS);
				
				WHILE ($row_OBJCROMOS = mysql_fetch_assoc($OBJCROMOS)) {
					$count_cromo +=  1;
					
					//consultando informações do uso do cromo
					$strSQL = "select uso.Id, tipo_br as tipo, subtipo_br as subtipo, descricao_br as descricao, valor from USO as uso, USO_TIPO as tipo, USO_SUBTIPO as sub, USO_DESC as descr where uso.id_tipo = tipo.Id and uso.id_utilizacao = sub.Id and uso.id_tamanho = descr.Id and uso.id = ".$row_OBJCROMOS["ID_USO"];
					mysql_select_db($database_sig, $sig);
					$objRsUso = mysql_query($strSQL, $sig) or die(mysql_error());
					$row_objRsUso = mysql_fetch_assoc($objRsUso);
					$totalRows_objRsUso = mysql_num_rows($objRsUso);

					//consultando nome fantasia do cliente
					$strSQL = " SELECT FANTASIA FROM CLIENTES WHERE ID = ".$row_objRsContratos["ID_CLIENTE"];  
					mysql_select_db($database_sig, $sig);
					$objRsCliente = mysql_query($strSQL, $sig) or die(mysql_error());
					$row_objRsCliente = mysql_fetch_assoc($objRsCliente);
					$totalRows_objRsCliente = mysql_num_rows($objRsCliente);
					
					$row_OBJCROMOS["DESCONTO"] = fixnumber($row_OBJCROMOS["DESCONTO"]);
					$row_OBJCROMOS["VALOR"] = fixnumber($row_OBJCROMOS["VALOR"]);
					
					$CROMO_VALOR = $row_OBJCROMOS["VALOR"] - $row_OBJCROMOS["DESCONTO"];

					$IMPOSTO_VALOR = $CROMO_VALOR * ($row_objRsImposto["REFERENCIA"] / 100);
					
					//COMISSAO COMPRADOR
					
					$DIVISOR_INDIO = 0;
					$DIVISOR_AUTOR = 0.45;
					If($indio)
						$DIVISOR_INDIO = 1/3;	
					$date_arr = explode('/',$row_objRsContratos['DATA_PAGTO']);
					$date_mysql = $date_arr[2].'-'.$date_arr[1].'-'.$date_arr[0];
					If(strtotime($date_mysql) < strtotime('2013-03-01')) {
						$DIVISOR_AUTOR = 0.50;
						$isOld = true;
					}
										
					IF($row_objRsContratos["ID_CONTATO"] != "") {
						$strSQL = "SELECT COMISSAO, CONTATO FROM CONTATOS WHERE ID = ".$row_objRsContratos["ID_CONTATO"]; 
						mysql_select_db($database_sig, $sig);
						$OBJCONTATO = mysql_query($strSQL, $sig) or die(mysql_error());
						$row_OBJCONTATO = mysql_fetch_assoc($OBJCONTATO);
						$totalRows_OBJCONTATO = mysql_num_rows($OBJCONTATO);
				    
						if($totalRows_OBJCONTATO > 0) {
												
							$cliente_contato = $row_OBJCONTATO["CONTATO"];
						
						
							if($row_OBJCONTATO["COMISSAO"] != "") {
								$COMPRADOR_COMISSAO = ($CROMO_VALOR - $IMPOSTO_VALOR)  * ($row_OBJCONTATO["COMISSAO"] / 100);
								$COMISSAO_INDIO		= (($CROMO_VALOR - $IMPOSTO_VALOR) - $COMPRADOR_COMISSAO) * ($DIVISOR_INDIO);
								$COMISSAO_AUTOR     = (($CROMO_VALOR - $IMPOSTO_VALOR) - $COMPRADOR_COMISSAO) * (1-$DIVISOR_INDIO) * $DIVISOR_AUTOR;
							}
							else {
								$COMPRADOR_COMISSAO = ($CROMO_VALOR - $IMPOSTO_VALOR)  * (0 / 100);
								$COMISSAO_INDIO		= (($CROMO_VALOR - $IMPOSTO_VALOR) - $COMPRADOR_COMISSAO) * ($DIVISOR_INDIO);
								$COMISSAO_AUTOR     = (($CROMO_VALOR - $IMPOSTO_VALOR) - $COMPRADOR_COMISSAO) * (1-$DIVISOR_INDIO) * $DIVISOR_AUTOR;
							}
						}
						else {
							$cliente_contato = "N/I";
							$COMISSAO_INDIO	= ($CROMO_VALOR - $IMPOSTO_VALOR) * ($DIVISOR_INDIO);
							$COMISSAO_AUTOR = ($CROMO_VALOR - $IMPOSTO_VALOR) * (1-$DIVISOR_INDIO) * $DIVISOR_AUTOR;
						}
					}
					ELSE {
						$cliente_contato = "N/I";
						$COMISSAO_INDIO = ($CROMO_VALOR - $IMPOSTO_VALOR) * ($DIVISOR_INDIO);
						$COMISSAO_AUTOR = ($CROMO_VALOR - $IMPOSTO_VALOR) * (1-$DIVISOR_INDIO) * $DIVISOR_AUTOR;
					}

			?>
            <tr>
                <td><center><?php If($indio) echo "*";?><?php If($isOld) echo "@";?><?php echo $row_objRsContratos["ID"];?></center></td>
                <td><?php echo $row_objRsCliente["FANTASIA"]; ?></td>
<!-- 	                <td><?php echo $cliente_contato;?></td> -->
                <td><a href="http://www.pulsarimagens.com.br/listing/detailResult/0?tombo=<?php echo $row_OBJCROMOS["CODIGO"];?>&page=1&type=<?php echo (isVideo($row_OBJCROMOS["CODIGO"])?"video":"image");?>"><?php echo $row_OBJCROMOS["CODIGO"];?></a></td>
                <td title="Uso: <?php echo $row_objRsUso["tipo"].$row_objRsUso["subtipo"] ?>"><?php echo $row_OBJCROMOS["ASSUNTO"];?></td>
                <td>R$ <?php If($CROMO_VALOR >= 0) echo formatnumber($CROMO_VALOR); Else echo "0,00";?></td>
                <td>R$ <?php If($COMISSAO_AUTOR >= 0) echo formatnumber($COMISSAO_AUTOR); Else echo "0,00";?></td>
            </tr>
			<?php		
			    If($COMISSAO_AUTOR >= 0) {
					$COMISSAO_AUTOR_TOTAL += $COMISSAO_AUTOR; 
					if($indio) {
						$total_indio += $COMISSAO_INDIO;
					}
			    }	
				}					
			}
			?>
			
			<tr>
				<td colspan="4"></td>
				<td><p align="right">TOTAL:</p></td>
				<td><b>R$ <?php echo formatnumber($COMISSAO_AUTOR_TOTAL);?></b></td>
			</tr>
			<tr>
				<td colspan="4"></td>
				<td><p align="right">TOTAL INDIOS:</p></td>
				<td><b>R$ <?php echo formatnumber($total_indio);?></b></td>
			</tr>
			<tr>
				<td colspan="6"> Foram localizados (<b><?php echo $count_cromo;?></b>) cromos com esta consulta. <a href="consulta_comissoes.php"><b>Clique aqui</b></a> para realizar nova consulta.</td>
			</tr>
				
            </tbody>
        </table>
		
		<center>
	        <form name="form_imp" action="relatorio_comissoes.php" target="_blank" method="get">
			    <input type="hidden" name="de" value="<?php echo $de;?>"   />
			    <input type="hidden" name="ate" value="<?php echo $ate;?>" />
			    <input type="hidden" name="sigla_autor" value="<?php echo $sigla_autor;?>" />
			    <!-- <input value="Imprimir" style="border:1px solid #333;background-color:#FFF;color:#333;font-weight:bold;background-image:url(images/print.png);background-repeat:no-repeat;padding:2px 2px 2px 10px;background-position:left center;" type="submit" /> -->
	        </form>
	    </center>
<?php
		}
	}
?>
	</div>
    <div class="colB">
<?php include("part_sidemenu.php");?>
    </div>
    <div class="clear"></div>
</div>
</body>
</html>

<?php //fechar e eliminar todos os objetos recordset e de conexão?>