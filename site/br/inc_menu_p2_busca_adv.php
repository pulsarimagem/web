<script type="text/javascript">
jQuery(document).ready(function() {
	var timer;
	
	$('.hide_5s').mouseleave(function() {
		clearTimeout(timer);
		timer = setTimeout(function () {
	        $('.hide_5s').hide();
	        $('.clBar').hide();
	        $('.clLevel0').hide();
	        $('.clLevel1border').hide();
		}, 5000);
	});
	$('.clBar').mouseleave(function() {
		clearTimeout(timer);
		timer = setTimeout(function () {
	        $('.hide_5s').hide();
	        $('.clBar').hide();
	        $('.clLevel0').hide();
	        $('.clLevel1border').hide();
		}, 5000);
	});
	$('.clLevel0').mouseleave(function() {
		clearTimeout(timer);
		timer = setTimeout(function () {
	        $('.hide_5s').hide();
	        $('.clBar').hide();
	        $('.clLevel0').hide();
	        $('.clLevel1border').hide();
		}, 5000);
	});
	$('.clLevel1border').mouseleave(function() {
		clearTimeout(timer);
		timer = setTimeout(function () {
	        $('.hide_5s').hide();
	        $('.clBar').hide();
	        $('.clLevel0').hide();
	        $('.clLevel1border').hide();
		}, 5000);
	});
});	

function findPos(){
  if(bw.ns4){   //Netscape 4
    x = document.layers.layerMenu.pageX
    y = document.layers.layerMenu.pageY
  }else{ //other browsers
    x=0; y=0; var el,temp
    el = bw.ie4?document.all["divMenu"]:document.getElementById("divMenuAdv");
    if(el.offsetParent){
      temp = el
      while(temp.offsetParent){ //Looping parent elements to get the offset of them as well
        temp=temp.offsetParent;
        x+=temp.offsetLeft
        y+=temp.offsetTop;
      }
    }
    x+=el.offsetLeft
    y+=el.offsetTop
  }
  return [x,y]
}

pos = findPos()

/***
This is the menu creation code - place it right after you body tag
Feel free to add this to a stand-alone js file and link it to your page.
**/

//Menu object creation
oCMenu=new makeCM("oCMenu") //Making the menu object. Argument: menuname

//Menu properties
oCMenu.pxBetween=0
oCMenu.fromLeft=pos[0]-7
oCMenu.fromTop=pos[1]
oCMenu.onresize="pos = findPos(); oCMenu.fromLeft=pos[0]; oCMenu.fromTop=pos[1]"
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
oCMenu.level[0].width=140
oCMenu.level[0].height=20
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
//oCMenu.level[1].width=oCMenu.level[0].width-2
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
oCMenu.makeMenu('m<?php echo $row_temas_menu_busca_adv['Id']; ?>','<?php if ($row_temas_menu_busca_adv['Pai'] <> 0) echo 'm'.$row_temas_menu_busca_adv['Pai'] ?>','<?php echo $row_temas_menu_busca_adv['Tema']; ?>','listing.php?tema_action=&tema=<?php echo $row_temas_menu_busca_adv['Id']; ?>&id_estado=<?php echo $row_estado['id_estado'];?>&clear=true','_self',<?php if ($row_temas_menu_busca_adv['Pai'] == 0) {echo "140";} else {if ((strlen($row_temas_menu_busca_adv['Tema'])*5+20) <140) {echo "140";} else {echo (strlen($row_temas_menu_busca_adv['Tema'])*5+20);};}; ?>)
<?php } while ($row_temas_menu_busca_adv = mysql_fetch_assoc($temas_menu_busca_adv)); ?>

//Leave this line - it constructs the menu
oCMenu.construct()
</script>