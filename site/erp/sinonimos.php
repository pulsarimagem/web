<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_sinonimos.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pulsar Admin - Sinônimos</title>
<meta charset="iso-8859-1" />
<?php include('includes_header.php'); ?>
</head>
<body>

	<?php include('page_top.php'); ?>

	<?php include('sidebar.php'); ?>

	<div id="content">
		<div id="content-header">
			<h1>Sinônimos</h1>
		</div>
		<div id="breadcrumb">
			<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a> 
			<a href="#" class="current">Sinônimos</a>
		</div>
		<div class="container-fluid">

			<div class="row-fluid">
				<div class="span8">
					<form method="get">
						Palavras: <input class="input-xxlarge" type="text" name="palavras-chave" placeholder="Busca Palavras Separadas por ';'" />
					</form>
				</div>
			</div>
<?php if(isset($_GET['palavras-chave'])) { ?>			
			<div class="row-fluid">
				<div class="span12">
					<table class="table table-bordered table-striped with-check">
						<thead>
							<tr>
								<th style="width: 20%">Código</th>
								<th>Palavras-Chave Existentes</th>
								<th>Palavras-Chave Faltando</th>
<?php if($siteDebug) { ?>
								<th>palavrasArr</th>
								<th>palavras</th>
								<th>arrDiff</th>
<?php } ?>								
							</tr>
						</thead>
						<tbody>
<?php 
$todasCnt = 0;
foreach($CodigoPalavrasArr as $codigo => $palavras) { 
	$arrDiff = array_diff($palavrasArr,$palavras);	
	if(count($arrDiff) > 0) {
?>							
							<tr>
								<td><a href="http://www.pulsarimagens.com.br/br/details.php?tombo=<?php echo $codigo?>" target="_blank"><?php echo $codigo?></a></td>
								<td><?php echo implode(";", $palavras)?></td>
								<td><?php echo implode(";", $arrDiff)?></td>
<?php if($siteDebug) { ?>
								<td><?php print_r($palavrasArr)?></td>
								<td><?php print_r($palavras)?></td>
								<td><?php print_r($arrDiff)?></td>
<?php } ?>								
							</tr>
<?php 
	}
	else {
		$todasCnt++;
	}
} 
?>
						</tbody>
					</table>
				</div>
				<div class="span5">
					<table class="table table-bordered table-striped with-check">
						<thead>
							<tr>
								<th style="width: 80%">Palavras-Chave</th>
								<th style="width: 20%">Total</th>
							</tr>
						</thead>
						<tbody>
<?php 
foreach($totaisArr as $palavra => $total) { 
?>							
							<tr>
								<td><?php echo $palavra?></td>
								<td><?php echo $total?></td>
							</tr>
<?php 
} 
?>
							<tr>
								<td>Códigos com Todas</td>
								<td><?php echo $todasCnt?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
<?php }?>

			<?php include('page_bottom.php'); ?>
		</div>
	</div>
	<!-- END #content -->

	<?php include('includes_footer.php'); ?>

</body>
</html>
