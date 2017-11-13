<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/11/13
 * Time: 15:02
 */

namespace app\lib\exception;


/**
 * 创建成功（如果不需要返回任何消息）
 * 201 创建成功，202需要一个异步的处理才能完成请求
 */
class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg = 'ok';
    public $errorCode = 0;
}