<?php if($lingua == "br" || true) { ?>
<div id="dhtmltooltip"></div>
<script src='../js/tooltip.js' type='text/javascript'></script>
<style>
#dhtmltooltip{
font-family: Arial, Helvetica, sans-serif;
font-size: 10px;
position: absolute;
width: 150px;
border: 1px solid black;
padding: 2px;
background-color: lightyellow;
visibility: hidden;
z-index: 100;
}
</style>
<?php } else { ?>
<script>
function ddrivetip(thetext, thecolor, thewidth){
}
</script>
<?php } ?>
