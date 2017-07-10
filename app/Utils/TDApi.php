<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-3-30
 * Time: 下午3:54
 */

namespace App\Utils;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class TDApi
{
  public static function getClient()
  {
    $h = [
      'Accept' => 'application/json',
    ];
    $opts = [
      'headers'     => $h,
      'http_errors' => false,
      'verify'      => false,
    ];

    return new Client($opts);
  }

  /**
   * @param Response|ResponseInterface $response
   * @return \Symfony\Component\HttpFoundation\Response|Response
   */
  public static function toIlluminateResponse($response)
  {
    /** @var \Illuminate\Http\Response $res */
    $res = response($response->getBody(), $response->getStatusCode(), array_except($response->getHeaders(), 'Transfer-Encoding'));
    $statusTexts = \Symfony\Component\HttpFoundation\Response::$statusTexts;
    (!$res->isSuccessful() && env('APP_ENV') == 'local') && \Log::error(array_get($statusTexts, $res->getStatusCode(), 'Unknown') . ':' . $res->getContent());

    return $res;
  }

  public static function loginService($data)
  {
    return static::post('service/login', $data);
  }

  public static function assignImUser()
  {
    return static::post('service/chatter/assign');
  }

  public static function post($uri, $data = [])
  {
    $uri = ltrim($uri, '/');
    $url = env('TD_API_ADDRESS', 'http://192.168.1.2:8088/api/') . $uri;
//    dd($url, $data);
    $response = static::getClient()->post($url, ['form_params' => $data]);
    return static::toIlluminateResponse($response);
  }

  public static function get($uri, $data = [])
  {
    $uri = ltrim($uri, '/');
    $url = env('TD_API_ADDRESS', 'http://192.168.1.2:8088/api/') . $uri;

    $response = static::getClient()->get($url, ['query' => $data]);
    return static::toIlluminateResponse($response);
  }
}