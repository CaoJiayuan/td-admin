<?php
namespace App\Traits;
use OSS\OssClient;

trait Uploads
{

  public function putObject($content,$object=null)
  {
    $bucket = config('oss.bucket');
    $dir = config('oss.dir');
    if(empty($object))
    {
      $object = $dir.md5(microtime());
    }else{
      $object = $dir.$object;
    }
    $client = self::init();
    return $client->putObject($bucket,$object,$content);
  }

  static function init()
  {
    $accessKeyId = config('oss.accessKeyId');
    $accessKeySecret = config('oss.accessKeySecret');
    $endpoint = config('oss.endpoint');
    return new OssClient($accessKeyId, $accessKeySecret, $endpoint);
  }

  public function decodeBase64Image($content, $post = true)
  {
    $content = preg_replace_callback('#<img.*?src="(.*?)".*?>#', function ($match) use ($post){
      $image = $match[1];
      if ($post) {
        $image = str_replace(' ', '+', $image);
      }

      if (preg_match('/^(data:(\s*image\/(\w+));base64,)/', $image, $result)) {
        $imgString = str_replace($result[1], '', $image);
        $data = [
          base64_decode($imgString),
          $result[2],
          $result[3]
        ];
        $path = $this->putObject($data[0],md5(microtime()).'.'.$result[3]);
        return str_replace($image, $path['info']['url'] ,$match[0]);
      }
      return $match[0];
    }, $content);

    $content = preg_replace_callback('#<(.*?)>(.*?)<(.*?)>#', function ($m) {
      $con = str_replace(' ', '&nbsp;', $m[2]);
      return "<{$m[1]}>$con<{$m[3]}>";
    }, $content);

    return $content;
  }
}