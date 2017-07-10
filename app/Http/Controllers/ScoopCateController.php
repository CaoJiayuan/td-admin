<?php

namespace App\Http\Controllers;

use App\Repository\ScoopRepository;
use Illuminate\Http\Request;

class ScoopCateController extends Controller
{
  public function index(ScoopRepository $repository)
  {
    return $repository->getScoopsCategories();
  }

  public function scoopComments(ScoopRepository $repository,$id)
  {

    return $repository->getScoopComments($id);
  }

  public function scoopAdd(ScoopRepository $repository,Request $request)
  {
    $data =$this->getValidatedData([
      'name' => 'required'
    ]);
    return $repository->addScoopCate($data);
  }

  public function scoopEdit(ScoopRepository $repository,Request $request,$id)
  {
    $data =$this->getValidatedData([
      'name' => 'required'
    ]);
    return $repository->editScoopCate($data,$id);
  }

  public function scoopDel(ScoopRepository $repository,$id)
  {
    return $repository->delScoopCate($id);
  }
}
