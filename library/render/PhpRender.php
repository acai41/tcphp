<?php


require_once _SYS_PATH . 'core/Render.php';


class PhpRender implements Render
{
    private $value = array();
    public function init(){

    }
    public function assign($key,$value){
        $this->value[$key]=$value;
    }
    public function display($view=''){
        extract($this->value);
        include $view;
    }
}