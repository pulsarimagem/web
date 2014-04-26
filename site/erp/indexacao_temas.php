<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_indexacao_temas.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Temas</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Temas</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Indexação</a>
        <a href="#" class="current">Temas</a>
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
          <div class="span9">
 <?php if(!$isEdit) { ?>          
            <button class="btn btn-success showNovo">Novo</button>
<?php } else {?>
            <a class="btn btn-success showNovo" href="indexacao_temas.php">Limpar</a>
<?php } ?>            
<!--             <a class="btn btn-danger " href="#">Excluir todos</a> -->
          </div>
          <div class="span3">
            <form>
              <input class="span12" name="busca" type="text" placeholder="Busca" />
            </form>
          </div>
        </div>
        <form>
          <div class="row-fluid novo" <?php if(!$isEdit) echo "style=\"display:none\""?>>
            <div class="span8">
              Tema Pai:
              <select class="span10" name="tema_pai" data-placeholder="--Escolha--">
               	<option value="0">-- Nenhum --</option>
<?php while ($rowTemas = mysql_fetch_assoc($rsTemas)) {?>            	
           		<option value="<?php echo $rowTemas['Id']?>" <?php echo (($isEdit&&$rowTemas['Id']==$rowEdit['Pai'])?"selected":"")?>><?php echo $rowTemas['Tema_total']?></option>
<?php } ?>            	
   	   	      </select>
            </div>
          </div>
          <div class="row-fluid novo" <?php if(!$isEdit) echo "style=\"display:none\""?>>
            <div class="span4">
              Tema: <input name="tema" type="text" placeholder="Tema" value="<?php echo ($isEdit?$rowEdit['Tema']:"")?>"/>
            </div>
            <div class="span4">
              Tema En: <input name="tema_en" type="text" placeholder="Tema En" value="<?php echo ($isEdit?$rowEdit['Tema_en']:"")?>"/>
            </div>
            <div class="span3">
<?php if($isEdit) { ?>            
              <button class="btn btn-success" name="action" type="submit" value="alterar">Alterar</button>
              <a class="btn btn-danger confirmOnclick" href="indexacao_temas.php?action=del&id_tema=<?php echo $rowEdit['Id']?>">Excluir</a>
              <input type="hidden" name="id_tema" value="<?php echo $rowEdit['Id']?>"/>
<?php } else { ?>              
              <button class="btn btn-success" name="action" type="submit" value="criar">Criar</button>
<?php } ?>              
            </div>
          </div>
        </form>
        <div class="row-fluid">
          <div class="span12">

            <table class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th><input type="checkbox" /></th>
                  <th colspan="2">Nível 1</th>
                  <th colspan="2">Nível 2</th>
                  <th colspan="2">Nível 3</th>
                  <th colspan="2">Nível 4</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
