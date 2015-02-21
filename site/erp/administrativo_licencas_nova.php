<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_licencas_nova.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Nova</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Nova</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Administrativo</a>
        <a href="administrativo_licencas.php">Licença</a>
        <a href="#" class="current">Nova</a>
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
        <div class="row-fluid">
          <div class="span12">
      	    <form method="post" class="checkForm">
          
	            <table class="table table-bordered table-striped">
	              <thead>
	                  <tr>
	                      <th colspan="2">Geração de Licença N° <?php echo $id_contrato?></th>
	                      <th colspan="2">Data de criação <?php echo $data?></th>
	                  </tr>
<?php 
if($baixado == "S") {
	if(!$editar) { 
?>
	                  <tr>
	                  	<th colspan="2">Nota N° <?php echo $nota?></th>
	                  	<th colspan="2">Data Baixa <?php echo $data_nota?></th>
	                  </tr>
<?php 
	}
	else {
?>
	                  <tr>
	                  	<th colspan="2">Nota N° <input name="nota" type="text" value="<?php echo $nota?>"/></th>
	                  	<th colspan="2">Data Baixa <input name="data_nota" class="calendar" type="text" value="<?php echo $data_nota?>"/></th>
	                  </tr>
<?php 
	}
} 
?>                  
	                  <tr>
	                  
	                  <th>Nome Fantasia</th>
	                  <th>Razão Social</th>
	                  <th>CNPJ</th>
	                  <th>Contato</th>
	                </tr>
	              </thead>
	              <tbody>
	                
	                  <tr>
	                    
<?php If ($editar && !$isFinalizado) { ?>
	                    <td>
	                    	<select name="cliente_sig" id="selectCliente" data-placeholder="Escolha um cliente">
								<option></option>
<?php 	while($row_empresas = mysql_fetch_assoc($empresas)) { ?>
								<option value="<?php echo $row_empresas['ID']?>" <?php echo ($row_empresas['ID']==$id_cliente?"selected":"")?>><?php echo $row_empresas['RAZAO']." / ".$row_empresas['FANTASIA']?></option>
<?php 	} ?>
    	  					</select>
<?php } else { ?>                    
        	            <td class="tooltipme" title='<?php echo $obs?>'><?php echo $fantasia?></td>
<?php } ?>
            	        <td class="tooltipme" title='<?php echo $obs?>'><?php echo $razao?></td>
	                    <td><?php echo $cnpj?></td>
	                    <td>
		<?php If ($editar && !$isFinalizado) { ?>
						<?php echo  $qcontato ?>
		<?php } Else { ?>
			    <?php echo  $contato ?>
			    <input name="qcontato" type="hidden" value="<?php echo $id_contato?>"/>
		<?php } ?>                      
            	        </td>
                	  </tr>
               
	                  <tr>
	                      
	                      <th colspan="2">Endereço</th>
	                      <th colspan="2">Contrato</th>
	                      
	                  </tr>
	                  <tr>
	                      <td colspan="2"><?php echo  $endereco ?> - <?php echo  $cep ?> - <?php echo  $cidade ?> - <?php echo  $estado ?> | <?php echo  $telefone ?></td>
	
					      <td colspan="2" id="border"> 
						<?php If ($editar && !$isBaixado) { ?>
					        <select id="selectContrato" name="contrato_desc" data-placeholder="--"  class="span10">
					            <?php while ($row_objContrDescs = mysql_fetch_assoc($objContrDescs)) { ?>
				                    <option <?php if ($row_objContrDesc['Id'] == $row_objContrDescs['Id']) echo "selected"; ?> value='<?php echo  $row_objContrDescs['Id'] ?>'><?php echo  $row_objContrDescs['titulo'] ?> - P:<?php If (ord($row_objContrDescs['padrao']) == 1 || ord($row_objContrDescs['padrao']) == 49) echo "Sim"; else echo "Não"; ?> | A:<?php If (ord($row_objContrDescs['assinatura']) == 1 || ord($row_objContrDescs['assinatura']) == 49) echo "Sim"; else echo "Não"; ?> </option>	            
					            <?php } ?>
					        </select>
					    <?php } Else { ?>
				    	      <?php echo  $row_objContrDesc['titulo'] ?> - Padrão: <?php If (ord($row_objContrDesc['padrao']) == 1 || ord($row_objContrDesc['padrao']) == 49) echo "Sim"; else echo "Não"; ?> | Assinatura Digital:  <?php If (ord($row_objContrDesc['assinatura']) == 1 || ord($row_objContrDesc['assinatura']) == 49) echo "Sim"; else echo "Não"; ?>
				    	      <input name="contrato_desc" type="hidden" value="<?php echo $row_objContrDesc['Id']?>"/>
					    <?php } ?>
					      </td>	    
	
	                  </tr>
	                  <tr>
	                      <th colspan="6">Descrição</th>
	                      
	                  </tr>
	                  
	                  <tr>
	                      <td colspan="6"> 
	                    <?php If ($editar) { ?>
	                    		<textarea class="span12" name="descricao" onkeyup="progreso_tecla(this)" type="text"><?php echo $descricao ?></textarea><div id="progreso">(0 / 250)</div>
	                            <input type="hidden" name="editaCromo" value="nao" id="input_editaCromo"/>
	                            <input type="hidden" name="salvaDesCont" value="sim" id="input_salvaDes"/>
				        	    <input class="btn btn-primary unbind_unload" type="submit" name="action" value="Salvar Descrição"/>
				        	    <input type="hidden" name="id_contrato" value="<?php echo $id_contrato?>"/>
	
						<?php } else { ?>
	   	                         <?php echo  $descricao ?>
						<?php }?>
	                      </td>
	                  </tr>
	            </tbody>
