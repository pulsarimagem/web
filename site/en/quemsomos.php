<?php require_once('Connections/pulsar.php'); ?>
<?php include("../tool_gethomeimg.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pulsar Images</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>

<?php include("part_topbar.php")?>

<div class="main size960">

<!--<?php //include("part_grid_left.php")?>-->

	<div class="grid-center">
		<div class="quemsomos">
<!-- 			<p class="welcome"></p> -->
			<img src="<?php echo $home_img;?>" style="max-width:716px; max-height:221px;" class="big" />
			<div class="colA">
				<p>Since 1991 Pulsar Imagens has been growing and consolidating its presence in the market. Our collaborators work with top of the line equipment that produces high-resolution digital originals always in tune with market demand.</p>
				<p>Our collection has over one million images and videos documenting Brazilian’s subjects extending from traditional/folk festivals, landscapes, roads, industry, national parks, handcraft, tourism, etc. We have one of the richest collections of beauty and characteristics of our country besides a great collection of images from others countries.</p>
<br /><h2>Clients</h2>
				<p>Pulsar Imagens actually works with all major educational publishers in the country and other big players in the publisher’s market. Advertising agencies also testified our quality publishing big campaign nationally using our collection. Also publishing internationally in many countries like France, United Kingdon, Germany and USA.  </p>
			</div>
			<div class="colB">
				<p>Our collaborators renew constantly their equipment always in search for the best quality and insuring our collection is always updated. All our analogical images (slides) have been scanned using high-end equipment to guarantee we have the best digital imagery for any usage or size.</p>
				<p> Our staff formed by experienced photographers and filmmakers, winners of prizes like Nikon of Photography, Esso Journalism, Wladimir Herzog of Human Rights and many others. Many of our images can be found in important public collections in Brazil and abroad. </p>
		  <p class="quote">Working with us, you rely on a specialized and experienced team of researchers, in order for you to receive the media you need in the time you need. Browse our site and <a href="contato.php">talk to us</a>.
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
