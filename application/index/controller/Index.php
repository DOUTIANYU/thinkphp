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
        ];
        $app = Factory::officialAccount($config);
        $response = $app->oauth->scopes(['snsapi_userinfo'])
            ->redirect($request->domain());
        $user = $app->oauth->user();
        var_dump($user);
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