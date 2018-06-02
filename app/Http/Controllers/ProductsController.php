<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Products;

class ProductsController extends Controller
{
    /**
     * The product reqpository instance
     */
    protected  $product;

    /**
     * The request repository instance
     */
    protected  $requests;

    /**
     * ProductsController constructor.
     *
     * @param Products $category
     * @param Request $requests
     */
    public function __construct(Products $products, Request $requests)
    {
        $this->product = new Repository($products);

        $this->requests = $requests;
    }

    /**
     * Get all the number of data and the data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $request = $this->requests->input();

        $get = $this->product->getPaginatedData($request,[],false);

        return response()->json($get,200);
    }

    /**
     * Store the  data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $this->validate($this->requests, [
            'description' => 'required|max:150',
            'price' => 'required|numeric'
        ]);

        $hasUniqueCode = false;
        $uniqueCode = null;

       // Loop unitl a unique number is generated
        while(!$hasUniqueCode)
        {
            $temUniqueCode = $this->product->generateNumber();

            $count = Products::where('code','=',$temUniqueCode)->count();
            //Check if generated code is unique and assign it to $uniqueCode to be save in database and exit the loop
            if($count == 0)
            {
                $hasUniqueCode = true;
                $uniqueCode = $temUniqueCode;
            }
        }


        $data = ['code' => $uniqueCode,
            'description' => $this->requests->input('description'),
            'price' => $this->requests->input('price'),
            'category_id' => $this->requests->input('category_id')];

        $this->product->create($data);

        return response()->json(['isCreated' => true],201);
    }

    /**
     * Update the  data
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {

        $this->validate($this->requests, [
            'description' => 'required|max:150',
            'price' => 'required|numeric'
        ]);

        $data = ['description' => $this->requests->input('description'),
            'price' => $this->requests->input('price'),
            'category_id' => $this->requests->input('category_id')];


        $this->product->update($data,$id);

        return response()->json(['isUpdated' => true]);
    }
}
