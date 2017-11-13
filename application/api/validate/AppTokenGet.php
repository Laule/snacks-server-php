<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/11/13
 * Time: 10:00
 */

namespace app\api\validate;


class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'ac' => 'require|isNotEmpty',
        'se' => 'require|isNotEmpty'
    ];
}