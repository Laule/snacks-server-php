<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/25
 * Time: 10:41
 */

namespace app\api\model;


use think\Db;

class Banner
{
    public static function getBannerByID($id)
    {

//        $result=
//        Db::query('select * from banner_item where banner_id=?',[$id]);
//        return $result;

        $result = Db::table('banner_item')->where('banner_id', '=', $id)->select();
        return $result;
    }
}