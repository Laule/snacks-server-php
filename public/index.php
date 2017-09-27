<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

//在这里修改日志文件路径，修改了base 就无效
define('LOG_PATH', __DIR__ . '/../log/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';


//在这里配置sql 日志 每个请求过来都会经过这个入口文件（初始化全局日志记录
\think\Log::init([
    'type' => 'File',
    'path' => LOG_PATH,
    'level' => ['sql']
]);
