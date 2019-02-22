<?php

namespace app\common\lib;

class Redis
{
	public static $sms_prefix = 'sms_';

	public static $user_prefix = 'user_';

	public static function smsKey($phone)
	{
		return self::$sms_prefix . $phone;
	}

	public static function userKey($phone)
	{
		return self::$user_prefix . $phone;
	}
}