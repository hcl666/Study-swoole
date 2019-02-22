<?php

namespace app\index\controller;

use app\common\lib\Util;
use app\common\lib\Redis;
use app\common\lib\Predis;

class Login
{
	public function index()
	{
		$phone_number = request()->get('phone_num');
		$code = request()->get('code');

		if (empty($phone_number) || empty($code)) {
			return Util::failed(config('code.error'), [], 'empty data');
		}

		$redis_code = Predis::getInstance()->get(Redis::smsKey($phone_number));

		if ($redis_code == $code) {
			$user_data = [
				'user' => $phone_number,
				'src_key' => md5(Redis::userKey($phone_number)),
				'time' => time(),
				'is_login' => true,
			];

			
			Predis::getInstance()->set(Redis::userKey($phone_number), $user_data);
			return Util::success(config('code.success'), $user_data);
		}

		return Util::failed(config('code.error'), [], 'login error');
	}
}
