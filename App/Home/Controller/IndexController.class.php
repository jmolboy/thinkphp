<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends \Lib\Com\Controller\AppController
{
    public function index()
    {
        $Logic=new \Home\Logic\TestLogic();
        $Logic->Test();

        $this->display();
    }


}