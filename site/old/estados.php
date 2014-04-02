<?php require_once('Connections/pulsar.php'); ?>
<?php

    $query  = "SELECT Estado, Sigla FROM Estados order by Sigla";
	mysql_select_db($database_pulsar, $pulsar);
    $result = mysql_query($query,$pulsar);

	 if( !$result )
     {
        die("Erro ao obter estados");
     }

     $nrows = mysql_num_rows($result);
     $row   = 0;
	 
	 echo "<select class=\"select\" name=\"estados\">";
	 
     while( $row < $nrows )
     {
			
		$estado  = mysql_result($result,$row,"Estado");
		$sigla = mysql_result($result,$row,"Sigla");
		$default_estados = "";
		if(isset($estados) && $sigla == $estados) {
			$default_estados = "selected";
		}
			
		echo "<option value='" . $sigla . "' ".$default_estados.">" . $estado . "</option>\r\n";
		
		$row++;
     }
	 
 	 echo "</select>";
    
	 mysql_free_result($result);
     mysql_close();
?>
