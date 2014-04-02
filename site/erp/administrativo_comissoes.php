<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_comissoes.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Relatórios</title>
    <meta charset="iso-8859-1" />
<?php if(!$print) { ?>
    <?php include('includes_header.php'); ?>
<?php } else { ?>    
<link href="css/sig.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    table { page-break-inside:auto; margin-top: 12px;  }
    tr    { page-break-inside:avoid; page-break-after:auto; border: 1px solid #F2F2F2; }
    td	  { border: 1px solid #F2F2F2;}
    th	  { border: 1px solid #F2F2F2; padding: 5px; font-weight:bold; } 
    thead { display:table-header-group; background: #F2F2F2; }
    tfoot { display:table-footer-group; }
</style>
<script>
	window.print();
</script>
<?php } ?>
  </head>
  <body>
<?php if(!$print) { ?>
    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Relatórios</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Administrativo</a>
        <a href="#" class="current">Relatórios</a>
      </div>
      <div class="container-fluid">

        <div class="row-fluid">
          <form class="form-inline">
      		  <div class="span2">
					<div class="input-append calendar">
				    	De <input data-format="dd/MM/yyyy" type="text" name="de" class="input-small" placeholder="Data Inicial" value="<?php echo $de?>" maxlength="10" onKeyPress="return txtBoxFormat(this, '99/99/9999', event);"/>
				    	<span class="add-on">
				      		<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      		</i>
				    	</span>
				  	</div>
	          </div>
	          <div class="span2">
					<div class="input-append calendar">
				    	Até <input data-format="dd/MM/yyyy" type="text" name="ate" class="input-small" placeholder="Data Final" value="<?php echo $ate?>" maxlength="10" onKeyPress="return txtBoxFormat(this, '99/99/9999', event);"/>
				    	<span class="add-on">
				      		<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      		</i>
				    	</span>
				  	</div>
	          </div>
            <div class="span3">
              <select name="sigla_autor" data-placeholder="autor">
	          	<option value="TODOS">-- Todos os Autores --</option>
<?php while ($row_sigla_autor = mysql_fetch_assoc($objAutor)) { ?>
				<option value="<?php echo $row_sigla_autor['SIGLA'];?>"><?php echo $row_sigla_autor['NOME']?></option>
<?php }?>
  			  </select>	
            </div>
            <div class="span5">
              Só Luis? <input name="soLuis" type="checkbox" value="true"/>
              Videos <input name="showVideos" type="checkbox" value="true" <?php if($showFotos&&$showVideos || $showVideos&&!$showFotos|| !$showFotos&&!$showVideos) echo "checked"?>/>
              Fotos <input name="showFotos" type="checkbox" value="true" <?php if($showFotos&&$showVideos || $showFotos&&!$showVideos || !$showFotos&&!$showVideos) echo "checked"?>/>
              <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
          </form>
        </div>
<?php } else { ?>
    <div id="content">
        <h1><center>Relatórios de <?php echo $de?> até <?php echo $ate?></center></h1>
      <div class="container-fluid">
<?php } ?>
        <br />
        <div class="row-fluid">
          <div class="span12">

<!--             <table class="table table-bordered table-striped with-check"> -->
<!-- 			<thead> -->
<!-- 			<tr> -->
<!-- 				<td colspan="4" align="center"><center>Relatório de Comissão de Autores</center></td> -->
<!-- 			</tr> -->
<!-- 			</thead> -->
<!-- 			<tbody> -->
<!-- 			<tr> -->
<!-- 				<td colspan="4"><center><b>Período Solicitado</b></center></td> -->
<!-- 			</tr> -->
<!-- 			<tr> -->
<!-- 				<td><p>De</td> -->
<!-- 				<td><b><?php echo $de;?></b></td> -->
<!-- 				<td><p>Até</td> -->
<!-- 				<td><b><?php echo $ate;?></b></td>		 -->
<!-- 			</tr> -->
<!-- 			</tbody> -->
<!-- 		</table> -->
<?php If($sigla_autor == "TODOS" && $totalRows_objRsContratos>0) { ?>			
        <table class="table table-bordered table-striped with-check">
            <thead>
            <tr>
                <th>CONTRATO</th>
                <th>CLIENTE</th>
                <th>V. BRUTO NF</th>
                <th>IMPOSTO</th>
                <th>COMPRADOR</th>
                <th>C.C.</th>
                <th>C.P.</th>
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
						$pulsar_comissao = ((($row_objRsContratos["VALOR_TOTAL"] - $impvalor) - $cliente_comissao) - $indio_comissao)*0.55;
						$total_indio = $total_indio + $indio_comissao;
					}
					else {
						$pulsar_comissao = ((($row_objRsContratos["VALOR_TOTAL"] - $impvalor) - $cliente_comissao))*0.55;
					}
			?>
			
					<tr>
						<td><center><a href="administrativo_licencas_nova.php?id_contrato=<?php echo $row_objRsContratos["ID"]?>"><?php If($indio) echo "*";?> <?php echo $row_objRsContratos["ID"];?></a></center></td>
						<td><?php echo $row_objRsCliente["FANTASIA"];?></td>
						<td>R$ <?php echo $row_objRsContratos["VALOR_TOTAL"];?></td>
						<td>R$ <?php If($impvalor >= 0) echo formatNumber($impvalor); Else echo "0,00";?></td>
						<td><?php echo $cliente_contato;?></td>
						<td>R$ <?php If($cliente_comissao >= 0) echo formatNumber($cliente_comissao); Else echo"0,00";?></td>
						<td>R$ <?php If($pulsar_comissao >= 0) echo formatNumber($pulsar_comissao); Else echo"0,00";?></td>
					</tr>
		
			<?php
					//soma dos totais de cada coluna
					$nf_tot += $row_objRsContratos["VALOR_TOTAL"];
					$imp_tot += $impvalor;
					If($cliente_comissao >= 0) {
					    $com_comp_tot += $cliente_comissao;
					}
					If($pulsar_comissao >= 0) {
					    $com_aut_tot += $pulsar_comissao;
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
		</div>
		<div class="span6">
        <table class="table table-bordered table-striped with-check">
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

					$strSQL = "
					SELECT * FROM CONTRATOS 
					RIGHT JOIN CROMOS ON CROMOS.ID_CONTRATO = CONTRATOS.ID
					WHERE CAST(CONCAT(SUBSTR(CONTRATOS.DATA_PAGTO,7,4),'-',SUBSTR(CONTRATOS.DATA_PAGTO,4,2),'-',SUBSTR(CONTRATOS.DATA_PAGTO,1,2)) as DATE) BETWEEN '".$de_mysql."' AND '".$ate_mysql."' 
					AND CONTRATOS.BAIXADO = 'S' AND CROMOS.AUTOR = '".$row_OBJAUTORES["SIGLA"]."'
					";
					if($luis)
						$strSQL .= " and CONTRATOS.ID_CONTATO in (select ID from CONTATOS where CONTATO like 'lu%vila%')";
					if(!$showFotos)
						$strSQL .= "AND ID_CONTRATO_DESC IN (SELECT Id FROM CONTRATOS_DESC WHERE tipo LIKE 'V')";
					if(!$showVideos)
						$strSQL .= "AND ID_CONTRATO_DESC IN (SELECT Id FROM CONTRATOS_DESC WHERE tipo LIKE 'F')";
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
			<td colspan="2">Total</td>
			<td id="border">R$ <?php If($TOTAL >= 0) echo FORMATNUMBER($TOTAL); Else echo "0,00";?></td>
		</tr>		
		</tbody>
	</table>
	</div>
	<div class="span3">
        <table class="table table-bordered table-striped with-check">
            <thead>
        	    <tr>
            	    <th>TRIBO</th>
                	<th>COMISSÃO</th>
            	</tr>
            </thead>
            <tbody>		

<?php
	$tmp_total = 0;
	mergeTribos($comissoes_indios, $sig);
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
				<td id="border">Total</td>
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
		<br/>
<?php } ?>		
<?php if(!$print) { ?>
<!-- 	    <center> -->
		    <form name="form_imp" action="relatorio_comissoes.php" target="_blank" method="get">
				<input type="hidden" name="de" value="<?php echo $de;?>"   />
				<input type="hidden" name="ate" value="<?php echo $ate;?>" />
				<input type="hidden" name="sigla_autor" value="<?php echo $sigla_autor;?>" />
				<input type="hidden" name="print" value="true" />
				<input class="btn btn-primary printBtn" value="Imprimir"  type="button" />
		    </form>
<!-- 		</center> -->
<?php } ?>
<?php } else if($totalRows_objRsContratos>0) { 


	//consultando cromos vendidos do autor selecionado nos contratos baixados no período solicitado
	$strSQL = "SELECT * FROM CONTRATOS A, CROMOS B WHERE CAST(CONCAT(SUBSTR(A.DATA_PAGTO,7,4),'-',SUBSTR(A.DATA_PAGTO,4,2),'-',SUBSTR(A.DATA_PAGTO,1,2)) as DATE) BETWEEN '".$de_mysql."' AND '".$ate_mysql."' AND A.BAIXADO = 'S' AND A.ID = B.ID_CONTRATO AND B.AUTOR = '".$sigla_autor."'";
	mysql_select_db($database_sig, $sig);
	$objRsCromo = mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRsCromo = mysql_fetch_assoc($objRsCromo);
	$totalRows_objRsCromo = mysql_num_rows($objRsCromo);
//	echo $strSQL;
	?> 	
					<?php
				$strSQL="SELECT nome FROM AUTORES_OFC WHERE sigla='".$sigla_autor."' ORDER BY NOME ";
				mysql_select_db($database_sig, $sig);
				$objRsAutor = mysql_query($strSQL, $sig) or die(mysql_error());
				$row_objRsAutor = mysql_fetch_assoc($objRsAutor);
				$totalRows_objRsAutor = mysql_num_rows($objRsAutor);
				?>
					
        <table class="table table-bordered table-striped with-check">
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
                <td><a href="http://www.pulsarimagens.com.br/br/details.php?tombo=<?php echo $row_OBJCROMOS["CODIGO"];?>" target="_BLANK"><?php echo $row_OBJCROMOS["CODIGO"];?></a></td>
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
				<td colspan="6"> Foram localizados (<b><?php echo $count_cromo;?></b>) cromos com esta consulta.</td>
<?php } ?>
			</tr>
				
            </tbody>
        </table>
<?php if(!$print) { ?>
	        <form name="form_imp" action="relatorio_comissoes.php" target="_blank" method="get">
			    <input type="hidden" name="de" value="<?php echo $de;?>"   />
			    <input type="hidden" name="ate" value="<?php echo $ate;?>" />
			    <input type="hidden" name="sigla_autor" value="<?php echo $sigla_autor;?>" />
				<input type="hidden" name="imprimir" value="sim" />
			    <input class="printBtn" value="Imprimir" style="border:1px solid #333;background-color:#FFF;color:#333;font-weight:bold;background-image:url(images/print.png);background-repeat:no-repeat;padding:2px 2px 2px 10px;background-position:left center;" type="button" />
	        </form>
<?php }?>




<?php } ?>



<!--             
              <thead>
                <tr>
                  <th><input type="checkbox" /></th>
                  <th>Pesquisas</th>
                  <th>Ocorrências</th>
                  <th>PC/PA</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php for ($i = 0; $i < 20; $i++): ?>
                  <tr>
                    <td><input type="checkbox" /></td>
                    <td>zoca</td>
                    <td>Zoca LTDA</td>
                    <td></td>
                  </tr>
                <?php endfor; ?>
              </tbody>
            </table>

            <div class="pagination pagination-right">
              <ul>
                <li class="disabled"><a href="#">«</a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">»</a></li>
              </ul>
            </div>

          </div>
        </div>

 -->
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
