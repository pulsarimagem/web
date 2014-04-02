		<div class="content">
<?php include("create_menu.php");
mysql_select_db($database_pulsar, $pulsar);
$query_temas = "SELECT * FROM temas where Pai = 0 ORDER BY Pai,Tema ASC";
$temas_menu = mysql_query($query_temas, $pulsar) or die(mysql_error());
   
   $html = "
			<ul class=\"menu-nossos-temas\">";
   rootTree($temas_menu, $html, $pulsar);
   $html .= "
			</ul>
			";
 
   printf("%s", $html);

?>

		</div>
