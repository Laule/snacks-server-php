<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/11/13
 * Time: 10:10
 */

namespace app\api\model;


class ThirdApp extends BaseModel
{
    public static function check($ac, $se)
    {
        // 且
        $app = self::where('app_id', '=', $ac)
            ->where('app_secret', '=', $se)
            ->find();
        return $app;
    }
}