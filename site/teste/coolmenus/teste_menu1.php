<?php require_once('../Connections/pulsar.php'); ?>
<?php
mysql_select_db($database_pulsar, $pulsar);
$query_temas = "SELECT * FROM temas ORDER BY Pai,Tema ASC";
$temas = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas = mysql_fetch_assoc($temas);
$totalRows_temas = mysql_num_rows($temas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Teste menu 1</title>
<style>
/* CoolMenus 4 - default styles - do not edit */
.clCMEvent{position:absolute; width:99%; height:99%; clip:rect(0,100%,100%,0); left:0; top:0; visibility:visible}
.clCMAbs{position:absolute; visibility:hidden; left:0; top:0}
/* CoolMenus 4 - default styles - end */
  
/*Style for the background-bar*/
.clBar{position:absolute; width:10; height:10; background-color:#FF9900; layer-background-color:#FF9900; visibility:hidden}

/*Styles for level 0*/
.clLevel0,.clLevel0over{position:absolute; padding:1px; font-family:tahoma,arial,helvetica; font-size:12px; font-weight:bold}
.clLevel0{color:#336699;}
.clLevel0over{background-color:#336699; layer-background-color:#336699; color:#FF9900; cursor:pointer; cursor:hand; }

/*Styles for level 1*/
.clLevel1, .clLevel1over{position:absolute; width:180; padding:2px; font-family:tahoma, arial,helvetica; font-size:11px; font-weight:bold}
.clLevel1{background-color:#FF9900; layer-background-color:#FF9900; color:#336699;}
.clLevel1over{background-color:#336699; layer-background-color:#336699; color:#FF9900; cursor:pointer; cursor:hand; }
.clLevel1border{position:absolute; visibility:hidden; background-color:#006699; layer-background-color:#006699}


/*Styles for level 2*/
.clLevel2, .clLevel2over{position:absolute;  padding:2px; font-family:tahoma,arial,helvetica; font-size:10px; font-weight:bold}
.clLevel2{background-color:Navy; layer-background-color:Navy; color:white;}
.clLevel2over{background-color:#0099cc; layer-background-color:#0099cc; color:Yellow; cursor:pointer; cursor:hand; }
.clLevel2border{position:absolute; visibility:hidden; background-color:#006699; layer-background-color:#006699}
</style>
<script language="JavaScript1.2" src="coolmenus4.js">
/*****************************************************************************
Copyright (c) 2001 Thomas Brattli (webmaster@dhtmlcentral.com)

DHTML coolMenus - Get it at coolmenus.dhtmlcentral.com
Version 4.0_beta
This script can be used freely as long as all copyright messages are
intact.

Extra info - Coolmenus reference/help - Extra links to help files **** 
CSS help: http://192.168.1.31/projects/coolmenus/reference.asp?m=37
General: http://coolmenus.dhtmlcentral.com/reference.asp?m=35
Menu properties: http://coolmenus.dhtmlcentral.com/properties.asp?m=47
Level properties: http://coolmenus.dhtmlcentral.com/properties.asp?m=48
Background bar properties: http://coolmenus.dhtmlcentral.com/properties.asp?m=49
Item properties: http://coolmenus.dhtmlcentral.com/properties.asp?m=50
******************************************************************************/
</script>
</head>

<body>
<script>
/*** 
This is the menu creation code - place it right after you body tag
Feel free to add this to a stand-alone js file and link it to your page.
**/

//Menu object creation
oCMenu=new makeCM("oCMenu") //Making the menu object. Argument: menuname

//Menu properties   
oCMenu.pxBetween=1
oCMenu.fromLeft=10 
oCMenu.fromTop=50   
oCMenu.rows=0 
oCMenu.menuPlacement=0

oCMenu.offlineRoot="file:///C|/Inetpub/wwwroot/dhtmlcentral/" 
oCMenu.onlineRoot="" 
oCMenu.resizeCheck=1 
oCMenu.wait=1000 
oCMenu.fillImg="cm_fill.gif"
oCMenu.zIndex=0

//Background bar properties
oCMenu.useBar=1
oCMenu.barWidth="menu"
oCMenu.barHeight="menu" 
oCMenu.barClass="clBar"
oCMenu.barX="menu"
oCMenu.barY="menu"
oCMenu.barBorderX=0
oCMenu.barBorderY=0
oCMenu.barBorderClass=""

//Level properties - ALL properties have to be spesified in level 0
oCMenu.level[0]=new cm_makeLevel() //Add this for each new level
oCMenu.level[0].width=120
oCMenu.level[0].height=15
oCMenu.level[0].regClass="clLevel0"
oCMenu.level[0].overClass="clLevel0over"
oCMenu.level[0].borderX=0 
oCMenu.level[0].borderY=0
oCMenu.level[0].borderClass=0
oCMenu.level[0].offsetX=0 
oCMenu.level[0].offsetY=0
oCMenu.level[0].rows=0
oCMenu.level[0].align="right" 


//EXAMPLE SUB LEVEL[1] PROPERTIES - You have to spesify the properties you want different from LEVEL[0] - If you want all items to look the same just remove this
oCMenu.level[1]=new cm_makeLevel() //Add this for each new level (adding one to the number)
oCMenu.level[1].width=oCMenu.level[0].width-2
//oCMenu.level[1].height=22
oCMenu.level[1].regClass="clLevel1"
oCMenu.level[1].overClass="clLevel1over"
oCMenu.level[1].style=""
oCMenu.level[1].align="right" 
oCMenu.level[1].offsetX=0
oCMenu.level[1].offsetY=0
oCMenu.level[1].borderClass="clLevel1border"
oCMenu.level[1].borderX=1 
oCMenu.level[1].borderY=1
oCMenu.level[1].rows=0
 

/******************************************
Menu item creation:
myCoolMenu.makeMenu(name, parent_name, text, link, target, width, height, regImage, overImage, regClass, overClass , align, rows, nolink, onclick, onmouseover, onmouseout) 
*************************************/
<?php do { ?>
oCMenu.makeMenu('m<?php echo $row_temas['Id']; ?>','m<?php if ($row_temas['Pai'] <> 0) echo $row_temas['Pai'] ?>','<?php echo $row_temas['Tema']; ?>')
<?php } while ($row_temas = mysql_fetch_assoc($temas)); ?>

//Leave this line - it constructs the menu
oCMenu.construct()	
</script>

</body>
</html>
<?php
mysql_free_result($temas);
?>