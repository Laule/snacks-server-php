<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/22
 * Time: 16:53
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    // const 常量

    // 待支付
    const UNPAID = 1;

    // 已支付
    const PAID = 2;

    //已发货
    const DELIVERED = 3;

    // 已支付，但库存不足
    const PAID_BUT_OUT_OF = 4;
}