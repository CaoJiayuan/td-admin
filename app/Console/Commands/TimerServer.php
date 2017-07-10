<?php

namespace App\Console\Commands;

use App\Jobs\PushMessage;
use Illuminate\Console\Command;
use Workerman\Connection\TcpConnection;
use Workerman\Lib\Timer;
use Workerman\Worker;

class TimerServer extends Command
{
  protected $signature = 'timer';
  protected $description = '定时推送服务器';
  protected $messages = [];
  const DELAY = 1;
  const THREAD = 1;

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    global $argv;
    $argv[1] = 'start';
    $worker = new Worker("tcp://127.0.0.1:" . env('TIMER_PORT', 2333));
    $worker->count = static::THREAD;
    $worker->onConnect = [$this, 'onConnection'];
    $worker->onMessage = [$this, 'onMessage'];
    $worker->onClose = [$this, 'onClose'];
    Worker::runAll();
  }

  public function timer()
  {
    Timer::delAll();
    Timer::add(static::DELAY, [$this, 'onTick']);
  }

  /**
   * @param TcpConnection $connection
   */
  public function onConnection($connection)
  {
    $this->info('>>>>>>>>>>>>>connected>>>>>>>>>' . $connection->getRemoteIp());
  }

  public function onTick()
  {
    $time = time();
    $plans = array_get($this->messages, $time, []);
    foreach ($plans as $plan) {
      $this->info('Do plan' . json_encode($plan));
      dispatch(new PushMessage($plan));
    }
    if ($plans) {
      unset($this->messages[$time]);
    }
  }


  /**
   * @param TcpConnection $connection
   * @param $data
   */
  public function onMessage($connection, $data)
  {
    $data = json_decode($data, true);
    $time = array_get($data, 'time');
    $this->messages[$time][] = $data;
    $time = date('Y-m-d H:i:s', $time);
    $this->info("Add plan:{$time}" . json_encode($data));
    $this->timer();
  }

  /**
   * @param TcpConnection $connection
   */
  public function onClose($connection)
  {
    $this->info('<<<<<<<<<<<<<<<<<<closed<<<<<<<<<<<<' . $connection->getRemoteIp());
  }
}
