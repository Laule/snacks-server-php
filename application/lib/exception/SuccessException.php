<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/17
 * Time: 22:12
 */

namespace app\lib\exception;


class SuccessException
{
    public $code = 201;
    public $msg = 'ok';
    public $errorCode = 0;
}