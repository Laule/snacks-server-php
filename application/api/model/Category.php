<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/12
 * Time: 8:45
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden=['delete_time','update_time','create_time'];
   public function img()
   {
       return $this->belongsTo('Image','topic_img_id','id');
   }
}