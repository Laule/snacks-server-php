<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/17
 * Time: 21:11
 */

namespace app\api\controller\v1;


use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\SuccessException;
use app\lib\exception\UserException;

class Address
{
    //创建和更新用户地址
    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();
        // 根据Token 获取uid
        // 根据uid 来查找用户数据，判断用户用户是否存在 ，若不存在 抛出异常
        // 获取用户从客户端提交来的地址信息
        // 根据用户地址信息是否存在 ，从而判断是判断地址还是更新地址

        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserException();
        }
        $dataArray = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        if (!$userAddress) {
            $user->address()->save($dataArray);

        } else {
            $user->address->save($dataArray);

        }
        return json(new SuccessException(),201) ;

    }

}