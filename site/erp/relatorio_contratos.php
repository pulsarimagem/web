<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_relatorio_contratos.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Relatórios</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Relatórios</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Site</a>
        <a href="#" class="current">Relatórios</a>
      </div>
      <div class="container-fluid">
      <form class="form-inline">
  	    <div class="row-fluid">
		    <div class="span5">
              Cliente: <select class="span10" name="id_cliente" data-placeholder="cliente">
	          	<option value="TODOS">-- Todos os Clientes --</option>
<?php while($row_empresas = mysql_fetch_assoc($empresas)) { ?>
				<option value="<?php echo $row_empresas['ID']?>" <?php echo (isset($idcliente)&&$idcliente==$row_empresas['ID']?"selected":"")?>><?php echo $row_empresas['RAZAO']." / ".$row_empresas['FANTASIA']?></option>
<?php } ?>
  			  </select>	
            </div>
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
         </div>
  	    <div class="row-fluid">
      		  <div class="span5"> 
      		  	Tipo de Relatorio: 
	              <select class="span5" name="tipo" data-placeholder="tipo de relatorio">
		          	<option value="normal" <?php echo (!$simples?"selected":"")?>>Normal</option>
	               	<option value="simples" <?php echo ($simples?"selected":"")?>>Simplificado</option>
	  			  </select>	
	          </div>
      		  <div class="span5"> 
      		  	Número Licença: 
				<input type="text" name="id_contrato" class="input-small" placeholder="Número" value="<?php echo $idContrato?>" maxlength="10"/>	
	          </div>
	          
            <div class="span2">
              <button type="submit" class="btn btn-primary">Consultar</button>
            </div>
          </div>
        </form>
        <br />
        <div class="row-fluid">
          <div class="span12">      
      
<?php 	
	if (!$row_objRs) {
?>

		<table class="table table-bordered table-striped">
			<tr>
				<th colspan="2"><center>Relatório de Contratos</center></th>
			</tr>
			
			<tr></tr>
	
			<tr>
				<td colspan="2">Nenhum registro encontrado com as informações digitadas.</td>
			</tr>
		
			<tr>
				<td width="25%">Nome Fantasia:</td>
				<td><b><?php echo ($idcliente?$row_objRs2["FANTASIA"]:"") ?>&nbsp;</b></td>
			</tr>

			<tr>
				<td width="25%">de:</td>
				<td><b><?php echo  $de ?>&nbsp;</b></td>
			</tr>

			<tr>
				<td width="25%">até:</td>
				<td><b><?php echo  $ate ?>&nbsp;</b></td>
			</tr>
			
		</table>

	<?php } Else { 	?>
	
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th colspan="4"><center>Relatório de Contratos</center></th>
				</tr>
<?php 
if($idcliente != ""){
?>			
		<tr>
			<th><p align="right">Cliente:</p></th>
			<th><b><?php echo $row_objRs2["FANTASIA"]?></b></th>
			<th><p align="right">CNPJ:</p></th>
			<th><b><?php echo $row_objRs2["CNPJ"]?></b></th>		
		</tr>
		
		<tr>
			<th><p align="right">Razão Social:</p></th>
			<th colspan="3"><b><?php echo $row_objRs2["RAZAO"]?></b></th>
		</tr>
<?php }?>		
			<tr>
				<th colspan="7">
					<center>
						<table>
							<tr><td colspan="4"><center>Período Solicitado</center></td></tr>
							<tr>
								<td><p align="right">de:</td>
								<td><b><?php echo  $de ?></b></td>
								<td><p align="right">até:</td>
								<td><b><?php echo  $ate ?></b></td>		
							</tr>
						</table>
					</center/>
				</th>
			</tr>
			</thead>
		</table>

		<table class="table table-bordered table-striped">
			<thead>
			<tr>
				<th><center><b>CONTRATO</b></center></th>
				<th><center><b>EMISSÃO</b></center></th>
<?php if (!$simples) {?>					
<?php 	if (!$idcliente) { ?>
				<th><center><b>CLIENTE</b></center></th>
<?php 	} ?>
				<th><center><b>DESCRIÇÃO</b></center></th>
				<th><center><b>TOTAL</b></center></th>
				<th><center><b>PAGTO.</b></center></th>
				<th><center><b>NF</b></center></th>
<?php } else { ?>
				<th><center><b>No. FOTOS</b></center></th>
				<th><center><b>TOTAL</b></center></th>
<?php }?>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			do {
				$x += 1;

				$strSQL 		= "SELECT * FROM CLIENTES WHERE ID = '" . $row_objRs["ID_CLIENTE"] . "'";
				$objRs3 = mysql_query($strSQL, $sig) or die(mysql_error());
				$row_objRs3 = mysql_fetch_assoc($objRs3);
			?>		
			
				<tr>
					<input type="hidden" name="id_contrato" value="<?php echo $row_objRs["ID"]?>" />
					<td><center><a href="administrativo_licencas_nova.php?id_contrato=<?php echo $row_objRs["ID"]?>" title="Visualizar dados do contrato"><b><?php echo $row_objRs["ID"]?></b></a></center></td>
					<td><?php echo formatdate($row_objRs["DATA"])?></td>
<?php if (!$simples) {?>					
<?php 	if ($idcliente=="") { ?>
					<?php if ( $row_objRs3) { ?>
						<td><?php echo  $row_objRs3["FANTASIA"] ?></td>
					<?php } Else { ?>
						<td>&nbsp;</td>
					<?php } ?>
<?php 	} ?>					
					<td><?php echo $row_objRs["DESCRICAO"]?></td>
					<td>R$ <?php echo  $row_objRs["VALOR_TOTAL"] ?></td>
					<td><?php echo  $row_objRs["DATA_PAGTO"] ?>&nbsp;</td>
					<td><?php echo  $row_objRs["NOTA_FISCAL"] ?>&nbsp;</td>
<?php } else {?>
					<td><?php echo  $row_objRs["num_fotos"] ?></td>
					<td>R$ <?php echo  $row_objRs["VALOR_TOTAL"] ?></td>
<?php }?>			
				</tr>
			
			<?php
				$total += fixnumber($row_objRs["VALOR_TOTAL"]);
				if($simples) $total_fotos += $row_objRs["num_fotos"];
			} while ($row_objRs = mysql_fetch_assoc($objRs));
			?>
			
			<tr>
				<td colspan="<?php echo ($simples?"2":"4")?>"> 
<?php if(!$print) { ?>					Foram localizados (<b><?php echo $x?></b>) registros com esta consulta. <?php } ?>
				</td>
<?php if($simples)	{ ?>			<td><?php echo  $total_fotos ?> fotos</td> <?php }?>
				<td colspan="3">R$ <?php echo  FormatNumber($total) ?></td>
			</tr>
			
		</table>
		<center>
		    <form name="form_imp" action="relatorio-venda-imp.asp" target="_blank" method="get">
				<input type="hidden" name="de" value="<?php echo  $de ?>"   />
				<input type="hidden" name="ate" value="<?php echo  $ate ?>" />
<?php if(!$print) { ?>
				<input class="printBtn" value="Imprimir" style="border:1px solid #333;background-color:#FFF;color:#333;font-weight:bold;background-image:url(images/print.png);background-repeat:no-repeat;padding:2px 2px 2px 10px;background-position:left center;" type="button" />
<?php } ?>
			</form>					
		</center>

	<?php
	}
	//'Fechando o objeto Record Set
	//'Eliminando o objeto Record Set
?>
			</div>
		</div>
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>


