<?php
//namespace Tcphp\core;


class Loader
{
    public static function loadClass(){

    }
    public static function loadLibClass($class){
        $classFile=_ROOT.$class.'.php';
        require_once $classFile;
    }
}