<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/24
 * Time: 11:10
 */

namespace app\api\service;


use think\Loader;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class WxNotify extends \WxPayNotify
{
  public function NotifyProcess($data, &$msg)
  {

  }
}