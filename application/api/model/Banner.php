<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/25
 * Time: 10:41
 */

namespace app\api\model;


class Banner extends BaseModel
{
    //需要隐藏的字段
    protected $hidden = ['update_time','delete_time'];

    public function items()
    {
//      关联模型的模型名字、关联模型外键id,当前模型主键id
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerByID($id)
    {

        $banner = self::with((['items', 'items.img']))
            ->find($id);

        return $banner;

    }
}