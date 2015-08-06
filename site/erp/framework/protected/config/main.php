<?php
//Descomente para definir um caminho "path alias"
//Yii::setPathOfAlias('local','path/to/local-folder');
//Esta e a configuração da aplicação Web principal. editavel
//CWebApplication propriedades podem ser configurados aqui.
return array(
	//Diretorio base
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	//Controller padrao
	'defaultController' => 'home/index',
    //Nome da empresa
	'name'=>'Pulsar Admin',
	//Definindo linguagem e onde buscar a traducao base
	'sourceLanguage'=>'pt_br',
    'language'=>'pt_br',
	//Componente pre-carregamento 'log'
	'preload'=>array('log'),
	//Upload de classes, componentes e extensoes
	'import'=>array(
		'application.models.*',
        'application.components.*',
        'application.extensions.*',
		'application.dao.*',
		'application.extensions.menu.*',
	), 
	//Criacoes do Gii models/formularios/controllers/cruds/modulos
	'modules'=>array(
		//Configuracao de senhas para o acesso ao modulo
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'m4v3r1ck',
			//Configurar Bloqueio por ips
			//'ipFilters'=>array('127.0.0.1','::1'),
		),		
	),
	//Componentes da aplicacao
	'components'=>array(
		'session' => array(
			'class' => 'CDbHttpSession',
            'timeout' => 63115200000,
        ),	
		'user'=>array(
			//Habilitar a autenticação baseada em cookie
			'allowAutoLogin'=>true,
			'autoRenewCookie' => true,
            'authTimeout' => 63115200000,
		),
		//Formatacao de data e hora, data, hora, numeros decimais com duas casas e separados por virgula 
		'formater' => array(
	        'datetimeFormat' => 'd/m/Y H:i:s',
	        'dateFormat' => 'd/m/Y',
	        'timeFormat' => 'H:i:s',
	        'numberFormat' => array(
	          'decimals' => '2',
	          'decimalSeparator' => ',',
	          'thousandSeparator' => '.',
	        )
	    ),
		//Descomente o seguinte codigo para ativar URLs amigaveis, a configuracao do .hthaccss esta na pasta
		//	protected/documents/urlAmigaveisNoYii/configurar.txt sevindo como exemplo.
		
	    'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'caseSensitive'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				
			),
		),
		//Codigo de configuracao para usar o banco de dados em MYSQL
		
		'db'=>array(
			'connectionString' => 'mysql:host=pulsar-dev.cgtvqlyxved2.sa-east-1.rds.amazonaws.com;dbname=pulsar_dev',
			'emulatePrepare' => false,
			'username' => 'pulsaraws',
			'password' => 'v41qv412012',
			'charset' => 'utf8',
		),
		//Codigo de configuracao para usar o banco de dados em MYSQL
		
		'dbSig'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=pulsar-dev.cgtvqlyxved2.sa-east-1.rds.amazonaws.com;dbname=sig_dev',
			'emulatePrepare' => false,
			'username' => 'pulsaraws',
			'password' => 'v41qv412012',
			'charset' => 'utf8',
		),
		
		//pagina de erros 
		'errorHandler'=>array(
			'errorAction'=>'error/error',
		),
		//Log
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				//descomente o seguinte codigo para exibir as mensagens de erro de log na página web	
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),
	),
	//Parametros de nivel de aplicativo que podem ser acessados
	//Usando Yii::app()->params['paramName']
	'params'=>array(
		// Isto é usado em página de contato
		'adminEmail'=>'fernandomdib@gmail.com',
	),
);
