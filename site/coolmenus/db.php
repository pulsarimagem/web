<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_teste = "10.139.11.72";
$database_teste = "livro-apache";
$username_teste = "pulsarimagens";
$password_teste = "basepulsar1991";
$teste = mysql_pconnect($hostname_teste, $username_teste, $password_teste) or trigger_error(mysql_error(),E_USER_ERROR); 
?>