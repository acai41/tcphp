<?php


namespace Tcphp\core;

use library \render as render;

class Controller
{
    private $db;
    private $view;
    protected static $route;

    public function __construct()
    {
        require_once _ROOT.'library/render/PhpRender.php';
        //$this->view = new render\PhpRender();
        $this->view = new \PhpRender();

    }

    protected function assign($key, $val)
    {
        $this->view->assign($key, $val);
        return $this->view;
    }

    public function db($conf = [])
    {
        if ($conf == NULL) {
            $conf = $GLOBALS['_config']['db'];
        }
        $this->db = Db::getInstance($conf);
        return $this->db;
    }

    public function fetch($file = "")
    {
        ob_start();
        ob_implicit_flush(0);
        $this->display($file);
        $contents = ob_get_clean();
        return $contents;
    }
}