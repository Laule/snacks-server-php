<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/11/13
 * Time: 13:51
 */

namespace app\api\service;


use app\api\model\User;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;

class DeliveryMessage extends WxMessage
{
    const DECLVERY_MSG_ID = 'you template message id';

    public function sendDeliveryMessage($order, $tplJumpPage = '')
    {
        if (!$order) {
            throw new OrderException([]);
        } else {
            $this->tplID = self::DECLVERY_MSG_ID;
            $this->formID = $order->prepay_id;
            $this->page = $tplJumpPage;
            $this->prepareMessageDate($order);
            $this->emphasisKeyWord = 'Keyword2.DATA';
            return parent::sendMessage($this->getUserOpenID($order->user_id));
        }
    }

    private function prepareMessageDate($order)
    {
        $dt = new \DateTime();
        $data = [
            'keyword1' => [
                'value' => '呵呵哈哈',
            ],
            'keyword2' => [
                'value' => $order->snap_name,
                'color' => '#27408B'
            ],
            'keyword3' => [
                'value' => $order->order_no,
            ],
            'keyword4' => [
                'value' => $dt->format('Y-m-d H:i'),
            ],
        ];
        $this->data = $data;
    }

    private function getUserOpenID($uid)
    {
        $user = User::get($uid);
        if (!$user) {
            throw new UserException();
        }
        return $user->openid;
    }
}