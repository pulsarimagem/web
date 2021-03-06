<?php
mysql_select_db($database_pulsar, $pulsar);
$query_fotografos = "SELECT * FROM fotografos ORDER BY Nome_Fotografo ASC";
$fotografos = mysql_query($query_fotografos, $pulsar) or die(mysql_error());
$row_fotografos = mysql_fetch_assoc($fotografos);
$totalRows_fotografos = mysql_num_rows($fotografos);
?>

<div class="buscarimagens">

<div class="block-busca">
	<form action="listing.php" method="get" id="form_block_busca">
		<h3><b>Sua busca</b></h3>
	    <div class="block-lateral1 block">
	        <ul>
	            <li>
	                <p style="font-style:oblique; font-weight:bold">Palavras-chaves</p>
	            </li>
	            <li>
<?php 
$search_cnt = 0;
foreach($pesquisas as $pesquisa) {
			$show_campo = "";
			if($pesquisa->searchVars != true) {
				if($pesquisa->fracao == true ) {
					$show_campo = PARTBUSCA_FRACAO;
				}
				else if($pesquisa->not == true) {
					if($pesquisa->arrCampos["assunto"] == true) {
						$show_campo = PARTBUSCA_NAO;
					}
				}
				else if($pesquisa->pc > 0) {
					$show_campo = PARTBUSCA_PC.$pesquisa->pc;
				}
				else {
					foreach($pesquisa->arrCampos as $campo=>$val) {
						if($val == true) {
							$show_campo = constant(PARTBUSCA_.mb_strtoupper($campo));
						}
					}
				}
			} 
			if($pesquisa->not == true && $pesquisa->arrCampos["pc"] == true) {
			}
			else { 
				foreach($pesquisa->arrPalavras as $palavra=>$idioma) {
?>
					<div class="p-chave" id="search_<?php echo $search_cnt?>">
<?php 
					if($show_campo == "id_estado") {
						echo translate_idestado($palavra[0],$pulsar);
					}
					else {
						echo is_array($palavra)?$palavra[0]:$palavra;
						echo ($idioma != $lingua)?" {translated}":"";
					}
					if(isset($show_campo)&&$show_campo!="") {
						echo " <span class=\"det\">[$show_campo]</span>";
					}
					$pesquisa->getInput($palavra, $lingua);
?>
					</div>
<?php 
					if ($idioma == $lingua) { 
?>					
	                <div class="x-chave"><a class="x-chave-btn" id="<?php echo $search_cnt?>">x</a></div>
<?php 
					}
					$search_cnt++;
				}
			}
?>
<?php 
}
foreach($engine->arrFiltros as $filtro=>$val) {
			unset($show_campo);
			if($val !== true) {
				if($filtro == "direito_aut") {
					$show_campo = PARTBUSCA_FILTRO_DIREITO_AUT;
				}
				else if($filtro == "id_tema") {
					$show_campo = PARTBUSCA_FILTRO_ID_TEMA;
				}
				else if($filtro == "id_autor") {
					$show_campo = PARTBUSCA_FILTRO_ID_AUTOR;
				}
/*
				data
				dia
				mes
				ano
				horizontal
				vertical
*/							
			} 
			if(isset($show_campo)) {
?>
					<div class="p-chave" id="search_<?php echo $search_cnt?>">
<?php 
				if($filtro == "id_tema") {
					echo translate_idtema($val,$pulsar);
				}
				else if($filtro == "id_autor") {
					echo translate_idautor($val[0],$pulsar);
				}
				else 
					echo is_array($val)?$val[0]:$val;
				if(isset($show_campo)) {
					echo " <span class=\"det\">[$show_campo]</span>";
				}
				$engine->getInput($filtro);
?>
					</div>
	                <div class="x-chave"><a class="x-chave-btn" id="<?php echo $search_cnt?>">x</a></div>
<?php 
				$search_cnt++;
			}
?>
<?php } ?>
	                <div class="clear"></div>
	            </li>
	            <li>
	                <span class="limpar-busca">
	                    <a href="listing.php?clear=true">Limpar todas</a>
	                </span>
	            </li>
	        </ul>
	        
	        <div class="clear"></div>
	    </div>	   
	    
	    <div class="block-lateral2 block">
	    	<h1><b>Refina sua busca</b></h1>
	        <input type="text" class="seach" id="seach-palavra-chave" name="pc_arr[]"/>
	        <input type="submit" value="" id="bt-ok" class="bt-ok" />
	        <input type="hidden" name="pc_action" value="true" />
	        <div class="clear"></div>
	        <span class="busca-avancada">
	        <a href="buscaavancada.php">Busca avan�ada</a>
	        </span>               
	    </div>
		
	    <span class="linha"></span>
      	
      	<div class="block-lateral5 block">
	    	<h1><b>Data:</b></h1>
	        <select name="ano" class="select" id="select_data">
		        <option value="" <?php if(!isset($_GET['ano'])) echo "selected";?>>Todos</option>
