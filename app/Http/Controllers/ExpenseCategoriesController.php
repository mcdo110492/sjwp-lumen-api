<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\ExpenseCategories;

class ExpenseCategoriesController extends Controller
{
    /**
     * The category reqpository instance
     */
    protected  $category;

    /**
     * The request repository instance
     */
    protected  $requests;

    /**
     * Controller constructor.
     *
     * @param ExpenseCategories $category
     * @param Request $requests
     */
    public function __construct(ExpenseCategories $category, Request $requests)
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
     * Store the  data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $this->validate($this->requests, [
            'name' => 'required|max:150|unique:expenseCategories'
        ]);


        $data = ['name' => $this->requests['name']];

        $this->category->create($data);

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
        $category = $this->category->findOrFail($id);

        $this->validate($this->requests, [
            'name' => ['required', 'max:150', Rule::unique('expenseCategories')->ignore($category->id)],
            'parent_id' => 'integer'
        ]);

        $data = ['name' => $this->requests['name'], 'parent_id' => $this->requests->input('parent_id')];


        $category->update($data);

        return response()->json(['isUpdated' => true]);
    }
}
