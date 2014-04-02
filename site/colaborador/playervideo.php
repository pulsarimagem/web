<?php require_once('Connections/pulsar.php'); ?>
<?php include('tool_auth.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="../br/style.css" rel="stylesheet" type="text/css" />
<link href="css.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php")?>
<script>
function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
</script>
</head>
<body>
					<img id="mp"/>
	<script type="text/javascript">
		jwplayer("mp").setup({
			flashplayer: "../video/player.swf",
			file: "<?php echo $cloud_server?>/read_video.php?user=<?php echo $_GET['user']?>&tombo=<?php echo $_GET['tombo']?>",
			type: "video",
			provider: "video",
			height: 360,
	        width: 640,
			autostart: true
		});
	</script>
</body>
</html>


