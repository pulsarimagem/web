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
							<form method="get" class="form-horizontal">
								<div class="control-group">
									<label class="control-label">Pré Indexação Fotos</label>
									<div class="controls clearfix">
										<div class="span3">
										 	<select name="autor" id="indexSelectAutorFotos">
										   		<option>Escolha Autor</option>
<?php while ($row_autor_fotos_tmp_select = mysql_fetch_assoc($autor_fotos_tmp_select)){ ?>
										   		<option value="<?php echo $row_autor_fotos_tmp_select['id_autor'];?>" <?php if($row_autor_fotos_tmp_select['id_autor'] == $id_autor) echo " SELECTED"?>><?php echo $row_autor_fotos_tmp_select['nome'];?> [<?php echo $row_autor_fotos_tmp_select['total'];?> foto(s)]</option>
<?php } ?>
										   	</select>
										</div>		
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"></label>
									<div class="controls clearfix">
										<div class="indexSelectFotos span3" <?php if($id_autor=="") echo "style=\"display:none\""?>>
										   	<select name="tombos[]" id="indexSelectFotos" class="notChosen do_submit">
									   			<option value="nada">--- Tombo ---</option>
<?php while ($row_fotos_tmp_select = mysql_fetch_assoc($fotos_tmp_select)){ ?>
									   			<option value="<?php echo $row_fotos_tmp_select['tombo'];?>"><?php echo $row_fotos_tmp_select['tombo'];?></option>
<?php } ?>
									   		</select>
										</div>
										<div class="indexSelectFotos span4" <?php if($id_autor=="") echo "style=\"display:none\""?>>
											<input type="hidden" name="fotoTmp" value="true"/>
											<button type="submit" name="action" value="consultar" class="btn btn-primary do_button">Consultar</button>
										</div>
									</div>
								</div>
							</form>		
							<form method="get" class="form-horizontal">
								<div class="control-group">
									<label class="control-label">Pré Indexação Vídeos</label>
									<div class="controls clearfix">
										<div class="span3">
										 	<select name="autor" id="indexSelectAutorVideos">
										   		<option>Escolha Autor</option>
<?php while ($row_autor_videos_tmp_select = mysql_fetch_assoc($autor_videos_tmp_select)){ ?>
										   		<option value="<?php echo $row_autor_videos_tmp_select['id_autor'];?>" <?php if($row_autor_videos_tmp_select['id_autor'] == $id_autor) echo " SELECTED"?>><?php echo $row_autor_videos_tmp_select['nome'];?> [<?php echo $row_autor_videos_tmp_select['total'];?> Video(s)]</option>
<?php } ?>
										   	</select>
										</div>		
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"></label>
									<div class="controls clearfix">																				
										<div class="indexSelectVideos span3" <?php if($id_autor=="") echo "style=\"display:none\""?>>
										   <select name="tombos[]" id="indexSelectVideos" class="notChosen do_submit">
										   		<option value="nada">--- Tombo ---</option>
<?php while ($row_videos_tmp_select = mysql_fetch_assoc($videos_tmp_select)){ ?>
										   		<option value="<?php echo $row_videos_tmp_select['tombo'];?>"><?php echo $row_videos_tmp_select['tombo'];?></option>
<?php } ?>
										   </select>
										</div>
										<div class="indexSelectVideos span4" <?php if($id_autor=="") echo "style=\"display:none\""?>>
											<input type="hidden" name="fotoTmp" value="true"/>
											<button type="submit" name="action" value="consultar" class="btn btn-primary do_button">Consultar</button>
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
											<div class="span12">
