<?php

namespace app\common\lib;

class Predis
{
	public $redis = null;

	// redis对象
	private static $_instance = null;

	public static function getInstance()
	{
		if (empty(self::$_instance)) {
			self::$_instance = new Predis();
		}

		return self::$_instance;
	}

	public function get($key)
	{
		return $this->redis->get($key);
	}

	public function set($key, $data, $time = 0)
	{

		if (is_array($data)) {
			$data = json_encode($data);
		}

		return $this->redis->set($key, $data);
	}

	private function __construct()
	{
		$this->redis = new \Redis();
		$this->redis->connect(config('redis.host'), config('redis.port'), config('redis.time_out'));
		$result = $this->redis->auth(config('redis.password'));

		if (!$result) {
			throw new Exception('redis connect error');
		}

		return $this->redis;
	}

	private function __clone()
	{

	}
}