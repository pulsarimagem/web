<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p>Tombos selecionados:<br />
<script language="javascript">
var max = window.opener.document.form3.vai.length;
var commax = 0;
if (max) {
	for (var idx = 0; idx < max; idx++) {
	if (eval("window.opener.document.form3.vai[" + idx + "].checked") == true) {
		if (commax == 1) {
			document.write(',');
			}
		document.write('"'+eval("window.opener.document.form3.vai[" + idx + "].value")+'"');
		commax = 1;
		}
	}
} else {
	document.write('"'+eval("window.opener.document.form3.vai.value")+'"');
}
alert(total);
</script>
</p>
</body>
</html>
