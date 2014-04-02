<?php  

//session_start();

if (isset($_GET['logout'])) {
	//declare two session variables and assign them
	unset($GLOBALS['MM_Username']);
	unset($GLOBALS['MM_UserGroup']);
	
	//register the session variables
//	session_unregister("MM_Username");
//	session_unregister("MM_UserGroup");
	unset($_SESSION['MM_Username']);
	unset($_SESSION['MM_UserGroup']);
	
	$logged = false;
	header("Location: index.php");
}

function get_location_xml( $ip ) {
  return http_get( "http://api.hostip.info/?ip=$ip" );
}

function http_get( $url ) {
  $request = fopen( $url, "rb" );
  $result = "";

  while( !feof( $request ) ) {
    $result .= fread( $request, 8192 );
  }

  fclose( $request );

  return $result;
}

function get_tag_contents( $xml, $tag ) {
  $result = "";
  $s_tag = "<$tag>";
  $s_offs = strpos( $xml, $s_tag );

  // If we found a starting offset, then look for the end-tag.
  //
  if( $s_offs >= 0 ) {
    $e_tag = "</$tag>";
    $e_offs = strpos( $xml, $e_tag, $s_offs );

    // If we have both tags, then dig out the contents.
    //
    if( $e_offs >= 0 ) {
      $result = substr(
        $xml,
        $s_offs + strlen( $s_tag ),
        $e_offs - $s_offs - strlen( $e_tag ) + 1 );
    }
  }

  return $result;
}

function get_remote_ip() {
  return $_SERVER['REMOTE_ADDR'];
}

function parse_city( $location ) {
  $contents = get_tag_contents( $location, "Hostip" );
  $city = trim( get_tag_contents( $contents, "gml:name" ) );

  // If the city couldn't be found, it'll contain the word "private".
  //
  if( stristr( $city, "private" ) ) {
    $city = "";
  }

  return $city;
}

function parse_country( $location, $default = "BR" ) {
  $contents = get_tag_contents( $location, "Hostip" );
  $country = trim( get_tag_contents( $contents, "countryAbbrev" ) );

  // If the country couldn't be found, default to Canada.
  //
  if( stristr( $country, "xx" ) ) {
    $country = $default;
  }

  return $country;
}

if (!(isset($_SESSION['MyPulsar']))) {
	
	require_once('Connections/pulsar.php'); 
//	session_register("MyPulsar");
	$_SESSION['MyPulsar'] = "MyPulsar";
	
//	$lang = getenv('HTTP_ACCEPT_LANGUAGE');
//	$lang = preg_replace('/(;q=[0-9]+.[0-9]+)/i','',$lang);
//	$lang_array = explode(",", $lang);
//	$lang_type = substr ($lang, 0, 2);
	$lang_type == "br";
	/*
	$location = get_location_xml( get_remote_ip() );
	$city = parse_city( $location );
	$country = parse_country( $location );
	*/
	$country="XX";
/*	require('languages.php');
	$languages = new languages();
	$country = $languages->lang;
    $GLOBALS['MyPulsar'] = $country;
*/
	if ($country == "BR") 
	{
//	  Header("Location: ".$homeurl.""); 
    } else { 
      	if ($lang_type == "en" OR $lang_type == "en") 
      	{
//			Header("Location: ".$homeurl."/en/"); 
        } else {
//        	Header("Location: ".$homeurl."/"); 
    	}
    }
//	exit;
}

?>