<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MOVIMENTO/CONTRATO/CONSULTA .::SIG - SISTEMA DE INFORMA��ES
	GERENCIAIS PULSAR IMAGENS::.</title>
<script language="javascript">
	function valida(){
		if (form.baixa.value=='' && form.nf.value=='')
		{alert('Nenhum dado fornecido...');form.baixa.focus();return false;}
		form.action="baixaContrato4.asp";
		form.ENCTYPE = "";
		form.method="get";
		form.submit(); 
	}
	
	function SomenteNumero(e){
    	var tecla=(window.event)?event.keyCode:e.which;
    
		if((tecla > 47 && tecla < 58)) return true;
    	else{
    		if (tecla != 8) return false;
    	else return true;
    		}
	}
	
	function txtBoxFormat(objeto, sMask, evtKeyPress) {
			var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;
	
			if(document.all) { // Internet Explorer
			nTecla = evtKeyPress.keyCode;
			} else if(document.layers) { // Nestcape
			nTecla = evtKeyPress.which;
			} else {
			nTecla = evtKeyPress.which;
			if (nTecla == 8) {
			return true;
			}
		}
		sValue = objeto.value;
		// Limpa todos os caracteres de formata��o que
		// j� estiverem no campo.
		sValue = sValue.toString().replace( "-", "" );
		sValue = sValue.toString().replace( "-", "" );
		sValue = sValue.toString().replace( ".", "" );
		sValue = sValue.toString().replace( ".", "" );
		sValue = sValue.toString().replace( "/", "" );
		sValue = sValue.toString().replace( "/", "" );
		sValue = sValue.toString().replace( ":", "" );
		sValue = sValue.toString().replace( ":", "" );
		sValue = sValue.toString().replace( "(", "" );
		sValue = sValue.toString().replace( "(", "" );
		sValue = sValue.toString().replace( ")", "" );
		sValue = sValue.toString().replace( ")", "" );
		sValue = sValue.toString().replace( " ", "" );
		sValue = sValue.toString().replace( " ", "" );
		fldLen = sValue.length;
		mskLen = sMask.length;
	
		i = 0;
		nCount = 0;
		sCod = "";
		mskLen = fldLen;
	
		while (i <= mskLen) {
		  bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/") || (sMask.charAt(i) == ":"))
		  bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))
		  if (bolMask) {
			sCod += sMask.charAt(i);
			mskLen++; }
		  else {
			sCod += sValue.charAt(nCount);
			nCount++;
		  }
		  i++;
		}
		objeto.value = sCod;
		if (nTecla != 8) { // backspace
		  if (sMask.charAt(i-1) == "9") { // apenas n�meros...
			return ((nTecla > 47) && (nTecla < 58)); } 
		  else { // qualquer caracter...
			return true;
		  } 
		}
		else {
		  return true;
		}
	  }
</script>
<link href="atributos/global.css" type="text/css" rel="stylesheet"
	media="screen" />
<link href="atributos/tablecloth.css" type="text/css" rel="stylesheet"
	media="screen" />
<LINK href="css/style.css" type=text/css rel=STYLESHEET />
<style>
#border {
	border-style: solid;
	border-width: thin;
	border-color: #999999;
	padding: 5px 5px 5px 5px;
	font-family: Georgia, Times New Roman, Times, serif
}
</style>
<?php include("scripts.php")?>
<?php include("part_top.php")?>
</head>