<?php foreach($tombos as $tombo) { ?>											
												<img src="https://s3-sa-east-1.amazonaws.com/pulsar-media/fotos/previews/<?php echo $tombo?>.jpg" onclick="MM_openBrWindow('https://s3-sa-east-1.amazonaws.com/pulsar-media/fotos/previews/<?php echo $tombo?>.jpg','','resizable=yes,width=550,height=550')"/>
<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"></label>
									<div class="controls">
										<div class="row-fluid">
											<div class="span12">
<?php if(file_exists($orig)) { ?>											
												<IFRAME ID=IFrame1 FRAMEBORDER=0 SCROLLING=YES SRC="iptc.php?foto=<?php echo $form_tombo; ?>"></IFRAME>
<?php } ?>
											</div>
<?php } else { ?>
											<div class="span4">
<?php 	foreach ($thumbs as $thumb) {?>	           	
	     							          	<img src="<?php echo $cloud_server?>Videos/thumbs/<?php echo $thumb?>" onclick="MM_openBrWindow('playervideo.php?tombo=<?php echo $form_tombo; ?>','','resizable=yes,width=640,height=400')"/>
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
										<button type="button" class="btn btn-primary" onclick="window.open('<?php //echo $homeurl ?>./toolkit/Example.php?jpeg_fname=<?php echo $colname_dados_foto?>','','scrollbars=yes,resizable=yes,width=600,height=800')">Extra IPTC</button>
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
										<input type="text" name="tombo" value="<?php echo ($toLoad?$form_tombo:"");?>" disabled="disabled"/>
										<input type="hidden" name="tombo" value="<?php echo ($toLoad?$form_tombo:"");?>"/>
<?php }?>						
									</div>
								</div>
<?php if($isFotoTmp && isVideo($colname_dados_foto)) { ?>								
								<div class="control-group">
									<label class="control-label">Nome do Arquivo</label>
									<div class="controls clearfix">
										<input type="text" name="filename_video" value="<?php echo $form_filename;?>" disabled="disabled"/>
									</div>
								</div>
<?php } ?>																
								<div class="control-group">
									<label class="control-label">Copiar dados</label>
									<div class="controls clearfix">
										<input type="text" name="copy_tombo" id="copy_tombo" value="" style="width: 250px"/>
										<input type="hidden" name="copy_url" id="copy_url" value="<?php echo $_SERVER['REQUEST_URI'];?>"/>
										<button type="submit" name="action" value="copy_btn" class="btn btn-primary">Copiar</button>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Assunto principal</label>
									<div class="controls clearfix">
										<input type="text" name="assunto_principal" id="assunto_principal" value="<?php echo (isset($_GET['assunto_principal'])?$_GET['assunto_principal']:($toLoad?($form_assunto==""?$iptc_assunto:$form_assunto):""));?>"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Informação adicional</label>
									<div class="controls clearfix">
										<input type="text" name="extra" value="<?php echo (isset($_GET['extra'])?$_GET['extra']:($toLoad?$form_extra:""));?>"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Direito de imagem</label>
									<div class="controls">
										<div class="span6">
											<label style="display: inline;"><input type="radio" name="dir_img" value="0" <?php echo ($form_dirimg%10 != 1 && $form_dirimg%10 != 2 && $form_dirimg%10 != 3? "checked":"");?>></label><label style="display: inline;">Nenhum</label><br/>
											<label style="display: inline;"><input type="radio" name="dir_img" value="1" <?php echo ($form_dirimg%10 == 1 ? "checked":"");?>></label><label style="display: inline;">Uso autorizado</label> <br/>
											<label style="display: inline;"><input type="radio" name="dir_img" value="2" <?php echo ($form_dirimg%10 == 2 ? "checked":"");?>></label><label style="display: inline;">Uso autorizado + Acrécimo de 100%</label><br/>
<!-- 											<label><input type="radio" name="dir_img" value="3" <?php echo ($form_dirimg%10 == 3 ? "checked":"");?>> Não autorizado</label> -->
										</div>
									</div>
								</div>
<!-- 								<div class="control-group" style="display:none">
									<label class="control-label">Direito de propriedade</label>
									<div class="controls">
										<div class="span6">
											<label><input type="radio" name="dir_prop" value="0" <?php echo (intval($form_dirimg/10) != 1 && $form_dirimg/10 != 2 ? "checked":"");?>> Nenhum</label> 
											<label><input type="radio" name="dir_prop" value="10" <?php echo (intval($form_dirimg/10) == 1 ? "checked":"");?>> Autorizado</label> 
											<label><input type="radio" name="dir_prop" value="20" <?php echo (intval($form_dirimg/10) == 2 ? "checked":"");?>> Não autorizado</label>
										</div>
									</div>
								</div> -->
								<div class="control-group">
									<label class="control-label">Autor</label>
									<div class="controls clearfix">
										<select name="autor" data-placeholder=" - - - - - Escolha - - - - - " <?php if ($autor_encontrado) { ?>disabled="disabled" <?php } ?>>
											<option value=""></option>
            <?php
do {  
?>
            <option value="<?php echo $row_fotografos['id_fotografo']?>"<?php if (!(strcmp($row_fotografos['id_fotografo'], $form_autor))) {echo "SELECTED";}?>><?php echo $row_fotografos['Nome_Fotografo']?></option>
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
			<input name="autor" type="hidden" value="<?php echo ($form_autor); ?>"/>
<?php } ?>											
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Data</label>
									<div class="controls clearfix">
										<input name="data_tela" type="text" id="data_tela" onBlur="fix_data()" value="<?php if(isset($_GET['data_tela'])) { echo $_GET['data_tela']; } else if($toLoad) { if($form_data=="") { echo $iptc_data; } else { if (strlen($form_data) == 4) {
			echo $form_data;
		} elseif (strlen($form_data) == 6) {
			echo substr($form_data,4,2).'/'.substr($form_data,0,4);
		} elseif (strlen($form_data) == 8) {
			echo substr($form_data,6,2).'/'.substr($form_data,4,2).'/'.substr($form_data,0,4);
		}}} ?>">
										<input type="hidden" name="data" value="<?php echo ($toLoad?($form_data==""?fix_iptc_date($iptc_data):$form_data):"");?>"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Cidade</label>
									<div class="controls clearfix">
										<input class="span5" type="hidden" name="cidade" id="indexCidade" value="<?php echo (isset($_GET['cidade'])?$_GET['cidade']:($toLoad?($form_cidade==""?$iptc_local:$form_cidade):""));?>">
