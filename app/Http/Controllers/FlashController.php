<?php

namespace App\Http\Controllers;


use App\Repository\FlashRepository;

class FlashController extends Controller
{
    public function index(FlashRepository $repository)
    {
      return $repository->getFlashes();
    }
}
