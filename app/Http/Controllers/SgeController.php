<?php

namespace App\Http\Controllers;

use App\Repository\SgeRepository;
class SgeController extends Controller
{
  public function index(SgeRepository $repository)
  {
      return $repository->getSge();
  }

  public function addSgeCate(SgeRepository $repository)
  {
      $data =$this->getValidatedData([
        'name' => 'max:24'
      ]);
      return $repository->createSgeCate($data);
  }

  public function editSgeCate(SgeRepository $repository, $id)
  {
      $data = $this->getValidatedData([
        'name' => 'required|max:24'
      ]);
      return $repository->updateSgeCate($id,$data);
  }

  public function delSgeCate(SgeRepository $repository,$id)
  {
      return $repository->deleteSgeCate($id);
  }
}
