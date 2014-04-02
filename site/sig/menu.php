<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Imagens - Menu Principal</title>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body id="menuprincipal">
<div class="main">
<?php include("part_header.php");?> 
	<div class="colA">
    	<h2>Menu Principal</h2>
        <div class="menu">
        	<div class="col">
            	<ul>
<?php 
$x = 1;
$title = isset($_GET['title'])?$_GET['title']:"";
foreach($opt_menu as $opt=>$url) {
?>
                <li><a href="<?php echo $url?>"><?php echo $x?>. <?php echo $opt?></a></li>
<?php 
$x++;
}
?>            	
                </ul>
            </div>
          
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php include("part_footer.php");?>
</body>
</html>
