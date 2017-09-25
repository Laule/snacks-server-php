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
use think\Request;

class ExceptionHandler extends Handle
{

    //重写Handle 下的 render 方法 :: 父类 Handle  子类 ，本页
    //改写了后需要重新指定全局异常处理类config下配置'exception_handle' ，就是使用子类
    private $code;
    private $msg;
    private $errorCode;

    //需要返回客户端当前请求的URL路径
    public function render(Exception $e)
    {
        if ($e instanceof BaseException) {
            //  如果是自定义的异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            $this->code = 500;
            $this->msg = '服务器错误，不想告诉你';
            $this->errorCode = 999;

        }
        $request = Request::instance();

        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url()
        ];
        return json($result, $this->code);
    }
}