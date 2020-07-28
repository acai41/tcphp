<?php

class Tcphp
{
    private $route;

    public function run()
    {
        require_once _SYS_PATH . 'core/Route.php';
        $this->route();
        $this->dispatch();
    }

    public function route()
    {
        $this->route = new Route();
        $this->route->init();
    }

    public function dispatch()
    {
        $controlName = $this->route->control . 'Controller';
        $actionName = $this->route->action . 'Action';
        $path = _APP . 'front' . DIRECTORY_SEPARATOR . 'module';
        $path .= DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $controlName . '.php';
        require_once $path;
        $methods = get_class_methods($controlName);
        if (!in_array($actionName, $methods, TRUE)) {
            throw new Exception(sprintf('方法名%s->%s不存在或非public', $controlName, $actionName));
        }
        $handler = new $controlName();
        $handler->param = $this->param;
        $handler->{$actionName}();
    }
}