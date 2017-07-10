<?php

namespace App\Http\Controllers;

use App\Repository\SgeCataDetailRepository;

class SgeQuestionController extends Controller
{
    public function index(SgeCataDetailRepository $repository, $id)
    {
        return $repository->getDetail($id);
    }

    public function questionAdd(SgeCataDetailRepository $repository)
    {
        $data = $this->getValidatedData([
            'sge_catalog_id' => 'required',
            'question',
            'answer'
        ]);
        return $repository->addQuestion($data);
    }

    public function questionEdit(SgeCataDetailRepository $repository, $id)
    {
        $data = $this->getValidatedData([
            'question',
            'answer'
        ]);
        return $repository->editSgeQuestion($data, $id);
    }

    public function questionDel(SgeCataDetailRepository $repository, $id)
    {
        return $repository->delQuestion($id);
    }
}
