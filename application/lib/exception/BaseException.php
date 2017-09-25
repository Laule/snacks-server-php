<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/25
 * Time: 14:41
 */

namespace app\lib\exception;


class BaseException
{
    //HTTP 状态码 400,200
    public $code = 400;
    //错误具体信息
    public $msg = '参数错误';
    //自定义错误码
    public $errorCode = 10000;
}