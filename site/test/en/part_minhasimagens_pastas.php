<?php date_default_timezone_set('America/Sao_Paulo');
include("../tool_minhasimagens_pastas.php") ?>
<div class="minhasimagens">
  <h2 class="titulo-pagina">My Area</h2>
  <form name="form1" method="post" action="primeirapagina.php">
    <input type="hidden" name="opcao" value="">
    <input type="hidden" name="q_pasta" value="">

    <div class="wrapper-lista-pasta">

        <?php if ($has_msg) { ?>
        <div class="alert-message">
        <?php echo $msg; ?>
        </div>
      <?php } ?>
<?php if ($totalRows_pastas == 0) { ?>				
        <div class="error-msg">
          No folders saved
        </div>
<?php } else { ?>				
        <div class="minhasimages-pastas">
         
            <div class="subtitulo">
              My folders
            </div>
         
          
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
	            <thead>
  					<tr>
            			<td width="14"><input name="checkbox1" type="checkbox" value="checkbox" onClick="MM_callJS('checkAll(document.form1);')"/></td>
            			<td>&nbsp;</td>
<?php if($sort == "nome") { ?>
            			<td><a href="primeirapagina.php?ordem=nome<?php if(!$desc) echo "&rev=";?>">Name <span><?php if($desc)echo "&#9650;"; else echo "&#9660;";?><!-- A  &#9650; --></span></a></td>
<?php } else {?>
            			<td><a href="primeirapagina.php?ordem=nome">Name <span>&nbsp;</span></a></td>
<?php }
if($sort == "fotos") { ?>
            			<td><a href="primeirapagina.php?ordem=fotos<?php if(!$desc) echo "&rev=";?>">Files <span><?php if($desc)echo "&#9650;"; else echo "&#9660;";?></span></a></td>
<?php } else {?>
            			<td><a href="primeirapagina.php?ordem=fotos">Files <span>&nbsp;</span></a></td>
<?php }
if($sort == "criacao") { ?>
            			<td><a href="primeirapagina.php?ordem=datacriacao<?php if(!$desc) echo "&rev=";?>">Date of creation <span><?php if($desc)echo "&#9650;"; else echo "&#9660;";?></span></a></td>
<?php } else {?>
            			<td><a href="primeirapagina.php?ordem=datacriacao">Date of creation <span>&nbsp;</span></a></td>
<?php }
if($sort == "edicao") { ?>
			            <td><a href="primeirapagina.php?ordem=dataedicao<?php if(!$desc) echo "&rev=";?>">Last modified <span><?php if($desc)echo "&#9650;"; else echo "&#9660;";?></span></a></td>
<?php } else {?>
            			<td><a href="primeirapagina.php?ordem=dataedicao">Last modified <span>&nbsp;</span></a></td>
<?php } ?>
            		</tr>
            	</thead>
            	<tbody>
<?php do {?>
            		<tr>
            			<td class="check"><input name="chkbox[]" type="checkbox" value="<?php echo $row_pastas['id_pasta']; ?>" /></td>
            			<td class="image"><span><img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_pastas['tombo']; ?>p.jpg" title="<?php echo $row_pastas['tombo']; ?>" style="max-width:77px; max-height:77px;" /></span></td>
            			<td class="form">
<?php if($rename_id == $row_pastas['id_pasta']) {?>
            				<input name="rename" type="text" class="text" value="<?php echo $rename_name ?>"/>
            				<input name="rename_id" type="hidden" class="text" value="<?php echo $row_pastas['id_pasta']; ?>"/>
            				<input name="rename_action" type="submit" class="button" value="Ok" />
            				<input name="msgopcao" type="hidden" value="<?php echo $opcao; ?>"/>
<?php } else {?>
				            <a href="primeirapagina.php?id_pasta=<?php echo $row_pastas['id_pasta']; ?>"><?php echo $row_pastas['nome_pasta']; ?></a><?php }?>
	            		</td>
	            		<td><p align="center"><?php echo $row_pastas['num_fotos']; ?></p></td>
	            		<td><p align="center"><?php if ($row_pastas['data_cria'] <> "") echo date("d/m/Y", strtotime($row_pastas['data_cria'])); ?></p></td>
	            		<td><p align="center"><?php if ($row_pastas['data_mod'] <> "") echo date("d/m/Y", strtotime($row_pastas['data_mod'])); ?></p></td>
	            	</tr>
<?php } while ($row_pastas = mysql_fetch_assoc($pastas));
            /*								<tr class="select">
            <td class="check"><input name="" type="checkbox" value="" /></td>
            <td class="image"><span><img src="http://local.opg.co/dummyimage/77x52" width="77" height="52" /></span></td>
            <td class="form">
            <input name="" type="text" class="text" />
            <input name="" type="button" class="button" value="Ok" />
            </td>
            <td><p align="center">1</p></td>
            <td><p align="center">10/10/2010</p></td>
            <td><p align="center">10/10/2010</p></td>
            </tr><?Php */ ?>

            	</tbody>
            </table>
        </div>
<?php } ?>
<?php include("part_minhasimagens_botoes_home.php") ?>
      <div class="clear"></div>

    </div>
  </form>
</div>