<!-- 										<input type="text" name="cidade" value="<?php echo ($toLoad?$form_cidade:"");?>"/> -->
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Estado</label>
									<div class="controls clearfix">
										<select name="estado" data-placeholder=" - - - - - Escolha - - - - - ">
            <option value="" <?php if (!(strcmp("", $form_estado)) && $iptc_estado == "") {echo "SELECTED";} ?>></option>
            <option value>Nenhum</option>
            <?php
do {  
?>
            <option value="<?php echo $row_estado['id_estado']?>"<?php if (isset($_GET['estado'])) { if(!(strcmp($row_estado['id_estado'], $_GET['estado']))) {echo "SELECTED";} } else if (!(strcmp($row_estado['id_estado'], $form_estado)) || !(strcasecmp($row_estado['Sigla'], $iptc_estado))) {echo "SELECTED";} ?>><?php echo $row_estado['Estado']?></option>
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
            <option value="" <?php if (!(strcmp("", $form_pais)) && $iptc_pais == "") {echo "SELECTED";} ?>></option>
            <option value>Nenhum</option>
            <?php
do {  
?>
            <option value="<?php echo $row_pais['id_pais']?>"<?php if (isset($_GET['pais'])) { if(!(strcmp($row_pais['id_pais'], $_GET['pais']))) {echo "SELECTED";} } else if (!(strcmp($row_pais['id_pais'], $form_pais)) || !(strcasecmp(removeAccents($row_pais['nome']), removeAccents($iptc_pais)))) {echo "SELECTED";} ?>><?php echo $row_pais['nome']?></option>
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
								<div class="control-group">
									<label class="control-label">Copiar temas e descritores</label>
									<div class="controls clearfix">
										<input type="text" name="copy_desc" id="copy_desc" value="" style="width: 250px"/>
										<input type="hidden" name="copy_url" id="copy_url" value="<?php echo $_SERVER['REQUEST_URI'];?>"/>
										<button type="submit" name="action" value="copy_desc_btn" class="btn btn-primary">Copiar</button>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Descritores Inline</label>
									<div class="controls clearfix">
										<div class="span8">
											<input type="text" name="descritores_inline" value="">
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
<?php if($isFotoTmp) { ?>
											<button type="submit" name="action" value="copy_iptc_btn" class="btn btn-primary">Incluir Descritores</button>
											<input type="hidden" name="iptcPal" value="<?php echo $iptc_pal?>">
<?php } else { ?>
											<button type="button" class="btn btn-primary" id="btnSaveIptc">Incluir Descritores</button>
<?php } ?>
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
										<input type="hidden" name="id_fotos[]" value="<?php echo $idFoto?>"/>
<?php } ?>										
<?php if($isFotoTmp) { ?>
										<input type="hidden" name="deleteVideoTmp" value="true"/>
<?php } ?>
										<button type="submit" name="action" value="gravar" class="btn btn-primary">Gravar</button>
										<a class="btn btn-danger confirmOnclick" href="indexacao.php?action=excluir&id_fotos[]=<?php echo $idFoto?>">Excluir</a>
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
