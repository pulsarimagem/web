        <div class="tombo">
        	<form action="adm_index.php" method="get" name="form0">
<?php if($totalRows_toindex > 0) { ?>
	        	<label>C�digo dispon�veis:</label>
	        	<select name="tombo">
<?php 	do { ?>
				<option value="<?php echo $row_toindex['tombo'];?>" <?php if($tombo==$row_toindex['tombo']) echo "SELECTED"?>><?php echo $row_toindex['tombo'];?></option>
<?php 	} while($row_toindex = mysql_fetch_assoc($toindex));?>				
	        	</select>
<!-- 	            <input name="Submit" type="submit" id="button" value="Consultar" class="button" /> -->
	            <input name="button" type="button" id="button" value="Atualizar Lista" class="button" onclick="MM_goToURL('parent','function_tombos_toindex.php');"/>
<!-- 	        </form> -->
			<div class="clear"></div>
<?php } else { ?>
	        <label>N�o existem novos c�digos!</label>
<?php }?>        	
<!--         	<form action="adm_index.php" method="get" name="form1"> -->
	        	<label>C�digo:</label>
	            <input name="tombo2" type="text" /> <!-- value="<?php echo $tombo;?>"/> -->
	            <input name="Submit" type="submit" id="button" value="Consultar" class="button" />
	            <div class="clear"></div>
			</form>
        </div>