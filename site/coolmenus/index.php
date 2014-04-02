<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
include "include/db.php";
include "include/functions.php";
?>

<html>
<head>

<style type="text/css">
<!--
@import url(style.css);
-->
</style>

<script TYPE="text/javascript" src="coolmenu.js">
/* menu script by Thomas Brattli (webmaster@dhtmlcentral.com), http://dhtmlcentral.com */
</script>

</head>

<body>

<script language="JavaScript" TYPE="text/javascript">
<!--
oM=new makeCM("oM"); oM.resizeCheck=1; oM.rows=2; oM.onlineRoot=""; oM.pxBetween =0;
oM.fillImg="cm_fill.gif"; oM.fromTop=30; oM.fromLeft=20; oM.wait=300; oM.zIndex=800;
oM.useBar=0; oM.barWidth="0"; oM.barHeight="0"; oM.barX="menu";oM.barY="menu"; oM.barClass="clBar";
oM.barBorderX=0; oM.barBorderY=0;
oM.menuPlacement="left";
oM.level[0]=new cm_makeLevel(70,20,"clT","clTover",1,1,"clB",0,"bottom",0,0);
oM.level[1]=new cm_makeLevel(130,20,"clS","clSover",1,1,"clB",0,"right",0,0);
oM.level[2]=new cm_makeLevel(130,20,"clS2","clS2over");
oM.level[3]=new cm_makeLevel(130,20);

<?php create_menu(0,0,5,1,1); ?>

oM.construct()

//-->
</script>

</body>
</html>

