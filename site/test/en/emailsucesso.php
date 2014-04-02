<?php require_once('Connections/pulsar.php'); ?>
<?php 
$anterior = "index.php";
if (isset($_POST['anterior'])) {
	$anterior = $_POST['anterior'];
}
else if (isset($_GET['anterior'])) {
	$anterior = $_GET['anterior'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
<?php include("google_conversion_contato.php")?>
</head>
<body>

<?php include("part_topbar.php")?>

<div class="main size960">

<?php //include("part_grid_left_porque.php")?>

	<div class="grid-center">
		<div class="cadastro">
			<h2>Message sent successfully</h2>
			<a href="<?php echo $anterior;?>" class="back">« Back</a>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
