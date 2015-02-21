<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_licencas.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Licenças</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Licenças</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Administrativo</a>
        <a href="#" class="current">Licenças</a>
      </div>
      <div class="container-fluid">
<?php if(isset($msg) && $msg != "") { ?>
            <div class="alert alert-success">
              <?php echo $msg?>
              <a href="#" data-dismiss="alert" class="close">×</a>
            </div>
<?php } ?>             		
<?php if(isset($error) && $error != "") { ?>
            <div class="alert alert-error">
              <?php echo $error?>
              <a href="#" data-dismiss="alert" class="close">×</a>
            </div>
<?php } ?>    
     	<form class="form-inline" method="post">
      		<div class="row-fluid">
		        <div class="span5">
		            <a class="btn btn-success" href="administrativo_licencas_nova.php?novo=true">Novo</a>
		            <a class="btn btn-success" href="administrativo_licencas_nova.php?copiar=true&editar=true">Copiar dados da última licença</a>
		        </div>
		    </div> 
		    <hr />
      		<div class="row-fluid">
		          <div class="span5">
					<div class="input-append calendar">
	                   Cliente <select class="span12 do_submit" name="id_cliente" data-placeholder="Escolha um cliente">
							<option value="">Escolha um cliente</option>
<?php 	while($row_empresas = mysql_fetch_assoc($empresas)) { ?>
							<option value="<?php echo $row_empresas['ID']?>" <?php echo ($row_empresas['ID']==$id_cliente?"selected":"")?>><?php echo $row_empresas['RAZAO']." / ".$row_empresas['FANTASIA']?></option>
<?php 	} ?>
    	  				</select>		          
					</div>      			  
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
          		  <div class="span2">
		              LR: <input class="input-small" name="lr" type="text" placeholder="No. da LR" value="<?php echo $lr?>" maxlength="10"/>
		          </div>
<!-- 	    		  <div class="span2"> -->
<!--		              <input name="baixados" type="checkbox" <?php echo ($show_baixados?"checked":"")?>/> Mostra baixados -->
<!-- 		          </div> -->
		          <div class="span1">
<!-- 		              Cliente: <input class="input-large" name="cliente" type="text" placeholder="Nome fantasia ou Razão social" value="<?php echo $cliente?>"/> -->
		              <button type="submit" name="action" value="enviar" class="btn btn-primary do_button">Consultar</button>
		          </div>
		        </div>
<?php if($totalTotal > 0) { ?>		        
		        <hr />
		        <div class="row-fluid">
		          <div class="span12">
		    		<a class="btn btn-info showBaixaLote" onclick='this.form.action="";this.form.target=""'>Baixa Lote</a>
		        	<input class="btn btn-primary" type="submit" name="action" value="Imprimir" onclick='this.form.action="contrato_print.php";this.form.target="_blank"'/>	
		    		
	          	</div>
<?php } ?>	          	
	          </div>
<?php if($totalTotal > 0) { ?>		        
			<div class="row-fluid">
	          <div class="span12">
	            <table class="table table-bordered table-striped with-check">
	              <thead>
	                <tr>
	                  <th><input class="checkAllBaixa" id="0.0" type="checkbox" /></th>
	                  <th>Licenças</th>
	                  <th>Razão Social</th>
	                  <th>CNPJ</th>
	                  <th>Ações</th>
	                </tr>
	              </thead>
	              <tbody>
	                <?php while($rowTotal = mysql_fetch_array($objTotal)) { ?>
	                  <tr>
	                    <td><input class="checkBaixa" id="<?php echo $rowTotal["VALOR_TOTAL"]?>" type="checkbox" name="contratos[]" value="<?php echo $rowTotal["ID"]?>"/></td>
	                    <td><a href="administrativo_licencas_nova.php?id_contrato=<?php echo $rowTotal["ID"]?>"><?php echo $rowTotal["ID"]?></a></td>
	                    <td><?php echo $rowTotal["razao"]?></td>
	                    <td><?php echo $rowTotal["cnpj"]?></td>
	                    <td class="baixaShow_<?php echo $rowTotal["ID"]?> baixaShow">
<!-- 	                      <a class="btn btn-info baixaBtn" id="baixaId_<?php echo $rowTotal["ID"]?>" href="administrativo_licencas_nova.php?baixar=true&id_contrato=<?php echo $rowTotal["ID"]?>">Baixa</a> -->
	                      <a class="btn btn-info baixaBtn" id="baixaId_<?php echo $rowTotal["ID"]?>">Baixa</a>
	                      <a class="btn btn-primary" href="administrativo_licencas_nova.php?editar=true&id_contrato=<?php echo $rowTotal["ID"]?>">Editar</a>
	                      <a class="btn btn-danger confirmOnclick" href="administrativo_licencas_nova.php?excluir=true&id_contrato=<?php echo $rowTotal["ID"]?>">Excluir</a>
	                    </td>
	                    <td class="baixaHide_<?php echo $rowTotal["ID"]?> baixaHide" style="display:none">
                    		Data Baixa: <input class="span7" type="text" name="baixa<?php echo $rowTotal['ID']?>" value="<?php echo $rowTotal['DATA_PAGTO']?>" maxlength="10" size="10" onkeypress="return txtBoxFormat(this, '99/99/9999',event);" />
							NF: <input class="span5" type="text" name="nf<?php echo $rowTotal['ID']?>" value="<?php echo $rowTotal['NOTA_FISCAL']?>" maxlength="10" size="10" />
						</td>
	                  </tr>
	                <?php } ?>
	              </tbody>
	            </table>
	            <input class="btn btn-info baixaActionBtn baixaHide" type="submit" name="action" value="Baixar" onclick='this.form.action="";this.form.target=""' style="display:none">
	
<!-- 	            <div class="pagination pagination-right"> -->
<!-- 	              <ul> -->
<!-- 	                <li class="disabled"><a href="#">«</a></li> -->
<!-- 	                <li class="active"><a href="#">1</a></li> -->
<!-- 	                <li><a href="#">2</a></li> -->
<!-- 	                <li><a href="#">3</a></li> -->
<!-- 	                <li><a href="#">4</a></li> -->
<!-- 	                <li><a href="#">5</a></li> -->
<!-- 	                <li><a href="#">»</a></li> -->
<!-- 	              </ul> -->
<!-- 	            </div> -->
	
	          </div>
	        </div>
<?php } ?>
	        <br />
      		<div class="row-fluid baixaLote" style="display:none">
		        <div class="span2">
		            <input class="span10" name="nf" type="text" placeholder="Nota Fiscal" value="" />
		        </div>
		        <div class="span3">
					<div class="input-append calendar">
				    	Data <input data-format="dd/MM/yyyy" type="text" name="baixa" class="input-small" placeholder="Data Baixa" maxlength="10" onKeyPress="return txtBoxFormat(this, '99/99/9999', event);"/>
				    	<span class="add-on">
				      		<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				      		</i>
				    	</span>
				  	</div>
		        </div>
		        <div class="span3">
		            <button class="btn btn-info" type="submit" name="action" value="baixaLote">Baixar Lote</button>
		        </div>
		        <div class="span4">
		            <p>Total Baixa: <span class="sum_total">R$ 0,00</span></p>
		        </div>
		        
			</div>	        
			<br/>

		</form>
	        
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