<!--             </form> -->
            </table>
<?php if($editar && !$isBaixado) { ?>	            
<!--             	<form method="post" class="formInserirCromos"> -->
                  <table class="table table-bordered table-striped formInserirCromos">
                      <tbody>
                  <tr>
                      <th colspan="2">Código</th>
                      <th colspan="2">Uso</th>
                      <th colspan="2"></th>
                  </tr>
                  
                  <tr>
                      <td colspan="2"><input type="text" placeholder="Código" class="gimefocus" id="qcodigo" name="qcodigo[]" /></td>
                      <td colspan="2"><select data-placeholder="- Escolha um uso -" name="id_uso" id="id_uso" class="span12 notChosen">
                          <option value=""> - Escolha um uso - </option>

			<?php while ($row_objTipo = mysql_fetch_assoc($objTipo)) { ?>
				    <optgroup label="<?php echo $row_objTipo['tipo'] ?>">
				    <?php
				        $strSub = "select distinct subtipo_br as subtipo, sub.Id from USO_SUBTIPO as sub, USO as uso where uso.id_utilizacao = sub.Id and uso.id_tipo = " . $row_objTipo['Id'] ." AND uso.contrato like '$tipo_contrato'";
//				    	$strSub = "select distinct subtipo, sub.Id from USO_SUBTIPO as sub, USO as uso where uso.id_subtipo = sub.Id and uso.id_tipo = " . $row_objTipo['Id'] ." AND uso.contrato like '$tipo_contrato'";
				        $objSub = mysql_query($strSub, $sig) or die(mysql_error());
				        
				        while ($row_objSub = mysql_fetch_assoc($objSub)) {
				    ?>
				        <optgroup label="<?php echo $row_objSub['subtipo'] ?>">
				        
				        <?php
				        
				        $strDesc = "select uso.Id, uso_formato.formato_br as formato, uso_distribuicao.distribuicao_br as distribuicao, uso_periodicidade.periodicidade_br as periodicidade, descr.descricao_br as descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor 
									from USO as uso 
									left join USO_DESC as descr on uso.id_tamanho = descr.Id
									left join uso_formato on uso.id_formato = uso_formato.id
									left join uso_distribuicao on uso.id_distribuicao = uso_distribuicao.id 
									left join uso_periodicidade on uso.id_periodicidade = uso_periodicidade.id  
									where uso.id_utilizacao = " . $row_objSub['Id']." AND uso.id_tipo = " . $row_objTipo['Id'] ." AND uso.contrato like '$tipo_contrato'";
//				        echo $strDesc;
//				        $strDesc = "select uso.Id, descr.descricao_br as descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor from USO_DESC as descr, USO as uso where uso.id_tamanho = descr.Id and uso.id_utilizacao = " . $row_objSub['Id']." AND uso.contrato like '$tipo_contrato'";
//				        $strDesc = "select uso.Id, descr.descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor from USO_DESC as descr, USO as uso where uso.id_descricao = descr.Id and uso.id_subtipo = " . $row_objSub['Id']." AND uso.contrato like '$tipo_contrato'";
				        $objDesc =  mysql_query($strDesc, $sig) or die(mysql_error());
				        
				        	while ($row_objDesc = mysql_fetch_assoc($objDesc)) {
				        
				        ?>
				            <option <?php if ( isset($id_uso) && $row_objDesc['Id'] == $id_uso) echo"selected"; ?> value="<?php echo $row_objDesc['Id']?>"><?php echo $row_objDesc['Id']."-".$row_objDesc['formato']." ".$row_objDesc['distribuicao']." ".$row_objDesc['periodicidade']." ".$row_objDesc['descricao'] ?> (R$ <?php echo $row_objDesc['valor']?>)</option>
				        <?php } ?>
				        </optgroup>
				    <?php } ?>
				    </optgroup>
				<?php } ?>
                          
                          
                          
    	                    </select></td>
	                      <td colspan="2">
	                      	<input class="btn btn-primary unbind_unload" type="submit" name="action" value="Inserir"/>
	                      	<input class="btn btn-primary cadastrarCromo" type="button" value="Cromo Não Cadastrado"/>
	                      	<input type="hidden" name="exec" value="cromo"/>
	                      	<input type="hidden" id="id_contrato" name="id_contrato" value="<?php echo $id_contrato?>"/>
	                     </td>
	                  </tr>
	              </tbody>
            	</table>
              <br />
<!--               </form> -->
<!--              <form method="post" class="formCadastrarCromos" style="display:none"> -->
                  <table class="table table-bordered table-striped formCadastrarCromos" style="display:none">
                      <tbody>
                  <tr>
                      <th colspan="2">Uso</th>
                      <th colspan="2">Assunto</th>
                      <th colspan="2">Autor</th>
                      <th colspan="2"></th>
                  </tr>
                  
                  <tr>
                      <td colspan="2"><select data-placeholder=" - Escolha um uso - " name="id_uso2" id="id_uso_cadastro" class="notChosen">
                          <option value=""></option>

<?php 
				mysql_data_seek($objTipo,0); 
				while ($row_objTipo = mysql_fetch_assoc($objTipo)) { 
?>
				    <optgroup label='<?php echo $row_objTipo['tipo'] ?>'>
				    <?php
				        $strSub = "select distinct subtipo_br as subtipo, sub.Id from USO_SUBTIPO as sub, USO as uso where uso.id_utilizacao = sub.Id and uso.id_tipo = " . $row_objTipo['Id'] ." AND uso.contrato like '$tipo_contrato'";
//				    	$strSub = "select distinct subtipo, sub.Id from USO_SUBTIPO as sub, USO as uso where uso.id_subtipo = sub.Id and uso.id_tipo = " . $row_objTipo['Id'] ." AND uso.contrato like '$tipo_contrato'";
				        $objSub = mysql_query($strSub, $sig) or die(mysql_error());
				        
				        while ($row_objSub = mysql_fetch_assoc($objSub)) {
				    ?>
				        <optgroup label="<?php echo $row_objSub['subtipo'] ?>">
				        
				        <?php
				        
				        $strDesc = "select uso.Id, uso_formato.formato_br as formato, uso_distribuicao.distribuicao_br as distribuicao, uso_periodicidade.periodicidade_br as periodicidade, descr.descricao_br as descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor 
									from USO as uso 
									left join USO_DESC as descr on uso.id_tamanho = descr.Id
									left join uso_formato on uso.id_formato = uso_formato.id
									left join uso_distribuicao on uso.id_distribuicao = uso_distribuicao.id 
									left join uso_periodicidade on uso.id_periodicidade = uso_periodicidade.id  
									where uso.id_utilizacao = " . $row_objSub['Id']." AND uso.id_tipo = " . $row_objTipo['Id'] ." AND uso.contrato like '$tipo_contrato'";
//				        echo $strDesc;
//				        $strDesc = "select uso.Id, descr.descricao_br as descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor from USO_DESC as descr, USO as uso where uso.id_tamanho = descr.Id and uso.id_utilizacao = " . $row_objSub['Id']." AND uso.contrato like '$tipo_contrato'";
//				        $strDesc = "select uso.Id, descr.descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor from USO_DESC as descr, USO as uso where uso.id_descricao = descr.Id and uso.id_subtipo = " . $row_objSub['Id']." AND uso.contrato like '$tipo_contrato'";
				        $objDesc =  mysql_query($strDesc, $sig) or die(mysql_error());
				        
				        	while ($row_objDesc = mysql_fetch_assoc($objDesc)) {
				        
				        ?>
				            <option <?php if ( isset($id_uso) && $row_objDesc['Id'] == $id_uso) echo"selected"; ?> value="<?php echo $row_objDesc['Id']?>"><?php echo $row_objDesc['formato']." ".$row_objDesc['distribuicao']." ".$row_objDesc['periodicidade']." ".$row_objDesc['descricao'] ?> (R$ <?php echo $row_objDesc['valor']?>)</option>
				        <?php } ?>
				        </optgroup>
				    <?php } ?>
				    </optgroup>
				<?php } ?>
                          
                          
                          
    	                    </select>
    	              </td>
                      <td colspan="2"><input type="text" placeholder="Assunto" class="gimefocus" name="qassunto" /></td>
                      <td colspan="2"><input type="text" placeholder="Autor" class="gimefocus" name="qautor" /></td>
                      <td colspan="2">
						<button class="btn btn-primary unbind_unload" type="submit" name="action" value="InserirNew">Inserir</button>
	                    <input type="hidden" name="exec" value="cromo"/>
	                    <input type="hidden" name="id_contrato" value="<?php echo $id_contrato?>"/>
	                    <input type="hidden" id="cromo_nao_cadastrado" name="cromo_nao_cadastrado" value="s" />	                      	
					  </td>
	                  </tr>
	              </tbody>
            	</table>
              <br />
              </form>
<?php } ?>	              
              <form method="post" class="reuso_form">
              <table class="table table-bordered table-striped">
                  <tbody>
                      <tr>
                          <th>Código</th>
                          <th>Assunto</th>
                          <th>Autor</th>
                          <th>Valor</th>
                          <th>Desconto</th>
                          <th>Total</th>
                          <th>Reuso</th>
                          <th>Indio</th>
