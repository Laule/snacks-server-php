<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/22
 * Time: 16:02
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
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
   public function receiveNotify()
   {
       // 通知频率为15/15/30/180/1800/1800/1800/1800/3600 .单位秒
       // 1.检测库存量.超卖
       // 2.更新订单status状态
       // 3.减库存
       // 4.如果成功处理，我们返回成功处理的信息，否则，返回没有成功处理。

       // 特点：post;xml格式，不会携带参数

   }
}