<?php require_once('Connections/pulsar.php'); ?>
<?php
	$idioma = "";
	if($lingua != "br")
		$idioma = "_".$lingua;

    $query  = "SELECT id_pais, nome$idioma FROM paises order by nome$idioma ";
	mysql_select_db($database_pulsar, $pulsar);
    $result = mysql_query($query,$pulsar);

	 if( !$result )
     {
        die("Erro ao obter países");
     }

     $nrows = mysql_num_rows($result);
     $row   = 0;
	 
	 echo "<select class=\"select\" name=\"paises\">";
	 
     while( $row < $nrows )
     {
			
		$nome  = mysql_result($result,$row,"nome$idioma");
		$id_pais = mysql_result($result,$row,"id_pais");
		
		if($id_pais == "BR"){$selected = "selected";}else{$selected = "";}

		echo "<option " . $selected  . " value='" . $id_pais . "'>" . $nome . "</option>\r\n";

		$row++;
     }
	 
 	 echo "</select>";
    
	 mysql_free_result($result);
     //mysql_close();
?>
