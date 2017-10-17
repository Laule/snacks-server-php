<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/17
 * Time: 15:45
 */

namespace app\api\model;


class ProductImage extends BaseModel
{

    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }

}