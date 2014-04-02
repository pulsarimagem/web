<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<style>
	body{
	font-size:8pt;
	text-align: justify;
	font-family:Verdana;
	margin-top:0px;	
	}
	   
	a{
	text-decoration:none;
	color:#000;
	}
	
	a:hover{
	text-decoration:none;
	color:#f60;
	}
	
	.quebra{ 
       	page-break-after: always;
	}
	
	#anexo{
	border-style:solid;
	border-width:thin;
	border-color:#999999;
	}
	
	#assunto{
	border-style:solid;
	border-width:thin;
	border-color:#999999;
	font-size:small;
	}	   
	
	table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
</style>

<?php

function unidades($num) {
	$vet_unidades = Array("um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove");
	$aux = Right($num,2);
	if ((int)$aux < 20 ) {
		if ((int)$aux > 0 ) {
			$str = $vet_unidades[(int)($aux-1)];
		} else {
			$str = "";
		}
	} else {
		$str = $vet_unidades[((int)(right($num,1)) - 1)];
	}
	$unidades = $str;
	return $unidades;
}

function dezenas($num) {
	$vet_dezenas = Array("", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
	$aux = Right($num,2);
	$aux = Left($aux,1);
	if (strlen($num) >= 2 ) {
		if ((int)$aux >= 2 ) {
			$str = $vet_dezenas[(int)($aux)-1];
			if (right($num,1) > 0 ) {
				$str = $str ." e ".unidades($num);
			}
		} else {
			$str = unidades($num);
		}
	} else {
		$str = unidades($num);
	}
	$dezenas = $str;
	return $dezenas;
}

function centenas($num, $numero) {
	$vet_centenas = Array("cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
	if ((int)$num > 99 ) {
		$aux = Right($num, 3);
		$aux = Left($aux, 1);
		if ((int)right($num,2) > 0 ) {
			$vet_centenas[0] = "cento";
		}
		$str = $vet_centenas[$aux-1];
		if ((int)right($num, 2) > 0 ) {
			$str = $str . " e ";
		}
	} else {
		$str = "";
	}
	$centenas = $str . dezenas($num);
	return $centenas;
}

function milhares($num, $numero) {
	$aux = right($numero,3);
	$aux = left($aux,1);
	if ((int)$aux > 0 ) {
		$auxstr = ", ";
	} else {
		$auxstr = " e ";
	}
	if ((int)$num != 0 ) {
		$str = centenas($num, $numero)." mil".$auxstr;
	} else {
		$str = "";
	}
	$milhares = $str;
	return $milhares;
}

function milhoes($num, $numero) {
	$aux = (int)$num;
	if ($aux > 0 ) {
		if ($aux == 1 ) {
			$strmilhao = "milhão,";
		} else {
			$strmilhao = "milhões,";
		}
		$str = centenas($num, $numero)." ".strmilhao." ";
	} else {
		$str = "";
	}
	$milhoes = $str;
	return $milhoes;
}

function bilhoes($num, $numero) {
	$aux = (int)$num;
	if ($aux > 0 ) {
		if ($aux == 1 ) {
			$strbilhao = "bilhão,";
		} else {
			$strbilhao = "bilhões,";
		}
		$str = centenas($num, $numero)." ".$strbilhao." ";
	} else {
		$str = "";
	}
	$bilhoes = $str;
	return $bilhoes;
}

function centavos($num) {
	$num = "0".$num;
	if ((int)$num > 0 ) {
		if ((int)$num == 1 ) {
			$strcent = " centavo";
		} else {
			$strcent = " centavos";
		}
		$str = centenas($num, $num).$strcent;
	} else {
		$str = "";
	}
	$centavos = $str;
	return $centavos;
}

function extenso($num) {
	$num = str_replace(".", "", $num);
	$aux_array = explode(",", $num);
	if ($num == "" ) {
		$extenso = "";
		break;
	}
	if (count($aux_array) > 0 ) {
		$inteiro = $aux_array[0];
		$cents = left($aux_array[1],2);
	} else {
		$inteiro = $aux_array[0];
		$cents = "00";
	}
	if (strpos($inteiro, "-") > 0 ) {
		$inteiro = right($inteiro, len($inteiro) - 1);
		$strsinal = "menos ";
	} else {
		$strsinal = "";
	}
	$sizenum = strlen($inteiro);
	$aux = str_repeat("0", 13 - $sizenum);
	$inteiro = $aux . $inteiro;
	$bilhar = substr($inteiro, 1, 3);
	$milhao = substr($inteiro, 4, 3);
	$milhar = substr($inteiro, 7, 3);
	$centena = substr($inteiro, 10, 3);
	
//	echo "$sizenum $aux $inteiro $bilhar $milhao $milhar $centena<br>";
	
	
	if ((int)$inteiro == 1 ) {
		$strreal = " real ";
	} else {
		if ((int)$inteiro == 0 ) {
			$strreal = "";
		} else {
			$strreal = " reais ";
		}
	}
	if ((int)$cents > 0 && (int)$inteiro > 0 ) {
		$strvirgula = "e ";
	} else {
		$strvirgula = "";
	}
	$strextenso = bilhoes($bilhar, $inteiro);
	$strextenso = $strextenso . milhoes($milhao, $inteiro);
	$strextenso = $strextenso . milhares($milhar, $inteiro);
	$strextenso = $strextenso . centenas($centena, $inteiro);
	$strextenso = $strsinal . $strextenso . $strreal . $strvirgula . centavos($cents);
	$extenso = $strextenso;
	return $extenso;
}

?>

<?php
//resgatando parâmetros enviados pela url
$id_contrato = $_GET["id_contrato"];

//consultando informações do cliente
$strSQL 		= "SELECT * FROM CONTRATOS WHERE ID=".$id_contrato;
$objRS	= mysql_query($strSQL);
$row_objRS	= mysql_fetch_assoc($objRS);
$id_cliente	= $row_objRS["ID_CLIENTE"];
$id_contato	= $row_objRS["ID_CONTATO"];
$descricao	= $row_objRS["DESCRICAO"];
$contratoDesc = $row_objRS["ID_CONTRATO_DESC"];
$data		= $row_objRS["DATA"];
$obj_date = new DateTime($data);

if ($contratoDesc != 0 ) {
    $strSQLDESC = "SELECT b.Id, ID_CONTRATO_DESC, titulo, padrao, condicoes, assinatura  FROM CONTRATOS a, CONTRATOS_DESC b WHERE a.ID_CONTRATO_DESC = b.Id and a.Id = " .$id_contrato;
} else {
    $strSQLDESC = "SELECT Id, titulo, padrao, condicoes, assinatura  FROM CONTRATOS_DESC WHERE padrao = true";
}
$objContrDesc =  mysql_query($strSQLDESC);
$row_objContrDesc = mysql_fetch_assoc($objContrDesc);


$strSQL 		= "SELECT * FROM CLIENTES WHERE id='".$id_cliente."'"; 
$objRS1	= mysql_query($strSQL);
$row_objRS1 = mysql_fetch_assoc($objRS1);
$cliente		= $row_objRS1["FANTASIA"];
$razao_social= $row_objRS1["RAZAO"];
$endereco	= $row_objRS1["ENDERECO"];
$bairro		= $row_objRS1["BAIRRO"];
$cidade		= $row_objRS1["CIDADE"];
$estado		= $row_objRS1["ESTADO"];
$cep			= $row_objRS1["CEP"];
$end_completo= $endereco." - ".$cep." - ".$bairro." - ".$cidade." - ".$estado;
$telefone	= $row_objRS1["TELEFONE"];

if ($id_contato!="" ) {
	$strSQL 		= "SELECT * FROM CONTATOS WHERE id_cliente='".$id_cliente."' AND id='".$id_contato."'";
	$objRS4 	= mysql_query($strSQL);
	$row_objRS4 = mysql_fetch_assoc($objRS4);
	$contato		= $row_objRS4["CONTATO"];
}

//consultando informações do contrato
$strSQL = "SELECT ID,ID_CONTRATO,ID_USO,CODIGO,ASSUNTO,AUTOR,VALOR,DESCONTO,VALOR_FINAL FROM CROMOS WHERE ID_CONTRATO=".$id_contrato;
$objRS5 = mysql_query($strSQL);

$strSQL = "SELECT ID,ID_CONTRATO,ID_USO,CODIGO,ASSUNTO,AUTOR,VALOR,DESCONTO,VALOR_FINAL FROM CROMOS WHERE ID_CONTRATO=".$id_contrato;
$objRS6 = mysql_query($strSQL);

//somando valor total do contrato 
$total = 0;
While ($row_objRS6 = mysql_fetch_assoc($objRS6)) {
	$valor_final=fixnumber($row_objRS6["VALOR"])-fixnumber($row_objRS6["DESCONTO"]);
	$total = Round((float)$total,2) + Round((float)$valor_final,2);
}

$strSQL = "SELECT ID,ID_CONTRATO,ID_USO,CODIGO,ASSUNTO,AUTOR,VALOR,DESCONTO,VALOR_FINAL FROM CROMOS WHERE ID_CONTRATO=".$id_contrato;
$objRS7 = mysql_query($strSQL);
//verificando qtd de cromos constantes no contrato
$contador = 0;
While ($row_objRS5 = mysql_fetch_assoc($objRS5)) { 
	$contador = $contador + 1;	
}
?>
</head>

<body>
<table width="100%" style="margin-top:0px;">	
	<tr><td align="center"><img src="../images/pulsarimagens.png"></td></tr>
	<tr><td width="90%" align="center">
	        <b>LICENÇA DE REPRODUÇÃO - DIGITAL</b><br />
	        <a href="contrato-consulta-cliente.asp?mens=Contrato nº <?php echo $id_contrato ?> registrado com sucesso.">Contrato: <b><?php echo $id_contrato?></b></a>
	    </td>
	</tr>
</table>
<table width="100%" style="margin-top:0px;">
	<tr><td colspan="2"><b>A. PARTES:</b></td></tr>
	<tr><td width="12%"><B>Licenciante:</B></td><td><B>PULSAR IMAGENS LTDA.</B></td></tr>
	<tr><td width="10%">&nbsp;</td><td>Rua Apiacás, 934 - 05017-020 - Perdizes - São Paulo - SP - Fone/Fax: (11) 3875-0101</td></tr>
	<tr><td width="12%">&nbsp;</td><td>CNPJ 66.647.157/0001-11 - CCM 9.898.008-4</td></tr>
	<tr><td colspan="2" height="5px;"></td></tr>
	<tr><td width="12%"><B>Licenciada(o):</B></td><td><b><?php echo $razao_social ?></b></td></tr>
	<tr><td width="12%">&nbsp;</td><td><?php echo $end_completo?></td></tr>
	<tr><td colspan="2" height="5px;"></td></tr>
	<tr><td colspan="2"><b>B. OBRA(S) LICENCIADA(S) CONFORME ANEXO(S):&nbsp;&nbsp;&nbsp;<?php echo $contador ?></b></td></tr>
	<tr><td colspan="2" height="5px;"></td></tr>
	<tr><td colspan="2"><b>C. PREÇO TOTAL LÍQUIDO E CERTO DESTA LICENÇA:&nbsp;&nbsp;&nbsp;R$&nbsp;<?php echo FormatNumber($total,2)?></b></td></tr>
	<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<b>QUANTIA POR EXTENSO:&nbsp;&nbsp;&nbsp;<?php echo ucfirst(Extenso(FormatNumber($total,2))) ?></b></td></tr>
	<tr><td colspan="2" height="5px;"></td></tr>
	<tr><td colspan="2"><b>D. PUBLICAÇÃO EM QUE SERÁ USADO O MATERIAL:</b></td></tr>
	<tr><td colspan="2"><?php echo $descricao ?></td></tr>
	<tr><td colspan="2" align="left" height="5px;"></td></tr>
	<tr><td colspan="2" align="left">
	    <?php echo $row_objContrDesc["condicoes"] ?>
	</td></tr>
	<tr><td colspan="4" align="right">São Paulo, <?php echo $obj_date->format('d')." de ".getMonthName((int)$obj_date->format('m'))." de ".$obj_date->format('Y') ?>.</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
</table>
<table width="100%">
	<tr><td align="center">______________________________</td><td align="center">
	    <?php if (ord($row_objContrDesc['assinatura']) == 1 || ord($row_objContrDesc['assinatura']) == 49) { ?>
	        <img src="img/Assinatura.JPG" />
        <?php } else { ?>______________________________
        <?php } ?>
    </td></tr>
	<tr><td align="center"><b><?php echo $razao_social ?></b></td><td align="center"><b>Pulsar Imagens LTDA.</b></td></tr>
</table>
<div class="quebra"></div>
<table align="center" width="100%">
	<tr><td colspan="2"><center><img src="../images/pulsarimagens.png"/></center></td></tr>
	<tr><td align="center"><b>ANEXO: 1</b></td></tr>
	<tr><td colspan="2"></td></tr>
</table>
<table align="center" width="100%">
	<tr>
		<td align="center" width="10%"><b>Código</b></td>
		<td align="center" width="15%"><b>Autor</b></td>
		<td align="center" width="45%"><b>Assunto Principal</b></td>
		<td align="center" width="10%"><b>Valor</b></td>
		<td align="center" width="10%"><b>Desconto</b></td>
		<td align="center" width="10%"><b>Total</b></td>
	</tr>
	<tr><td colspan="6">&nbsp;</td></tr>
	<?php
	While ($row_objRS7 = mysql_fetch_assoc($objRS7)) {
		$id_uso=$row_objRS7["ID_USO"];
		//$strSQL      = "select tipo.tipo as TIPO, sub.subtipo as SUBTIPO, descr.descricao as DESCRICAO, uso.Id, tipo.Id as id_tipo, sub.Id as id_subtipo, descr.Id as id_desc,valor from USO as uso, USO_TIPO as tipo, USO_SUBTIPO as sub, USO_DESC as descr where uso.id_tipo = tipo.Id and uso.Id = " . $id_uso . " and uso.id_subtipo = sub.Id and uso.id_descricao = descr.Id order by tipo, subtipo,descricao,valor ";
		$strSQL      = "select tipo.tipo_br as TIPO, sub.subtipo_br as SUBTIPO, descr.descricao_br as DESCRICAO, uso.Id, tipo.Id as id_tipo, sub.Id as id_subtipo, descr.Id as id_desc,valor from USO as uso, USO_TIPO as tipo, USO_SUBTIPO as sub, USO_DESC as descr where uso.id_tipo = tipo.Id and uso.Id = " . $id_uso . " and uso.id_utilizacao = sub.Id and uso.id_tamanho = descr.Id order by tipo, subtipo,descricao,valor ";
		$objRS8 	= mysql_query($strSQL) or die(mysql_error());	
		$row_objRS8 = mysql_fetch_assoc($objRS8);
		$uso			= "(".strtolower($row_objRS8["TIPO"])." - ".strtolower($row_objRS8["SUBTIPO"])." - ".strtolower($row_objRS8["DESCRICAO"]).")"; 
		
		$strSQL = " SELECT NOME FROM AUTORES_OFC WHERE SIGLA = '" . $row_objRS7["AUTOR"] . "'";
		$objRS9 = mysql_query($strSQL);
		$row_objRS9 = mysql_fetch_assoc($objRS9);
	?>
		<tr id="anexo"><td align="center" id="anexo"><?php echo $row_objRS7["CODIGO"]?>&nbsp;</td><td align="center" id="anexo"><?php echo $row_objRS9["NOME"]?></td><td align="left" id="assunto"><?php echo $row_objRS7["ASSUNTO"]?></td><td align="center" id="anexo">R$ <?php echo FormatNumber((float)fixnumber($row_objRS7["VALOR"]),2)?></td><td align="center" id="anexo">R$ <?php echo FormatNumber((float)fixnumber($row_objRS7["DESCONTO"]),2)?></td>
		<?php $valor_final = fixnumber($row_objRS7["VALOR"]) - fixnumber($row_objRS7["DESCONTO"]) ?>
		<td align="center" id="anexo">R$ <?php echo FormatNumber($valor_final,2)?></td></tr>
		<?php
	}
		?>
		<tr><td colspan="6">&nbsp;</td></tr>
		<tr><td colspan="4">Total de cromos consignados:&nbsp;&nbsp;&nbsp;<b><?php echo $contador ?></b></td><td align="center" width="10%">Valor Total:</td><td align="center" width="10%"><b>R$&nbsp;<?php echo FormatNumber($total,2)?></b></td></tr>
</table>
<table width="100%">
	<tr><td align="center">______________________________</td><td align="center"><?php if (ord($row_objContrDesc['assinatura']) == 1 || ord($row_objContrDesc['assinatura']) == 49) { ?><img src="img/Assinatura.JPG" /><?php } else { ?>______________________________<?php } ?></td></tr>
	<tr><td align="center"><b><?php echo $razao_social ?></b></td><td align="center"><b>Pulsar Imagens LTDA.</b></td></tr>
</table>

<script type="text/javascript">
    window.print();
</script>

</BODY>
</HTML>
