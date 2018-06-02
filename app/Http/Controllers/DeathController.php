<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Death;

class DeathController extends Controller
{
    // Property for death Instance
    protected $death;


    //Property for request instance
    protected $request;



    /**
     * DeathController constructor.
     * @param Death $death
     * @param Request $request
     */
    public  function __construct(Death $death, Request $request)
    {

        $this->death = new Repository($death);

        $this->request = $request;


    }

    /**
     * Get all the data depending on the request paramaters
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $relationship = ['minister'];

        $get = $this->death->getPaginatedData($this->request->input(),$relationship);


        return response()->json(['count' => $get['count'],'data' => $get['data']],200);

    }

    /**
     * Create a new record for death
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {

        $this->validate($this->request,[
            'firstName' => 'required|max:50',
            'middleName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'deathDate' => 'required|date',
            'burialDate' => 'required|date',
            'residence' => 'required|max:150',
            'burialPlace' => 'required|max:150',
            'book' => 'required',
            'page' => 'required',
            'entry' => 'required',
            'minister_id' => 'required|integer'
        ]);



        $data = [
            'firstName' => $this->request->input('firstName'),
            'middleName' => $this->request->input('middleName'),
            'lastName' => $this->request->input('lastName'),
            'nameExt' => $this->request->input('nameExt'),
            'deathDate' => $this->request->input('deathDate'),
            'burialDate' => $this->request->input('burialDate'),
            'residence' => $this->request->input('residence'),
            'burialPlace' => $this->request->input('burialPlace'),
            'book' => $this->request->input('book'),
            'page' => $this->request->input('page'),
            'entry' => $this->request->input('entry'),
            'minister_id' => $this->request->input('minister_id')
        ];


         $this->death->create($data);



        return response()->json(['isCreated' => true],201);


    }


    /**
     * Update the death data
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id)
    {
        $this->validate($this->request,[
            'firstName' => 'required|max:50',
            'middleName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'deathDate' => 'required|date',
            'burialDate' => 'required|date',
            'residence' => 'required|max:150',
            'burialPlace' => 'required|max:150',
            'book' => 'required',
            'page' => 'required',
            'entry' => 'required',
            'minister_id' => 'required|integer'
        ]);

        $data = [
            'firstName' => $this->request->input('firstName'),
            'middleName' => $this->request->input('middleName'),
            'lastName' => $this->request->input('lastName'),
            'nameExt' => $this->request->input('nameExt'),
            'deathDate' => $this->request->input('deathDate'),
            'burialDate' => $this->request->input('burialDate'),
            'residence' => $this->request->input('residence'),
            'burialPlace' => $this->request->input('burialPlace'),
            'book' => $this->request->input('book'),
            'page' => $this->request->input('page'),
            'entry' => $this->request->input('entry'),
            'minister_id' => $this->request->input('minister_id')
        ];

        $this->death->update($data,$id);

        return response()->json(['isUpdated' => true],200);
    }



}