<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/16
 * Time: 18:44
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code ='')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return $token;
    }
}