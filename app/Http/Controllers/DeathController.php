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

    //Property for the death table
    protected $table;


    /**
     * DeathController constructor.
     * @param Death $death
     * @param Request $request
     */
    public  function __construct(Death $death, Request $request)
    {

        $this->death = new Repository($death);

        $this->request = $request;

        $this->table = $death->getTable();

    }

    /**
     * Get all the data depending on the request paramaters
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $relationship = ['minister'];

        $get = $this->death->getPaginatedDataWithRelationship($this->request->input(),$relationship);


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
            'firstName' => $this->request['firstName'],
            'middleName' => $this->request['middleName'],
            'lastName' => $this->request['lastName'],
            'nameExt' => $this->request['nameExt'],
            'deathDate' => $this->request['deathDate'],
            'burialDate' => $this->request['burialDate'],
            'residence' => $this->request['residence'],
            'burialPlace' => $this->request['burialPlace'],
            'book' => $this->request['book'],
            'page' => $this->request['page'],
            'entry' => $this->request['entry'],
            'minister_id' => $this->request['minister_id']
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
            'firstName' => $this->request['firstName'],
            'middleName' => $this->request['middleName'],
            'lastName' => $this->request['lastName'],
            'nameExt' => $this->request['nameExt'],
            'deathDate' => $this->request['deathDate'],
            'burialDate' => $this->request['burialDate'],
            'residence' => $this->request['residence'],
            'burialPlace' => $this->request['burialPlace'],
            'book' => $this->request['book'],
            'page' => $this->request['page'],
            'entry' => $this->request['entry'],
            'minister_id' => $this->request['minister_id']
        ];

        $this->death->update($data,$id);

        return response()->json(['isUpdated' => true],200);
    }



}