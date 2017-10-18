<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/18
 * Time: 9:37
 */

namespace app\lib\enum;


class ScopeEnum
{
    // scope = 16 代表App 用户的权限数值
    // scope = 32 代表CMS(管理员)用户的权限数值
    const User = 16;
    const Super = 32;
}