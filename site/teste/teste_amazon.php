<?php
$user="aislan";
$data = file_get_contents('http://177.71.182.64/get_videos.php?user='.$user);
if($data === false) echo "retorno false para http://177.71.182.64/get_videos.php?user=".$user."!";
$files_toindex = json_decode($data);
?>
<?php 	foreach ($files_toindex as $file){ ?>
<?php echo $file;?>
<?php 	} ?>		
