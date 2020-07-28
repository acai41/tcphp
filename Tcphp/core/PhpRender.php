<?php


namespace Tcphp\core;


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