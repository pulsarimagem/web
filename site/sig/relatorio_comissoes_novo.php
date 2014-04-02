<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php 
if($siteDebug) {
	$timeStart = microtime(true);
}

$luis = isset($_GET['luis'])?true:false;

$de = $_GET['de'];
$ate = $_GET['ate'];
//$sigla_autor = strtoupper($row_top_login['Iniciais_Fotografo']);
$sigla_autor = strtoupper($_GET['sigla_autor']);

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
$comissoes_indios = get_tribos();// array("Kalapalo" => 0, "Caingangue" => 0, "Bororo" => 0, "Yanomami" => 0, "Kamayurá" => 0, "Xavante" => 0, "Yawalapiti" => 0, "Guarani" => 0, "Kambeba" => 0, "Kolulu" => 0, "Kaingang" => 0);
$comissoes_indios_nenhum = 0;
$contrato_indios_nenhum = "";
$comissoes_indios_dois = 0;
$contrato_indios_dois = "";


if($siteDebug) {
	$timeBefore = microtime(true);
}

//consultando contratos baixados no período solicitado 
$strSQL = " SELECT ID, DATA, DATA_PAGTO, ID_CLIENTE, ID_CONTATO, VALOR_TOTAL, ID_CONTRATO_DESC FROM CONTRATOS WHERE CAST(CONCAT(SUBSTR(DATA_PAGTO,7,4),'-',SUBSTR(DATA_PAGTO,4,2),'-',SUBSTR(DATA_PAGTO,1,2)) as DATE) BETWEEN '".$de_mysql."' AND '".$ate_mysql."' AND BAIXADO = 'S' ";
if($luis) 
	$strSQL .= "and ID_CONTATO in (select ID from CONTATOS where CONTATO like 'lu%vila%')";
mysql_select_db($database_sig, $sig);
$objRsContratos = mysql_query($strSQL, $sig) or die(mysql_error());
//$row_objRsContratos = mysql_fetch_assoc($objRsContratos);
$totalRows_objRsContratos = mysql_num_rows($objRsContratos);

