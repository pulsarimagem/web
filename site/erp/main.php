<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_main.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

		<?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Dashboard</h1>
      </div>
      <div id="breadcrumb">
        <a href="#" title="Go to Home" class="tip-bottom current"><i class="icon-home"></i>Dashboard</a>
      </div>
      <div class="container-fluid">
        
        <div class="row-fluid">
          <div class="span12">
<!--           
            <div class="alert">
              Seja bem vindo ao seu novo <strong>painel administrativo</strong>.
              <a href="#" data-dismiss="alert" class="close">Ã—</a>
            </div>
            <div class="alert alert-success">
              Seja bem vindo ao seu novo <strong>painel administrativo</strong>.
              <a href="#" data-dismiss="alert" class="close">Ã—</a>
            </div>
            <div class="alert alert-info">
              Seja bem vindo ao seu novo <strong>painel administrativo</strong>.
              <a href="#" data-dismiss="alert" class="close">Ã—</a>
            </div>
            <div class="alert alert-error">
              Seja bem vindo ao seu novo <strong>painel administrativo</strong>.
              <a href="#" data-dismiss="alert" class="close">Ã—</a>
            </div>
 -->            
            <div class="widget-box">
              <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>Últimas vendas</h5></div>
              <div class="widget-content">
                <div class="row-fluid">
                  
                  <div class="span12">
<?php if ($totalRows_dwn1>0) { do { echo $row_dwn1['login']."/".$row_dwn1['empresa']."(".$row_dwn1['qtd'].")<br> ";} while ($row_dwn1 = mysql_fetch_assoc($dwn1)); }; ?>
                  </div>	
                </div>							
              </div>
            </div>					
          </div>
        </div>
        <div class="row-fluid">
          <div class="span6">
            <div class="widget-box">
              <div class="widget-title"><span class="icon"><i class="icon-file"></i></span><h5>Últimas imagens</h5><!-- <span title="54 imagens" class="label label-info tip-left">54</span> --></div>
              <div class="widget-content nopadding">
                <ul class="recent-posts">
<?php while($row_lastadd = mysql_fetch_array($lastadd)) { ?>                  
           		  <li>
                    <div class="user-thumb">
                      <img width="40" height="40" alt="User" src="<?php echo $urlThumbs.$row_lastadd['tombo']?>p.jpg">
                    </div>
                    <div class="article-post">
                       <span class="user-info"><?php echo $row_lastadd['Nome_Fotografo']?></span>
                      <p>
                        <a href="#"><?php echo $row_lastadd['assunto_principal']?></a>
                      </p>
<!--                       <a href="#" class="btn btn-primary btn-mini">Editar</a> <a href="#" class="btn btn-success btn-mini">Publicar</a> <a href="#" class="btn btn-danger btn-mini">Apagar</a> -->
                    </div>
                  </li>
<?php } ?>                  
<!--                   <li class="viewall">
                    <a title="Ver todos" class="tip-top" href="#"> + Ver todos + </a>
                  </li> -->
                </ul>
              </div>
            </div>
          </div>
          <div class="span6">
            <div class="widget-box">
              <div class="widget-title"><span class="icon"><i class="icon-comment"></i></span><h5>Indexações pendentes</h5><span title="<?php echo $num_pending?> pendentes" class="label label-info tip-left"><?php echo $num_pending?></span></div>
              <div class="widget-content nopadding">
                <ul class="recent-comments">
<?php while($row_pendings = mysql_fetch_array($pendings)) {?>
                  <li>
                    <div class="user-thumb">
                      <img width="40" height="40" alt="User" src="<?php echo $urlThumbs.$row_pendings['tombo']?>p.jpg">
                    </div>
                    <div class="comments">
                      <span class="user-info"><?php echo $row_pendings['Nome_Fotografo']?> (<?php echo $row_pendings['pending']?>)</span>
                      <p>
                        <a href="#"><?php echo $row_pendings['assunto_principal']?></a>
                      </p>
                      <a href="#" class="btn btn-primary btn-mini">Indexar</a><!--  <a href="#" class="btn btn-success btn-mini">Publicar</a> <a href="#" class="btn btn-danger btn-mini">Apagar</a> -->
                    </div>
                  </li>
<?php } ?>                  
                  <li class="viewall">
                    <a title="Ver todos" class="tip-top" href="#"> + Ver todos + </a>
                  </li>
                </ul>
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
