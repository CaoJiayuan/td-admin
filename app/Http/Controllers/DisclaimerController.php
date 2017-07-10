<?php

namespace App\Http\Controllers;

use App\Repository\DisclaimerRepository;
use Illuminate\Http\Request;

class DisclaimerController extends Controller
{
    public function index(DisclaimerRepository $repository)
    {
        return $repository->getDisclaimer();

    }

    public function disclaimerEdit(DisclaimerRepository $repository, Request $request, $id)
    {
        $data = $this->getValidatedData([
            'content' => 'required'
        ]);
        return $repository->editDisclaimer($data, $id);
    }
}
