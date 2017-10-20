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
    // 自动写入时间戳
    // 如果TP5 检测到你是一个创建操作 就再create_time添加一个时间戳，如果删除操作，就在delete_time添加一个时间戳 同理 ...
    protected $autoWriteTimestamp = true;
    // 指定数据库时间创建字段
    //  protected $createTime = 'create_timestamp';
}