<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Feedback;
use App\Repository\Repository;

class FeedbackController extends Controller
{
  public function index(Repository $repository)
  {
    $data = $repository->getSearchAbleData(Feedback::class,['content','mobile'],function($builder){
      $builder->with('user');
    });
    return response()->json($data);
  }
}
