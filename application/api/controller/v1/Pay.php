<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/22
 * Time: 16:02
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    // 请求预订单信息 # 只能用户访问
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    public function getPreOrder($id = '')
    {
        (new IDMustBePostiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();

    }
    // 转发调试
//    public function redirectNotify()
//    {
//        // 通知频率为15/15/30/180/1800/1800/1800/1800/3600 .单位秒
//        // 1.检测库存量.超卖
//        // 2.更新订单status状态
//        // 3.减库存
//        // 4.如果成功处理，我们返回成功处理的信息，否则，返回没有成功处理。
//
//        // 特点：post;xml格式，不会携带参数
//        $notify = new WxNotify();
//        $notify->Handle();
//    }



    public function receiveNotify()
    {
        // 通知频率为15/15/30/180/1800/1800/1800/1800/3600 .单位秒
        // 1.检测库存量.超卖
        // 2.更新订单status状态
        // 3.减库存
        // 4.如果成功处理，我们返回成功处理的信息，否则，返回没有成功处理。

        // 特点：post;xml格式，不会携带参数
        $notify = new WxNotify();
        $notify->Handle();

//        // 用于接收微信传递过来的参数
//        $xmlData = file_get_contents('php://input');
//        // 转发的地址 （这里需要写一个新的路由指向redirectNotify 这个方法 。 这里我就不写了）
//        $result = curl_post_raw('http://z.cn/api/v1/pya/re_notify?XDEBUG_SESSION_START=14831',$xmlData);

    }
}