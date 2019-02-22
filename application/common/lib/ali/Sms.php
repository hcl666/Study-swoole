<?php

namespace app\common\lib\ali;

class Sms{

	public static function sendShortMessage($phone, $sms_code)
	{
		file_put_contents(
			'/vagrant_data/thinkphp_5.0.23_swoole/runtime/log.txt', 
			'发送短信成功:phone' . $phone . ' code:' . $sms_code . "\r\n", 
			FILE_APPEND
		);

		return $sms_code;
	}
}
