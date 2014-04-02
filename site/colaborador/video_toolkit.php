<?php
// $type must equal 'GET' or 'POST'
function curl_request_async($url, $params, $type='POST')
{
	foreach ($params as $key => &$val) {
		if (is_array($val)) $val = implode(',', $val);
		$post_params[] = $key.'='.urlencode($val);
	}
	$post_string = implode('&', $post_params);

	$parts=parse_url($url);

	$fp = fsockopen($parts['host'],
	isset($parts['port'])?$parts['port']:80,
	$errno, $errstr, 30);

	// Data goes in the path for a GET request
	if('GET' == $type) $parts['path'] .= '?'.$post_string;

	$out = "$type ".$parts['path']." HTTP/1.1\r\n";
	$out.= "Host: ".$parts['host']."\r\n";
	$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
	$out.= "Content-Length: ".strlen($post_string)."\r\n";
	$out.= "Connection: Close\r\n\r\n";
	// Data goes in the request body for a POST request
	if ('POST' == $type && isset($post_string)) $out.= $post_string;
//echo $out."<br>";
	fwrite($fp, $out);
	fclose($fp);
}


function create_movie_thumb($base_dir, $src_file, $dst_dir) {
	
	// where ffmpeg is located, such as /usr/sbin/ffmpeg
	$ffmpeg = 'E:/Pulsar/ffmpeg-git-4082198-win32-static/bin/ffmpeg';
	 
	// the input video file
	$video  = $base_dir."/".$src_file;
	 
	// where you'll save the image
	$image  = $src_file;
	 
	// default time to get the image
	$second = 1;
	 
	// get the duration and a random place within that
	$cmd = "$ffmpeg -i $video 2>&1";

	if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
	    $total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
	    for($i = 0; $i < $total; $i+=10)
	    	$seconds[] = $i;
	}

	$seconds = array(0,3,6);
	foreach ($seconds as $second) {
		$image = str_ireplace(".mov", "", $src_file)."_".$second."s.jpg";
		// get the screenshot
		$cmd = "$ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -s 150x100 -r 1 -y -vcodec mjpeg -f mjpeg $dst_dir/$image 2>&1";
		$return = `$cmd`;
	}	 
	// done! <img src="http://blog.amnuts.com/wp-includes/images/smilies/icon_wink.gif" alt=";-)" class="wp-smiley">
	echo 'done!';
}

function generate_codigo($autor, $filename, $pulsar) {
/*
create table codigo_video  (
autor varchar(5) not null,
ano int(2) not null,
contador int(4) not null default 0,
codigo varchar(11),
arquivo varchar(100),
primary key (autor,ano,contador)
);
 */
	if($filename == "")
		return false;
	$ano = date("y");
	$query_busca_filename = "SELECT * FROM codigo_video WHERE autor like '$autor' AND arquivo like '$filename' AND ano = $ano AND DATE(data) = DATE(NOW())";
	$busca_filename = mysql_query($query_busca_filename, $pulsar) or die(mysql_error());
	$row_busca_filename = mysql_fetch_assoc($busca_filename);
	$totalRows_busca_filename = mysql_num_rows($busca_filename);
	if($totalRows_busca_filename > 0) {
		return $row_busca_filename['codigo'];
	}
	$query_ultimo_codigo = "SELECT contador FROM codigo_video WHERE autor like '$autor' AND ano = $ano ORDER BY contador DESC LIMIT 1";
//echo $query_ultimo_codigo;
	$ultimo_codigo = mysql_query($query_ultimo_codigo, $pulsar) or die(mysql_error());
	$row_codigo = mysql_fetch_assoc($ultimo_codigo);
	$totalRows_codigo = mysql_num_rows($ultimo_codigo);
	if($totalRows_codigo > 0) {
		$contador=$row_codigo['contador']+1;
//echo 		$contador;
	}
	else {
		$contador=0;
	}
	$codigo = $autor.$ano.str_pad($contador,4,"0",STR_PAD_LEFT);
	$query_soma_codigo = "INSERT INTO codigo_video (autor,ano,contador,codigo,arquivo) VALUES ('$autor',$ano,$contador,'$codigo','$filename')";
	$soma_codigo = mysql_query($query_soma_codigo, $pulsar) or die(mysql_error());
	return $codigo;
}
?>