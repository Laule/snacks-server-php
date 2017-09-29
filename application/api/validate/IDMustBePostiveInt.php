<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/22
 * Time: 11:21
 */

namespace app\api\validate;


class IDMustBePostiveInt extends BaseValidate
{

    protected $rule =
        [
            'id' => 'require|isPositiveInteger'
        ];
    protected $message = [
        'id' => 'id必须是正整数'
    ];

}