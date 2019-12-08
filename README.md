## youquanya-social
有券呀(www.youquanya.com)授权登录扩展

## 安装（扩展包）
```php
composer require liliuwei/youquanya-social
```

# 配置Config信息
```php
// 安装之后会在config目录里自动生成youquanya_social.php配置文件
<?php
return [
    //有券呀登录配置
    'youquanya' => [
        'app_key' => '*******', //应用注册成功后分配的 APP ID
        'app_secret' => '*******',  //应用注册成功后分配的KEY
        'callback' => 'http://www.youquanya.com/oauth/callback/type/youquanya', // 应用回调地址
    ]
];

```

## 用法示例
````
<a href="{:url('Oauth/login',['type'=>'youquanya'])}">登录</a>
   ````
```php
//设置路由
Route::get('oauth/callback','index/oauth/callback');
```

```php
<?php

namespace app\index\controller;
use think\Controller;
class Oauth extends Controller
{
    //登录地址
        public function login($type = null)
        {
            if ($type == null) {
                $this->error('参数错误');
            }
            // 获取对象实例
            $sns = \youquanya\social\Oauth::getInstance($type);
            //跳转到授权页面
            $this->redirect($sns->getRequestCodeURL());
        }
    
        //授权回调地址
        public function callback($type = null, $code = null)
        {
            if ($type == null || $code == null) {
                $this->error('参数错误');
            }
            $sns = \youquanya\social\Oauth::getInstance($type);
            // 获取TOKEN
            $token = $sns->getAccessToken($code);
            //获取当前第三方登录用户信息
            if (is_array($token)) {
                $user_info = \youquanya\social\GetInfo::getInstance($type, $token);
                dump($user_info);// 获取用户资料
                echo '登录成功!!';
                echo '正在持续开发中，敬请期待!!';
            } else {
                echo "获取用户的基本信息失败";
            }
        }
}
```
