<?php
//Alterar os seguintes caminhos se necessario
$yii=dirname(__FILE__).'/protected/yii-1.1.13/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

//Remova as seguintes linhas no modo de producao ou altere para false
defined('YII_DEBUG') or define('YII_DEBUG',false);
//Especificar quantos niveis de pilha de chamadas deve ser mostrado em cada mensagem de log
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
//Registra e aplica todas as configuracoes
Yii::createWebApplication($config)->run();
