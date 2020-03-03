<?php
namespace app\index\controller;

use think\Request;
use EasyWeChat\Factory;
class Index
{
    public function index(Request $request)
    {
        $config = [
            'app_id' => 'wx3cf0f39249eb0exx',
            'secret' => 'f1c242f4f28f735d4687abb469072axx',
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => 'http://gfr.zgmtapp.com/Index/callback',
            ],
        ];
        $app = Factory::officialAccount($config);
        $oauth = $app->oauth;

        // 未登录
        if (empty($_SESSION['wechat_user'])) {

            //$_SESSION['target_url'] = 'user/profile';

            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }

        // 已经登录过
        $user = $_SESSION['wechat_user'];
        var_dump($user);
    }
    public function callback()
    {
        $config = [
            'app_id' => 'wx3cf0f39249eb0exx',
            'secret' => 'f1c242f4f28f735d4687abb469072axx',
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => 'http://gfr.zgmtapp.com/Index/callback',
            ],
        ];
        $app = Factory::officialAccount($config);
        $oauth = $app->oauth;

// 获取 OAuth 授权结果用户信息
        $user = $oauth->user();

        $_SESSION['wechat_user'] = $user->toArray();

        $targetUrl = empty($_SESSION['target_url']) ? '/' : $_SESSION['target_url'];

        header('location:'. $targetUrl); // 跳转到 user/profile
    }
    //获取user信息
    public function getUserSession($code)
    {
        //return config('config.APP_CONFIG');
        $app = Factory::miniProgram(config('config.APP_CONFIG'));
        $auth = $app->auth->session($code);
        return $auth;
    }

    //解密
    public function decryptData($session, $iv, $data)
    {
        $app = Factory::miniProgram(config('config.APP_CONFIG'));

        return $decryptedData = $app->encryptor->decryptData($session, $iv, $data);
    }
}