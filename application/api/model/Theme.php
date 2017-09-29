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
    public function topicImg()
    {
//      定义一对一关系
        return $this->belongsTo('Image','topic_img_id','id');
    }
    public function headImg()
    {
        return $this->belongsTo('Image','head_img_id','id');
    }
}