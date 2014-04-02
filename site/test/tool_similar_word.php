<?php require_once('Connections/pulsar.php');?>
<?php
//$input = strtolower($_GET['word']);
$input = strtolower($query);

$interval = 3;
$input_len = strlen($input);
$word_len_max = $input_len + $interval;
$word_len_min = ($input_len - $interval) < 0 ? "0":($input_len - $interval);


$query_all_words = "SELECT DISTINCT(LOWER(Pal_Chave)) as Pal_Chave FROM pal_chave WHERE length(Pal_Chave) BETWEEN $word_len_min AND $word_len_max ORDER BY Pal_Chave ASC";
//echo $query_all_words;
$all_words = mysql_query($query_all_words, $pulsar) or die(mysql_error());
$totalRows_all_words = mysql_num_rows($all_words);
if($totalRows_all_words == 0) {
	echo $query_all_words;
}

$words = array();
while($row_all_words = mysql_fetch_assoc($all_words)) {
	$words[] = $row_all_words['Pal_Chave']; 
}

$distance = -1;

foreach($words as $word){
	$lev = levenshtein($input, $word);

	// exact match
	if($lev == 0){
		$closest = array();
		$closest[] = $word;
		$distance = 0;
		// no need to continue as we have found exact match
		break;
	}

	// if distance is less than the currently stored distance and it is less than our initial value
	if($lev <= $distance || $distance < 0){
		if($lev == $distance) {
			$closest[]  = $word;
		} else {
			$closest = array();
			$closest[]  = $word;
			$distance = $lev;
		}
	}
}
if(count($closest) > 0 && ($distance < ($input_len/2)) && ($distance < $interval*2)) {
?>
	<p class="p">Sugestões:</p>
	<ul>
<?php 
	foreach($closest as $similar) {
?>	 
		<li><a href="listing.php?query=<?php echo $similar?>&tombo=&id_autor%5B%5D=&local=&dia=&mes=&ano=&data_tipo=exata&pc_action=Ir&pc_action=Ir&tipo=inc_pc.php&autorizada=autorizada&horizontal=H&vertical=V&type=pc"><?php echo $similar?></a>: <?php echo $distance?></li>
<?php 		
	}
?>
	</ul>
<?php	
}
?>
