<?php
return array(
//数据库配置信息
	'DB_TYPE'         => 'mysql', // 数据库类型
	'DB_HOST'         => '127.0.0.1', // 服务器地址
	'DB_NAME'         => 'innsysonline', // 数据库名
	'DB_USER'         => 'innsysdb', // 用户名
	'DB_PWD'          => 'miotinnsys', // 密码
	'DB_PORT'         => 3306, // 端口
	'DB_PREFIX'       => '', // 数据库表前缀
	'DB_CHARSET'      => 'utf8',
	'DEFAULT_FILTER'  => 'm_parse_param,htmlspecialchars',
	'DATA_CACHE_TYPE' => 'Memcache',// 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator
	'MEMCACHE_SERVER' => array(
		'type'   => 'Memcache',
		'host'   => '127.0.0.1',
		'port'   => '16490',
		'prefix' => 'yunzhanggui',
		'expire' => 60//默认cache过期时间,会被cahce配置覆盖
	),
	//云掌柜只读数据库配置
	'DB_CONFIG1'      => array(
		'db_type'    => 'mysql',
		'db_host'    => '127.0.0.1',
		'db_user'    => 'innsysdb',
		'db_pwd'     => 'miotinnsys',
		'db_port'    => '3306',
		'db_name'    => 'innsysonline',
		'db_charset' => 'utf8',
	),
	'DB_CONFIG2'      => array(
		'db_type'    => 'mysql',
		'db_host'    => '127.0.0.1',
		'db_user'    => 'innsysdb',
		'db_pwd'     => 'miotinnsys',
		'db_port'    => '3306',
		'db_name'    => 'innsysonline',
		'db_charset' => 'utf8',
	),
);


