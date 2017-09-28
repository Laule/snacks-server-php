<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/22
 * Time: 9:05
 */

namespace app\api\controller\v1;

//别名
use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\BannerMissException;

class Banner
{

    //获取指定id的Banner信息
    //@$url / banner /:id
    //@http GET
    //@id banner 的 id 号
    public function getBanner($id)
    {
        //  拦截器 、 如果请求的数据不符合 直接过滤掉这次请求
        (new IDMustBePostiveInt())->goCheck();

        $banner = BannerModel::getBannerByID($id);
        if (!$banner) {
            throw new BannerMissException();
        }
        return $banner;
    }
}