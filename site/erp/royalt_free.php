<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_royalt_free.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Mineraçao de Dados > Royalt Free</title>
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
        <a href="#">Mineração</a>
        <a href="#" class="current">Royalt Free</a>
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
                    <label class="control-label">Temas Excluidos</label>
                    <div class="controls clearfix">
                      <div class="span4">
						<select class="span12" name="id_temas_ex[]" multiple data-placeholder="-- Escolha o Tema --">
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
					<label class="control-label">Autores Excluidos</label>
                    <div class="controls-row">
                      <div class="controls clearfix">
                        <div class="span4">
                        
										<select name="id_autores_ex[]" multiple data-placeholder="-- Autor --">
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
                  </div>
                  <div class="control-group">
                    <label class="control-label">Idade</label>
                    <div class="controls clearfix">
                      <div class="span2">
                        Mais que
                      </div>
                      <div class="span2">
                        <input name="idade" type="text" value="<?php echo isset($_GET['idade'])?$_GET['idade']:""?>" placeholder="Idade" />
                      </div>
                      <div class="span2">
                        anos
                      </div>
                      
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Indice de vendas</label>
                    <div class="controls clearfix">
                      <div class="span2">
                        Menos que
                      </div>
                      <div class="span2">
                        <input name="indice_vendas" type="text" value="<?php echo isset($_GET['indice_vendas'])?$_GET['indice_vendas']:""?>" placeholder="Vendas" />
                      </div>
                      <div class="span3">
                        vendas dos últimos
                      </div>
                      <div class="span2">
                        <input name="indice_anos" type="text" value="<?php echo isset($_GET['indice_anos'])?$_GET['indice_anos']:""?>" placeholder="Anos" />
                      </div>
                      <div class="span2">
                        anos
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
			<div class="nnav">
				<?php echo $startRow_retorno?> de <?php echo $totalRows_retorno ?> imagem(ns) 
			</div>
<?php 
echo $nav_bar[0];
echo $nav_bar[1];
echo $nav_bar[2];
echo "<div class=\"clear\"></div>";
?>			      
        <div class="row-fluid">
          <div class="span12">
            <form name="form2" class="form-horizontal">


            
          <ul class="thumbnails lista-imagens">
          
<?php 
$tot_fotos = 1;
$count_fotos = $startRow_retorno;

while($row_retorno = mysql_fetch_assoc($retorno)) { 
?>       
          
  <li class="span2">
    <input type="checkbox" class="checkbox" name="indexacao[]" value="<?php echo $row_retorno['Id_Foto']; ?>" checked="checked">
    <div class="thumbnail" style="width: 152px;height: 165px">
<?php if(isVideo($row_retorno['tombo'])) { ?>    
      <a href="../br/details.php?tombo=<?php echo $row_retorno['tombo']; ?>">
      <img src="<?php echo $cloud_server?>Videos/thumbs/<?php echo $row_retorno['tombo']; ?>_3s.jpg" alt="">
      </a>
<?php } else { ?>
      <a href="../br/details.php?tombo=<?php echo $row_retorno['tombo']; ?>">
      <img src="<?php echo "http://www.pulsarimagens.com.br/"//$homeurl?>bancoImagens/<?php echo $row_retorno['tombo']; ?>p.jpg" alt="">
      </a>
<?php } ?>      
      <div class="clearfix">
	      <h4><?php echo $row_retorno['tombo']; ?></h4>
	      <div class="bt-zoom">
		      <a class="icon icon-zoom-in" href="#" alt="visualizar"></a>
		  </div>
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
