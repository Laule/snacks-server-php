<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/25
 * Time: 14:37
 */

namespace app\lib\exception;


use think\Config;
use think\Exception;
use think\exception\Handle;
use think\Log;
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
//       [instanceof] 作用：（1）判断一个对象是否是某个类的实例，（2）判断一个对象是否实现了某个接口。
        if ($e instanceof BaseException) {
            //  如果是自定义的异常(客户端引发的错误)
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
//            服务器代码错误、调用外部接口错误

//            Config::get('app_debug'); 这个能直接从config中读取配置信息

            //用app_debug 变量代替 开关变量
            if (config('app_debug')) {
                return parent::render($e);
            } else {
                $this->code = 500;
                $this->msg = '服务器错误，不想告诉你';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }


        }
        $request = Request::instance();

        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url()
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(Exception $e)
    {
        Log::init([ //初始化日志配置
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error'] //这里定义error级别的（只有高于error级别的才能记录日志）
        ]);
        Log::record($e->getMessage(), 'error');
    }
}