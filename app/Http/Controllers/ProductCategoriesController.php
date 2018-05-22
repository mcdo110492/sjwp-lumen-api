<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\ProductCategories;

class ProductCategoriesController extends Controller
{
    /**
     * The minister reqpository instance
     */
    protected  $category;

    /**
     * The request repository instance
     */
    protected  $requests;

    /**
     * MinistersController constructor to create a new controller instance
     *
     * @param ProductCategories $category
     * @param Request $requests
     */
    public function __construct(ProductCategories $category, Request $requests)
    {
        $this->category = $category;

        $this->requests = $requests;
    }

    /**
     * Get all the number of data and the data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $page = $this->requests['page'];
        $limit = $this->requests['limit'];
        $field = $this->requests['field'];
        $filter = $this->requests['filter'];
        $order = strtoupper($this->requests['order']);
        $limitPage = $page - 1;
        $offset = $limit * $limitPage;
        $parent_id = $this->requests['parent_id'];


        $query = $this->category->where(function ($q) use ($parent_id){
            $q->where('parent_id','=',$parent_id);
        })->where($field, 'LIKE', '%'.$filter.'%');


        $count = $query->count();
        $data = $query->take($limit)->skip($offset)->orderBy($field,$order)->get();

        return response()->json(compact('count','data'));
    }

    /**
     * Store the minister data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $this->validate($this->requests, [
            'name' => 'required|max:50|unique:productCategories'
        ]);


        $data = ['name' => $this->requests['name']];

        $this->category->create($data);

        return response()->json(['isCreated' => true],201);
    }

    /**
     * Update the minister data
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $category = $this->category->withUuid($id)->firstOrFail();

        $this->validate($this->requests, [
            'name' => ['required', Rule::unique('productCategories')->ignore($category->id)],
            'price' => 'number',
            'parent_id' => 'integer'
        ]);

        $data = ['name' => $this->requests['name'], 'price' => $this->requests['price'], 'parent_id' => $this->requests['parent_id']];


        $category->update($data);

        return response()->json(['isUpdated' => true]);
    }
}