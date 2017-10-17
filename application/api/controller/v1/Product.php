<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/11
 * Time: 15:48
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getAllInCategory($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $products = ProductModel::getProductByCategoryID($id);
        if ($products->isEmpty()) {
            throw new  ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getOne($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if (!$product) {
            throw new ProductException();
        } else {
            return $product;
        }
    }
}