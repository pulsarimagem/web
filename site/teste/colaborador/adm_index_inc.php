<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_adm_index_inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Imagens - Indexação</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>

<body id="indexacao">
<div class="main">
<?php include("part_header.php");?>
    <div class="colA">
    	<h2>Indexação</h2>
<?php include("part_consultatombo.php");?>
<?php if(true) { //$show_alteracao && $totalRows_dados_foto > 0) {?>
        <div class="alteracao">
	        <div class="image">
	           	<div class="thumb">
	               	<img src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $tombo; ?>p.jpg" onclick="MM_openBrWindow('http://www.pulsarimagens.com.br/bancoImagens/<?php echo $_GET['tombo']; ?>.jpg','','resizable=yes,width=550,height=550')"/>
	        		<input name="" type="button" id="button" value="Extra IPTC" style="float: none;" onclick="MM_openBrWindow('<?php echo $homeurl;?>toolkit/Example.php?jpeg_fname=<?php echo $tombo; ?>','','scrollbars=yes,resizable=yes,width=600,height=800')"/>
	            </div>
<!-- 	            <p>
	            <strong>Orientação:</strong> Horizontal
	            <br/><br/>
	                    ---Pal. Chaves---
	            </p> -->
<?php include("iptc.php"); ?>
	            <div class="clear"></div>
			</div>
	        
			<form name="form2" method="post" action="<?php echo $editFormAction; ?>">
	        	<ul>
	            	<li>
	                    <label>Código:</label>
	                    <input name="tombo2" type="text" id="tombo2" value="<?php echo $_GET['tombo']; ?>" disabled="disabled"/>
	                    <input name="tombo" type="hidden" id="tombo" value="<?php echo $_GET['tombo']; ?>"/>
	                    <input name="Id_Foto" type="hidden" id="Id_Foto" value="<?php echo $row_dados_foto['Id_Foto']; ?>">
	                    <div class="clear"></div>
	                </li>
	            	<li>
	                    <label>Assunto Principal:</label>
	                    <input name="assunto_principal" type="text" id="assunto_principal" value="<?php echo ($iptc_assunto != "" ? $iptc_assunto : $row_dados_foto['assunto_principal']); ?>" size="55" maxlength="100"/>
	                    <div class="clear"></div>
	                </li>
	            	<li>
	                    <label>Informação Adicional:</label>
	                    <input name="extra" type="text" id="extra" value="<?php echo $row_dados_foto['extra']; ?>" size="55"/>
	                    <div class="clear"></div>
	                </li>
	            	<li>
	                    <label>Autor:</label>
	                    <select name="autor" id="autor" disabled="disabled"><?php
do {  
?>
            <option value="<?php echo $row_fotografos['id_fotografo']?>"<?php if (!(strcmp($row_fotografos['id_fotografo'], $row_dados_foto['id_autor']))) {echo "SELECTED";} else if (!(strcmp($row_fotografos['Iniciais_Fotografo'], $row_ini_fotografo['Iniciais_Fotografo']))) {echo "SELECTED";}?>><?php echo $row_fotografos['Nome_Fotografo']?></option>
            <?php
} while ($row_fotografos = mysql_fetch_assoc($fotografos));
  $rows = mysql_num_rows($fotografos);
  if($rows > 0) {
      mysql_data_seek($fotografos, 0);
	  $row_fotografos = mysql_fetch_assoc($fotografos);
  }
?>         				</select>
						<input name="autor" type="hidden" id="autor" value="<?php echo $row_ini_fotografo['id_fotografo']; ?>"/>
	                    <div class="clear"></div>
	                </li>
	            	<li>
	                    <label>Data:</label>
						<input name="data_tela" type="text" id="data_tela" onBlur="MM_callJS('fix_data()')" value="<?php 
//		echo ($iptc_data != "" ? $iptc_data : $row_dados_foto['data_foto']);
		if($iptc_data != "") {
			echo $iptc_data;		
		} else {			
			if (strlen($row_dados_foto['data_foto']) == 4) {
				echo $row_dados_foto['data_foto'];
			} elseif (strlen($row_dados_foto['data_foto']) == 6) {
				echo substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
			} elseif (strlen($row_dados_foto['data_foto']) == 8) {
				echo substr($row_dados_foto['data_foto'],6,2).'/'.substr($row_dados_foto['data_foto'],4,2).'/'.substr($row_dados_foto['data_foto'],0,4);
			}
		} ?>"/>
	           			<input name="data" type="hidden" id="data" value="<?php echo ($iptc_data != "" ? fix_iptc_date($iptc_data) : $row_dados_foto['data_foto']); ?>"/>
	                    <i style="margin-left: 10px; font-size:10px; color:#CCCCCC">mm/aaaa</i>
	                    <div class="clear"></div>
	                </li>
	            	<li>
	                    <label>Cidade:</label>
	                    <input name="cidade" type="text" id="cidade" value="<?php echo ($iptc_local != "" ? $iptc_local : $row_dados_foto['cidade']); ?>" size="55"/>
	                    <div class="clear"></div>
	                </li>
	            	<li>
	                    <label>Estado:</label>
	                    <select name="estado" id="estado">
	            			<option value="" <?php if (!(strcmp("", $row_dados_foto['id_estado'])) && $iptc_estado == "") {echo "SELECTED";} ?>>--- em branco ---</option>
<?php
do {  
?>
			            	<option value="<?php echo $row_estado['id_estado']?>"<?php if (!(strcmp($row_estado['id_estado'], $row_dados_foto['id_estado'])) || !(strcmp($row_estado['Sigla'], $iptc_estado))) {echo "SELECTED";} ?>><?php echo $row_estado['Estado']?></option>
<?php
} while ($row_estado = mysql_fetch_assoc($estado));
  $rows = mysql_num_rows($estado);
  if($rows > 0) {
      mysql_data_seek($estado, 0);
	  $row_estado = mysql_fetch_assoc($estado);
  }
?>
			          	</select>
			          	<div class="clear"></div>
			       </li>
			       <li>
	                    <label>País:</label>
						<select name="pais" id="pais">
				            <option value="" <?php if (!(strcmp("", $row_dados_foto['id_pais'])) && $iptc_pais == "") {echo "SELECTED";} ?>>--- em branco ---</option>
<?php
do {  
?>
				            <option value="<?php echo $row_pais['id_pais']?>"<?php if (!(strcmp($row_pais['id_pais'], $row_dados_foto['id_pais'])) || !(strcmp($row_pais['nome'], $iptc_pais))) {echo "SELECTED";} ?>><?php echo $row_pais['nome']?></option>
<?php
} while ($row_pais = mysql_fetch_assoc($pais));
  $rows = mysql_num_rows($pais);
  if($rows > 0) {
      mysql_data_seek($pais, 0);
	  $row_pais = mysql_fetch_assoc($pais);
  }
?>
          				</select>
          				<div class="clear"></div>
	                </li>
<!--	            	<li>
 	                    <label>Orientação:</label>
	                    <select name=""></select>
	                    <div class="clear"></div>
	                </li> -->
	            	<li>
	                    <label>Temas:</label>
						<select name="tema" size="5" id="tema">
<?php
if ( $totalRows_temas > 0 ) {
	do {  
?>
			                <option value="<?php echo $row_temas['Id']?>"><?php echo $row_temas['Tema_total']?></option>
<?php
	} while ($row_temas = mysql_fetch_assoc($temas));
  $rows = mysql_num_rows($temas);
  if($rows > 0) {
      mysql_data_seek($temas, 0);
	  $row_temas = mysql_fetch_assoc($temas);
  }
}
?>
            			</select>
	                    <div class="clear"></div>
	                    <input name="" type="button" id="button" value="Incluir" style="margin-left: 148px; float: none;" onClick="MM_openBrWindow('adm_index_tema2.php?Id_Foto=<?php echo $row_dados_foto['Id_Foto']; ?>&tombo=<?php echo $row_dados_foto['tombo']; ?>','','width=680,height=140,top=400,left=250')"/>
			            <input type="button" name="Submit2" id="button" value="Copiar temas de..." onClick="copiarDados()" style="float: none;">
	                    <input name="" type="button" id="badbutton" value="Excluir" style="float: none;" onClick="excluir2(document.form2.tema.selectedIndex)"/>
	                </li>
	            	<li>
	                    <label>Palavras-chave:</label>
                        <input name="descritor" type="text" id="descritor" value="<?php echo ($iptc_pal != "" ? $iptc_pal : $row_dados_foto['pal_chave']); ?>" size="55"/>	                    
	                    <div class="clear"></div>
<!-- 						<select name="descritor[]" size="5" multiple id="descritor">
<?php
if ($totalRows_descritore > 0) {
	do {  
?>
			                <option value="<?php echo $row_descritore['id_rel']?>"><?php echo $row_descritore['Pal_Chave']?></option>
<?php
	} while ($row_descritore = mysql_fetch_assoc($descritore));
  $rows = mysql_num_rows($descritore);
  if($rows > 0) {
      mysql_data_seek($descritore, 0);
	  $row_descritore = mysql_fetch_assoc($descritore);
  }
}
?>
                        </select>
	                    <input name="" type="button" id="button" value="Incluir" style="margin-left: 148px; float: none;" onClick="MM_openBrWindow('adm_index_desc2.php?Id_Foto=<?php echo $row_dados_foto['Id_Foto']; ?>&tombo=<?php echo $row_dados_foto['tombo']; ?>','','width=450,height=80,top=500,left=250')"/>
	                    <input name="" type="button" id="badbutton" value="Excluir" style="float: none;" onClick="removeMe();"/> -->
	                </li>
	            </ul>
                <input name="todos_temas" type="hidden" id="todos_temas"/>
                <input name="todos_descritores" type="hidden" id="todos_descritores"/>
                <input type="hidden" name="MM_insert" value="form2"/>
	            <input name="button" type="button" id="button" value="Gravar" style="margin-left: 148px; float: left;" onClick="grava();"/>
	        </div>
		</form>
<?php } ?>    
    </div>
    <div class="colB">
<?php include("part_sidemenu.php");?>
    </div>
    <div class="clear"></div>
</div>
<?php include("part_footer.php");?>
</body>
</html>
