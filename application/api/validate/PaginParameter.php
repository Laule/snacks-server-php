<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/24
 * Time: 19:02
 */

namespace app\api\validate;


class PaginParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger'
    ];
    protected $message = [
        'page'=>'分页参数必须是正整数',
        'size'=>'分页参数必须是正整数',

    ];
}