<?php
return array(
	//关闭多module模式
	'MULTI_MODULE'         => true,
	'MODULE_ALLOW_LIST'    => array('Home'),
	//默认module
	'DEFAULT_MODULE'       => 'Home',
	'URL_PARAMS_BIND'      => true,
	'TMPL_TEMPLATE_SUFFIX' => '.html',
	'URL_CASE_INSENSITIVE' => true,
	'URL_MODEL'            => 2,//0=普通模式,1=pathinfo模式,2=rewrite模式,3=兼容模式
	'SESSION_AUTO_START'   => false,
	'URL_ROUTER_ON'        => true,
	// 显示页面Trace信息，上线时关闭
	'SHOW_PAGE_TRACE'      => false,
	// 关闭数据库字段缓存	
	'DB_FIELDS_CACHE'      => false,
	'DEFAULT_FILTER'       => 'm_parse_param,htmlspecialchars',
	'LOAD_EXT_CONFIG'      => 'db_debug,cache,tahitisync,constant,constant_diff_debug',//加载其它配置文件
	'MODULE_DENY_LIST'     => array('Common', 'Runtime'),
	'TMPL_PARSE_STRING'    => array(
		'__PUBLIC__' => '', // 更改默认的/Public 替换规则
		'__JS__'     => '/jsmin', // 增加新的JS类库路径替换规则
		'__CSS__'    => '/css', // 增加新的CSS类库路径替换规则
		'__PAGEJS__' => '/pagejsmin', // 增加新的PAGEJS类库路径替换规则
		'__UPLOAD__' => '/upload', // 增加新的上传路径替换规则
		'__PIC__'    => '/pic', // 增加新的图片路径替换规则
		'__CSSH5__'  => '/h5/css',
		'__PICH5__'  => '/h5/pic',
		'__JSH5__'   => '/h5/jsmin',
	),
	'AUTOLOAD_NAMESPACE'   => array(
		'Lib' => APP_PATH . 'Lib',
	),
	'ADD_WHOOPS'           => true,//是否添加Excel格式化输出的whoops(需要composer install)
);