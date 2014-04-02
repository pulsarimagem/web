<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
function readItemsFromDatabase(){

	$db = mysql_connect("10.139.11.72","pulsarimagens","basepulsar1991");
	mysql_select_db("pulsar",$db);
	
	$q = mysql_query("SELECT menuID,mName,mLink,parent from tblMenu ORDER BY parent,menuID ASC");
    while (($menu = mysql_fetch_array($q))) {
      $menuID = "m".$menu[menuID];;
      $mName  = $menu[menuID];
			$mLink  = $menu[mLink];
			if($mLink=="") $mLink="";
			$parent = $menu[parent];
			if($parent!=0) $parent = "m".$parent;
    	else $parent="";
      print "oCMenu.makeMenu('".$menuID."','".$parent."','".$menu[mName]."','".$mLink."')\n";
  }
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
</head>

<body>
//Calling function
<?php
readItemsFromDatabase();
?>
</body>
</html>
