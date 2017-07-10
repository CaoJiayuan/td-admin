<?php

namespace App\Http\Controllers\Products;

use App\Entity\Product;
use App\Http\Controllers\Controller;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers;
class ProductsController extends Controller
{
    public function index(ProductRepository $repository)
    {
        return $repository->getProducts();
    }

    public function productAdd(ProductRepository $repository)
    {
        $data = $this->getValidatedData([
            'name',
            'code',
            'content'
        ]);
        return $repository->addProduct($data);
    }

    public function productEdit(ProductRepository $repository, $id)
    {
        $data = $this->getValidatedData([
            'name',
            'code',
            'content'
        ]);
        return $repository->editProduct($data, $id);
    }

    public function editSummary($id)
    {
        $data = Product::whereId($id)->select('id', 'name', 'code', 'content')->first();
        return response()->json($data);
    }

    public function productDel(ProductRepository $repository, $id)
    {
        return $repository->delProduct($id);
    }

    public function getComplaint(ProductRepository $repository)
    {
        return $repository->complaints();
    }

    public function getComments(ProductRepository $repository, Request $request)
    {
        $data['type'] = $request->get('type');
        $data['comment_id'] =$request->get('comment_id');
        return $repository->comments($data);
    }

}
