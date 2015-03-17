<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_indexacao_lote.php"); ?>
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
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Indexação</a>
        <a href="#" class="current">Imagens</a>
      </div>
      <div class="container-fluid">

        <div class="row-fluid">

          <div class="span12">
            <div class="widget-box-form">
              <div class="widget-title">
                <span class="icon"><i class="icon-remove"></i></span>
                <h5>Filtros</h5>
              </div>
              <div class="widget-content nopadding">
                <form method="get" class="form-horizontal">

                  <div class="control-group">
                    <label class="control-label">Tema</label>
                    <div class="controls clearfix">
                      <div class="span10">
						<select class="span10" name="tema" data-placeholder="-- Escolha o Tema --">
							<option value=""></option>
<?php
do {  
?>
		                  <option value="<?php echo $rowAllTemas['Id']?>" <?php if(isset($_GET['tema'])&&$_GET['tema']==$rowAllTemas['Id']) echo "selected"?>><?php echo $rowAllTemas['Tema_total']?></option>
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
                    <label class="control-label">Palavra-Chave</label>
                    <div class="controls clearfix">
                      <div class="span10">
						<input class="span10" type="hidden" name="descritores" id="indexDesc2" value="<?php if(isset($_GET['descritores'])) echo $_GET['descritores']?>">
                      </div>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <div class="controls-row">
                      <div class="controls clearfix">
                        <div class="span4">
							Autor
							<select name="autor[]" data-placeholder="-- Autor --">
								<option value=""></option>
<?php
do {  
?>
					            <option value="<?php echo $row_fotografos['id_fotografo']?>" <?php if(isset($_GET['autor'])&& in_array($row_fotografos['id_fotografo'],$_GET['autor'])) echo "selected"?>><?php echo $row_fotografos['Nome_Fotografo']?></option>
            <?php
} while ($row_fotografos = mysql_fetch_assoc($fotografos));
  $rows = mysql_num_rows($fotografos);
  if($rows > 0) {
      mysql_data_seek($fotografos, 0);
	  $row_fotografos = mysql_fetch_assoc($fotografos);
  }
?>
							</select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="control-group">
                    <div class="controls-row">
                      <div class="controls clearfix">
                        <div class="span4">
							Cidade
							<input name="cidade" type="text" placeholder="Cidade" value="<?php if(isset($_GET['cidade'])) echo $_GET['cidade'];?>" />
                        </div>
                        <div class="span4">
							Estado
							<select name="estado" data-placeholder="-- Estado --">
            					<option value=""></option>
<?php
do {  
?>
					            <option value="<?php echo $row_estado['Sigla']?>" <?php if(isset($_GET['estado'])&&$_GET['estado']==$row_estado['Sigla']) echo "selected"?>><?php echo $row_estado['Estado']?></option>
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
                        <div class="span4">
						Pais
							<select name="pais" data-placeholder="-- País --">
            					<option value=""></option>
<?php
do {  
?>
					            <option value="<?php echo $row_pais['id_pais']?>" <?php if(isset($_GET['pais'])&&$_GET['pais']==$row_pais['id_pais']) echo "selected"?>><?php echo $row_pais['nome']?></option>
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
                  </div>
                  <div class="control-group">
                    <label class="control-label">Assunto</label>
                    <div class="controls clearfix">
                      <div class="span6">
                        <input name="assunto_principal" type="text" placeholder="Assunto principal " value="<?php if(isset($_GET['assunto_principal'])) echo $_GET['assunto_principal'];?>" />
                      </div>
                    </div>
                  </div>
                      
                  <div class="control-group">
                    <label class="control-label">Assunto Extra</label>
                    <div class="controls clearfix">
                      <div class="span6">
                        <input name="extra" type="text" placeholder="Assunto secundário " value="<?php if(isset($_GET['extra'])) echo $_GET['extra'];?>" />
                      </div>
                    </div>
                  </div>

                  <div class="form-actions2">

                    <div class="controls clearfix">
                      <button name="action" value="pesquisar" type="submit" class="btn btn-primary">Pesquisar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
<?php if(isset($totalRows_retorno) && $totalRows_retorno > 0) { ?>        
        <div class="row-fluid">
          <div class="span12">
            <form name="form2" class="form-horizontal">


            
          <ul class="thumbnails lista-imagens">
          
<?php 
$tot_fotos = 1;
$count_fotos = $startRow_retorno;

while($row_retorno = mysql_fetch_assoc($retorno)) { 
?>       
          
  <li class="span2" style="width: 520px;">
    <div class="thumbnail" style="width: 512px;height: 265px">
    <div>
<?php if(isVideo($row_retorno['tombo'])) { ?>    
      <a href="indexacao.php?tombos[]=<?php echo $row_retorno['tombo']."&action=consultar"; ?>">
      <img src="<?php echo $cloud_server?>Videos/thumbs/<?php echo $row_retorno['tombo']; ?>_3s.jpg" alt="">
      </a>
<?php } else { ?>
      <a href="indexacao.php?tombos[]=<?php echo $row_retorno['tombo']."&action=consultar"; ?>">
      <img src="https://s3-sa-east-1.amazonaws.com/pulsar-media/fotos/previews/<?php echo $row_retorno['tombo']; ?>p.jpg" alt="">
      </a>
<?php } ?>      
	</div>
      <div class="clearfix">
    		  <span><input type="checkbox" class="checkbox" name="indexacao[]" value="<?php echo $row_retorno['Id_Foto']; ?>" checked="checked"><font style="font-weight: bold;">Codigo: </font><?php echo $row_retorno['tombo']; ?></span><br/>
	      	  <span><font style="font-weight: bold;">Assunto: </font><?php echo $row_retorno['assunto_principal']; ?></span><br/>
	      	  <span><font style="font-weight: bold;">Info Extra: </font><?php echo $row_retorno['extra']; ?></span><br/>
	      	  <span><font style="font-weight: bold;">Autor: </font><?php echo $row_retorno['Nome_Fotografo']; ?></span><br/>
	      	  <span><font style="font-weight: bold;">Data: </font><?php echo $row_retorno['data_foto']; ?></span><br/>
	      	  <span><font style="font-weight: bold;">Local: </font><?php echo $row_retorno['cidade']; ?>-<?php echo $row_retorno['Sigla']; ?>-<?php echo $row_retorno['nome']; ?></span><br/>
	      	  <span><font style="font-weight: bold;">Temas: </font><br/><?php
	      	  mysql_select_db($database_pulsar, $pulsar);
	      	  $query_temas = "SELECT Fotos.tombo, super_temas.Tema_total as Tema, super_temas.Id FROM super_temas INNER JOIN rel_fotos_temas ON (super_temas.Id=rel_fotos_temas.id_tema) INNER JOIN Fotos ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) WHERE (Fotos.tombo = '".$row_retorno['tombo']."')";
	      	  $temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
	      	  while ($row_temas = mysql_fetch_assoc($temas)) { echo $row_temas['Tema']."<br/>"; };
	      	  ?></span>
	      	  <span><font style="font-weight: bold;">PC: </font><br/><?php 
	      	  mysql_select_db($database_pulsar, $pulsar);
	      	  $query_palavras = " SELECT    pal_chave.Pal_Chave as Pal_Chave,   pal_chave.Id FROM  rel_fotos_pal_ch  INNER JOIN Fotos ON (rel_fotos_pal_ch.id_foto=Fotos.Id_Foto)  INNER JOIN pal_chave ON (pal_chave.Id=rel_fotos_pal_ch.id_palavra_chave) WHERE   (Fotos.tombo LIKE '".$row_retorno['tombo']."' AND Pal_Chave IS NOT NULL) GROUP BY Pal_Chave order by Pal_Chave";
	      	  $palavras = mysql_query($query_palavras, $pulsar) or die(mysql_error());
	      	  while ($row_palavras = mysql_fetch_assoc($palavras)) { echo $row_palavras['Pal_Chave']." | "; };
	      	  mysql_select_db($database_sig, $sig);
	      	  ?></span>
	    </div>
    </div>
  </li>
  
<?php } ?>  
  
</ul>            

            	<div class="widget-box-form">
					<div class="widget-title">
						<span class="icon"><i class="icon-align-justify"></i></span>
						<h5>Formulário</h5>
					</div>
					<div class="widget-content nopadding">
								<div class="control-group">
									<label class="control-label">Assunto principal</label>
									<div class="controls clearfix">
										<input type="text" name="assunto_principal" placeholder="-- Não mudar --"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Informação adicional</label>
									<div class="controls clearfix">
										<input type="text" name="extra" placeholder="-- Não mudar --"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Autor</label>
									<div class="controls clearfix">
										<select name="autor" data-placeholder="-- Não mudar --">
											<option value=""></option>
            <?php
do {  
?>
            <option value="<?php echo $row_fotografos['id_fotografo']?>"><?php echo $row_fotografos['Nome_Fotografo']?></option>
            <?php
} while ($row_fotografos = mysql_fetch_assoc($fotografos));
  $rows = mysql_num_rows($fotografos);
  if($rows > 0) {
      mysql_data_seek($fotografos, 0);
	  $row_fotografos = mysql_fetch_assoc($fotografos);
  }
?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Data</label>
									<div class="controls clearfix">
										<input name="data_tela" type="text" id="data_tela" onBlur="fix_data()" placeholder="-- Não mudar --">
										<input type="hidden" name="data" value=""/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Cidade</label>
									<div class="controls clearfix">
										<input type="text" name="cidade" placeholder="-- Não mudar --""/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Estado</label>
									<div class="controls clearfix">
										<select name="estado" data-placeholder="-- Não mudar --">
            <option value="" <?php if (!(strcmp("", $row_dados_foto['id_estado']))) {echo "SELECTED";} ?>></option>
            <?php
do {  
?>
            <option value="<?php echo $row_estado['id_estado']?>"><?php echo $row_estado['Estado']?></option>
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
										<select name="pais" data-placeholder="-- Não mudar --">
            <option value="" <?php if (!(strcmp("", $row_dados_foto['id_pais']))) {echo "SELECTED";} ?>></option>
            <?php
do {  
?>
            <option value="<?php echo $row_pais['id_pais']?>"><?php echo $row_pais['nome']?></option>
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
								<div class="control-group">
									<label class="control-label">Incluir Temas</label>
									<div class="controls clearfix">
										<div class="span8">
											<select class="span12" name="incTemas[]" multiple data-placeholder="-- Não mudar --">
												<option value=""></option>
<?php
do {  
?>
                  <option value="<?php echo $rowAllTemas['Id']?>"><?php echo $rowAllTemas['Tema_total']?></option>
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
									<label class="control-label">Excluir Temas</label>
									<div class="controls clearfix">
										<div class="span8">
											<select class="span12" name="excTemas[]" multiple data-placeholder="-- Não mudar --">
												<option value=""></option>
<?php
do {  
?>
                  <option value="<?php echo $rowAllTemas['Id']?>"><?php echo $rowAllTemas['Tema_total']?></option>
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
									<label class="control-label">Incluir Descritores</label>
									<div class="controls clearfix">
										<div class="span8">
											<input class="span12 indexDesc" type="hidden" name="incDescritores" placeholder="-- Não mudar --">
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Excluir Descritores</label>
									<div class="controls clearfix">
										<div class="span8">
											<input class="span12 indexDesc" type="hidden" name="excDescritores" placeholder="-- Não mudar --">
										</div>
									</div>
								</div>			
				                <div class="form-actions2">
									<div class="controls clearfix">
										<button name="action" value="indexar" type="submit" class="btn btn-primary">Alterar</button>
                    				</div>
								</div>													
					</div>
				</div>
					
            </form>
          </div>
        </div>
<?php 
	$tot_fotos++;
	$count_fotos++;
} 
?>
        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
