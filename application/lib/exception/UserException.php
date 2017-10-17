<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/17
 * Time: 21:57
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = '60000';
}