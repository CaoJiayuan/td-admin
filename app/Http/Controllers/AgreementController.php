<?php

namespace App\Http\Controllers;

use App\Entity\Agreement;
use App\Repository\AgreementRepository;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
    public function index(AgreementRepository $repository)
    {
        return $repository->getAgreement();
    }

    public function agreementAdd(AgreementRepository $repository, Request $request)
    {
        $data = $this->getValidatedData([
            'title',
            'keyWords',
            'type',
            'content',
        ]);
        return $repository->addAgreement($data);
    }

    public function edit($id)
    {//获取
        $data = Agreement::whereId($id)->select()->first();
        return response()->json($data);
    }

    public function agreementEdit(AgreementRepository $repository, Request $request, $id)
    {//修改
        $data = $this->getValidatedData([
            'title',
            'keyWords',
            'type',
            'content'
        ]);
        return $repository->editAgreement($data, $id);
    }

    public function agreementDel(AgreementRepository $repository, $id)
    {
        return $repository->delAgreement($id);
    }
}
