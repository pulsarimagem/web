<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_sig = "localhost";
$database_sig = "sig_teste";
$username_sig = "pulsar";
$password_sig = "v41qv412012";
$sig = mysql_pconnect($hostname_sig, $username_sig, $password_sig) or trigger_error(mysql_error(),E_USER_ERROR); 
?>