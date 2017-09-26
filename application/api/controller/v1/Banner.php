<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/22
 * Time: 9:05
 */

namespace app\api\controller\v1;

use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\BannerMissException;
use think\Exception;//别名
class Banner
{
    //获取指定id的Banner信息
    //@$url / banner /:id
    //@http GET
    //@id banner 的 id 号
    public function getBanner($id)
    {
        //拦截器 、 如果请求的数据不符合 直接过滤掉这次请求
        (new IDMustBePostiveInt())->goCheck();

        $banner = BannerModel::getBannerByID($id);

        //如果Banner为空 抛出Miss
        if (!$banner) {
//           throw new BannerMissException();
            throw new Exception('内部错误');

        }
        return $banner;
    }
}