<body>
	<form action="consulta_contrato_baixa.php" method="get">
		<?php
		//resgatando par�metros enviados pelo form via m�todo get
		$id_contrato = isset($_GET['id_contrato'])?$_GET['id_contrato']:"";
		$fantasia 	= isset($_GET['fantasia'])?$_GET['fantasia']:"";
		$de			= isset($_GET['de'])?$_GET['de']:"";
		$ate		= isset($_GET['ate'])?$_GET['ate']:"";
		$id_cliente	= isset($_GET['id_cliente'])?$_GET['id_cliente']:"";
		$baixa	= isset($_GET['baixa'])?true:false;
		$lote	= isset($_GET['lote'])?true:false;
		$action = isset($_GET['action'])?$_GET['action']:false;

		if($de != "") {
			$data_de = explode("/", $de);
			$de_ano	  = $data_de[2];
			$de_mes	  = $data_de[1];
			$de_dia	  = $data_de[0];
			$de_mysql = $de_ano."/".$de_mes."/".$de_dia;
		}
		if($ate != "") {
			$data_ate = explode("/", $ate);
			$ate_ano  = $data_ate[2];
			$ate_mes  = $data_ate[1];
			$ate_dia  = $data_ate[0];
			$ate_mysql= $ate_ano."/".$ate_mes."/".$ate_dia;
		}

		$x = 0;

		if ($action == "Concluir") {
			//requisitando par�metros
			$id_contratos		= $_GET['id_contrato'];
			//	id_contrato_S 	= Split(id_contrato,",")
			//	id_contrato_U 	= UBound(id_contrato_S)
			$mens		 	= "";
			if($lote) {
				$baixa_lote	= $_GET['baixa_lote'];
				$nf_lote	= $_GET['nf_lote'];
			}

			foreach ($id_contratos as $id_contrato) {
				if($lote) {
					$baixa	= isset($_GET['baixa'.Trim($id_contrato)])?"true":"";
					If ($baixa != "") {
						$nf = $nf_lote;
						$baixa = $baixa_lote;
					}
				} else {
					$baixa	= $_GET['baixa'.Trim($id_contrato)];
					$nf		= $_GET['nf'.Trim($id_contrato)];
				}
				$strSQL	= "UPDATE CONTRATOS SET baixado='S' ";
				$strSQL	.= ",data_pagto='" . $baixa . "' ";
				$strSQL	.= ",nota_fiscal='" . $nf . "' ";
				$strSQL	.= " WHERE id= " . $id_contrato;

				If ($baixa != "") {
					$mens .= $id_contrato;
					$strSQL = str_replace("''", "null", $strSQL);
					$objRS	= mysql_query($strSQL, $sig) or die(mysql_error());
					fixContrato($id_contrato, $sig);
					//echo $strSQL;
				}
			}
			if($mens == "") {
				echo "Campos vazios. Nenhuma baixa efetuada.<br /><a href=\"javascript:history.back();\"><b>Voltar para a p�gina anterior</b></a>";
			} else {
				?>
		Baixa(s) efetuada(s) com sucesso.<br /> <br /> Rela��o de contratos
		baixados para simples confer�ncia:<br />
		<table>
			<tr>
				<td id="border"><center>
						<font face="Times New Roman" color="#000000"><b>CONTRATO</b> </font>
					</center></td>
				<td id="border"><center>
						<font face="Times New Roman" color="#000000"><b>PAGTO.</b> </font>
					</center></td>
				<td id="border"><center>
						<font face="Times New Roman" color="#000000"><b>NF</b> </font>
					</center></td>
			</tr>

			<?php 
			foreach ($id_contratos as $id_contrato) {
				if($lote) {
					$baixa	= isset($_GET['baixa'.Trim($id_contrato)])?"true":"";
					If ($baixa != "") {
						$nf = $nf_lote;
						$baixa = $baixa_lote;
					}
				} else {
					$baixa	= $_GET['baixa'.Trim($id_contrato)];
					$nf		= $_GET['nf'.Trim($id_contrato)];
				}
				If ($baixa != "") {
					?>

			<tr>
				<td id="border"><?php echo $id_contrato?></td>
				<td id="border"><?php echo $baixa?></td>
				<td id="border"><?php echo $nf?></td>
			</tr>

			<?php 
				}
			}
			?>
			<tr>
				<td colspan="6"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique
							aqui</b> </a> para nova baixa.</td>
			</tr>
		</table>
		<?php 		
			}
		}
		//realizando a consulta por id do contrato
		else if ( $id_contrato != "" ) {
			$strSQL    = "SELECT CONTRATOS.ID, CONTRATOS.ID_CLIENTE, CONTRATOS.DATA, CONTRATOS.DESCRICAO, CONTRATOS.DATA_PAGTO, CONTRATOS.NOTA_FISCAL, sum(cast(replace(VALOR,',','.') as decimal(10,2))-cast(replace(DESCONTO,',','.') as decimal(10,2))) AS VALOR_TOTAL FROM CROMOS LEFT JOIN CONTRATOS ON CONTRATOS.ID = CROMOS.ID_CONTRATO WHERE CONTRATOS.ID='".$id_contrato."' AND CONTRATOS.FINALIZADO = 'S' AND BAIXADO='N' GROUP BY CONTRATOS.ID ";
			$objRS = mysql_query($strSQL, $sig) or die(mysql_error());

			if (!$row_objRS = mysql_fetch_assoc($objRS)) {
				?>
		<table>
			<tr>
				<th colspan="2"><center>
						<font face="Times New Roman">Consulta de Contratos</font>
					</center></th>
			</tr>

			<tr></tr>

			<tr>
				<td id="border" colspan="2">Nenhum registro encontrado com as
					informa��es digitadas.</td>
			</tr>

			<tr>
				<td id="border" width="25%">N� do contrato:</td>
				<td id="border"><b><?php echo  $id_contrato ?>&nbsp;</b></td>
			</tr>

			<tr>
				<td colspan="2"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique
							aqui</b> </a> para realizar nova consulta.</td>
			</tr>
		</table>
		<?php
			} Else {
				?>

		<table width="95%">
			<tr>
				<td id="border"><center>
						<font face="Times New Roman" color="#000000"><b>CONTRATO</b> </font>
					</center></td>
				<td id="border" width="10%"><center>
						<font face="Times New Roman" color="#000000"><b>EMISS�O</b> </font>
					</center></td>
				<td id="border" width="10%"><center>
						<font face="Times New Roman" color="#000000"><b>CLIENTE</b> </font>
					</center></td>
				<td id="border" width="%"><center>
						<font face="Times New Roman" color="#000000"><b>DESCRI��O</b> </font>
					</center></td>
				<td id="border" width="10%"><center>
						<font face="Times New Roman" color="#000000"><b>TOTAL</b> </font>
					</center></td>
				<td id="border" width="10%"><center>
						<font face="Times New Roman" color="#000000"><b>PAGTO.</b> </font>
					</center></td>
				<td id="border" width="10%"><center>
						<font face="Times New Roman" color="#000000"><b>NF</b> </font>
					</center></td>
			</tr>

			<?php
			do {
				$x += 1;
				$strSQL 		= "SELECT * FROM CLIENTES WHERE ID = '" . $row_objRS['ID_CLIENTE'] . "'";
				$objRS3 = mysql_query($strSQL, $sig) or die(mysql_error());
				$row_objRS3 = mysql_fetch_assoc($objRS3);
					
				?>

			<tr>
				<input type="hidden" name="id_contrato[]"
					value="<?php echo $row_objRS['ID']?>" />
				<td id="border"><center>
						<a
							href="consulta_contrato_visualiza.php?id_contrato=<?php echo $row_objRS['ID']?>"
							title="Visualizar dados do contrato"><b><?php echo $row_objRS['ID']?>
						</b> </a>
					</center></td>
				<td id="border"><?php echo formatdate($row_objRS['DATA']) ?></td>
				<td id="border"><?php echo $row_objRS3['FANTASIA']?></td>
				<td id="border"><textarea cols="70" rows="2" readonly="readonly">
						<?php echo $row_objRS['DESCRICAO']?>
					</textarea></td>
				<td id="border">R$ <?php echo formatnumber($row_objRS['VALOR_TOTAL'])?>&nbsp;
				</td>
				<?php if(!$lote) { ?>
				<td id="border"><input type="text"
					name="baixa<?php echo $row_objRS['ID']?>" maxlength="10" size="10"
					onkeypress="return txtBoxFormat(this, '99/99/9999',event);" /></td>
				<td id="border"><input type="text"
					name="nf<?php echo $row_objRS['ID']?>" maxlength="10" size="10" />
				</td>
				<?php } else { ?>
				<td colspan="2" id="border"><input type="checkbox"
					name="baixa<?php echo $row_objRS['ID']?>" /></td>
				<?php } ?>
			</tr>

			<?php
			} while($row_objRS = mysql_fetch_assoc($objRS));
			?>
			<?php if($lote) { ?>
			<tr>
				<td colspan="5" id="border"><input type="hidden" name="lote"
					value="true"></input></td>
				<td id="border"><input type="text" name="baixa_lote" maxlength="10"
					size="10"
					onkeypress="return txtBoxFormat(this, '99/99/9999',event);" /></td>
				<td id="border"><input type="text" name="nf_lote" maxlength="10"
					size="10" /></td>
			</tr>
			<?php }?>

			</tr>
			<tr>
				<td><input type="submit" name="action" value="Concluir">
				
				</td>
			</tr>


			<tr>
				<td colspan="6"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique
							aqui</b> </a> para nova consulta.</td>
			</tr>
		</table>
		<?php
			}

			//realizando a consulta por nome fantasia e/ou per�odo
		} Else if ( $id_cliente == ""  && $fantasia != "") {
			$strSQL2		= "SELECT * FROM CLIENTES WHERE FANTASIA LIKE('%".$fantasia."%') ORDER BY FANTASIA";
			$objRS2 = mysql_query($strSQL2, $sig) or die(mysql_error());
			if (!$row_objRS2 = mysql_fetch_assoc($objRS2)) {
				?>
		<table>
			<tr>
				<th colspan="2"><center>
						<font face="Times New Roman">Consulta de Contratos</font>
					</center></th>
			</tr>

			<tr></tr>

			<tr>
				<td id="border" colspan="2">Nenhum registro encontrado com as
					informa��es digitadas.</td>
			</tr>

			<tr>
				<td id="border" width="25%">Nome Fantasia:</td>
				<td id="border"><b><?php echo  $fantasia ?>&nbsp;</b></td>
			</tr>

			<tr>
				<td colspan="2"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique
							aqui</b> </a> para realizar nova consulta.</td>
			</tr>
		</table>
		<?php
			} ELSE {
				?>
		<table width="95%">
			<tr>
				<th colspan="3"><center>
						<font face="Times New Roman">Consulta de Contratos</font>
					</center></th>
			</tr>

			<tr></tr>

			<tr>
				<td id="border"><center>
						<font face="Times New Roman" color="#000000"><b>NOME FANTASIA</b>
						</font>
					</center></td>
				<td id="border" width="50%"><center>
						<font face="Times New Roman" color="#000000"><b>RAZ�O SOCIAL</b> </font>
					</center></td>
				<td id="border" width="20%"><center>
						<font face="Times New Roman" color="#000000"><b>CNPJ</b> </font>
					</center></td>
			</tr>

			<?php
			do {
				$x += 1;
				?>

			<tr>
				<td id="border"><a
					href="consulta_contrato_baixa.php?id_cliente=<?php echo $row_objRS2['ID']?>&amp;de=<?php echo  $de ?>&amp;ate=<?php echo  $ate ?><?php echo ($lote?"&lote=true":"")?>"
					title="Selecionar Cliente"><b><?php echo  $row_objRS2['FANTASIA']?>
					</b> </a></td>
				<td id="border"><?php echo $row_objRS2['RAZAO']?></td>
				<td id="border"><b><?php echo $row_objRS2['CNPJ']?> </b></td>
			</tr>

			<?php
			} while ($row_objRS2 = mysql_fetch_assoc($objRS2));
			?>
			<tr>
				<td colspan="23">Foram localizados (<b><?php echo $x?> </b>)
					registros com esta consulta. <a
					href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b> </a>
					para nova consulta.
				</td>
			</tr>
		</table>
		<?php
			}
		} else {

			//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
			//'''''''VISUALIZANDO CONTRATOS DO CLIENTE SELECIONADO'''''''''''''''''''''''
			//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
			$strSQL_data = "";
			if ( $de != "" && $ate != "" ) {
				$strSQL_data  = "AND DATA BETWEEN' ".$de_mysql." 'AND' ".$ate_mysql." '";
			}
			$strSQL_cliente = "";
			if($id_cliente != "") {
				$strSQL_cliente = "AND ID_CLIENTE='".$id_cliente."'";
			}
			$strSQL	= "SELECT CONTRATOS.ID, CONTRATOS.DATA, CONTRATOS.DESCRICAO, CONTRATOS.DATA_PAGTO, CONTRATOS.NOTA_FISCAL, SUM(cast(replace(CROMOS.VALOR,',','.') as decimal(10,2))-cast(replace(CROMOS.DESCONTO,',','.') as decimal(10,2))) AS VALOR_TOTAL
			FROM CROMOS
			LEFT JOIN CONTRATOS ON CONTRATOS.ID = CROMOS.ID_CONTRATO
			WHERE CONTRATOS.FINALIZADO='S' AND BAIXADO='N' $strSQL_data $strSQL_cliente
			GROUP BY CONTRATOS.ID ORDER BY ID DESC";

			$objRS = mysql_query($strSQL, $sig) or die(mysql_error());

			$strSQL2		= "";
			$strSQL2		.= "SELECT * FROM CLIENTES WHERE ID='".$id_cliente."'";
			$objRS2 = mysql_query($strSQL2, $sig) or die(mysql_error());
			$row_objRS2 = mysql_fetch_assoc($objRS2);

			if (!$row_objRS = mysql_fetch_assoc($objRS)) {
				?>
		<table>
			<tr>
				<th colspan="2"><center>
						<font face="Times New Roman">Consulta de Contratos</font>
					</center></th>
			</tr>

			<tr></tr>

			<tr>
				<td id="border" colspan="2">Nenhum registro encontrado com as
					informa��es digitadas.</td>
			</tr>

			<tr>
				<td id="border" width="25%">CLIENTE:</td>
				<td id="border"><b><?php echo  $row_objRS2['FANTASIA']?>&nbsp;</b></td>
			</tr>

			<tr>
				<td id="border" width="25%">PER�ODO:</td>
				<td id="border">de: <b><?php echo $de?> </b>&nbsp;&nbsp;&nbsp;at�: <b><?php echo $ate?>
				</b>
				</td>
			</tr>

			<tr>
				<td colspan="2"><a href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique
							aqui</b> </a> para realizar nova consulta.</td>
			</tr>
		</table>
		<?php } Else { ?>
		<table width="95%">
			<tr>
				<th colspan="4"><center>
						<font face="Times New Roman">Consulta de Contratos</font>
					</center></th>
			</tr>

			<tr></tr>

			<tr>
				<td id="border" width="10%"><p align="right">Cliente:
				
				</td>
				<td id="border"><b><?php echo $row_objRS2['FANTASIA']?> </b></td>
				<td id="border" width="10%"><p align="right">CNPJ:
				
				</td>
				<td id="border" width="20%"><b><?php echo $row_objRS2['CNPJ']?> </b>
				</td>
			</tr>

			<tr>
				<td id="border"><p align="right">Raz�o Social:
				
				</td>
				<td colspan="3" id="border"><b><?php echo $row_objRS2['RAZAO']?> </b>
				</td>
			</tr>
		</table>

		<table width="95%">
			<tr>
				<td id="border"><center>
						<font face="Times New Roman" color="#000000"><b>CONTRATO</b> </font>
					</center></td>
				<td id="border" width="10%"><center>
						<font face="Times New Roman" color="#000000"><b>EMISS�O</b> </font>
					</center></td>
				<!-- 				<td id="border" width="10%"><center><font face="Times New Roman" color="#000000"><b>CLIENTE</b></font></center></td> -->
				<td id="border" width="%"><center>
						<font face="Times New Roman" color="#000000"><b>DESCRI��O</b> </font>
					</center></td>
				<td id="border" width="10%"><center>
						<font face="Times New Roman" color="#000000"><b>TOTAL</b> </font>
					</center></td>
				<td id="border" width="10%"><center>
						<font face="Times New Roman" color="#000000"><b>PAGTO.</b> </font>
					</center></td>
				<td id="border" width="10%"><center>
						<font face="Times New Roman" color="#000000"><b>NF</b> </font>
					</center></td>
			</tr>

			<?php
			do {
				$x += 1;
				//				$strSQL 		= "SELECT * FROM CLIENTES WHERE ID = '" . $row_objRS['ID_CLIENTE'] . "'";
				//				$objRS3 = mysql_query($strSQL, $sig) or die(mysql_error());
				//				$row_objRS3 = mysql_fetch_assoc($objRS3);

				?>

			<tr>
				<input type="hidden" name="id_contrato[]"
					value="<?php echo $row_objRS['ID']?>" />
				<td id="border"><center>
						<a
							href="consulta_contrato_visualiza.php?id_contrato=<?php echo $row_objRS['ID']?>"
							title="Visualizar dados do contrato"><b><?php echo $row_objRS['ID']?>
						</b> </a>
					</center></td>
				<td id="border"><?php echo formatdate($row_objRS['DATA']) ?></td>
				<!-- 					<td id="border"><?php echo $row_objRS3['FANTASIA']?></td> -->
				<td id="border"><textarea cols="70" rows="2" readonly="readonly">
						<?php echo $row_objRS['DESCRICAO']?>
					</textarea></td>
				<td id="border">R$ <?php echo formatnumber($row_objRS['VALOR_TOTAL'])?>&nbsp;
				</td>
				<?php if(!$lote) { ?>
				<td id="border"><input type="text"
					name="baixa<?php echo $row_objRS['ID']?>" maxlength="10" size="10"
					onkeypress="return txtBoxFormat(this, '99/99/9999',event);" class="calendar"/></td>
				<td id="border"><input type="text"
					name="nf<?php echo $row_objRS['ID']?>" maxlength="10" size="10" />
				</td>
				<?php } else { ?>
				<td colspan="2" id="border"><input type="checkbox"
					name="baixa<?php echo $row_objRS['ID']?>"
					value="<?php echo formatnumber($row_objRS['VALOR_TOTAL'])?>" /></td>
				<?php }?>
			</tr>

			<?php
			} while($row_objRS = mysql_fetch_assoc($objRS));
			?>
			<?php if($lote) { ?>
			<tr>
				<td colspan="2" id="border"><input type="hidden" name="lote"
					value="true"></input></td>
				<td id="border" style="text-align: right">Total:</td>
				<td id="border" class="sum_total">0,00</td>
				<td id="border"><input type="text" name="baixa_lote" maxlength="10"
					size="10"
					onkeypress="return txtBoxFormat(this, '99/99/9999',event);" /></td>
				<td id="border"><input type="text" name="nf_lote" maxlength="10"
					size="10" /></td>
			</tr>
			<?php }?>

			<tr>
				<td><input type="submit" name="action" value="Concluir">
				
				</td>
			</tr>

			<tr>
				<td colspan="6">Foram localizados (<b><?php echo $x?> </b>)
					registros com esta consulta.<a
					href="<?php echo $_SESSION['menu_url'] ?>"><b>Clique aqui</b> </a>
					para nova consulta.
				</td>
			</tr>
		</table>
		<?php
}}
?>
	</form>
</body>
</html>

<?php //Fechar e eliminar os objetos recordset e de conexao ?>

