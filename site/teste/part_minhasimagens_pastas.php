<?php date_default_timezone_set('America/Sao_Paulo');
include("tool_minhasimagens_pastas.php") ?>
<div class="minhasimagens">
  <h2 class="titulo-pagina">Minha Conta</h2>
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
          Voc� n�o adicionou nenhuma imagem ou pasta
        </div>
<?php }
else { ?>				
        <div class="minhasimages-pastas">
          <div class="palheta-top">
            <div class="top-pasta block">
              Minhas Pastas / {Nome da Pasta}
            </div>
            <div class="clear"></div>
          </div>
          <table class="pasta-lista">
            <tbody>
              <tr>
                <td style="border:none;" class="chekbox-pasta" colspan="4"><input name="checkboxAll" type="checkbox" value=""/></td>
              </tr>
              <tr>
                <td width="14"><input name="checkbox1" type="checkbox" value="checkbox" onClick="MM_callJS('checkAll(document.form1);')"/></td>
                <td>
                  <div class="imagem">
                    <img src="<?php echo "http://www.pulsarimagens.com.br/"; //$homeurl;  ?>bancoImagens/<?php echo $row_pastas['tombo']; ?>p.jpg" title="<?php echo $row_pastas['tombo']; ?>" />
                  </div>
                  <div class="descricao">
                    <ul>
                      <li class="autor"><span class="label">Autor:</span> Andr� Seale</li>
                      <li class="codigo"><span class="label">C�digo:</span> 26AS205</li>
                      <li class="assunto"><span class="label">Assunto:</span> Assunto aqui</li>
                    </ul>
                  </div>
                </td>
                <td width="14">
                  <a href="#" class=""><img src="images/icon-zoom.png" border="0" /></a>
                </td>
              </tr>
            </tbody>
          </table>
          

          <?php /* ?><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
            <td width="14"><input name="checkbox1" type="checkbox" value="checkbox" onClick="MM_callJS('checkAll(document.form1);')"/></td>
            <td width="83">&nbsp;</td>
            <?php if($sort == "nome") { ?>
            <td><a href="primeirapagina.php?ordem=nome<?php if(!$desc) echo "&rev=";?>">Nome da Pasta <span><?php if($desc)echo "&#9650;"; else echo "&#9660;";?><!-- A  &#9650; --></span></a></td>
            <?php } else {?>
            <td><a href="primeirapagina.php?ordem=nome">Nome da Pasta <span>&nbsp;</span></a></td>
            <?php }
            if($sort == "fotos") { ?>
            <td><a href="primeirapagina.php?ordem=fotos<?php if(!$desc) echo "&rev=";?>">Fotos <span><?php if($desc)echo "&#9650;"; else echo "&#9660;";?></span></a></td>
            <?php } else {?>
            <td><a href="primeirapagina.php?ordem=fotos">Fotos <span>&nbsp;</span></a></td>
            <?php }
            if($sort == "criacao") { ?>
            <td><a href="primeirapagina.php?ordem=datacriacao<?php if(!$desc) echo "&rev=";?>">Data de Cria��o <span><?php if($desc)echo "&#9650;"; else echo "&#9660;";?></span></a></td>
            <?php } else {?>
            <td><a href="primeirapagina.php?ordem=datacriacao">Data de Cria��o <span>&nbsp;</span></a></td>
            <?php }
            if($sort == "edicao") { ?>
            <td><a href="primeirapagina.php?ordem=dataedicao<?php if(!$desc) echo "&rev=";?>">�ltima Edi��o <span><?php if($desc)echo "&#9650;"; else echo "&#9660;";?></span></a></td>
            <?php } else {?>
            <td><a href="primeirapagina.php?ordem=dataedicao">�ltima Edi��o <span>&nbsp;</span></a></td>
            <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php do {?>
            <tr>
            <td class="check"><input name="chkbox[]" type="checkbox" value="<?php echo $row_pastas['id_pasta']; ?>" /></td>
            <?php if ($row_pastas['tombo'] != "") {?>
            <td class="image"><span><img src="<?php echo "http://www.pulsarimagens.com.br/";//$homeurl; ?>bancoImagens/<?php echo $row_pastas['tombo']; ?>p.jpg" title="<?php echo $row_pastas['tombo']; ?>" style="max-width:77px; max-height:77px;" /></span></td>
            <?php } else {?>
            <td class="image"><span></span></td>
            <?php } ?>
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
            </tr>

            </tbody>
            </table><?php */ ?>
        </div>
<?php } ?>
<?php include("part_minhasimagens_botoes_pastas.php") ?>
      <div class="clear"></div>

    </div>
  </form>
</div>