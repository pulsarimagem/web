<?php
$startRenderTime = microtime(true);
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$homeurl = "/var/www/pulsar/site/";
$homeftp = "/var/www/pulsar/site/ftp/";
$fotosalta = "/var/fotos_alta/";
$thumbpop = "/var/www/pulsar/site/bancoImagens/";

$cloud_server = "http://177.71.182.64/";

$siteDebug = false;
//$siteDebug = true;

$hostname_pulsar = "localhost";
$database_pulsar = "pulsar_teste";
$username_pulsar = "pulsar";
$password_pulsar = "v41qv412012";
$pulsar = mysql_pconnect($hostname_pulsar, $username_pulsar, $password_pulsar) or trigger_error(mysql_error(),E_USER_ERROR); 

include("functions.php");
?>