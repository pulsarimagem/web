<?php
$toFilter = false;
if($filtro == "foto") {
	$query_filter = "DELETE FROM tmp WHERE tombo RLIKE '^[a-zA-Z]'";
	$toFilter = true;
}
else if($filtro == "video") {
	$query_filter = "DELETE FROM tmp WHERE tombo NOT RLIKE '^[a-zA-Z]'";	
	$toFilter = true;
}
if($toFilter)
	if($siteDebug) {
		echo "<strong>Filtro:</strong>$query_filter<br>";
	}
	mysql_query($query_filter);
?>