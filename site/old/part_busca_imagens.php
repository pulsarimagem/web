<?php 
mysql_select_db($database_pulsar, $pulsar);
$query_fotografos = "SELECT * FROM fotografos ORDER BY Nome_Fotografo ASC";
$fotografos = mysql_query($query_fotografos, $pulsar) or die(mysql_error());
$row_fotografos = mysql_fetch_assoc($fotografos);
$totalRows_fotografos = mysql_num_rows($fotografos);
?>
		<div class="buscarimagens">
			<h2>Buscar Imagens:</h2>
			<form name="form_buscaimagens" method="get" action="listing.php" id="form_buscaimagens">
				<ul>
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
						<option value="<?php echo $row_fotografos['id_fotografo']?>"><?php echo $row_fotografos['Nome_Fotografo']?></option>
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
			</form>
		</div>