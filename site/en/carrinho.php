<?php 
include('Connections/pulsar.php');
include('../tool_auth.php');
include('ecommerce/carrinho.class.php');
$carrinho = new Carrinho();
$carrinho->lingua = $lingua;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Pulsar Images</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    
<!--    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
 	<script type="text/javascript" src="js/easyTooltip.js"></script>
	<script type="text/javascript" src="js/sitewite.js"></script>
 	<script src="js/jquery.ui.totop.js" type="text/javascript"></script> -->
    <?php include("scripts.php"); ?>
 <!--    <script src="js/carrinho.js" type="text/javascript"></script> -->
    <script type="text/javascript">
$(document).ready(function() {
	$('.calculator').click(function () {
		alert($(this).attr('id'));
	});
	$('.show_uso').click(function () {
		var id = $(this).attr('id').split("_")[1];
		$("#uso_"+id).show();
	});
});
</script>    
  </head>
  <body>

    <?php include("part_topbar.php") ?>

    <div class="main size960">
      <div class="carrinho-page">
        <h2>My shopping cart</h2>
        <table class="carrinho-lista">
          <?php
                // monta o carrinho
                $carrinho->montaCarrinho();
            ?>
          
        <hr /><br />
      	<div class="dados-usuario" style="display:none"></div>
      </div>
    </div>

    <?php include("part_footer.php") ?>

  </body>
</html>
