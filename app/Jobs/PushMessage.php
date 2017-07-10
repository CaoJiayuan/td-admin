<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PushSDK;
use App\Entity\Notifiation;
use Carbon\Carbon;
use App\Entity\Scoop;

class PushMessage implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $sdk;
  /**
   * @var
   */
  private $data;
  /**
   * @var null
   */
  private $channels;

  /**
   * 透传
   */
  const TRANSMISSION = 0;

  /**
   * 通知
   */
  const NOTIFICATION = 1;

  public function __construct(Notifiation $data, $channels = null, $type = self::TRANSMISSION)
  {
    $this->data = $data;
    $this->channels = $channels;
    $this->sdk = new PushSDK();
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $this->data['like_count'] = 0;
    $this->data['scoop_id'] = $this->data['url'];
    if ($this->data['type'] == 4) {
      $scoop = Scoop::whereId($this->data['url'])->select('like')->first();
      $this->data['like_count'] = $scoop['like'];
      $this->data['url'] = config('resourceUrl.scoop') . $this->data['url'] . '/html';
    } elseif ($this->data['type'] == 3) {
      $this->data['url'] = config('resourceUrl.resource') . $this->data['url'] . '/html';
    }
    $noticeType = config('noticeType.noticeType');
    foreach ($noticeType as $v) {
      if ($v['code'] == $this->data['type'])
        $this->data['type'] = $v['baidu_code'];
    }
    $ios = $this->pushIOS();
    $android = $this->pushAndroid();
    if ($android && $ios) {
      Notifiation::whereId($this->data['id'])->update(['status' => 2, 'publish_at' => Carbon::now()]);
    }
  }

  private function _init($api_key, $secret_key)
  {
    $this->sdk->setApiKey($api_key);
    $this->sdk->setSecretKey($secret_key);
  }

  private function _pushMessage($message, $opts)
  {
    $rs = $this->sdk->pushMsgToAll($message, $opts);
    if ($rs === false) {
      $data['errorCode'] = $this->sdk->getLastErrorCode();
      $data['errorMessage'] = $this->sdk->getLastErrorMsg();
      \Log::error('>>>>>>>>>>>>>>>>>>>>>>>PUSH_ERROR', $data);
    }

    if (env('APP_ENV', 'local') === 'local')
      \Log::info('>>>>>>>>>>>>>>>>>>>>>>>PUSH', $message);
    return $rs;
  }

  protected function pushAndroid()
  {
    $opts = array(
      'msg_type' => 0
    );
    $message = array(
      'title' => $this->data['title'],
      'description' => $this->data['content'],
      'url' => $this->data['url'],
      'custom_content' => [
        'key' => (string)$this->data['type'],
        'id'=> (string)$this->data['scoop_id'],
        'like_count' => (string)$this->data['like_count'],
      ]
    );
    $this->_init(config('baidu.android_api_key'), config('baidu.android_secret_key'));
    return $this->_pushMessage($message, $opts);
  }

  protected function pushIOS()
  {
    $type = env('APP_ENV', 'local') == 'local' ? 1 : 2;
    $opts = array(
      'msg_type' => 1,
      'deploy_status' => $type,
    );
    $message = array(
      'aps' => array(
        'alert' => $this->data['content'],
        'sound' => 'default',
        'badge' => 0
      ),
      'key' => (string)$this->data['type'],
      'url' => $this->data['url'],
      'title' => $this->data['title'],
      'id' => (string)$this->data['scoop_id'],
      'like_count' => (string)$this->data['like_count'],
    );
    $this->_init(config('baidu.ios_api_key'), config('baidu.ios_secret_key'));
    return $this->_pushMessage($message, $opts);
  }
}