<?php 
while ($row = mysql_fetch_array($posfilters_data)) { 
	$ano = $row['ano'];
	$data_found = false;
	if($ano > 1900 && $ano < 2020) {
?>
	        	<option value="<?php echo $ano?>" <?php if(isset($_GET['ano'])&&$_GET['ano'] == $ano) {echo "selected";$data_found = true;}?>><?php echo $ano?></option>
<?php 
	}
}
if(!$data_found && (isset($_GET['ano'])&&$_GET['ano']!=""&&$_GET['ano']!="Todos")) {
?>
	        	<option value="<?php echo $_GET['ano']?>" selected><?php echo $_GET['ano']?></option>
<?php 		
}		
?>		        
        	</select> 
	        <select name="data_tipo" class="select">
		        <option value="exata" <?php if(isset($_GET['data_tipo'])&&$_GET['data_tipo'] == "exata") echo "selected"?>>Data Exata</option>
		        <option value="depois" <?php if(isset($_GET['data_tipo'])&&$_GET['data_tipo'] == "depois") echo "selected"?>>A partir de</option>
		        <option value="antes" <?php if(isset($_GET['data_tipo'])&&$_GET['data_tipo'] == "antes") echo "selected"?>>Anterior a</option>
        	</select>
      	</div>
      	
	    <span class="linha"></span>	
      	
	    <div class="block-lateral3 block">
	        <h1><b>Exibir somente:</b></h1>
	        <ul>
	        	<li>
	            	<label><input type="checkbox" name="filtro[]" value="foto" class="submit_onclick" <?php if($show_foto) echo "checked"?>/><span class="foto">Foto</span></label>
	            </li>
				<li>
	            	<label><input type="checkbox" name="filtro[]" value="video" class="submit_onclick" <?php if($show_video) echo "checked"?>/><span class="video">V�deo</span></label>
	            </li>
	        	<div class="clear"></div>
	        </ul>
	    </div>
	    
	    <span class="linha"></span>
	    
	    <div class="block-lateral4 block">
        <ul>
<?php 
$grupos_video = "";
$grupos_fotos = "";
$posfiltros_inputs = array("fullhd"=>0,"hd"=>0,"sd"=>0,"h"=>0,"v"=>0);

foreach ($posfilters_groups as $group=>$val) { 
	if($val > 0) {
		$checked = "";
		if(!isset($_GET['posfilter'])) {
			$checked = "checked";
		}
		else if(array_search($group, $posfiltro)!==false) {
			$checked = "checked";
		}
		
		switch($group) {
			case "fullhd":
				$grupos_video .= "<li><label><input type='checkbox' name='posfilter[]' value='fullhd' class='submit_onclick' $checked/>Full HD ($val)</label></li>";
				break;				
			case "hd":
				$grupos_video .= "<li><label><input type='checkbox' name='posfilter[]' value='hd' class='submit_onclick' $checked/>HD - 720p ($val)</label></li>";
				break;				
			case "sd":
				$grupos_video .= "<li><label><input type='checkbox' name='posfilter[]' value='sd' class='submit_onclick' $checked/>SD ($val)</label></li>";
				break;				
			case "h":
				$grupos_fotos .= "<li><label><input type='checkbox' name='posfilter[]' value='h' class='submit_onclick' $checked/>Horizontal ($val)</label></li>";
				break;				
			case "v":
				$grupos_fotos .= "<li><label><input type='checkbox' name='posfilter[]' value='v' class='submit_onclick' $checked/>Vertical ($val)</label></li>";
				break;
		}
		unset($posfiltros_inputs[$group]);
	}
}
if($grupos_video != "") {
?>
	    	<h1><b>Videos:</b></h1>
            <div class="clear"></div>
<?php 
	echo $grupos_video;
} 
if($grupos_video != "" && $grupos_fotos != "") { 
?>
<span class="linha"></span>
<?php 
}
if($grupos_fotos != "") {
?>
			<h1><b>Fotos:</b></h1>
<?php 
	echo $grupos_fotos;
} 
?>	    
		</ul>
        </div>
<?php foreach($posfiltros_inputs as $input=>$val) { ?>
<input type='hidden' name='posfilter[]' value='<?php echo $input?>'/>
<?php } ?>
        <input type="hidden" value="true" name="clear">
	</form>
</div>


  <?php /*?><h2>Busca:</h2>
  <form name="form_buscaimagens" method="get" action="listing.php" id="form_buscaimagens">
    <ul>
      <li>
        <label>Tipo:</label>
        <select class="select" name="filtro">
          <option value="foto" selected="selected">Fotos</option>
          <option value="video">V�deos</option>
        </select>
      </li>
      <li>
        <label>Palavra Chave:</label>
        <input name="query" type="text" class="text" />
      </li>
      <li>
        <label>C�digo:</label>
        <input name="tombo" type="text" class="text" />
      </li>
      <li>
        <label>Fot�grafo:</label>
        <select name="id_autor[]" class="select" id="select_autor">
          <option value="">Todos</option>
          <?php
          do {
            ?>
            <option value="<?php echo $row_fotografos['id_fotografo'] ?>"><?php echo $row_fotografos['Nome_Fotografo'] ?></option>
            <?php
          } while ($row_fotografos = mysql_fetch_assoc($fotografos));
          ?>
        </select>
      </li>
      <li>
        <label>Local:</label>
        <input name="local" type="text" class="text" />
      </li>
      <li>
        <label>Data:</label>
        <input name="dia" type="text" class="text" style="width: 31px;" /> <span>/</span> <input name="mes" type="text" class="text" style="width: 31px;" /> <span>/</span> <input name="ano" type="text" class="text" style="width: 70px;" /> 
      </li>
      <li>
        <select name="data_tipo" class="select">
          <option value="exata">Data Exata</option>
          <option value="depois">A partir de</option>
          <option value="antes">Anterior a</option>
        </select>
      </li>
      <li>
        <input name="pc_action" type="submit" class="button" value="Ir" />
        <input name="pc_action" type="hidden" value="Ir" />
        <input name="tipo" type="hidden" value="inc_pc.php"/>
        <input name="autorizada" type="hidden" value="autorizada"/>
        <input name="horizontal" type="hidden" value="H"/>
        <input name="vertical" type="hidden" value="V"/>
        <input name="type" type="hidden" value="pc"/>
        <a href="buscaavancada.php" class="badv">Ir para Busca Avan�ada</a>
        <div class="clear"></div>
      </li>
    </ul>
  </form><?php */?>
</div>