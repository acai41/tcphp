<?php
define('_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);//网站根目录
define('_SYS_PATH', _ROOT . 'Tcphp' . DIRECTORY_SEPARATOR);//系统目录
define('_APP', _ROOT . 'app' . DIRECTORY_SEPARATOR);//应用根目录
require _SYS_PATH . 'Tcphp.php';
$app = new Tcphp;
$app->run();