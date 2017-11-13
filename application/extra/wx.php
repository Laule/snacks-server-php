<?php
/**
 * Created by PhpStorm.
 * User: LYJ
 * Date: 2017/10/16
 * Time: 19:05
 */
return [
    'app_id' => 'wxad3d0fc6b70abcab',
    'app_secret' => 'd61f25b0cbf3f16cd9e786d35dba1878',
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s",

];