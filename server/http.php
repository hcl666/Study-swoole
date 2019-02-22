<?php

class Http
{
	const HOST = '0.0.0.0';
	const PORT = 9501;

	public $http = null;

	public function __construct()
	{
		$this->http = new Swoole\Http\Server(self::HOST, self::PORT);
		$this->http->set(
			[
				'document_root' 		=> '/vagrant_data/thinkphp_5.0.23_swoole/public/static',
				'enable_static_handler' => true,
				'worker_num'			=> 4,
				'task_worker_num'		=> 4
			]
		);

		$this->http->on('workerstart', [$this, 'onWorkerStart']);
		$this->http->on('request', [$this, 'onRequest']);
		$this->http->on('task', [$this, 'onTask']);
		$this->http->on('finish', [$this, 'onFinish']);
		$this->http->on('close', [$this, 'onClose']);

		$this->http->start();
	}

	public function onWorkerStart($server, $worker_id)
	{
		// 定义应用目录
		define('APP_PATH', __DIR__ . '/../application/');
		// ThinkPHP 引导文件
		// 1. 加载基础文件
		require __DIR__ . '/../thinkphp/base.php';
	}

	public function onRequest($request, $response)
	{
		$this->transfer($request); // 将请求数据转换成原生数据

		$output = $this->run();
		// echo request()->action() . PHP_EOL;
		// echo request()->model() . PHP_EOL;
		// echo request()->controller() . PHP_EOL;

		// $response->end('<h1>' . date('Y-m-d H:i:s') . '</h1>');
		$response->header('Cache-Contro', 'no-cache');
		$response->end($output);

		// print_r($request);

		// $http_server->close($request->fd);
	}

	public function onTask($server, $task_id, $worker_id, $data)
	{
		$task_obj = new app\common\lib\task\Task();
		$task_obj->$data['method']($data['data']);
		return 'on task finish';
	}

	public function onFinish($server, $task_id, $data)
	{
		echo 'task_id:' . $task_id;
		echo 'finish-data-success:' . $data . "\n";
	}

	public function onClose($server, $fd)
	{
		echo 'client_id:' . $fd;
	}

	public function run()
	{
		$_POST['http_server'] = $this->http;

		ob_start();

		try{
			think\App::run()->send();
		} catch(\Exception $e) {
			throw $e;
		}

		
		return ob_get_clean();
	}

	// 将数据转换成原生格式
	public function transfer($request)
	{
		$this->transferGet($request->get);
	    $this->transferPost($request->post);
		$this->transferServer($request->server);
	}

	// 转换get数据
	public function transferGet($get)
	{

		$_GET = [];
		if (!isset($get)) {
			return;
		}

		foreach ($get as $key => $value) {
			$_GET[$key] = $value;
		}
	}

	// 转换post数据
	public function transferPost($post)
	{

		$_POST = [];
		if (!isset($post)) {
			return;
		}

		foreach ($post as $key => $value) {
			$_POST[$key] = $value;
		}
	}

	// 转换server数据
	public function transferServer($server)
	{

		$_SERVER = [];
		if (!isset($server)) {
			return;
		}

		foreach ($server as $key => $value) {
			$_SERVER[strtoupper($key)] = $value;
		}
	}
}

new Http();