<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


//Route::rule('路由表达式'，'路由地址'，‘请求类型’，‘路由参数（数组）’，‘变量规则（数组）’);
//GET ,POST ,DELETE ,PUT ,*
//Route::rule('hello','sample/Test/hello','GET|POST|PUT',['https'=>false]);
//这里传一个:version 来控制版本号
use think\Route;

Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');
