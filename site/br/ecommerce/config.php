<?
///////////////////////PAYPAL
/// configuração paypal conta vendedor
define('PWD_PAYPAL','LHQQN75JQP8JN7M2');
define('USER_PAYPAL','saulo_api1.pulsarimagens.com.br');
define('SIGNATURE_PAYPAL','AFcWxV21C7fd0v3bYYYRCpSSRl31AwRR42uND6pSn5Y6fPKcGS-rA1VX');

// insira a pagina de retorno após pagamento paypal
//segue o exemplo: paginaERRO.php?check=false
define('RETORNO_PAYPAL_TRUE','../retornoERRO.php?check=true');
define('RETORNO_PAYPAL_FALSE','../retornoERRO.php?check=false');
define('RETORNO_PAYPAL_CANCEL','../retornoERRO.php?check=cancel');


////////////////////////////////////////////////////////////////////////////////

//////////PAGSEGURO
/// configuração pagseguro para validar vendedor
define('TOKEN', 'DA02880FB3764F229DE3F39CD0218ECD');
define('EMAIL', 'saulo@pulsarimagens.com.br');
// insira a pagina de retorno após pagamento pagseguro
//segue o exemplo : paginaERRO.php?check=false
define('RETORNO_PAGSERUGO','../retornoERRO.php?check=check');





////configuração base de dados.....
define('DATA_USER','root');
define('DATA_PWS','');
define('DATA_DB','pulsar_administra');

//define('DATA_USER','jonasrod');
//define('DATA_PWS','jonas_grouver2012');
//define('DATA_DB','jonasrod_pulsar');

?>