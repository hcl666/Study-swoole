<?php

namespace app\common\lib;

class Util
{
	public static function success($code = 200, $data = [], $msg = 'ok')
	{
		$output = [
			'code' => $code,
			'msg'  => $msg,
			'data' => $data
		];

		echo json_encode($output);
	}

	public static function failed($code = 400, $data = [], $msg = '')
	{
		$output = [
			'code' => $code,
			'msg'  => $msg,
			'data' => $data
		];

		echo json_encode($output);
	}
}
