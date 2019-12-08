<?php
/**
 * 获取用户信息类
 */

namespace youquanya\social;
final class GetInfo
{
    public static function getInstance($type, $token)
    {
        return self::$type($token);
    }

    //有券呀用户信息
    public static function youquanya($token)
    {
        $youquanya = Oauth::getInstance('youquanya', $token);
        $data = $youquanya->call('user/getinfo');
        if ($data['id']) {
            $userInfo['type'] = 'youquanya';
            $userInfo['name'] = $data['username'];
            $userInfo['nickname'] = $data['username'];
            $userInfo['avatar'] = $data['avatar'];
            $userInfo['openid'] = $data['id'];
            $userInfo['email'] = $data['email'];
            return $userInfo;
        } else {
            throw new \Exception("获取有券呀用户信息失败：{$data['error']}");
        }
    }

}