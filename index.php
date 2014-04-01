<?php

// alterar os seguintes caminhos se necessário
$yii=dirname(__FILE__).'/protected/yii-1.1.13/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remova as seguintes linhas no modo de produção
defined('YII_DEBUG') or define('YII_DEBUG',true);
// especificar quantos níveis de pilha de chamadas deve ser mostrado em cada mensagem de log
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
