        <div class="tombo">
<?php if(count($files_toindex) > 0) { ?>
        	<form action="adm_video_index_inc.php" method="get" name="form0">
	        	<label>Vídeos disponíveis:</label>
	        	<select name="tombo">
<?php 	foreach ($files_toindex as $file){ ?>
				<option value="<?php echo $file?>" <?php if($tombo==$file) echo "SELECTED"?>><?php echo $file;?></option>
<?php 	} ?>				
	        	</select>
	            <input name="Submit" type="submit" id="button" value="Consultar" class="button" />
	        </form>
			<div class="clear"></div>
<?php } else { ?>
	        <label>Não existem novos vídeos!</label>
			<div class="clear"></div>
<?php }?>        	
        </div>