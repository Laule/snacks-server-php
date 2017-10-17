<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/17
 * Time: 21:14
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
   protected $rule=[
       'name'=>'require|isNotEmpty',
       'mobile'=>'require|isMobile',
       'province'=>'require|isNotEmpty',
       'city'=>'require|isNotEmpty',
       'country'=>'require|isNotEmpty',
       'detail'=>'require|isNotEmpty',
   ];
}