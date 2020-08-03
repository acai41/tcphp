<?php

//namespace Tcphp;
class Tcphp
{
    private $route;

    public function __construct()
    {
        require_once _SYS_PATH . 'core/Loader.php';
        $GLOBALS['_config'] = require_once _SYS_PATH . 'config.php';
        spl_autoload_register(array('Loader', 'loadLibClass'));
        if ('debug' == $GLOBALS['_config']['mode']) {
            if (substr(PHP_VERSION, 0, 3) >= "5.5") {
                error_reporting(E_ALL);
            } else {
                error_reporting(E_ALL | E_STRICT);
            }
        }else{
            set_error_handler(['Tcphp','errorHandler']);
        }
        set_exception_handler(['Tcphp','exceptionHandler']);

    }

    public function run()
    {
        $this->route();
        $this->dispatch();
    }

    public function route()
    {
        $this->route = new \Tcphp\core\Route();
        $this->route->init();
    }

    public function dispatch()
    {
        $controlName = ucfirst($this->route->control) . 'Controller';
        $actionName = $this->route->action . 'Action';
        $group = $this->route->group;
        $className = "app\\{$group}\module\controller\\{$controlName}";
        $methods = get_class_methods($className);
        if (!in_array($actionName, $methods, TRUE)) {
            throw new Exception(sprintf('方法名%s->%s不存在或非public', $controlName, $actionName));
        }
        $handler = new $className();
        $reflectedClass = new ReflectionClass('Tcphp\core\Controller');
        $reflectedProperty = $reflectedClass->getProperty('route');
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue($this->route);
        $handler->{$actionName}();
    }

    public static function exceptionHandler($exception)
    {
        echo "caught exception:", $exception->getMessage(), "\n";
    }

    public static function errorHandler($errNo, $errStr, $errFile, $errLine)
    {
        $err = '错误级别:' . $errNo . '|错误描述:' . $errStr;
        $err .= '|错误所在文件:' . $errFile . '|错误所在行号:' . $errLine . "\r\n";
        echo $err;
        file_put_contents(_APP . 'log.txt', $err, FILE_APPEND);
    }
}