<?php if($editar && !$isBaixado) { ?>
                          <th>Excluir</th>
<?php }?>
                      </tr>
<?php 
$contador = 0;
$total = 0;
$desconto = 0;
While ($row_objRS5 = mysql_fetch_assoc($objRS5)) {
	$id_uso=$row_objRS5['ID_USO'];

	$strSQL = "select uso.Id, USO_TIPO.tipo_br as tipo, USO_SUBTIPO.subtipo_br as subtipo, uso_formato.formato_br as formato, uso_distribuicao.distribuicao_br as distribuicao, uso_periodicidade.periodicidade_br as periodicidade, descr.descricao_br as descricao, REPLACE(REPLACE(REPLACE(FORMAT(valor,2),'.','|'),',','.'),'|',',') as valor
									from USO as uso
									left join USO_TIPO on uso.id_tipo = USO_TIPO.Id
									left join USO_SUBTIPO on uso.id_utilizacao = USO_SUBTIPO.Id
									left join USO_DESC as descr on uso.id_tamanho = descr.Id
									left join uso_formato on uso.id_formato = uso_formato.id
									left join uso_distribuicao on uso.id_distribuicao = uso_distribuicao.id
									left join uso_periodicidade on uso.id_periodicidade = uso_periodicidade.id
									where uso.Id = ".$id_uso." AND uso.contrato like '$tipo_contrato'";

	$objRS6 	= mysql_query($strSQL, $sig) or die(mysql_error());
	$row_objRS6 = mysql_fetch_assoc($objRS6);
	$uso			= "uso: ".mb_strtolower($row_objRS6['tipo'])." / ".mb_strtolower($row_objRS6['subtipo'])." / ".mb_strtolower($row_objRS6['formato'])." / ".mb_strtolower($row_objRS6['distribuicao'])." / ".mb_strtolower($row_objRS6['periodicidade'])." / ".mb_strtolower($row_objRS6['descricao']);

	//deteccao se o cromo eh de indio
	foreach($arr_indios as $tribo => $total_tribo) {
		if(stristr($row_objRS5['ASSUNTO'],$tribo)!==false) {
			$has_indios = true;
		}
	}
	if(!$has_indios) {
		$has_normal = true;
	}

	if(isVideo($row_objRS5['CODIGO'])) {
		$has_video = true;
	} else {
		$has_foto = true;
	}
?>           
					  <input type="hidden" name="id<?php echo  $contador?>" value="<?php echo  $row_objRS5['ID'] ?>" />
                      <tr>
                          <td><?php echo $row_objRS5['CODIGO']?></td>
                          <td><?php echo mb_strtoupper($row_objRS5['ASSUNTO'])?><br /><?php echo $uso?></td>
                          <td><?php echo $row_objRS5['AUTOR']?></td>
<?php If ($editar && !$isBaixado) { ?>
							<td>R$ <input class="span7" type="text" name="valor<?php echo $contador?>" id="valor<?php echo $contador?>" value="<?php echo $row_objRS5['VALOR']?>"/></td>
							<td>R$ <input class="span7" type="text" name="desconto<?php echo $contador?>" id="desconto<?php echo $contador?>" value="<?php echo $row_objRS5['DESCONTO']?>"/></td>
							<?php $valor_final=fixnumber($row_objRS5['VALOR'])-fixnumber($row_objRS5['DESCONTO'])?>
							<td>R$ <input class="span7" type="text" name="valor_final<?php echo $contador?>" value="<?php echo formatnumber($valor_final)?>" readonly/></td>
							<td><input type="checkbox" name="reuso[]" value="<?php echo $row_objRS5['ID']?>" id="chk_<?php echo $contador?>" class="reuso unbind_unload" <?php echo ((int)$row_objRS5['reuso']%10)>=1?"checked":""?>/></td>
							<td><input type="checkbox" name="indio[]" value="<?php echo $row_objRS5['ID']?>" id="chkIndio_<?php echo $contador?>" class="chkIndio unbind_unload" <?php echo ((int)$row_objRS5['reuso']/10)>=1?"checked":""?>/></td>
							<td><center><a class="icon-remove unbind_unload" href="administrativo_licencas_nova.php?editar=true&id_contrato=<?php echo $id_contrato?>&trash=<?php echo $row_objRS5['ID']?>"><img src="images/del.gif" border="0" alt="excluir cromo do contrato" class="unbind_unload"/></a></center></td>
<?php } else { ?>
							<td>R$ <?php echo $row_objRS5['VALOR']?>&nbsp;</td>
							<td>R$ <?php echo $row_objRS5['DESCONTO']?>&nbsp;</td>
							<?php $valor_final=fixnumber($row_objRS5['VALOR'])-fixnumber($row_objRS5['DESCONTO'])?>
							<td>R$ <?php echo formatnumber($valor_final)?>&nbsp;</td>
							<td><input type="checkbox" name="reuso[]" value="<?php echo $row_objRS5['ID']?>" id="chk_<?php echo $contador?>" class="reuso" <?php echo ((int)$row_objRS5['reuso']%10)>=1?"checked":""?> disabled/></td>
							<td><input type="checkbox" name="indio[]" value="<?php echo $row_objRS5['ID']?>" id="chkIndio_<?php echo $contador?>" class="chkIndio" <?php echo ((int)$row_objRS5['reuso']/10)>=1?"checked":""?> disabled/></td>
<?php } ?>
                      </tr>
<?php 
	$total += $valor_final;
	$desconto += $row_objRS5['DESCONTO'];
	$contador=$contador+1;
}
?>
				<tr>
				<td colspan="4"><?php echo $contador?> cromo(s)</td>
				<td>R$ <?php echo formatnumber($desconto)?></td>
				<td>R$ <?php echo formatnumber($total)?></td>
