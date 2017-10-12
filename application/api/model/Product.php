<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/29
 * Time: 9:42
 */

namespace app\api\model;


class Product extends BaseModel
{
    // pivot字段  多对多关系的中间表
    protected $hidden = ['delete_time', 'main_img_id', 'pivot', 'category_id',
        'create_time', 'update_time'];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }
    public static function getProductByCategoryID($categoryID)
    {
        $products = self::where('category_id','=',$categoryID)
            ->select();
        return $products;
    }
}