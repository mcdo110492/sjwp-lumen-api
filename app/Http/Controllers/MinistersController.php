<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Repositories\Repository;
use App\Ministers;

class MinistersController extends Controller
{
    /**
     * property to bind the repository
     */
    protected  $model;

    /**
     * property to bind the requests
     */
    protected  $requests;

    /**
     * proepert to bind the table
     * @var string
     */
    protected $table;

    /**
     * MinistersController constructor to create a new controller instance
     *
     * @param Ministers $ministers
     * @param Request $requests
     */
    public function __construct(Ministers $ministers, Request $requests)
    {
        $this->model = new Repository($ministers);

        $this->requests = $requests;

        $this->table = $ministers->getTable();
    }

    /**
     * Get all the number of data and the data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $get = $this->model->getPaginatedData($this->requests->input(),[],false);

        return response()->json($get,200);
    }

    /**
     * Store the minister data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $this->validate($this->requests, [
            'name' => 'required|max:50|unique:'.$this->table
        ]);


        $data = ['name' => $this->requests->input('name'), 'active' => 0];

        $this->model->create($data);

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

        $this->validate($this->requests, [
            'name' => ['required', Rule::unique($this->table)->ignore($id)],
            'active' => 'required|integer'
        ]);

        $data = ['name' => $this->requests->input('name'), 'active' => $this->requests->input('active')];

        $this->model->update($data,$id);

        return response()->json(['isUpdated' => true],200);
    }


    public function changeStatus($id){

        $this->validate($this->requests, [
            'id' => 'required|integer',
            'active' => 'required|numeric'
        ]);
        
        $getCurrentActiveQuery = Ministers::where('active','=',1);

        $count = $getCurrentActiveQuery->count();
        //Check if there is a current active minister
        if($count > 0){
          $getCurrentActive = $getCurrentActiveQuery->get()->first();

          //Change the active status to 0 or inactive
          $currentActive = ['active' => 0];

          //Get the current id
          $currentActiveId = $getCurrentActive->id;

          //Update the current active
          $this->model->update($currentActive, $currentActiveId);
        }

        

        $data = ['active' => $this->requests->input('active')];

        $this->model->update($data, $id);

        return response()->json(['isStatusChanged' => true],200);

    }
}
