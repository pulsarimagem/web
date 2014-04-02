		<div class="nossostemas">
			<h2>Nossos Temas</h2>
<?php include("create_menu.php");
mysql_select_db($database_pulsar, $pulsar);
$query_temas = "SELECT * FROM temas where Pai = 0 ORDER BY Pai,Tema ASC";
$temas_menu = mysql_query($query_temas, $pulsar) or die(mysql_error());
   
   $html = "
			<ul>";
   rootTree($temas_menu, $html, $pulsar);
   $html .= "
   				<div class=\"clear\"></div>
			</ul>
			";
 
   printf("%s", $html);

?>

		</div>
