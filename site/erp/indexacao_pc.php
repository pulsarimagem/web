<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_indexacao_pc.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Palavras-chave</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Palavras-chave</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Indexação</a>
        <a href="#" class="current">Palavras-chave</a>
      </div>
      <div class="container-fluid">

        <div class="row-fluid">
          <div class="span6">

            <a class="btn btn-success showNovo" >Novo</a>
            <a class="btn btn-warning" href="indexacao_pc.php?todas_total=true">Relação PC</a>
<!--             <a class="btn btn-danger " href="#">Excluir todos</a> -->
<!--             <a class="btn btn-primary " href="#">Exportar lista</a> -->

          </div>
          <div class="span3">
            <form>
              <input class="span12" name="busca" type="text" placeholder="Busca" />
            </form>
          </div>
          <div class="span3">
            <form>
              <input class="span12" name="fracao" type="text" placeholder="Busca Fração" />
            </form>
          </div>
        </div>
        <form>
        <div class="row-fluid novo" <?php if (!$isEdit) { ?> style="display:none" <?php } ?>>
          <div class="span3">
            <input class="span12" name="pc" type="text" value="<?php echo ($isEdit?$row['Pal_Chave']:"") ?>" placeholder="Palavra-chave" />
          </div>
          <div class="span3">
            <input class="span12" name="pcEn" type="text" value="<?php echo ($isEdit?$row['Pal_Chave_en']:"") ?>" placeholder="Palavra-chave En" />
          </div>
          <div class="span3">
<?php if ($isEdit) { ?>
			<input name="pcId" type="hidden" value="<?php echo $pcid?>"/>          
            <button class="btn btn-success" name="action" type="submit" value="alterar">Salvar</button>
<?php } else { ?>
            <button class="btn btn-success" name="action" type="submit" value="criar">Criar</button>
<?php } ?>            
          </div>
        </div>
        </form>
        <div class="row-fluid">
          <div class="span12">        
			<table class="table table-bordered table-striped">
			  <tr>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=0-9">0-9</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=a%E1%E0%E2">A</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=b">B</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=c">C</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=d">D</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=e%E9%EA">E</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=f">F</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=g">G</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=h">H</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=i%ED">I</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=j">J</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=k">K</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=l">L</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=m">M</a></div></td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=n">N</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=o%F3%F4">O</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=p">P</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=q">Q</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=r">R</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=s">S</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=t">T</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=u%FC">U</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=v">V</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=w">W</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=x">X</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=y">Y</a></div></td>
			    <td><div align="center"><a href="indexacao_pc.php?inicial=z">Z</a></div></td>
			  </tr>
			</table>
		  </div>
		</div>
<?php if($isShow) { ?>		
        <div class="row-fluid">
          <div class="span12">
<?php if(!$isTotal) { ?>
                <table class="table table-bordered table-striped with-check">
<?php } else { ?>
                <table>
<?php } ?>
                  <thead>
                    <tr>
<?php if(!$isTotal) { ?>
                      <th><input type="checkbox" /></th>
<?php } ?>
                      <th>Português</th>
<?php if(!$isTotal) { ?>
                      <th>Inglês</th> 
<?php } ?>
                      <th>Ocorrências</th>
<?php if(!$isTotal) { ?>
                      <th>Ações</th>
<?php } ?>
                    </tr>
                  </thead>
                  <tbody>
<?php while ($row_palavra_chave = mysql_fetch_assoc($palavra_chave)) { ?>
                      <tr>
<?php if(!$isTotal) { ?>
                        <td><input type="checkbox" /></td>
<?php } ?>                        
                        <td><a href="../br/listing.php?so_pc=<?php echo $row_palavra_chave['Pal_Chave']; ?>&pc_action=Ir&type=pc&tipo=inc_pc.php&pc_action=Ir" target="_blank"><?php echo $row_palavra_chave['Pal_Chave']; ?></a></td>
<?php if(!$isTotal) { ?>
                        <td><a href="../en/listing.php?so_pc=<?php echo $row_palavra_chave['Pal_Chave_en']; ?>&pc_action=Ir&type=pc&tipo=inc_pc.php&pc_action=Ir" target="_blank"><?php echo $row_palavra_chave['Pal_Chave_en']; ?></a></td>
<?php } ?>
                        <td><?php echo $row_palavra_chave['total'];?></td>
<?php if(!$isTotal) { ?>
                        <td>
                          <a class="btn btn-primary" href="indexacao_pc.php?action=edit&pcid=<?php echo $row_palavra_chave['Id']?>">Editar</a>&nbsp;<a class="btn btn-danger confirmOnclick" href="indexacao_pc.php?action=del&pcid=<?php echo $row_palavra_chave['Id']?>">Excluir</a>&nbsp;<!-- <a class="btn btn-success" href="#">Copiar</a> -->
                        </td>
<?php } ?>
                      </tr>
<?php } ?>
                  </tbody>
                </table>
<!-- <table width="600" border="0" cellspacing="0" cellpadding="0"> -->
<!--   <tr> -->
<!--     <td> -->
<!-- 		<span class="style4"> -->
<?php 
// # variable declaration
// $prev_palavra_chave = "<< anterior ";
// $next_palavra_chave = " pr&oacute;xima >>";
// $separator = " | ";
// $max_links = 30;
// $pages_navigation_palavra_chave = buildNavigation($pageNum_palavra_chave,$totalPages_palavra_chave,$prev_palavra_chave,$next_palavra_chave,$separator,$max_links,false); 

// print $pages_navigation_palavra_chave[0]; 
// ?>
<?php //print $pages_navigation_palavra_chave[1]; ?> <?php //print $pages_navigation_palavra_chave[2]; ?>
<!-- 		</span> -->
<!-- 	</td> -->
<!--   </tr> -->
<!-- </table> -->
<?php if(!$isTotal) { ?>
            <div class="pagination pagination-right">
                  <ul>
<?php 
# variable declaration
$prev_palavra_chave = "«";
$next_palavra_chave = "»";
$separator = "";
// $separator = " | ";
$max_links = 10;
// $max_links = 30;
$pages_navigation_palavra_chave = buildNavigation3($pageNum_palavra_chave,$totalPages_palavra_chave,$prev_palavra_chave,$next_palavra_chave,$separator,$max_links,true); 

print $pages_navigation_palavra_chave[0]; 
print $pages_navigation_palavra_chave[1]; 
print $pages_navigation_palavra_chave[2]; 
?>
                  </ul>
                </div>
<?php } ?>

<!-- 		         <div class="pagination pagination-right"> -->
<!--         	       <ul> -->
<!-- 					 <li class="disabled"><a href="#">«</a></li> -->
<!--                     <li class="active"><a href="#">1</a></li> -->
<!--                     <li><a href="#">2</a></li> -->
<!--                     <li><a href="#">3</a></li> -->
<!--                     <li><a href="#">4</a></li> -->
<!--                     <li><a href="#">5</a></li> -->
<!--                     <li><a href="#">»</a></li> -->
<!--                   </ul> -->
<!--                 </div> -->

          </div>
        </div>
<?php } ?>

        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
