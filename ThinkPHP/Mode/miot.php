<?php
// +----------------------------------------------------------------------
// | Date: 2016.11.10
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://v.yunzhanggui.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jmol <guoyou.yang@miot.cn>
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
/**
 * ThinkPHP Lite模式定义
 */
return array(
    // 配置文件
    'config' => array(
        MODE_PATH . 'Lite/convention.php', // 系统惯例配置
        CONF_PATH . 'config' . CONF_EXT, // 应用公共配置
    ),

    // 别名定义
    'alias'  => array(
        'Think\Exception'         => CORE_PATH . 'Exception' . EXT,
        'Think\Model'             => CORE_PATH . 'Model' . EXT,
        'Think\Db'                => CORE_PATH . 'Db' . EXT,
        'Think\Cache'             => CORE_PATH . 'Cache' . EXT,
        'Think\Cache\Driver\File' => CORE_PATH . 'Cache/Driver/File' . EXT,
        'Think\Storage'           => CORE_PATH . 'Storage' . EXT,
    ),

    // 函数和类文件
    'core'   => array(
        MODE_PATH . 'Lite/functions.php',
        COMMON_PATH . 'Common/function.php',
        CORE_PATH . 'Hook' . EXT,
        CORE_PATH . 'App' . EXT,
        CORE_PATH . 'Dispatcher' . EXT,
        //CORE_PATH . 'Log'.EXT,
        CORE_PATH . 'Route' . EXT,
        CORE_PATH . 'Controller' . EXT,
        CORE_PATH . 'View' . EXT,
    ),
    // 行为扩展定义
    'tags'   => array(
    ),
);
