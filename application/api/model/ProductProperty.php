<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/17
 * Time: 15:48
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['product_id', 'delete_id', 'id'];
}