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

    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return $field . '必须是正整数';
        }
    }
}