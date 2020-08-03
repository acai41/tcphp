<?php
namespace app\front\module\controller;

use Tcphp\core\Controller;

class IndexController extends Controller
{
    public function indexAction(){

 5%0;
        //require_once _SYS_PATH.'core/Db.php';
        //print_r($GLOBALS);
        //$db=DB::getInstance($GLOBALS['_config']['db']);
        //$ret = $db->query('select * from aoa_bursement');
        //var_dump($ret);
        echo 'indexActon';
    }
    public function hiAction(){
        echo 'hiAction';
    }
}