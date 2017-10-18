<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/18
 * Time: 15:11
 */

namespace app\api\service;


use app\api\model\Product;

class Order
{
    // 订单的商品列表，也就是客户端传递过来的product参数
    protected $oProducts;

    // 真实的商品信息（包括库存量）
    protected $products;

    protected $uid;

    public function place($uid, $oProducts)
    {
        // oProduct 和 products 库存对比
        // products 从数据库中查询出来的

        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;

    }

    // 根据订单信息查找真实的商品信息
    private function getProductsByOrder($oProducts)
    {
//        foreach ($oProducts as $oProduct)
//        {
//            // 循环查询数据库（非常容易把数据库搞挂掉 ！）
//        }
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        $products = Product::all($oPIDs)
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();
        return $products;
    }
}