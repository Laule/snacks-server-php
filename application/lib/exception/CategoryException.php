<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/12
 * Time: 9:01
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '指定的类目不存在，请检查参数';
    public $errorCode = 50000;
}