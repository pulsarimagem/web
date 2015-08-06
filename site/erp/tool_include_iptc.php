<?php require_once('Connections/pulsar.php'); ?>
<?php
$tombo = $_GET['tombo'];

include('./toolkit/inc_IPTC4.php');

$thumbs = "/tmp/".$tombo."t.jpg";
$pop = "/tmp/".$tombo."p.jpg";

$cmd = "aws --profile pulsar s3 cp s3://pulsar-media/fotos/previews/$tombo.jpg $thumbs";
shell_exec($cmd);
$cmd = "aws --profile pulsar s3 cp s3://pulsar-media/fotos/previews/".$tombo."p.jpg $pop";
shell_exec($cmd);

$dest_file = $thumbs;
coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);
$dest_file = $pop;
coloca_iptc($tombo, $dest_file, $database_pulsar, $pulsar);

$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/fotos/previews/$tombo.jpg";
shell_exec($cmd);
$cmd = "aws --profile pulsar s3 rm s3://pulsar-media/fotos/previews/".$tombo."p.jpg";
shell_exec($cmd);

$cmd = "aws --profile pulsar s3 cp $thumbs s3://pulsar-media/fotos/previews/$tombo.jpg --acl public-read";
shell_exec($cmd);
$cmd = "aws --profile pulsar s3 cp $pop s3://pulsar-media/fotos/previews/".$tombo."p.jpg --acl public-read";
shell_exec($cmd);

if($deleteFotoTmp) {
	$deleteSQL = "DELETE FROM Fotos_tmp WHERE tombo='$tombo'";
	$Result1 = mysql_query($deleteSQL, $pulsar) or die(mysql_error());
}

unlink($thumbs);
unlink($pop);
unlink($orig);
?>