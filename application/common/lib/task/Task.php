<?php

namespace app\common\lib\task;

use app\common\lib\ali\Sms;
use app\common\lib\Redis;
use app\common\lib\Predis;

class Task
{
	public function sendSms($data)
	{
		try {
			$send_code = Sms::sendShortMessage($data['phone'], $data['sms_code']);
        } catch (\Exception $e) {
        	// TODO
        	return false;
        }

        return true;
	}
}