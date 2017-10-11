<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/11
 * Time: 15:57
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule =
        [
            'count' => 'isPositiveInteger|between:1,15'
        ];
}