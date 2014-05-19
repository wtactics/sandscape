<?php

$yii = dirname(__FILE__) . '/../framework/yii.php';
$config = dirname(__FILE__) . '/../sandscape/config/test.php';

if (is_file('debug.lock')) {
    $config = dirname(__FILE__) . '/../sandscape/config/local/test.php';

    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
}

require_once($yii);
Yii::createWebApplication($config)->run();
