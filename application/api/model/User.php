<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/16
 * Time: 18:53
 */

namespace app\api\model;


class User extends BaseModel
{
    public static function getByOpenID($openid)
    {
        $user = self::where('openid', '=', $openid)
            ->find();
        return $user;
    }
}