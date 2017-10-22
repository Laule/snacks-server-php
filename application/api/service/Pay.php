<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/22
 * Time: 16:18
 */

namespace app\api\service;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Loader;
use think\Log;

// extend/WxPay/WxPay.Api.php

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay
{
    private $orderID;
    private $orderNo;

    //构造函数
    function __construct($orderID)
    {
        if (!$orderID) {
            throw new Exception('订单号不允许为NULL');
        }
        $this->orderID = $orderID;
    }

    // 调用微信预订单接口的时候，最主要的参数（openid 用户ID，我们自己生成的订单编号）

    public function pay()
    {
        // me如果用户支付时，价格与下单时金额不一样怎么办？
        // 订单号可能根本不存在
        // 订单号确实存在，但是，订单号和当前用户不匹配的
        // 订单有可能已经被支付过
        // 进行库存量检测
        $this->checkOrderValid();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']) {
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    private function makeWxPreOrder($totalPrice)
    {
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }
        $wxOrderDate = new \WxPayUnifiedOrder();

        // 订单号
        $wxOrderDate->SetOut_trade_no($this->orderNo);
        // 交易类型
        $wxOrderDate->SetTrade_type('JSAPI');
        // 订单总金额 单位/分
        $wxOrderDate->SetTotal_fee($totalPrice * 100);
        // 订单简易描述
        $wxOrderDate->SetBody('零食商贩');
        // 用户Openid
        $wxOrderDate->SetOpenid($openid);
        // URL 用于接收微信支付回调地址（必填*）
        $wxOrderDate->SetNotify_url(config('secure.pay_back_url'));
        return $this->getPaySignature($wxOrderDate);
    }

    // 接收微信支付返回结果
    private function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if ($wxOrder['return_code'] != 'SUCCESS' ||
            $wxOrder['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('订单支付失败！', 'error');
        }
        // 处理微信返回的结果
        // prepay_id * 向用户推送一个模板消息必须用到prepay_id
        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder);

        return $signature;
    }

    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        // 签名
        $sign = $jsApiPayData->MakeSign();
        // 原始数据
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['appid']);
        return $rawValues;

    }

    private function recordPreOrder($wxOrder)
    {
        OrderModel::where('id', '=', $this->orderID)
            ->update(['prepay_id' => $wxOrder['prepay_id']]);
    }

    private function checkOrderValid()
    {
        $order = OrderModel::where('id', '=', $this->orderID)
            ->find();
        if (!$order) {
            throw new OrderException();
        }
        if (!Token::isValidOperate($order->user_id)) {
            throw new TokenException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        }
        if ($order->status != OrderStatusEnum::UNPAID) {
            throw new OrderException(
                [
                    'msg' => '订单已支付过啦~',
                    'errorCode' => 80003,
                    'code' => 400
                ]
            );
        }
        $this->orderNo = $order->order_no;
        return true;

    }
}