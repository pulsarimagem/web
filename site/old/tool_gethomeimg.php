<?php
//function getHomeImg() {
	
	mysql_select_db($database_pulsar, $pulsar);
	
	$where_home = "";
	if(isset($_SESSION['home_img'])) {
		$where_home = "
WHERE
	fotos_homepage.tombo != '".$_SESSION['home_img']."'	
		";
	}
	$query_home = "
SELECT 
	fotos_homepage.tombo
FROM 
	fotos_homepage
".$where_home."	
ORDER BY 
	RAND()
LIMIT 1
	";

if($siteDebug) {
	echo $query_home."<br><br>";
}
	
	
	$return_home = mysql_query($query_home, $pulsar) or die(mysql_error());
	$row_home = mysql_fetch_assoc($return_home);
	$totalRows_home = mysql_num_rows($return_home);
	
	if($totalRows_home < 1) {
		$home_img = "images/home.jpg";
	}
	else {
		$_SESSION['home_img'] = $row_home['tombo'];
		$file = $row_home['tombo'].".jpg";
		$source_file = '/var/fotos_alta/'.$file; 
		$home_img = "images/home/".$file;
		
		if(!file_exists($home_img)) {
			
			if(!file_exists($source_file))
				$file = $row_home['tombo'].'.JPG';
				
			$source_file = '/var/fotos_alta/'.$file;
			if(!file_exists($source_file)) {
				$home_img = "images/home.jpg";
			} else {
//				$home_img = "images/home/".$file;
			}

			if(!file_exists($home_img)) {
				
				include("tool_resize.php");
				
				$image = new SimpleImage();
				$image->load($source_file);
		
				$image->cropHome();
				$image->save($home_img);
			}
		}			
	}
//	$home_img = "images/home.jpg";
	
	//}

?>