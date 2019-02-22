<?php

namespace app\index\controller;

use app\common\lib\Util;
use app\common\lib\ali\Sms;
use app\common\lib\Redis;


class Send
{
	// 发送验证码
    public function index()
    {
        $phone_number = request()->get('phone_num', 0, 'intval');

        // 检查手机号格式
        if (empty($phone_number)) {
        	# code...
        	return Util::failed(config('code.error'), [], '手机号为空');
        }

        $sms_code = rand(1000, 9999);

        $task_data = [
            'method' => 'sendSms',
            'data' => [
                'phone' => $phone_number,
                'sms_code' => $sms_code
            ]
        ];
        $_POST['http_server']->task($task_data);


        // if ($send_code == true) {
        // 	// 验证码写入redis缓存
        // 	$redis = new \Swoole\Coroutine\Redis;
        // 	$redis->connect(config('redis.host'), config('redis.port'));
        // 	$redis->auth(config('redis.password'));
        // 	$redis->set(Redis::smsKey($phone_number), $send_code, config('redis.out_time'));
        // }

        return Util::success();
    }

}
