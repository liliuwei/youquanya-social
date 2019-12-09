<?php
/**
 * 有券呀 SDK
 */

namespace youquanya\social\sdk;

use youquanya\social\Oauth;

class Youquanya extends Oauth
{
    /**
     * 获取requestCode的api接口
     * @var string
     */
    protected $GetRequestCodeURL = 'http://passport.youquanya.com/oauth/authorize';

    /**
     * 获取access_token的api接口
     * @var string
     */
    protected $GetAccessTokenURL = 'http://passport.youquanya.com/oauth/token';

    /**
     * 获取request_code的额外参数,可在配置中修改 URL查询字符串格式
     * @var srting
     */
    protected $Authorize = 'state=xyz';

    /**
     * API根路径
     * @var string
     */
    protected $ApiBase = 'http://passport.youquanya.com/oauth/';

    /**
     * 组装接口调用参数 并调用接口
     * @param  string $api 有券呀 API
     * @param  string $param 调用API的额外参数
     * @param  string $method HTTP请求方法 默认为GET
     * @return json
     */
    public function call($api, $param = '', $method = 'GET', $multi = false)
    {
        /* 调用公共参数 */
        $params = array(
            'access_token' => $this->Token['access_token'],
        );
        $header = array(
            'X-Requested-With:xmlhttprequest'
        );
        $data = $this->http($this->url($api), $this->param($params, $param), $method, $header);
        return json_decode($data, true);
    }

    /**
     * 解析access_token方法请求后的返回值
     * @param string $result 获取access_token的方法的返回值
     */
    protected function parseToken($result, $extend)
    {
        $data = json_decode($result, true);
        if ($data['access_token'] && $data['token_type']) {
            $this->Token = $data;
            $data['openid'] = $this->openid();
            return $data;
        } else
            throw new \Exception("获取有券呀ACCESS_TOKEN出错：未知错误");
    }

    /**
     * 获取当前授权应用的openid
     * @return string
     */
    public function openid()
    {
        $data = $this->call('user/getinfo');
        if (isset($data['id']))
            return $data['id'];
        else
            throw new \Exception('没有获取到有券呀用户ID！');
    }
}