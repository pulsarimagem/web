<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_indexacao.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pulsar Admin - Indexação > Imagens</title>
<meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
<body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
		<div id="content-header">
			<h1>Imagens</h1>
		</div>
		<div id="breadcrumb">
			<a href="index.php" title="Go to Home" class="tip-bottom"><i
				class="icon-home"></i>Pulsar Admin - Indexação</a> <a href="#" class="current">Indexação</a>
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
					<div class="widget-box-form">
						<div class="widget-title">
							<span class="icon"><i class="icon-align-justify"></i></span>
							<h5>Formulário</h5>
						</div>
						<div class="widget-content nopadding">
							<form method="get" class="form-horizontal">

								<div class="control-group">
									<label class="control-label">Tombo</label>
									<div class="controls clearfix">
										<div class="span3">
											<input type="text" name="tombos[]" class="input-large" value="<?php echo ($toLoad?$colname_dados_foto:"");?>" placeholder="Tombo " />
										</div>
										<div class="span4">
											<button type="submit" name="action" value="consultar" class="btn btn-primary">Consultar</button>
										</div>
									</div>
								</div>
							</form>
							<form method="get" class="form-horizontal">

								<div class="control-group">
									<label class="control-label">Multiplos Tombos</label>
									<div class="controls clearfix">
										<div class="span3">
											<input type="text" name="prefix" class="input-large" value="<?php echo (isset($_GET['prefix'])?$_GET['prefix']:"");?>" placeholder="Prefixo" />
											<input type="text" name="inicio" class="input-large" value="<?php echo (isset($_GET['inicio'])?$_GET['inicio']:"");?>" placeholder="Inicio" />
											<input type="text" name="fim" class="input-large" value="<?php echo (isset($_GET['fim'])?$_GET['fim']:"");?>" placeholder="Fim" />
										</div>
										<div class="span4">
											<button type="submit" name="action" value="multi" class="btn btn-primary">Consultar</button>
										</div>
									</div>
								</div>
							</form>							
							<form method="post" class="form-horizontal" name="form2" action="indexacao.php">
