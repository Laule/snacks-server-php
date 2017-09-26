<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/9/22
 * Time: 11:17
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        // 获取http传入的参数
        //对这些参数做校验
        $request = Request::instance();
        $params = $request->param();
        //逐条验证
        $result = $this->batch()->check($params);

        if (!$result) {
            $e = new ParameterException(
                [
                    'msg' => $this->error
                ]
            );
            throw $e;
        } else {
            return true;
        }
    }
}