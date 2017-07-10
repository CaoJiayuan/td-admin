<?php

namespace App\Http\Controllers;

use App\Repository\ScoopRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScoopController extends Controller
{

  public function index(ScoopRepository $repository)
  {
    return $repository->getScoops();
  }

  public function scoopCategories(ScoopRepository $repository)
  {
    return $repository->getScoopsCategories();
  }

  public function delScoop(ScoopRepository $repository,$id)
  {
    return $repository->delScoop($id);
  }

  public function getCategories(ScoopRepository $repository)
  {
    return $repository->getCategories();
  }

  public function createScoop(ScoopRepository $repository,Request $request)
  {
    if($request['summary'] == ""){
      return response()->json(['code' => 422,'error'=>[],'message'=>'新闻摘要不能为空'],422);
    }elseif ($request['category']['id'] == "") {
        return response()->json(['code' => 422, 'errors' => [], 'message' => '类型不能为空'], 422);
      } else {
        $data = $this->getValidatedData([
          'title' => 'required',
          'category.id' => 'required',
          'from',
          'summary' =>'required',
          'thumbnail',
          'published_at',
          'content' => 'required',
        ]);
        return $repository->addScoop($data);
      }
  }

  public function getScoop(ScoopRepository $repository, $id)
  {
    return $repository->getScoop($id);
  }

  public function editScoop(ScoopRepository $repository,Request $request,$id)
  {
    if ($request['category']['id'] == ""){
      return response()->json(['code' => 422,'errors' => [], 'message' => '类型不能为空'], 422);
    }else{
      $data =$this->getValidatedData([
        'category.id' =>'required',
        'from',
        'summary' ,
        'thumbnail',
        'published_at',
        'content' => 'required',
        'title' => 'required',
      ]);
      return $repository->updateScoop($id,$data);
    }
  }

  public function getScoopCate(ScoopRepository $repository,$id)
  {
    return $repository->getScoopCate($id);
  }

  public function modifyStatus(ScoopRepository $repository,$id)
  {
    return $repository->changeStatus($id);
  }


}