<?php if($tomboExists) { ?>								
								<div class="control-group">
									<label class="control-label"></label>
									<div class="controls">
										<div class="row-fluid">
<?php if(!isVideo($colname_dados_foto)) { ?>										
											<div class="span4">
<?php foreach($tombos as $tombo) { ?>											
												<img src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $tombo?>.jpg" width="300" />
<?php } ?>
											</div>
											<div class="span8">
<?php if(file_exists($fotosalta.$row_dados_foto['tombo'].'.jpg')) { ?>											
												<IFRAME ID=IFrame1 FRAMEBORDER=0 SCROLLING=YES SRC="iptc.php?foto=<?php echo $row_dados_foto['tombo']; ?>"></IFRAME>
<?php } ?>
											</div>
<?php } else { ?>
											<div class="span4">
<?php 	foreach ($thumbs as $thumb) {?>	           	
	     							          	<img src="<?php echo $cloud_server?>Videos/thumbs/<?php echo $thumb?>" onclick="MM_openBrWindow('playervideo.php?tombo=<?php echo $_GET['tombo']; ?>','','resizable=yes,width=640,height=400')"/>
<?php 	}?>											</div>
											<div class="span8">
<?php 	foreach($video_info as $info=>$val) { ?>		
			<strong><?php echo $info?>:</strong> <?php echo $val?><br>
<?php 	} ?>			
											</div>
<?php } ?>											
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"></label>
									<div class="controls">
										<button type="button" class="btn btn-primary" onclick="window.open('<?php echo $homeurl ?>toolkit/Example.php?jpeg_fname=<?php echo $colname_dados_foto?>','','scrollbars=yes,resizable=yes,width=600,height=800')">Extra IPTC</button>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Tombo</label>
									<div class="controls clearfix">
<?php if($multiLoad) { ?>
										<input type="text" name="tombos[]" value="<?php echo ($toLoad?implode(",", $tombos):"");?>" disabled="disabled"/>
<?php 	foreach($tombos as $tombo) { ?>
										<input type="hidden" name="tombos[]" value="<?php echo $tombo;?>"/>
<?php 	}?>										
<?php } else { ?>
										<input type="text" name="tombo" value="<?php echo ($toLoad?$row_dados_foto['tombo']:"");?>" disabled="disabled"/>
										<input type="hidden" name="tombo" value="<?php echo ($toLoad?$row_dados_foto['tombo']:"");?>"/>
<?php }?>						
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Assunto principal</label>
									<div class="controls clearfix">
										<input type="text" name="assunto_principal" id="assunto_principal" value="<?php echo ($toLoad?($row_dados_foto['assunto_principal']==""?$iptc_assunto:$row_dados_foto['assunto_principal']):"");?>"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Informação adicional</label>
									<div class="controls clearfix">
										<input type="text" name="extra" value="<?php echo ($toLoad?$row_dados_foto['extra']:"");?>"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Direito de imagem</label>
									<div class="controls">
										<div class="span6">
											<label><input type="radio" name="dir_img" value="0" <?php echo ($row_dados_foto['direito_img']%10 != 1 && $row_dados_foto['direito_img']%10 != 2 && $row_dados_foto['direito_img']%10 != 3? "checked":"");?>> Nenhum</label> 
											<label><input type="radio" name="dir_img" value="1" <?php echo ($row_dados_foto['direito_img']%10 == 1 ? "checked":"");?>> Uso autorizado</label> 
											<label><input type="radio" name="dir_img" value="2" <?php echo ($row_dados_foto['direito_img']%10 == 2 ? "checked":"");?>> Uso autorizado + Acrécimo de 100%</label>
<!-- 											<label><input type="radio" name="dir_img" value="3" <?php echo ($row_dados_foto['direito_img']%10 == 3 ? "checked":"");?>> Não autorizado</label> -->
										</div>
									</div>
								</div>
								<div class="control-group" style="display:none">
									<label class="control-label">Direito de propriedade</label>
									<div class="controls">
										<div class="span6">
											<label><input type="radio" name="dir_prop" value="0" <?php echo (intval($row_dados_foto['direito_img']/10) != 1 && $row_dados_foto['direito_img']/10 != 2 ? "checked":"");?>> Nenhum</label> 
											<label><input type="radio" name="dir_prop" value="10" <?php echo (intval($row_dados_foto['direito_img']/10) == 1 ? "checked":"");?>> Autorizado</label> 
											<label><input type="radio" name="dir_prop" value="20" <?php echo (intval($row_dados_foto['direito_img']/10) == 2 ? "checked":"");?>> Não autorizado</label>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Autor</label>
									<div class="controls clearfix">
										<select name="autor" data-placeholder=" - - - - - Escolha - - - - - " <?php if ($autor_encontrado) { ?>disabled="disabled" <?php } ?>>
											<option value=""></option>
            <?php
do {  
?>
            <option value="<?php echo $row_fotografos['id_fotografo']?>"<?php if ((!(strcmp($row_fotografos['id_fotografo'], $row_dados_foto['id_autor'])))||(!(strcmp($row_fotografos['id_fotografo'], $row_ini_fotografo['id_fotografo'])))) {echo "SELECTED";}?>><?php echo $row_fotografos['Nome_Fotografo']?></option>
            <?php
} while ($row_fotografos = mysql_fetch_assoc($fotografos));
  $rows = mysql_num_rows($fotografos);
  if($rows > 0) {
      mysql_data_seek($fotografos, 0);
	  $row_fotografos = mysql_fetch_assoc($fotografos);
  }
?>
										</select>
<?php if ($autor_encontrado) { ?>          
			<input name="autor" type="hidden" value="<?php echo ($row_ini_fotografo['id_fotografo']); ?>"/>
<?php } ?>											
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Data</label>
									<div class="controls clearfix">
										<input name="data_tela" type="text" id="data_tela" onBlur="fix_data()" value="<?php if($toLoad) { if($row_dados_foto['data_foto']=="") { echo $iptc_data; } else { if (strlen($row_dados_foto['data_foto']) == 4) {
			echo $row_dados_foto['data_foto'];
		} elseif (strlen($row_dados_foto['data_foto']) == 6) {
			echo substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
		} elseif (strlen($row_dados_foto['data_foto']) == 8) {
			echo substr($row_dados_foto['data_foto'],6,2).'/'.substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
		}}} ?>">
										<input type="hidden" name="data" value="<?php echo ($toLoad?($row_dados_foto['data_foto']==""?fix_iptc_date($iptc_data):$row_dados_foto['data_foto']):"");?>"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Cidade</label>
									<div class="controls clearfix">
										<input class="span5" type="hidden" name="cidade" id="indexCidade" value="<?php echo ($toLoad?($row_dados_foto['cidade']==""?$iptc_local:$row_dados_foto['cidade']):"");?>">
