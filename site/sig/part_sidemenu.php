<?php 
$currentURL = $_SERVER["PHP_SELF"];
$partsURL = Explode('/', $currentURL);
$this_page = $partsURL[count($partsURL) - 1];
$baixa	= isset($_GET['baixa'])?true:false;
$relatorio	= isset($_GET['relatorio'])?true:false;

?>
    	<div class="secao_admin">
        	<div class="title">
            	<p>Seções do Admin.:</p>
            </div>
            <ol>
                <li><a href="menu.php">Menu Principal</a></li>
<?php 
$x = 1;
$title = isset($_GET['title'])?$_GET['title']:"";
foreach($opt_menu as $opt=>$url) {
?>
                <li><a href="<?php echo $url?>" <?php if($title == $opt) echo "class=\"select\"><span><img src=\"images/secao_admin-span.jpg\" /></span";?>><?php echo $x?>. <?php echo $opt?></a></li>
<?php 
$x++;
}
?>            	
            </ol>
        </div>
