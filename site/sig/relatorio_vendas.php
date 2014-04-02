<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php 

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
 

//consultando contratos baixados no período solicitado 
if($sigla_autor != "TODOS") {
	$filter_autor = " AND CROMOS.AUTOR = '$sigla_autor'";
}
$strSQL = "select CODIGO,ASSUNTO,count(codigo) as cnt, sum(valor) as total from (select CROMOS.CODIGO,CROMOS.ASSUNTO,CROMOS.AUTOR,CROMOS.VALOR,CONTRATOS.DATA from CROMOS inner join CONTRATOS on CROMOS.ID_CONTRATO = CONTRATOS.ID WHERE CONTRATOS.DATA BETWEEN '".$de_mysql."' AND '".$ate_mysql."' $filter_autor) as fotos group by CODIGO order by cnt desc limit 50";
$objRsFotos = mysql_query($strSQL, $sig) or die(mysql_error());
$totalRows_objRsFotos = mysql_num_rows($objRsFotos);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens - Relatório de Vendas</title>
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
<?php include("part_header.php");?> 
    <div class="colA">
		<h2>Relatório de Vendas</h2>
<?php
//todos os autores
If($sigla_autor == "TODOS") {
	If($totalRows_objRsFotos == 0) {
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
                <th>CODIGO</th>
                <th>ASSUNTO</th>
                <th>VENDAS</th>
                <th>VALOR TOTAL</th>
            </tr>
            </thead>
            <tbody>
<?php while ($row_objRsFotos = mysql_fetch_assoc($objRsFotos)) { ?>            		
					<tr>
						<td id="border"><center><?php echo $row_objRsFotos["CODIGO"];?></center></td>
						<td id="border"><?php echo $row_objRsFotos["ASSUNTO"];?></td>
						<td id="border"><?php echo $row_objRsFotos["cnt"];?></td>
						<td id="border">R$ <?php echo $row_objRsFotos["total"];?></td>
					</tr>
<?php } ?>					
			</tbody>		
		</table>		
<?php if(!$print) { ?>
	    <center>
		    <form name="form_imp" action="relatorio_vendas.php" target="_blank" method="get">
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
	If($totalRows_objRsFotos == 0) {
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
	    	        			
		if($totalRows_objRsFotos == 0) {
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
                <th>CODIGO</th>
                <th>ASSUNTO</th>
                <th>VENDAS</th>
                <th>VALOR TOTAL</th>
            </tr>
            </thead>
            <tbody>
<?php while ($row_objRsFotos = mysql_fetch_assoc($objRsFotos)) { ?>            		
					<tr>
						<td id="border"><center><?php echo $row_objRsFotos["CODIGO"];?></center></td>
						<td id="border"><?php echo $row_objRsFotos["ASSUNTO"];?></td>
						<td id="border"><?php echo $row_objRsFotos["cnt"];?></td>
						<td id="border">R$ <?php echo $row_objRsFotos["total"];?></td>
					</tr>
<?php } ?>					
			</tbody>		
        </table>
<?php if(!$print) { ?>
		<center>
	        <form name="form_imp" action="relatorio_vendas.php" target="_blank" method="get">
			    <input type="hidden" name="de" value="<?php echo $de;?>"   />
			    <input type="hidden" name="ate" value="<?php echo $ate;?>" />
			    <input type="hidden" name="sigla_autor" value="<?php echo $sigla_autor;?>" />
				<input type="hidden" name="print" value="true" />
			    <input value="Imprimir" style="border:1px solid #333;background-color:#FFF;color:#333;font-weight:bold;background-image:url(images/print.png);background-repeat:no-repeat;padding:2px 2px 2px 10px;background-position:left center;" type="submit" />
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

<?php //fechar e eliminar todos os objetos recordset e de conexão?>