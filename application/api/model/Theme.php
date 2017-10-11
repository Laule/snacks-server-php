<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/29
 * Time: 9:43
 */

namespace app\api\model;


class Theme extends BaseModel
{
    // 需要隐藏的字段
    protected $hidden = ['delete_time', 'topic_img_id', 'head_img_id', 'update_time'];

    //  定义一对一关系
    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    //  定义多对多关系
    public function products()
    {
        //  1.对应的表 2.中间表 3 4.关联关系的键
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }

    public static function getThemeWithProducts($id)
    {
        $themes = self::with('products,topicImg,headimg')
            ->find($id);
        return $themes;
    }
}