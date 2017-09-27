<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/25
 * Time: 10:41
 */

namespace app\api\model;


use think\Db;
use think\Model;

class Banner extends Model
{
//    protected $table='category';
    public static function getBannerByID($id)
    {

//        $result=
//        Db::query('select * from banner_item where banner_id=?',[$id]);
//        return $result;
//        $result = Db::table('banner_item')->where('banner_id', '=', $id)->select();
//        where('字段名','表达式','查询条件')
         //model 处理业务逻辑
        //表达式、数组法、闭包
        //在where里面传递一个匿名函数
        $result = Db::table('banner_item')
            ->where(function ($query)use ($id){
                $query->where('banner_id','=',$id);
            })
            ->select();
        return $result;
    }
}