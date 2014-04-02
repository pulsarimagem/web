<?php
///////////////////////PAYPAL
/// configuração paypal conta vendedor
define('PWD_PAYPAL','7Y9J6JWDKDSJYEDS');
define('USER_PAYPAL','contact_api1.pulsarimages.com');
define('SIGNATURE_PAYPAL','AFcWxV21C7fd0v3bYYYRCpSSRl31AQlWpjm65AomNb2Q3bJHzUiCNh5Z');


//define('PWD_PAYPAL','LHQQN75JQP8JN7M2');
//define('USER_PAYPAL','saulo_api1.pulsarimagens.com.br');
//define('SIGNATURE_PAYPAL','AFcWxV21C7fd0v3bYYYRCpSSRl31AwRR42uND6pSn5Y6fPKcGS-rA1VX');

// insira a pagina de retorno após pagamento paypal
//segue o exemplo: paginaERRO.php?check=false
define('RETORNO_PAYPAL_TRUE','../retornoERRO.php?check=true');
define('RETORNO_PAYPAL_FALSE','../retornoERRO.php?check=false');
define('RETORNO_PAYPAL_CANCEL','../retornoERRO.php?check=cancel');


require_once("log.class.php");
require_once("pedido.class.php");
$PWD = PWD_PAYPAL; /// constant
$USER = USER_PAYPAL;/// constant
$SIGNATURE = SIGNATURE_PAYPAL;/// constant

if ( isset( $_GET[ 'token' ] ) ) {
	$token = $_GET[ 'token' ];

	$nvp = array(
		'TOKEN'							=> $token,
		'METHOD'						=> 'GetExpressCheckoutDetails',
		'VERSION'						=> '91',
		'PWD'							=>  $PWD,
		'USER'							=> $USER,
		'SIGNATURE'						=> $SIGNATURE,
	);

	$curl = curl_init();
	/// link ambiente real https://api-3t.paypal.com/nvp
	curl_setopt( $curl , CURLOPT_URL , 'https://api-3t.paypal.com/nvp' ); //Link para ambiente de teste: https://api-3t.sandbox.paypal.com/nvp
	curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );
	curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );
	curl_setopt( $curl , CURLOPT_POST , 1 );
	curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );

	$response = urldecode( curl_exec( $curl ) );
	$responseNvp = array();

	if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
		foreach ( $matches[ 'name' ] as $offset => $name ) {
			$responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
		}
	}
	echo '<br><br><br>';
	if ( isset( $responseNvp[ 'TOKEN' ] ) && isset( $responseNvp[ 'ACK' ] ) ) {
		if ( $responseNvp[ 'TOKEN' ] == $token && $responseNvp[ 'ACK' ] == 'Success' ) {
			$nvp[ 'PAYERID' ]							= $responseNvp[ 'PAYERID' ];
			$nvp[ 'PAYMENTREQUEST_0_AMT' ]				= $responseNvp[ 'PAYMENTREQUEST_0_AMT' ];
			$nvp[ 'PAYMENTREQUEST_0_CURRENCYCODE' ]		= $responseNvp[ 'PAYMENTREQUEST_0_CURRENCYCODE' ];
			$nvp[ 'PAYMENTREQUEST_0_INVNUM' ] = $responseNvp[ 'PAYMENTREQUEST_0_INVNUM' ];
			$nvp[ 'METHOD' ]							= 'DoExpressCheckoutPayment';
			$nvp[ 'PAYMENTREQUEST_0_PAYMENTACTION' ]	= 'Sale';

			curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );

			$response = urldecode( curl_exec( $curl ) );
			$responseNvp = array();

			if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
				foreach ( $matches[ 'name' ] as $offset => $name ) {
					$responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
				}
			}

			if ( $responseNvp[ 'PAYMENTINFO_0_PAYMENTSTATUS' ] == 'Completed' ) {
				//O post foi validado pelo Paypal.
				// mudo o status da transação
				$dt = explode('-',$responseNvp['TIMESTAMP']);
				$day = substr($dt[2], 0, 2);
				$dt = $day.'/'.$dt[1].'/'.$dt[0]; 
				$statusTransacao = new Pedido();
				$statusTransacao->tabela = 'pedidos';
				$statusTransacao->atualizaTransacao(array('statustransacao' => 'Concluida', 'data' => $dt), 'cod_pedido='.$nvp[ 'PAYMENTREQUEST_0_INVNUM' ]);
				
				echo 'Parabéns, sua compra foi concluída com sucesso';
				header('Location: '.RETORNO_PAYPAL_TRUE);
				
			} else {
				$dt = explode('-',$responseNvp['TIMESTAMP']);
				$day = substr($dt[2], 0, 2);
				$dt = $day.'/'.$dt[1].'/'.$dt[0]; 
				$statusTransacao = new Pedido();
				$statusTransacao->tabela = 'pedidos';
				$statusTransacao->atualizaTransacao(array('statustransacao' => 'Pendente', 'data' => $dt), 'cod_pedido='.$nvp[ 'PAYMENTREQUEST_0_INVNUM' ]);
				
				header('Location: '.RETORNO_PAYPAL_FALSE);
				
			}
		} else {

			header('Location: '.RETORNO_PAYPAL_FALSE);
		}
	} else {
		echo '<pre>';
		
		echo 'Não foi possível concluir a transação';
	}

	curl_close( $curl );
}


?>