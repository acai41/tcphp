<?php
namespace app\front\module\controller;

class IndexController
{
    public function indexAction(){

        require_once _SYS_PATH.'core/Db.php';
        print_r($GLOBALS);
        //$db=DB::getInstance($GLOBALS['_config']['db']);
        //$ret = $db->query('select * from aoa_bursement');
        //var_dump($ret);
        echo 'indexActon';
    }
    public function hiAction(){
        echo 'hiAction';
    }
}