<!-- 										<input type="text" name="cidade" value="<?php echo ($toLoad?$row_dados_foto['cidade']:"");?>"/> -->
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Estado</label>
									<div class="controls clearfix">
										<select name="estado" data-placeholder=" - - - - - Escolha - - - - - ">
            <option value="" <?php if (!(strcmp("", $row_dados_foto['id_estado'])) && $iptc_estado == "") {echo "SELECTED";} ?>></option>
            <?php
do {  
?>
            <option value="<?php echo $row_estado['id_estado']?>"<?php if (!(strcmp($row_estado['id_estado'], $row_dados_foto['id_estado'])) || !(strcasecmp($row_estado['Sigla'], $iptc_estado))) {echo "SELECTED";} ?>><?php echo $row_estado['Estado']?></option>
            <?php
} while ($row_estado = mysql_fetch_assoc($estado));
  $rows = mysql_num_rows($estado);
  if($rows > 0) {
      mysql_data_seek($estado, 0);
	  $row_estado = mysql_fetch_assoc($estado);
  }
?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">País</label>
									<div class="controls clearfix">
										<div class="span5">
											<select class="span12" name="pais" data-placeholder=" - - - - - Escolha - - - - - ">
            <option value="" <?php if (!(strcmp("", $row_dados_foto['id_pais'])) && $iptc_pais == "") {echo "SELECTED";} ?>></option>
            <?php
do {  
?>
            <option value="<?php echo $row_pais['id_pais']?>"<?php if (!(strcmp($row_pais['id_pais'], $row_dados_foto['id_pais'])) || !(strcasecmp(removeAccents($row_pais['nome']), removeAccents($iptc_pais)))) {echo "SELECTED";} ?>><?php echo $row_pais['nome']?></option>
            <?php
} while ($row_pais = mysql_fetch_assoc($pais));
  $rows = mysql_num_rows($pais);
  if($rows > 0) {
      mysql_data_seek($pais, 0);
	  $row_pais = mysql_fetch_assoc($pais);
  }
?>
											</select>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Temas</label>
									<div class="controls clearfix">
										<div class="span8">
											<select class="span12" name="temas[]" multiple data-placeholder=" - - - - - Escolha os Temas - - - - - ">
												<option value=""></option>
<?php
do {  
?>
                  <option value="<?php echo $rowAllTemas['Id']?>" <?php echo (in_array($rowAllTemas['Id'],$temasArr)?"selected":"")?>><?php echo $rowAllTemas['Tema_total']?></option>
                  <?php
} while ($rowAllTemas = mysql_fetch_assoc($rsAllTemas));
  $rows = mysql_num_rows($rsAllTemas);
  if($rows > 0) {
      mysql_data_seek($rsAllTemas, 0);
	  $rowAllTemas = mysql_fetch_assoc($rsAllTemas);
  }
?>
											</select>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Descritores</label>
									<div class="controls clearfix">
										<div class="span8">
											<input class="span12" type="hidden" name="descritores" id="indexDesc" value="<?php echo $descConcat?>">
										</div>
									</div>
								</div>
<?php if($iptc_pal!="") {?>								
								<div class="control-group">
									<label class="control-label">Descritores IPTC</label>
									<div class="controls clearfix">
										<div class="span8">
											<input type="text" value="<?php echo $iptc_pal?>" disabled="disabled">
										</div>
										<div class="span2">
											<button type="button" class="btn btn-primary" id="btnSaveIptc">Incluir Descritores</button>
										</div>	
									</div>
								</div>
<?php } ?>								
								<div class="form-actions2">

									<div class="controls clearfix">
<?php 
if($multiLoad) {
	foreach($id_fotos as $id_foto) { ?>
										<input type="hidden" name="id_fotos[]" value="<?php echo $id_foto?>"/>
<?php 	
	}										
} else { ?>
										<input type="hidden" name="id_fotos[]" value="<?php echo $row_dados_foto['Id_Foto']?>"/>
<?php } ?>										
										<button type="submit" name="action" value="gravar" class="btn btn-primary">Gravar</button>
										<a class="btn btn-danger confirmOnclick" href="indexacao.php?action=excluir&id_fotos[]=<?php echo $row_dados_foto['Id_Foto']?>">Excluir</a>
									</div>
								</div>
<?php } ?>								
							</form>
						</div>
					</div>
				</div>
			</div>


        <?php include('page_bottom.php'); ?>
      </div>
	</div>
	<!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
