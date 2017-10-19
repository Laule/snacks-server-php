<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/18
 * Time: 14:43
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use app\lib\exception\ProductException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts'
    ];
    protected $singRule = [
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger'
    ];

    protected function checkProducts($values)
    {
        if (empty($values)) {
            throw new ProductException(
                [
                    'msg' => '商品列表不能为空'
                ]
            );
        }
        if (!is_array($values)) {
            throw new ProductException([
                'msg' => '商品列表不能为空'
            ]);
        }
        foreach ($values as $value) {
            $this->checkProduct($value);
        }
        return true;
    }

    protected function checkProduct($value)
    {
        $validate = new BaseValidate($this->singRule);
        $result = $validate->check($value);
        if (!$result) {
            throw new ProductException([
                'msg' => '商品列表参数错误',

            ]);
        }
    }
}