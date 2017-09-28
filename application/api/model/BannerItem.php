<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/28
 * Time: 9:47
 */

namespace app\api\model;


class BannerItem extends BaseModel
{

    protected $hidden = ['id','img_id','banner_id','update_time','delete_time'];
     public function img()
     {
//       belongsTo() 一对一关系就使用这个函数
         return $this->belongsTo('Image','img_id','id');
     }
}