<?php 
mysql_select_db($database_pulsar, $pulsar);
$whereBusca = str_replace(",,", ",", $whereBusca);
$sqlRoot = "SELECT temas.Id, Tema, Tema_en, Tema_total, Tema_total_en FROM temas LEFT JOIN super_temas ON super_temas.Id = temas.Id WHERE $whereBusca Pai = 0 ORDER BY Tema";
// echo $sqlRoot;
$rsRoot = mysql_query($sqlRoot, $pulsar) or die(mysql_error());
while($rowRoot = mysql_fetch_array($rsRoot)) { 
?>
                  <tr>
                    <td><input type="checkbox" /></td>
                    <td><?php echo $rowRoot['Tema']?></td>
                    <td><?php echo $rowRoot['Tema_en']?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a class="btn btn-primary" href="indexacao_temas.php?action=edit&id_tema=<?php echo $rowRoot['Id']?>">Editar</a>&nbsp;<a class="btn btn-danger confirmOnclick" href="indexacao_temas.php?action=del&id_tema=<?php echo $rowRoot['Id']?>">Excluir</a>
                    </td>
                  </tr>
<?php 
	$sqlFirst = "SELECT temas.Id, Tema, Tema_en, Tema_total, Tema_total_en FROM temas LEFT JOIN super_temas ON super_temas.Id = temas.Id WHERE $whereBusca Pai = ".$rowRoot['Id']." ORDER BY Tema";
	$rsFirst = mysql_query($sqlFirst, $pulsar) or die(mysql_error());
	while($rowFirst = mysql_fetch_array($rsFirst)) { ?>
                  <tr>
                    <td><input type="checkbox" /></td>
                    <td><?php echo $rowRoot['Tema']?></td>
                    <td><?php echo $rowRoot['Tema_en']?></td>
                    <td><?php echo $rowFirst['Tema']?></td>
                    <td><?php echo $rowFirst['Tema_en']?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a class="btn btn-primary" href="indexacao_temas.php?action=edit&id_tema=<?php echo $rowFirst['Id']?>">Editar</a>&nbsp;<a class="btn btn-danger confirmOnclick" href="indexacao_temas.php?action=del&id_tema=<?php echo $rowFirst['Id']?>">Excluir</a>
                    </td>
                  </tr>
<?php 
		$sqlSecond = "SELECT temas.Id, Tema, Tema_en, Tema_total, Tema_total_en FROM temas LEFT JOIN super_temas ON super_temas.Id = temas.Id WHERE $whereBusca Pai = ".$rowFirst['Id']." ORDER BY Tema";
		$rsSecond = mysql_query($sqlSecond, $pulsar) or die(mysql_error());

		while($rowSecond = mysql_fetch_array($rsSecond)) { ?>
                  <tr>
                    <td><input type="checkbox" /></td>
                    <td><?php echo $rowRoot['Tema']?></td>
                    <td><?php echo $rowRoot['Tema_en']?></td>
                    <td><?php echo $rowFirst['Tema']?></td>
                    <td><?php echo $rowFirst['Tema_en']?></td>
                    <td><?php echo $rowSecond['Tema']?></td>
                    <td><?php echo $rowSecond['Tema_en']?></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a class="btn btn-primary" href="indexacao_temas.php?action=edit&id_tema=<?php echo $rowSecond['Id']?>">Editar</a>&nbsp;<a class="btn btn-danger confirmOnclick" href="indexacao_temas.php?action=del&id_tema=<?php echo $rowSecond['Id']?>">Excluir</a>
                    </td>
                  </tr>
<?php 
			$sqlThird = "SELECT temas.Id, Tema, Tema_en, Tema_total, Tema_total_en FROM temas LEFT JOIN super_temas ON super_temas.Id = temas.Id WHERE $whereBusca Pai = ".$rowSecond['Id']." ORDER BY Tema";
			$rsThird = mysql_query($sqlThird, $pulsar) or die(mysql_error());
			while($rowThird = mysql_fetch_array($rsThird)) { ?>
                  <tr>
                    <td><input type="checkbox" /></td>
                    <td><?php echo $rowRoot['Tema']?></td>
                    <td><?php echo $rowRoot['Tema_en']?></td>
                    <td><?php echo $rowFirst['Tema']?></td>
                    <td><?php echo $rowFirst['Tema_en']?></td>
                    <td><?php echo $rowSecond['Tema']?></td>
                    <td><?php echo $rowSecond['Tema_en']?></td>
                    <td><?php echo $rowThird['Tema']?></td>
                    <td><?php echo $rowThird['Tema_en']?></td>
                    <td>
                      <a class="btn btn-primary" href="indexacao_temas.php?action=edit&id_tema=<?php echo $rowThird['Id']?>">Editar</a>&nbsp;<a class="btn btn-danger confirmOnclick" href="indexacao_temas.php?action=del&id_tema=<?php echo $rowThird['Id']?>">Excluir</a>
                    </td>
                  </tr>
                  
<?php 
			}
		}
	}
} 
?>
              </tbody>
            </table>

<!--             <div class="pagination pagination-right"> -->
<!--               <ul> -->
<!--                 <li class="disabled"><a href="#">«</a></li> -->
<!--                 <li class="active"><a href="#">1</a></li> -->
<!--                 <li><a href="#">2</a></li> -->
<!--                 <li><a href="#">3</a></li> -->
<!--                 <li><a href="#">4</a></li> -->
<!--                 <li><a href="#">5</a></li> -->
<!--                 <li><a href="#">»</a></li> -->
<!--               </ul> -->
<!--             </div> -->

          </div>
        </div>


        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
