<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/26
 * Time: 9:40
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}