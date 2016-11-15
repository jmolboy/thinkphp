<?php
// +----------------------------------------------------------------------
// | extension
// +----------------------------------------------------------------------
// | Author: johnny <johnnymol@163.com>
// +----------------------------------------------------------------------
namespace Lib\Com\Controller;
use Think\Controller;
class AppController extends Controller {

    //系统用户
    protected $SYSUSER=null;
    protected $SYSUSER_ID=0;
    protected $USERAUTH=null;

    protected $data=array();
    protected $ajaxdata=array('status'=>'success','msg'=>"");

    public function _initialize(){
        /**
         * 根据语言类型设置view不同主题
         *  LANG_SET是AppCheckLangBehavior定义的常量
         */
        if(defined('LANG_SET')){
            $this->theme(LANG_SET);
        }
        //session('[start]');
        $this->assignData('ts','161108');
        $this->assignData('data',$this->data);
	    if(defined('LANG_SET')){
		    $this->assignData('lang',LANG_SET);
	    }

        // add whops
        if(APP_DEBUG&&C('ADD_WHOOPS')){
            $whops=new \Whoops\Run();
            $isajax=IS_AJAX;
            if($isajax){
                $jsonHandler = new \Whoops\Handler\JsonResponseHandler();
                $jsonHandler->setJsonApi(true);
                $whops->pushHandler($jsonHandler);
            }
            else{
                $whops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
            }
            $whops->register();
        }
    }

    /**
     * @param array $arr array to assign,can visit from view
     */
    public function assignData($name,$arr=array())
    {
        if(count($arr)>0){
            $this->assign($name,$arr);
        }
    }


    /**
     * 根据语言类型显示语言模板
     * @param string $templateFile
     * @param string $charset
     * @param string $contentType
     * @param string $content
     * @param string $prefix
     */
    protected function appdisplay($templateFile='',$charset='',$contentType='',$content='',$prefix='') {
        $this->theme(LANG_SET)->display($templateFile,$charset,$contentType,$content,$prefix);
    }

    /**
     * assign default data
     */
    public function assignDefault()
    {
        $this->assign("data",$this->data);
    }

    /**
     * failed ajax resonse
     * @param string $msg
     */
    protected function ajaxFail($msg='')
    {
        $this->ajaxdata['status']='error';
        $this->ajaxdata['msg']=$msg;
        $this->ajaxReturn($this->ajaxdata);
        exit;
    }

    /**
     * successful ajax response
     * @param array $data
     */
    protected function ajaxSuccess($data=array())
    {
        $this->ajaxdata['status']='success';
        $this->ajaxdata['msg']='';
        $this->ajaxdata['data']=$data;
        $this->ajaxReturn($this->ajaxdata);
        exit;
    }

    /**
     * 使用location跳转
     * @param $url
     */
    public function locationredirect($url){
        header("Location: ".$url);exit;
    }

}