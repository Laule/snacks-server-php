<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/29
 * Time: 9:41
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;

class Theme
{
    /**
     * @url /theme/?ids=id1,id2,id3,....
     * @return 一组theme模型
     */
    public function getSimpleList($ids = '')
    {
        (new IDCollection())->goCheck();
        return 'this is getSimpleList';
    }
}