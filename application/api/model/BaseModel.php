<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/28
 * Time: 15:01
 */

namespace app\api\model;


use think\Model;
// 基类
class BaseModel extends Model
{
    //  getUrlAttr 这个名字会自动识别为  读取器
    //  get 固定字符  Url（驼峰命名）是要读取的字段的名字  Attr 固定字符
    protected function prefixImgUrl($value, $data)
    {
        //  把这一段代码提取到基类里，以后凡是继承与BaseModel的，以后碰到Url 这个字段 都会执行这个读取器
        $finalUrl = $value;
        //  from:1 表示本地图片 2:表示服务器上图片
        if ($data['from'] == 1) {
            $finalUrl = config('setting.img_prefix') . $value;
        }
        return $finalUrl;
    }
}