<?php

namespace app\common\lib\task;

use app\common\lib\ali\Sms;

class Task
{
	public function sendSms($data)
	{
		try {
			$send_code = Sms::sendShortMessage($data['phone'], $data['sms_code']);
        } catch (\Exception $e) {
        	// TODO
        	echo $e->getMessage();
        }

        print_r($data);
	}
}