if($siteDebug) {
	$diff = microtime(true) - $timeBefore;
	echo "<strong>delay Consulta Contrato: </strong>".$diff."</strong><br>";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens - Relatório Comissões</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<?php include('scripts.php')?>
<style type="text/css">
    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
</style>
</head>
<body id="relatorio_comissoes">
<div class="main">
<?php if(!$print) include("part_header.php");?> 
    <div class="colA">
		<h2>Relatório de Comissões</h2>
<?php
//todos os autores
If($sigla_autor == "TODOS") {
	If($totalRows_objRsContratos == 0) {
?>
		<table>
			<tr>
				<th colspan="2"><center><font face="Times New Roman">Relatório de Comissão de Autores</font></center></th>
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
				<td colspan="2"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
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
                <th>CONTRATO</th>
                <th>CLIENTE</th>
                <th>V. BRUTO NF</th>
                <th>IMPOSTO</th>
                <th>COMPRADOR</th>
                <th>C.C.</th>
                <th>C.A.</th>
            </tr>
            </thead>
            <tbody>		
			<?php
							
				//While Not objRsContratos.Eof
				$x = 0;
				$nf_tot = 0;
				$imp_tot = 0;
				$com_comp_tot = 0;
				$com_aut_tot = 0;
				
				if($siteDebug) {
					$timeBefore = microtime(true);
				}
				
				while ($row_objRsContratos = mysql_fetch_assoc($objRsContratos)) {
					
					//$row_objRsContratos['VALOR_TOTAL'] = str_replace(".","",$row_objRsContratos['VALOR_TOTAL']);
					//$row_objRsContratos['VALOR_TOTAL'] = str_replace(",",".",$row_objRsContratos['VALOR_TOTAL']);
					$row_objRsContratos['VALOR_TOTAL'] = fixnumber($row_objRsContratos['VALOR_TOTAL']);
					
					$x += 1;
					
					$indio = false;
					
					If(isIndio($row_objRsContratos["ID_CONTRATO_DESC"], $sig))
						$indio = true;
					
					//cálculo do imposto				
					$impvalor = ($row_objRsImposto["REFERENCIA"]/100) * $row_objRsContratos["VALOR_TOTAL"];
				
					//consultando nome do cliente
					$strSQL = " SELECT FANTASIA FROM CLIENTES WHERE ID = '".$row_objRsContratos["ID_CLIENTE"]."'";  
					mysql_select_db($database_sig, $sig);
					$objRsCliente = mysql_query($strSQL, $sig) or die(mysql_error());
					$row_objRsCliente = mysql_fetch_assoc($objRsCliente);
					$totalRows_objRsCliente = mysql_num_rows($objRsCliente);
										
					//cálculo da comissão do comprador
					If($row_objRsContratos["ID_CONTATO"] != "") {
						$strSQL = "SELECT contato,COMISSAO FROM CONTATOS WHERE ID_CLIENTE = '".$row_objRsContratos["ID_CLIENTE"]."' AND ID = ".$row_objRsContratos["ID_CONTATO"]; 
						mysql_select_db($database_sig, $sig);
						$objRsContato = mysql_query($strSQL, $sig) or die(mysql_error());
						$row_objRsContato = mysql_fetch_assoc($objRsContato);
						$totalRows_objRsContato = mysql_num_rows($objRsContato);
				
						if($totalRows_objRsContato > 0) {				
							$cliente_contato = $row_objRsContato["contato"];
							$cliente_comissao = ($row_objRsContratos["VALOR_TOTAL"] - $impvalor) * ($row_objRsContato["COMISSAO"] / 100);
						}
						else {
							$cliente_comissao = 0;
							$cliente_contato  = "N/I"; 
						}
					}
					Else {
						$cliente_comissao = 0;
						$cliente_contato  = "N/I"; 
					}
						
					if($cliente_comissao <= 0) { 
						$cliente_comissao = 0;
					}
					
					if($indio) {
						$indio_comissao = (($row_objRsContratos["VALOR_TOTAL"] - $impvalor) - $cliente_comissao) / 3;
						$autor_comissao = ((($row_objRsContratos["VALOR_TOTAL"] - $impvalor) - $cliente_comissao) - $indio_comissao)*0.45;
						$total_indio = $total_indio + $autor_comissao;
					}
					else {
//						$autor_comissao = (($row_objRsContratos["VALOR_TOTAL"] - $impvalor) - $cliente_comissao) / 2;
						$autor_comissao = ((($row_objRsContratos["VALOR_TOTAL"] - $impvalor) - $cliente_comissao))*0.45;
					}
					
			?>
			
					<tr>
						<td id="border"><center><?php If($indio) echo "*";?> <?php echo $row_objRsContratos["ID"];?></center></td>
						<td id="border"><?php echo $row_objRsCliente["FANTASIA"];?></td>
						<td id="border">R$ <?php echo $row_objRsContratos["VALOR_TOTAL"];?></td>
						<td id="border">R$ <?php If($impvalor >= 0) echo formatNumber($impvalor); Else echo "0,00";?></td>
						<td id="border"><?php echo $cliente_contato;?></td>
						<td id="border">R$ <?php If($cliente_comissao >= 0) echo formatNumber($cliente_comissao); Else echo"0,00";?></td>
						<td id="border">R$ <?php If($autor_comissao >= 0) echo formatNumber($autor_comissao); Else echo"0,00";?></td>
					</tr>
		
			<?php
					//soma dos totais de cada coluna
					$nf_tot += $row_objRsContratos["VALOR_TOTAL"];
					$imp_tot += $impvalor;
					If($cliente_comissao >= 0) {
					    $com_comp_tot += $cliente_comissao;
					}
					If($autor_comissao >= 0) {
					    $com_aut_tot += $autor_comissao;
					}				
				}
				if($siteDebug) {
					$diff = microtime(true) - $timeBefore;
					echo "<strong>delay Loop Consulta Contrato: </strong>".$diff."</strong><br>";
				}
			?>
			</tbody>
			<tr>
				<td colspan="2">Foram localizados (<b><?php echo $x;?></b>) registros com esta consulta.</td>
				<td id="border"><b>R$ <?php echo formatnumber($nf_tot);?></b></td>
				<td id="border"><b>R$ <?php echo formatnumber($imp_tot);?></b></td>
				<td>&nbsp;</td>
				<td id="border"><b>R$ <?php echo formatnumber($com_comp_tot);?></b></td>
				<td id="border"><b>R$ <?php echo FormatNumber($com_aut_tot);?></b></td>
			</tr>
		</table>
		
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th>AUTOR</th>
                <th>SIGLA</th>
                <th>COMISSÃO</th>
            </tr>
            </thead>
            <tbody>		
			
			<?php
				//CALCULANDO COMISSÃO DE CADA AUTOR
				$strSQL = "SELECT * FROM AUTORES_OFC ORDER BY trim(NOME)";
				mysql_select_db($database_sig, $sig);
				$OBJAUTORES = mysql_query($strSQL, $sig) or die(mysql_error());
				$totalRows_OBJAUTORES = mysql_num_rows($OBJAUTORES);
				
				$TOTAL = 0;
				
				if($siteDebug) {
					$timeBefore = microtime(true);
				}
				
				WHILE ($row_OBJAUTORES = mysql_fetch_assoc($OBJAUTORES)) {
					$COMISSAO_AUTOR_TOTAL = 0;
/*					 
					$strSQL = "SELECT * FROM CONTRATOS WHERE CAST(CONCAT(SUBSTR(DATA_PAGTO,7,4),'-',SUBSTR(DATA_PAGTO,4,2),'-',SUBSTR(DATA_PAGTO,1,2)) as DATE) BETWEEN '".$de_mysql."' AND '".$ate_mysql."' AND BAIXADO = 'S' ";
					if($luis)
						$strSQL .= "and ID_CONTATO in (select ID from CONTATOS where CONTATO like 'lu%vila%')";
					mysql_select_db($database_sig, $sig);
					$OBJCONTRATOS = mysql_query($strSQL, $sig) or die(mysql_error());
					$totalRows_OBJCONTRATOS = mysql_num_rows($OBJCONTRATOS);

					WHILE ($row_OBJCONTRATOS = mysql_fetch_assoc($OBJCONTRATOS)) {
						$strSQL = "SELECT * FROM CROMOS WHERE ID_CONTRATO = ".$row_OBJCONTRATOS["ID"]." AND AUTOR = '".$row_OBJAUTORES["SIGLA"]."'";
						mysql_select_db($database_sig, $sig);
						$OBJCROMOS = mysql_query($strSQL, $sig) or die(mysql_error());
						$totalRows_OBJCROMOS = mysql_num_rows($OBJCROMOS);

						$indio = false;

						If(isIndio($row_OBJCONTRATOS["ID_CONTRATO_DESC"])) {
							$indio = true;
						}

*/
					$strSQL = "
					SELECT * FROM CONTRATOS 
					RIGHT JOIN CROMOS ON CROMOS.ID_CONTRATO = CONTRATOS.ID
					WHERE CAST(CONCAT(SUBSTR(CONTRATOS.DATA_PAGTO,7,4),'-',SUBSTR(CONTRATOS.DATA_PAGTO,4,2),'-',SUBSTR(CONTRATOS.DATA_PAGTO,1,2)) as DATE) BETWEEN '".$de_mysql."' AND '".$ate_mysql."' 
					AND CONTRATOS.BAIXADO = 'S' AND CROMOS.AUTOR = '".$row_OBJAUTORES["SIGLA"]."'
					";
					if($luis)
						$strSQL .= " and CONTRATOS.ID_CONTATO in (select ID from CONTATOS where CONTATO like 'lu%vila%')";

					mysql_select_db($database_sig, $sig);
					$OBJCONTRATOS = mysql_query($strSQL, $sig) or die(mysql_error());
					$totalRows_OBJCONTRATOS = mysql_num_rows($OBJCONTRATOS);
					$OBJCROMOS = $OBJCONTRATOS;
					$totalRows_OBJCROMOS = $totalRows_OBJCONTRATOS;
						
						
						WHILE ($row_OBJCROMOS = mysql_fetch_assoc($OBJCROMOS)) {
							$row_OBJCONTRATOS = $row_OBJCROMOS; 
							$indio = false;

							If(isIndio($row_OBJCONTRATOS["ID_CONTRATO_DESC"], $sig)) {
								$indio = true;
							}
							
							$row_OBJCROMOS["DESCONTO"] = fixnumber($row_OBJCROMOS["DESCONTO"]);
							$row_OBJCROMOS["VALOR"] = fixnumber($row_OBJCROMOS["VALOR"]);
							
							$CROMO_VALOR = $row_OBJCROMOS["VALOR"] - $row_OBJCROMOS["DESCONTO"];
							
							$IMPOSTO_VALOR = $CROMO_VALOR * ($row_objRsImposto["REFERENCIA"] / 100);
							
							$DIVISOR_INDIO = 0;
							$DIVISOR_AUTOR = 0.45;
							If($indio)
								$DIVISOR_INDIO = 1/3;
							
							//COMISSAO COMPRADOR
							IF ($row_OBJCONTRATOS["ID_CONTATO"] != "") {
								$strSQL = "SELECT COMISSAO FROM CONTATOS WHERE ID = ".$row_OBJCONTRATOS["ID_CONTATO"];
								mysql_select_db($database_sig, $sig);
								$OBJCONTATO = mysql_query($strSQL, $sig) or die(mysql_error());
								$totalRows_OBJCONTATO = mysql_num_rows($OBJCONTATO);
								
								if($row_OBJCONTATO = mysql_fetch_assoc($OBJCONTATO)) {				

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
									$COMISSAO_INDIO	= ($CROMO_VALOR - $IMPOSTO_VALOR) * ($DIVISOR_INDIO);
									$COMISSAO_AUTOR = ($CROMO_VALOR - $IMPOSTO_VALOR) * (1-$DIVISOR_INDIO) * $DIVISOR_AUTOR;			
								}
							}								
							ELSE {
								$COMISSAO_INDIO = ($CROMO_VALOR - $IMPOSTO_VALOR) * ($DIVISOR_INDIO);
								$COMISSAO_AUTOR = ($CROMO_VALOR - $IMPOSTO_VALOR) * (1-$DIVISOR_INDIO) * $DIVISOR_AUTOR;
							}	
							
							if($COMISSAO_AUTOR >= 0) {
								$COMISSAO_AUTOR_TOTAL += $COMISSAO_AUTOR; 
							}
							If($indio) {
								$find = false;
								$double_find = false;
								$found_tribo = "";
								$found_tribo_val = 0;
								foreach($comissoes_indios as $tribo => &$total_tribo) {
									if(stristr($row_OBJCROMOS['ASSUNTO'],$tribo)!==false) {
//										echo "XXXXXXXX $COMISSAO_AUTOR $tribo<br>";
										$found_tribo = $tribo;
										$found_tribo_val += $COMISSAO_INDIO;
										if(!$find)
											$find = true;
										else
											$double_find = true;
									}
								}
								if(!$find) {
									$comissoes_indios_nenhum += $COMISSAO_INDIO;
									$contrato_indios_nenhum .= $row_OBJCROMOS['ID_CONTRATO'].", ";
								} else if($double_find) {
									$comissoes_indios_dois += $COMISSAO_INDIO;
									$contrato_indios_dois .= $row_OBJCROMOS['ID_CONTRATO'].", ";
								} else {
									$comissoes_indios[$found_tribo] += $found_tribo_val;
								}
							}
//						}						
					}
					//response.Write(cromo_valor)
					//response.End()
		?>
					<?php If($COMISSAO_AUTOR_TOTAL != 0) { ?>
					<tr>
						<td id="border"><?php echo $row_OBJAUTORES["NOME"];?></td>
						<td id="border"><?php echo $row_OBJAUTORES["SIGLA"];?></td>
						<td id="border">R$ <?php echo formatnumber($COMISSAO_AUTOR_TOTAL);?></td>
					</tr> 
		            <?php } ?>
		<?php
		            
		            if($COMISSAO_AUTOR_TOTAL >= 0) {
						$TOTAL += $COMISSAO_AUTOR_TOTAL;
		            }	
				}
				
				if($siteDebug) {
					$diff = microtime(true) - $timeBefore;
					echo "<strong>delay Loop Autores: </strong>".$diff."</strong><br>";
				}
		?>
		
		<tr>
			<td colspan="2"></td>
			<td id="border">R$ <?php If($TOTAL >= 0) echo FORMATNUMBER($TOTAL); Else echo "0,00";?></td>
		</tr>
<!-- 		<tr>
			<td id="border">TOTAL INDIOS</td>
			<td colspan="1"></td>
			<td id="border">R$ <?php echo FormatNumber($total_indio);?></td>
		</tr> -->		
		</tbody>
	</table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
        	    <tr>
            	    <th>TRIBO</th>
                	<th>COMISSÃO</th>
            	</tr>
            </thead>
            <tbody>		

<?php
	$tmp_total = 0;
	merge_tribos($comissoes_indios);
	foreach($comissoes_indios as $tribo => &$total_tribo) {
		if($total_tribo!=0) {
			$tmp_total += $total_tribo;
?>
				<tr>
					<td id="border"><?php echo $tribo?></td>
					<td id="border">R$ <?php echo FormatNumber($total_tribo)?></td>
				</tr> 
<?php 		
		}
	}
	$sum_indios = $tmp_total+$comissoes_indios_nenhum+$comissoes_indios_dois;
?>
			<tr>
				<td id="border"></td>
				<td id="border">R$ <?php echo FormatNumber($sum_indios)?></td>
			</tr>		
		</tbody>
	</table>
<?php 
	if($comissoes_indios_dois != 0) {
		echo "<br>Contrato Indio duas tribos :  ".$contrato_indios_dois."<br>";
		echo "Valor Contrato Indio duas tribos :  ".FormatNumber($comissoes_indios_dois)."<br>";
	}
	if($comissoes_indios_nenhum != 0) {
		echo "<br>Contrato Indio nao identificado :  ".$contrato_indios_nenhum."<br>";
		echo "Valor Contrato Indio nao identificado :  ".FormatNumber($comissoes_indios_nenhum)."<br>";
	}
?>
<?php 
	if(FormatNumber($total_indio) != FormatNumber($sum_indios)) {
		echo "<br><h2>Erro calculando indios. Divergencia de resultados. TOTAL1 = $total_indio e TOTAL2 = $sum_indios</h2><br>";
	}
?>	
<?php if(!$print) { ?>		
		<br/><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta.<br/>
<?php } ?>		
<?php if(!$print) { ?>
	    <center>
		    <form name="form_imp" action="relatorio_comissoes.php" target="_blank" method="get">
				<input type="hidden" name="de" value="<?php echo $de;?>"   />
				<input type="hidden" name="ate" value="<?php echo $ate;?>" />
				<input type="hidden" name="sigla_autor" value="<?php echo $sigla_autor;?>" />
				<input type="hidden" name="print" value="true" />
				<input class="printBtn" value="Imprimir" style="border:1px solid #333;background-color:#FFF;color:#333;font-weight:bold;background-image:url(images/print.png);background-repeat:no-repeat;padding:2px 2px 2px 10px;background-position:left center;" type="button" />
		    </form>
		</center>
<?php } ?>
<?php
	}
}

//consultando informações para um único autor
else {
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
				<td colspan="2"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
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
				<td colspan="2"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
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
				<td><p>De</p></td>
				<td><b><?php echo $de;?></b></td>
				<td><p>Até</p></td>
				<td><b><?php echo $ate;?></b></td>		
			</tr>
			</tbody>
		</table>
			
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th>CONTRATO</th>
                <th>CLIENTE</th>
<!--                  <td>COMPRADOR</td>-->	
                <th>CÓDIGO</th>
                <th>ASSUNTO</th>
                <th>VALOR</th>
                <th>COMISSÃO</th>
            </tr>
            </thead>
            <tbody>
			<?php
			$count_cromo = 0;
			$COMISSAO_AUTOR_TOTAL = 0;
			While($row_objRsContratos = mysql_fetch_assoc($objRsContratos)) {
			
				$indio = false;
				
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
					$strSQL = "select uso.Id, tipo, subtipo, descricao, valor from USO as uso, USO_TIPO as tipo, USO_SUBTIPO as sub, USO_DESC as descr where uso.id_tipo = tipo.Id and uso.id_subtipo = sub.Id and uso.id_descricao = descr.Id and uso.id = ".$row_OBJCROMOS["ID_USO"];
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
							
					
					IF($row_objRsContratos["ID_CONTATO"] != "") {
						$strSQL = "SELECT COMISSAO, CONTATO FROM CONTATOS WHERE ID = ".$row_objRsContratos["ID_CONTATO"]; 
						mysql_select_db($database_sig, $sig);
						$OBJCONTATO = mysql_query($strSQL, $sig) or die(mysql_error());
						$row_OBJCONTATO = mysql_fetch_assoc($OBJCONTATO);
						$totalRows_OBJCONTATO = mysql_num_rows($OBJCONTATO);
				    
						if($totalRows_OBJCONTATO > 0) {
												
							$cliente_contato = $row_OBJCONTATO["CONTATO"];
						
						
							if($row_OBJCONTATO["COMISSAO"] > 0) {							
								$COMPRADOR_COMISSAO = ($CROMO_VALOR - $IMPOSTO_VALOR) * ($row_OBJCONTATO["COMISSAO"] / 100);
								$COMISSAO_INDIO		= (($CROMO_VALOR - $IMPOSTO_VALOR) - $COMPRADOR_COMISSAO) * ($DIVISOR_INDIO);
								$COMISSAO_AUTOR     = (($CROMO_VALOR - $IMPOSTO_VALOR) - $COMPRADOR_COMISSAO) * (1-$DIVISOR_INDIO) * $DIVISOR_AUTOR;
								
							}
							else {
								$COMPRADOR_COMISSAO = ($CROMO_VALOR - $IMPOSTO_VALOR) * (0 / 100);
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
                <td><center><?php If($indio) echo "*";?><?php echo $row_objRsContratos["ID"];?></center></td>
                <td><?php echo $row_objRsCliente["FANTASIA"]; ?></td>
<!-- 	                <td><?php echo $cliente_contato;?></td> -->
                <td><a href="http://www.pulsarimagens.com.br/details.php?tombo=<?php echo $row_OBJCROMOS["CODIGO"];?>"><?php echo $row_OBJCROMOS["CODIGO"];?></a></td>
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
<?php if(!$print) { ?>			
				<td colspan="6"> Foram localizados (<b><?php echo $count_cromo;?></b>) cromos com esta consulta. <a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b></a> para realizar nova consulta.</td>
<?php } ?>
			</tr>
				
            </tbody>
        </table>
<?php if(!$print) { ?>
		<center>
	        <form name="form_imp" action="relatorio_comissoes.php" target="_blank" method="get">
			    <input type="hidden" name="de" value="<?php echo $de;?>"   />
			    <input type="hidden" name="ate" value="<?php echo $ate;?>" />
			    <input type="hidden" name="sigla_autor" value="<?php echo $sigla_autor;?>" />
				<input type="hidden" name="imprimir" value="sim" />
			    <input class="printBtn" value="Imprimir" style="border:1px solid #333;background-color:#FFF;color:#333;font-weight:bold;background-image:url(images/print.png);background-repeat:no-repeat;padding:2px 2px 2px 10px;background-position:left center;" type="button" />
	        </form>
	    </center>
<?php }?>
<?php
		}
	}
}
?>
	</div>
<?php if(!$print) { ?>
    <div class="colB">
<?php include("part_sidemenu.php");?>
    </div>
<?php } ?>
    <div class="clear"></div>
</div>
</body>
</html>

<?php 
//fechar e eliminar todos os objetos recordset e de conexão
if($siteDebug) {
	$timeEnd = microtime(true);
	$diff = $timeEnd - $timeStart;
	echo "<strong>Page LOAD: </strong>".$diff."</strong><br>";
}

?>