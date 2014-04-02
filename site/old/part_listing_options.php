<?php include ("tool_add_hidden.php")?>
<input name="preview" type="hidden" value=""/>
<!--<input name="preview" type="checkbox" onclick="listing_opts.submit();" value="preview" <?php if ($show_preview) echo "checked";?>/> <span>Preview |</span> --><input name="ajustar" type="hidden" value=""><input name="ajustar" type="checkbox" onclick="listing_opts.submit();" value="ajustar" <?php if (isset($_SESSION['ajustar'])) echo "checked";?>/> <span>Ajustar a tela | Exibir:</span> <?php include("tool_pageNum.php")?>
<?php add_hidden($startRow_retorno); ?>