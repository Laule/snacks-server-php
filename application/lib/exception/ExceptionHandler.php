<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/25
 * Time: 14:37
 */

namespace app\lib\exception;


use think\Exception;
use think\exception\Handle;

class ExceptionHandler extends Handle
{

    //重写Handle 下的 render 方法 :: 父类 Handle  子类 ，本页
    //改写了后需要重新指定全局异常处理类config下配置'exception_handle'
   public function render(Exception $ex)
   {
     return json('~~~~~~~~~~~~~~');
   }
}