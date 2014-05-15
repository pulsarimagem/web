<?php require_once('Connections/pulsar.php'); ?>
<?php include('tool_auth.php'); ?>
<?php include ("tool_details_video.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="../br/style.css" rel="stylesheet" type="text/css" />
<link href="css.css" rel="stylesheet" type="text/css" />
<?php include("../br/scripts.php")?>
<script>
function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
</script>
</head>
<body>
					<img id="mp<?php echo $row_dados_foto['tombo']; ?>"/>
<!--
 					<span class="video" style="width:640px;height:0px;"></span>
					<span class="video" style="width:0px;height:360px;"></span>
					<div class="video" id="2mp<?php echo $row_dados_foto['tombo']; ?>" style="width:640px;height:360px; position:absolute;right:37px;top:125px"></div>
 -->					
	<script type="text/javascript">
		jwplayer("mp<?php echo $row_dados_foto['tombo']; ?>").setup({
			flashplayer: "video/player.swf",
			file: "<?php echo $cloud_server?>/Videos/previews/<?php echo $tombo?>_<?php echo $res_pop?>.flv",
			image: "<?php echo $cloud_server?>/Videos/thumbs/<?php echo $tombo?>_3s.jpg",
			height: 360,
	        width: 640,
			autostart: true
		});
	</script>
</body>
</html>


