<?php

class paypalClass{
	
	public function Link($nvp){
		$curl = curl_init();
		// link ambiente real https://api-3t.paypal.com/nvp
		curl_setopt( $curl , CURLOPT_URL , 'https://api-3t.paypal.com/nvp' ); //Link para ambiente de teste: https://api-3t.sandbox.paypal.com/nvp
		curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );
		curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt( $curl , CURLOPT_POST , 1 );
		curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );
		
		$response = urldecode( curl_exec( $curl ) );
		
		curl_close( $curl );
		
		$responseNvp = array();
		
		if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
			foreach ( $matches[ 'name' ] as $offset => $name ) {
				$responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
			}
		}

		if ( isset( $responseNvp[ 'ACK' ] ) && $responseNvp[ 'ACK' ] == 'Success' ) {
			$paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
			$query = array(
				'cmd'	=> '_express-checkout',
				'token'	=> $responseNvp[ 'TOKEN' ]
			);
		
			return  $paypalURL . '?' . http_build_query( $query ) ;
			 
		} else {
			return 'retornoERRO.php?check=false';
		}

		
		
		}
	
	
	
	}



?>