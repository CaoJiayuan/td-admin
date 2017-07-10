<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OSS\OssClient;
use App\Traits\Uploads;

class UploadController extends Controller
{
  use Uploads;

  public function index(Request $request)
  {
    $file = $request->file('file');
    $content = file_get_contents($file->getPathname());
    $path = $this->putObject($content);
    return response()->json($path['info']['url']);
  }
}
