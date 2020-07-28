<?php
namespace Tcphp\core;

class Route
{
    public $group;
    public $control;
    public $action;
    public $params;

    public function __construct()
    {
    }

    public function init()
    {
        $route = $this->getRequest();
        $this->group = $route['group'];
        $this->control = $route['controll'];
        $this->action = $route['action'];
        !empty($route['param']) && $this->params = $route['param'];
    }

    public function getRequest()
    {

        $filter_param = array('<', '>', '"', "'", '%3C', '%3E', '%22', '%27', '%3c', '%3e');
        $uri = str_replace($filter_param, '', $_SERVER['REQUEST_URI']);
        $path = parse_url($uri);
        if (strpos($path['path'], 'index.php') == 0) {
            $urlR0 = $path['path'];
        } else {
            $urlR0 = substr($path['path'], strlen('index.php') + 1);
        }
        $urlR = ltrim($urlR0, '/');
        if ($urlR == '') {
            $route = $this->parseTradition();
            return $route;
        }
        $regArr = explode('/', $urlR);
        foreach ($regArr as $key => $value) {
            if (empty($value)) {
                unset($regArr[$key]);
            }
        }
        $cnt = count($regArr);
        if (empty($regArr) || empty($regArr[0])) {
            $cnt = 0;
        }
        switch ($cnt) {
            case 0:
                $route['controll'] = $GLOBALS['_config']['defaultController'];
                $route['action'] = $GLOBALS['_config']['defaultAction'];
                $route['group'] = $GLOBALS['_config']['defaultApp'];
                break;
            case 1:
                if (stripos($regArr[0], ':')) {
                    $gc = explode(':', $regArr[0]);
                    $route['group'] = $gc[0];
                    $route['controll'] = $gc[1];
                    $route['action'] = $GLOBALS['_config']['defaultAction'];
                } else {
                    $route['group'] = $GLOBALS['_config']['defaultApp'];
                    $route['controll'] = $regArr[0];
                    $route['action'] = $GLOBALS['_config']['defaultAction'];
                }
                break;
            default:
                if (stripos($regArr[0], ':')) {
                    $gc = explode(':', $regArr[0]);
                    $route['group'] = $gc[0];
                    $route['controll'] = $gc[1];
                    $route['action'] = $regArr[1];
                } else {
                    $route['group'] = $GLOBALS['_config']['defaultApp'];
                    $route['controll'] = $regArr[0];
                    $route['action'] = $regArr[1];
                }
                for ($i = 2; $i < $cnt; $i++) {
                    $route['param'][$regArr[$i]] = isset($regArr[++$i]) ? $regArr[$i] : '';
                }
                break;
        }
        if (!empty($path['query'])) {
            parse_str($path['query'], $routeQ);
            if (empty($route['param'])) {
                $route['param'] = array();
            }
            $route['param'] += $routeQ;
        }
        return $route;
    }
}