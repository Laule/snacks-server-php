<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/18
 * Time: 22:12
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
}