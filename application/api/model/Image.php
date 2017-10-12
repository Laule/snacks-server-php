<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/28
 * Time: 10:30
 */

namespace app\api\model;

// 子类
class Image extends BaseModel
{
    protected $hidden = ['id', 'from', 'update_time', 'delete_time'];

//    对于 private 、 public 这些个公共的方法 如果把它设置在基类里面的话子类会自动继承

//   这样写不会让所有子类模型自动继承BaseModel下的读取器。而是当你模型字段有需要，再调用基类的方法。
     public function getUrlAttr($value,$data)
     {
         return $this->prefixImgUrl($value,$data);
     }

}