<?php if($editar && !$isBaixado) { ?>
				<td colspan="2">
					<input class="btn btn-primary unbind_unload" type="submit" name="action" value="Atualizar valores"/>
				 	<input type="hidden" value="<?php echo $contador?>" name="contador"/>					
					<input type="hidden" value="true" name="atualizar"/>
					<input type="hidden" value="<?php echo $id_contrato?>" name="id_contrato"/>
				</td>
<?php } ?>				

				</tr>
                      
                  </tbody>
              </table>
              </form>
          </div>
        </div>
          
           <div class="row-fluid">
        <div class="span5"></div>
        <div class="span7">
        	<form method="post" class="formOnclick">
	        	<input type="hidden" value="<?php echo FormatNumber($total,2)?>" name="valor_total"/>
	        	<input type="hidden" value="<?php echo $id_contrato?>" name="id_contrato"/>
	           	<input type="hidden" value="true" name="finalizar"/>
	           	<a class="btn btn-secundary" href="<?php echo $_SESSION['back']?>">Voltar</a>&nbsp;
	           	
<?php if($editar) { ?>	        	
	        	<a class="btn btn-primary unbind_unload submitOnclick" href="#">Finalizar</a>&nbsp;<a class="btn btn-danger unbind_unload confirmOnclick" href="administrativo_licencas_nova.php?excluir=true&id_contrato=<?php echo $id_contrato?>">Excluir</a>
<?php } else { ?>
				<a class="btn btn-success" href="administrativo_licencas_nova.php?novo=true">Novo</a>&nbsp;
		        <a class="btn btn-success" href="administrativo_licencas_nova.php?copiar=true&editar=true">Copiar</a>&nbsp;
	        	<a class="btn btn-warning" href="tool_gerar_boleto_bradesco.php?id_contrato=<?php echo $id_contrato?>" target="_blank">Gerar Boleto</a>&nbsp;
	        	<a class="btn btn-warning" href="tool_nfe.php?id_contrato[]=<?php echo $id_contrato?>" target="_blank">Gerar NFSe-SP</a>&nbsp;
	        	<a class="btn btn-primary unbind_unload" href="contrato_print.php?contratos[]=<?php echo $id_contrato?>" target="_blank">Imprimir</a>&nbsp;
		        <a class="btn btn-primary unbind_unload" href="administrativo_licencas_nova.php?editar=true&id_contrato=<?php echo $id_contrato?>">Editar</a>&nbsp;
		        <a class="btn btn-danger unbind_unload confirmOnclick" href="administrativo_licencas_nova.php?excluir=true&id_contrato=<?php echo $id_contrato?>">Excluir</a>
<?php }?>
	        </form>
        </div>
    </div>
<?php if((!$is_indios && $has_indios)) { ?>
<?php //if((!$is_indios && $has_indios)&&!$editar) { ?>
<script>alert("Contrato normal contendo fotos de indio!");</script>
<?php } ?>
<?php if(($is_indios && $has_normal)) { ?>
<?php //if(($is_indios && $has_normal)&&!$editar) { ?>
<script>alert("Contrato indio sem fotos de indio!");</script>
<?php } ?>
<?php if(($is_video && $has_foto)) { ?>
<?php //if(($is_video && $has_foto)&&!$editar) { ?>
<script>alert("Contrato de video contendo foto!");</script>
<?php } ?>
<?php if((!$is_video && $has_video)) { ?>
<?php //if((!$is_video && $has_video)&&!$editar) { ?>
<script>alert("Contrato de foto contendo video!");</script>
<?php } ?>    
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
