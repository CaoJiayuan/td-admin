<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Utils\TDApi;

class LoginService implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $data;

  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $res = TDApi::loginService(['email'=>$this->data['email'],'password'=>'123456']);

    \Log::debug('Login>>>>>>', [
      'address' => env('TD_API_ADDRESS', 'http://112.74.246.68:8088/api/'),
      'data' => $this->data,
      'res' => $res->getContent()
    ]);
  }
}
