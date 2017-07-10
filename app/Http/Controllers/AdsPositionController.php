<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdsPositionController extends Controller
{
  public function index()
  {
    $data = config('adsPositions.adsPositions');
    return response()->json($data);
  }
}
