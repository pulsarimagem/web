<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_pauta.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Pauta Clientes</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Clientes</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#" class="current">Pauta Autores</a>
      </div>
      <div class="container-fluid">

        <div class="row-fluid">
          <div class="span12">

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Temas</th>
                  <th>Quantidade Pesquisas</th>
                </tr>
              </thead>
              <tbody>
<?php while($rowTemas = mysql_fetch_assoc($rsTemas)) { ?>              
                  <tr>
                    <td><?php echo $rowTemas['tema']?></td>
                    <td><?php echo $rowTemas['qty']?></td>
                  </tr>
<?php } ?>                  
              </tbody>
            </table>

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Palavra-Chave</th>
                  <th>Quantidade Pesquisas</th>
                </tr>
              </thead>
              <tbody>
<?php while($rowPCPesq = mysql_fetch_assoc($rsPCPesq)) { ?>              
                  <tr>
                    <td><?php echo $rowPCPesq['palavra']?></td>
                    <td><?php echo $rowPCPesq['qty']?></td>                    
                  </tr>
<?php } ?>                  
              </tbody>
            </table>
            
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Foto</th>
                  <th>Visualizações</th>
                </tr>
              </thead>
              <tbody>
<?php while($rowFotos = mysql_fetch_assoc($rsFotos)) { ?>                            
                  <tr>
                    <td><a href="http://www.pulsarimagens.com.br/br/details.php?tombo=<?php echo $rowFotos['tombo']?>" target="_blank"><?php echo $rowFotos['tombo']?></a></td>
                    <td><?php echo $rowFotos['qty']?></td>                                                            
                  </tr>
<?php } ?>                  
              </tbody>
            </table>
            
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Palavra-Chave</th>
                  <th>Retorno</th>
                  <th>Quantidade Pesquisas</th>
                </tr>
              </thead>
              <tbody>
<?php while($rowPCRetorno = mysql_fetch_assoc($rsPCRetorno)) { ?>                            
                  <tr>
                    <td><?php echo $rowPCRetorno['palavra']?></td>
                    <td><?php echo $rowPCRetorno['retorno']?></td>                                        
                    <td><?php echo $rowPCRetorno['qty']?></td>                                        
                  </tr>
<?php } ?>                  
              </tbody>
            </table>

          </div>
        </div>


        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
