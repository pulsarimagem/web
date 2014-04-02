<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Indexação > Imagens</title>
    <meta charset="UTF-8" />
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
            <form class="form-horizontal">
              
                <label class="radio inline">
                  <input type="radio" name="opcao" id="inlineCheckbox1" value="option1" /> Alterar
                </label>
                <label class="radio inline">
                  <input type="radio" name="opcao" id="inlineCheckbox2" value="option2" /> Incluir
                </label>
                
              <label class="select inline">
                <select>
                  <option>Selecione</option>
                </select>
              </label>
            </form>
          </div>
        </div>
        <div class="row-fluid">

          <div class="span12">
            <div class="widget-box-form">
              <div class="widget-title">
                <span class="icon"><i class="icon-remove"></i></span>
                <h5>Filtros</h5>
              </div>
              <div class="widget-content nopadding">
                <form action="#" method="post" class="form-horizontal">

                  <div class="control-group">
                    <label class="control-label">Tema</label>
                    <div class="controls clearfix">
                      <div class="span4">
                        <select data-placeholder="Tema">
                          <option value=""></option>
                          <option>First option</option>
                          <option>Second option</option>
                          <option>Third option</option>
                          <option>Fourth option</option>
                          <option>Fifth option</option>
                          <option>Sixth option</option>
                          <option>Seventh option</option>
                          <option>Eighth option</option>
                        </select>
                      </div>
                      <div class="span8">
                        <input type="text" placeholder="Palavras chaves " />
                      </div>
                    </div>
                  </div>
                  <div class="control-group">

                    <div class="controls-row">
                      <div class="controls clearfix">
                        <div class="span4">
                          <select data-placeholder="Autor">
                            <option value=""></option>
                            <option>First option</option>
                            <option>Second option</option>
                            <option>Third option</option>
                            <option>Fourth option</option>
                            <option>Fifth option</option>
                            <option>Sixth option</option>
                            <option>Seventh option</option>
                            <option>Eighth option</option>
                          </select>
                        </div>
                        <div class="span4">

                          <select data-placeholder="Estado">
                            <option value=""></option>
                            <option>First option</option>
                            <option>Second option</option>
                            <option>Third option</option>
                            <option>Fourth option</option>
                            <option>Fifth option</option>
                            <option>Sixth option</option>
                            <option>Seventh option</option>
                            <option>Eighth option</option>
                          </select>
                        </div>
                        <div class="span4">

                          <select data-placeholder="País">
                            <option value=""></option>
                            <option>First option</option>
                            <option>Second option</option>
                            <option>Third option</option>
                            <option>Fourth option</option>
                            <option>Fifth option</option>
                            <option>Sixth option</option>
                            <option>Seventh option</option>
                            <option>Eighth option</option>
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Assunto</label>
                    <div class="controls clearfix">
                      <div class="span6">
                        <input type="text" placeholder="Assunto principal " />
                      </div>
                      <div class="span6">
                        <input type="text" placeholder="Assunto secundário " />
                      </div>
                    </div>
                  </div>

                  <div class="form-actions2">

                    <div class="controls clearfix">
                      <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>


        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
