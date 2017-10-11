<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/29
 * Time: 9:41
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ThemeException;

class Theme
{
    /**
     * @url /theme/?ids=id1,id2,id3,....
     * @return 一组theme模型
     */
    public function getSimpleList($ids = '')
    {
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        $result = ThemeModel::with('topicImg,headImg')
            ->select($ids);
        if (!$result) {
            throw new ThemeException();
        }
        return $result;
    }

    /**
     * @url /theme/:id
     */
    public function getComplexOne($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $themes = ThemeModel::getThemeWithProducts($id);
        if (!$themes) {
            throw new ThemeException();
        }
        return $themes;
    }
}