<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/18
 * Time: 15:11
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\ProductException;
use app\lib\exception\UserException;
use app\api\model\Order as OrderModel;
//  哈哈哈~ 这个引用错了(本 service)，花了我好长时间 。
use think\Db;
use think\Exception;

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
        // 根据用户传输的订单信息 去数据库查找
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
        $status = $this->getOrderStatus();
        // 库存量检测失败 order_id -1
        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }
        // 开始创建订单
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;

    }

    private function createOrder($snap)
    {
        // 要么一起执行，要么都不执行
        // 开始事务
        Db::startTrans();
        // 对复杂的业务操作 或 数据库操作 最好加一个异常处理
        try {
            $orderNo = $this->makeOrderNo();
            $order = new OrderModel();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);

            $order->save();
            //  order 与 order_product
            $orderID = $order->id;
            $create_time = $order->create_time;
            // 需要加一个引用符号 这样才能对数组的属性进行操作
            // foreach作用: 修改了oProduct 修改完之后再保存  为oProduct每个子元素新增一个OrderId
            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            // 提交事务
            Db::commit();
            return
                [
                    'order_no' => $orderNo,
                    'order_id' => $orderID,
                    'order_time' => $create_time
                ];
        } catch (Exception $ex) {
            // 事务回滚（就是防止一个操作执行 ， 其它个不执行）
            Db::rollback();
            throw $ex;
        }
    }

//     生成订单号
    public static function makeOrderNo()
    {
        // dechex() 把10进制转换成16进制  strtoupper()转换成大写字符串 microtime 时间戳的微秒数
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }
    
    

    // 生成订单快照
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            // 订单缩略名字
            'snapName' => '',
            'snapImg' => '',
        ];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];
        if (count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }
        return $snap;

    }

    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)
            ->find();
        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户收货地址不存在，下单失败！',
                'errorCode' => 60001,

            ]);
        }
        return $userAddress->toArray();
    }

    // 获取订单的状态
    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []
        ];
        // 循环用户传输过来的oProduct（商品条目）
        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus(
                $oProduct['product_id'], $oProduct['count'], $this->products
            );
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            // orderPrice(订单总价) totalPrice（单个商品价格）
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }
    // 用户传递过来订单列表的某一条字段[商品ID，总数，数据库查询到的一组商品集合]
    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;
        // 保存商品的某一个详细信息
        // haveStock库存有无
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => ''
        ];
        // 根据商品ID 查找商品集合中的某一项 ，若有 $pIndex 赋新值
        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;

            }
        }
        if ($pIndex == -1) {
            // 客户端传递的product_id 有可能不存在
            throw new OrderException([
                'msg' => 'id为' . $oPID . '商品不存在，创建订单失败！'
            ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $product['price'] * $oCount;
            if ($product['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
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
//        if(is_array($products))
//        {
//            throw new ProductException([
//                'msg'=>'未找到商品信息！'
//            ]);
//        }
        return $products;
    }
}