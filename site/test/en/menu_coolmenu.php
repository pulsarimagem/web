<?php
mysql_select_db($database_pulsar, $pulsar);
$query_temas = "SELECT * FROM temas ORDER BY Pai,Tema ASC";
$temas_menu = mysql_query($query_temas, $pulsar) or die(mysql_error());
$row_temas_menu = mysql_fetch_assoc($temas_menu);
$totalRows_temas_menu = mysql_num_rows($temas_menu);
?>
<style type="text/css">
<?php include_once("inc_menu_p1.php"); ?>
</style>
<script language="JavaScript1.2" src="../js/coolmenus4.js"> 
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
<div class="nossostemas" >
			<h2>Nossos Temas</h2>
			<div id="divMenu">
				<img src="../coolmenus/cm_fill.gif" width="221" height="440" alt="" border="0">
			</div>
		</div>
