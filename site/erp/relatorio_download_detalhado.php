<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_relatorio_download_detalhado.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Relatórios</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
<script type="text/javascript">                                         
$(document).ready(function() {
	$("input:checkbox").click(function() {
//		alert(this.value+' '+this.checked);
		$.get("tool_ajax_fatura.php", { id_log: this.value, marca: this.checked } );
	});
});
</script>     
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Relatórios</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Site</a>
        <a href="#" class="current">Relatórios</a>
      </div>
      <div class="container-fluid">

        <div class="row-fluid">
          <div class="span12">
  			<a class="btn btn-success" href="<?php echo $_SESSION['back']?>">Voltar</a>
		  </div>
		</div>
	  </div>
	  <div class="container-fluid">
        <div class="row-fluid">
          <div class="span12">

  <table class="table table-bordered table-striped">
    <tr>
      <td colspan="2"><div align="center">RELATÓRIO MENSAL DE DOWNLOAD DE IMAGENS</div></td>
    </tr>
    <tr>
      <td><div align="left"><strong>Mês/Ano: </strong></div></td>
      <td><div align="left"><?php echo $data; ?>&nbsp;</div></td>
    </tr>
    <tr>
      <td><div align="left"><strong>Cliente:</strong></div></td>
      <td><div align="left"><?php echo $row_cliente['nome']; ?> / <?php echo $row_cliente['empresa']; ?>&nbsp;</div></td>
    </tr>
    <tr>
      <td><div align="left"><strong>Cliente SIG:</strong></div></td>
<?php 
if (isset($row_cliente['id_cliente_sig']) && ($row_cliente['id_cliente_sig'] != "")) { 
	$row_empresas = mysql_fetch_assoc($empresas);
?>
      <td><div align="left"><?php echo $row_empresas['RAZAO']." / ".$row_empresas['FANTASIA']?> <input class="btn btn-warning" type="button" value="Alterar" id="btnChangeSig"/></div></td>
<?php 
} 
else { 
?>      
      <td><div align="left"><select class="span8" name="clienteSig" id="clienteSig">
		<option>-- Selecione um Cliente --</option>
<?php while($row_empresas = mysql_fetch_assoc($empresas)) { ?>
		<option value="<?php echo $row_empresas['ID']?>"><?php echo $row_empresas['RAZAO']." / ".$row_empresas['FANTASIA']?></option>
<?php } ?>
      </select></div></td>
<?php 
}
?>      
    </tr>
    <tr>
      <td><div align="left"><strong>Contato SIG:</strong></div></td>
<?php 
if (isset($row_cliente['id_cliente_sig']) && ($row_cliente['id_cliente_sig'] != "")) { 
?>
      <td><div align="left"><select class="span8" name="contatoSig" id="contatoSig">
      		<option value="0">-- Selecione um Contato --</option>      
<?php while($row_contato = mysql_fetch_assoc($contato)) { ?>
		<option value="<?php echo $row_contato['ID']?>" <?php if ($row_contato['ID'] == $row_cliente['id_contato_sig']) echo "selected"?>><?php echo $row_contato['CONTATO']?></option>
<?php } ?>
<?php 
} 
else { 
?>      
      <td><div align="left"><select name="contatoSig" id="contato">
		<option>Escolha o Cliente Primeiro</option>
<?php /* while($row_contatos = mysql_fetch_assoc($contatos)) { ?>
		<option value="<?php echo $row_empresas['ID']?>"><?php echo $row_empresas['CONTATO']?></option>
<?php } */ ?>
      </select></div></td>
<?php 
}
?>      
    </tr>
    <tr>
      <td><div align="left"><strong>Total de Downloads:</strong></div></td>
      <td><div align="left"><?php echo $totalRows_arquivos; ?>&nbsp;</div></td>
    </tr>
    </table>
          

<div class="span2">    
  <form name="fatura_tudo" method="get">
  	<input class="btn btn-success" name="faturar_todas" type="submit" value="Faturar Todas"/>
  	<input name="id_login" type="hidden" value="<?php echo $colname_arquivos;?>"/>
  	<input name="data" type="hidden" value="<?php echo $data;?>"/>
  </form>
</div>
<div class="span3">  
  <form name="imprimir_rel" method="get" action="relatorio_download_detalhado_print.php" target="_blank">
  	<input class="btn btn-primary" name="imprimir" type="submit" value="Gerar versão para impressão"/>
  	<input name="id_login" type="hidden" value="<?php echo $colname_arquivos;?>"/>
  	<input name="tipo" type="hidden" value="<?php echo $relTipo?>"/>
  	<input name="data" type="hidden" value="<?php echo $data;?>"/>
  </form>
