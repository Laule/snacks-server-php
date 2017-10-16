<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/16
 * Time: 18:46
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule =
        [
            'code' => 'require|isNotEmpty'
        ];
    protected $message =
        [
            'code' => '没有code不能获取Token'
        ];
}