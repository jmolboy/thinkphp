<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {


        $whops=new \Whoops\Run();
        $whops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
        $whops->register();


        $Testlogic=new \Home\Logic\TestLogic();
        $res = $Testlogic->Test();
        print(json_encode($res));

        $this->division(10,0);
    }

    public function division($dividend,$divisor){
        if($divisor==0){
            throw new \Exception("Division by zero");
        }
    }

}