</div>
<div class="span3">  
  <form name="imprimir_rel" method="get" action="relatorio_download_detalhado_print.php">
  	<input class="btn btn-warning" name="imprimir" type="submit" value="Gerar versão Excel"/>
  	<input name="id_login" type="hidden" value="<?php echo $colname_arquivos;?>"/>
  	<input name="tipo" type="hidden" value="<?php echo $relTipo?>"/>
  	<input name="data" type="hidden" value="<?php echo $data;?>"/>
  	<input name="excel" type="hidden" value="true"/>
  </form>
</div>
<div class="span3">
</div>
  <form method="post" action="administrativo_licencas_nova.php">  
  <?php
  $divisor = false;
  $divisor2 = false;
  $new_group = false;

  $group_cnt = 0;
  $this_download = $row_arquivos;
  $last_download = $row_arquivos;
  
do {
	if($relTipo != "layout") { 
		if(is_numeric($row_arquivos['uso'])) {
			mysql_select_db($database_sig, $sig);
	  		$row_uso = translate_iduso_array($row_arquivos['uso'], "br", $sig);
		}
	}

  if ($divisor2 == false) {
    if($row_arquivos['faturado']==0) {
	  $divisor2 = true;
	  echo "<br><br><h2> Imagem(ns) N&atilde;o Faturada(s) </h2><br><br>";
	}
  }
  if ($divisor == false) {
    if($row_arquivos['faturado']==1) {
	  $divisor = true;
	  echo "<br><br><h2> Imagem(ns) J&aacute; Faturada(s) </h2><br><br>";
	}
  }
?>
<?php 
$last_download = $this_download;
$this_download = $row_arquivos;
//echo $this_download['projeto']." - ".$last_download['projeto']."<br>";
if(($this_download['projeto'] != $last_download['projeto'])||($this_download['indio'] != $last_download['indio'])) {
	echo "$group_cnt foto(s).".($last_download['indio']=="1"?" Tipo Indio.":"");
	$group_cnt = 0;
?>
    <input name="novoIntegra" type="hidden" value="true"/>  
    <input name="exec" type="hidden" value="cromo"/>  
    <input name="descricao" type="hidden" value="<?php echo $last_download['projeto']; ?>"/>  
<?php if($relTipo != "layout") { ?>
    <input class="gerarLR btn btn-danger" name="action" type="submit" value="Gerar LR"/>
	<input name="id_uso" type="hidden" value="<?php echo $last_download['uso']//"6";//$row_arquivos['id_uso']; ?>"/>
<?php } ?>
    <input name="id_cliente_sig" class="id_cliente_sig" type="hidden" value="<?php echo $row_cliente['id_cliente_sig'];//$row_arquivos['id_uso']; ?>"/>
    <input name="qcontato" class="id_contato_sig" type="hidden" value="<?php echo $row_cliente['id_contato_sig'];//$row_arquivos['id_uso']; ?>"/>
<?php if($relTipo == "videos") { ?>
    <input name="contrato_desc" type="hidden" value="<?php echo $contrato_video?>"/>
<?php } else {?>    
    <input name="contrato_desc" type="hidden" value="<?php echo ($this_download['indio']=="1"?$contrato_foto_indio:$contrato_foto_padrao)?>"/>
<?php } ?>    
    <input name="data" type="hidden" value="<?php echo $last_download['data_hora']; ?>"/>
</form>

<form method="post" action="administrativo_licencas_nova.php">
<?php } ?>
    <table class="table table-bordered table-striped">
      <tr>
        <td width="150" rowspan="9" valign="top"><img src="http://www.pulsarimagens.com.br/bancoImagens/<?php
		 echo strtoupper(str_replace($retirar,"",$row_arquivos['arquivo'])); ?>p.jpg" /></td>
        <td colspan="2"><div align="left">Assunto: <?php echo $row_arquivos['assunto_principal']; ?></div></td>
      </tr>
      <tr>
        <td><div align="left">C&oacute;digo: <?php echo strtoupper(str_replace($retirar,"",$row_arquivos['arquivo'])); ?></div></td>
        <td><div align="left">Autor: <?php echo $row_arquivos['Nome_Fotografo']; ?></div></td>
      </tr>
      <tr>
        <td><div align="left">Data do Download: <?php echo makeDateTime($row_arquivos['data_hora'], 'd/m/y'); ?></div></td>
        <td><div align="left">IP: <?php echo $row_arquivos['ip']; ?></div></td>
      </tr>
      <tr>
        <td colspan="2"><div align="left">Usu&aacute;rio: <?php echo $row_arquivos['usuario']; ?></div>          <div align="left"></div></td>
      </tr>
      
      
<?php if($relTipo == "layout") { ?>
      <tr>
        <td colspan="2"><div align="left">T&iacute;tulo: <?php echo $row_arquivos['projeto']; ?></div></td>
       </tr>
<?php } else { ?>      
      <tr>
        <td><div align="left">Circula&ccedil;&atilde;o: <?php echo $row_arquivos['circulacao']; ?></div></td>
        <td><div align="left">Tiragem: <?php echo $row_arquivos['tiragem']; ?></div></td>
      </tr>
      <tr>
        <td><div align="left">T&iacute;tulo: <?php echo $row_arquivos['projeto']; ?></div></td>
<?php 	if(is_numeric($row_arquivos['uso'])) { ?>
<!--          <td><div align="left">Tamanho: <?php echo $row_arquivos['tamanho_desc']; ?></div></td> -->
          <td><div align="left">Tamanho: <?php echo $row_uso['tamanho']; ?></div></td>
<?php 	} else { ?>                             
        <td><div align="left">Tamanho: <?php echo $row_arquivos['formato']; ?></div></td>
<?php 	} ?>        
      </tr>
      <tr>
<?php 	if(is_numeric($row_arquivos['uso'])) { ?>
<!--         <td colspan="2"><div align="left">Uso: <?php echo $row_arquivos['uso_desc']; ?></div></td> -->
		<td colspan="2"><div align="left">Uso: <?php echo $row_uso['tipo']." | ".$row_uso['utilizacao']; ?></div></td>
<?php 	} else { ?>
        <td colspan="2"><div align="left">Uso: <?php echo $row_arquivos['uso']; ?></div></td>
<?php 	} ?>
      </tr>
<?php } ?>      
      
      
      <tr>
        <td colspan="2"><div align="left">Obs: <?php echo str_replace(array("\\r\\n", "\\r", "\\n"), "<br />", $row_arquivos['obs']); ?></div></td>
      </tr>
      <tr>
        <td colspan="2"><div align="left">Faturado:
            <input type="checkbox" id="faturado" value="<?php echo $row_arquivos['id_log']; ?>" <?php if ($row_arquivos['faturado']==1) { ?> checked="checked" <?php } ?>/>
            <input name="fat[]" type="hidden" value="<?php echo $row_arquivos['id_log']; ?>" />
		</div></td>
      </tr>
    </table>
    <input name="qcodigo[]" type="hidden" value="<?php echo strtoupper(str_replace($retirar,"",$row_arquivos['arquivo'])); ?>"/>
    <input name="quso[]" type="hidden" value="<?php echo $row_arquivos['uso']?>"/>
<?php if($relTipo != "layout") { ?>    
    <input name="uso_<?php echo strtoupper(str_replace($retirar,"",$row_arquivos['arquivo']))?>" type="hidden" value="<?php echo $row_arquivos['uso'] ?>"/>
<?php } ?>    
<?php
	$group_cnt ++;
} while ($row_arquivos = mysql_fetch_assoc($arquivos));
echo "$group_cnt foto(s).".($this_download['indio']=="1"?" Tipo Indio.":"");
$group_cnt = 0;
?>
	<input name="novoIntegra" type="hidden" value="true"/>  
    <input name="exec" type="hidden" value="cromo"/>  
    <input name="descricao" type="hidden" value="<?php echo $this_download['projeto']; ?>"/>  
<?php if($relTipo != "layout") { ?>
    <input class="gerarLR btn btn-danger" name="action" type="submit" value="Gerar LR"/>
	<input name="id_uso" type="hidden" value="<?php echo $this_download['uso']//"6";//$row_arquivos['id_uso']; ?>"/>
<?php } ?>
    <input name="id_cliente_sig" class="id_cliente_sig" type="hidden" value="<?php echo $row_cliente['id_cliente_sig'];//$row_arquivos['id_uso']; ?>"/>
    <input name="qcontato" class="id_contato_sig" type="hidden" value="<?php echo $row_cliente['id_contato_sig'];//$row_arquivos['id_uso']; ?>"/>
<?php if($relTipo == "videos") { ?>
    <input name="contrato_desc" type="hidden" value="<?php echo $contrato_video?>"/>
<?php } else {?>    
    <input name="contrato_desc" type="hidden" value="<?php echo ($this_download['indio']=="1"?$contrato_foto_indio:$contrato_foto_padrao)?>"/>
<?php } ?>    
	<input name="data" type="hidden" value="<?php echo $this_download['data_hora']; ?>"/>
</form>
    
         <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
