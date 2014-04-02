<?php require_once('Connections/pulsar.php'); ?>
<head>
<meta http-equiv="refresh" content="5">
</head>
<body>
<?php
function translateTextLocal($palavra, $idioma = "pt") {
	$return = array();
	if($palavra != '' && $idioma != ''){
		$palavra = preg_replace("/[ÀàÂâÄäÃãÁá]/","a", $palavra);
		$palavra = preg_replace("/[ÈèÊêËëÉé]/","e", $palavra);
		$palavra = preg_replace("/[ÌìÎîÏïÍí]/","i", $palavra);
		$palavra = preg_replace("/[ÒòÔôÖöÕõÓó]/","o", $palavra);
		$palavra = preg_replace("/[ÙùÛûÜüÚú]/","u", $palavra);
		$palavra = preg_replace("/[Çç]/","c", $palavra);
		$palavra = preg_replace("/[Ññ]/","n", $palavra);

		//		$palavra = utf8_decode($palavra);
		//		echo "http://translate.google.com/translate_a/t?client=p&text=".utf8_encode(urlencode($palavra))."&hl=en&sl=".$idioma."&tl=en&ie=ISO-8859-1&oe=ISO-8859-1&multires=1&otf=1&ssel=0&tsel=0&sc=1";

		$data2 = file_get_contents("http://translate.google.com/translate_a/t?client=p&text=".urlencode(utf8_encode($palavra))."&hl=".$idioma."&sl=".$idioma."&tl=en&ie=ISO-8859-1&oe=ISO-8859-1&multires=1&otf=1&ssel=0&tsel=0&sc=1");
		//		echo $data2;
		$dados = json_decode(utf8_encode($data2));

		if(false) {
			echo "Array google translator: ";
			print_r($dados);
			echo "<br>";
			echo "<br>";
		}

		//			$return[] = $data[1];
		if($dados->sentences[0]->trans == "") {
			$return= $palavra;
		}
		else {
			$return= utf8_decode($dados->sentences[0]->trans);
		}
		return $return;
	}
	return $palavra;
}

set_time_limit(10);
ini_set("max_execution_time", 10);

$cnt = 0;
$cntOk = 0;
$cntNok = 0;

mysql_select_db($database_pulsar, $pulsar);
$sql = "SELECT Id_foto, assunto_principal FROM Fotos WHERE assunto_en IS NULL ORDER BY Id_Foto DESC LIMIT 1000";
$codigos = mysql_query($sql, $pulsar) or die(mysql_error());

$timeBefore = microtime(true);

while($row_codigos = mysql_fetch_assoc($codigos)) {
	$cnt++;
	$id_foto = $row_codigos['Id_foto'];
	$assunto = $row_codigos['assunto_principal'];
	$assunto_en = addslashes(translateTextLocal($assunto));
	if($assunto_en != $assunto) {
		$update = "UPDATE Fotos SET assunto_en = '$assunto_en' WHERE Id_foto = $id_foto";
		echo $update."<br>";
		mysql_query($update, $pulsar) or die(mysql_error());
		$cntOk++;
	}
	else {
		echo "NOK: $id_foto | $assunto<br>";
		$update = "UPDATE Fotos SET assunto_en = '$assunto_en' WHERE Id_foto = $id_foto";
		echo $update."<br>";
		mysql_query($update, $pulsar) or die(mysql_error());
		$cntNok++;
	}
}

$timeAfter = microtime(true);
$diff = $timeAfter - $timeBefore;

echo "Time: $diff<br>";
echo "Records/Second: ".$cnt/$diff."<br>";
echo "Ok: $cntOk | Nok: $cntNok<br>";
?>
</body>