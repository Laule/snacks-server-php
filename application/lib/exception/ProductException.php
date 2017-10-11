<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/11
 * Time: 16:09
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $msg = '指定的商品不存在，请检查参数';
    public $errorCode = 20000;
}