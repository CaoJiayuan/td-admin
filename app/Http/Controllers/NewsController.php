<?php

namespace App\Http\Controllers;

use App\Repository\NewsRepository;

class NewsController extends Controller
{
  public function index(NewsRepository $repository)
  {
    return $repository->getNews();
  }

  public function newsComments(NewsRepository $repository, $id)
  {
    return  $repository->getNewsComments($id);
  }

  public function modifyStatus(NewsRepository $repository,$id)
  {
    return $repository->changeStatus($id);
  }
}
