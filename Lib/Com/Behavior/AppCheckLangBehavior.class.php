<?php
// +----------------------------------------------------------------------
// | Date: 2014.09.22
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://v.yunzhanggui.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: Johnny <guoyou.yang@miot.cn>
// +----------------------------------------------------------------------
// | Description:语言检测文件
// +----------------------------------------------------------------------
namespace Lib\Com\Behavior;
/**
 * 语言检测 并自动加载语言包
 */
class AppCheckLangBehavior {
    // 行为扩展的执行入口必须是run
    public function run(&$params){
        // 检测语言
        $this->checkLanguage();
    }

    /**
     * 语言检查
     * 检查浏览器支持语言，并自动加载语言包
     * @access private
     * @return void
     */
    private function checkLanguage() {
        // 不开启语言包功能，仅仅加载框架语言文件直接返回
        if (!C('LANG_SWITCH_ON',null,false)){
            return;
        }
        $langSet = C('DEFAULT_LANG');
        $varLang =  C('VAR_LANGUAGE',null,'l');
        $langList = C('LANG_LIST',null,'zh-cn');

        //客户端语言文件cookie名称
        $langCookieName=C('VAR_LANGUAGE_COOKIENAME',null,'think_language');
        // 启用了语言包功能
        // 根据是否启用自动侦测设置获取语言选择
        //临时关闭语言检测
	    cookie($langCookieName,$langSet,3600);
        if (C('LANG_AUTO_DETECT',null,false)){
            if(isset($_GET[$varLang])){
                $langSet = $_GET[$varLang];// url中设置了语言变量
                cookie($langCookieName,$langSet,3600);
            }elseif(cookie($langCookieName)){// 获取上次用户的选择
                $langSet = cookie($langCookieName);
            }elseif(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){// 自动侦测浏览器语言
                preg_match('/^([a-z\d\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches);
                $langSet = $matches[1];
                cookie($langCookieName,$langSet,3600);
            }
            if(false === stripos($langList,$langSet)) { // 非法语言参数
                $langSet = C('DEFAULT_LANG');
            }
        }
        // 定义当前语言
        define('LANG_SET',strtolower($langSet));

        // 读取框架语言包
        $file   =   THINK_PATH.'Lang/'.LANG_SET.'.php';
        if(LANG_SET != C('DEFAULT_LANG') && is_file($file))
            L(include $file);

        //读取框架扩展语言包
        $file   =   APP_PATH.'Lib/Lang/'.LANG_SET.'.php';
        if(LANG_SET != C('DEFAULT_LANG') && is_file($file))
            L(include $file);

        // 读取应用公共语言包
        $file   =  LANG_PATH.LANG_SET.'.php';
        if(is_file($file))
            L(include $file);
        
        // 读取模块语言包
        $file   =   MODULE_PATH.'Lang/'.LANG_SET.'.php';
        if(is_file($file))
            L(include $file);

        // 读取当前控制器语言包
        $file   =   MODULE_PATH.'Lang/'.LANG_SET.'/'.strtolower(CONTROLLER_NAME).'.php';
        if (is_file($file))
            L(include $file);
    }
}
