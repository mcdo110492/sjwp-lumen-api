<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Baptism;
use App\BaptismSponsor;

class BaptismController extends Controller
{
    // Property for baptism Instance
    protected $baptism;

    //Property for baptism sponsor instance
    protected $sponsor;

    //Property for request instance
    protected $request;



    /**
     * BaptismController constructor.
     * @param Baptism $baptism
     * @param BaptismSponsor $sponsor
     * @param Request $request
     */
    public  function __construct(Baptism $baptism, BaptismSponsor $sponsor, Request $request)
    {

        $this->baptism = new Repository($baptism);

        $this->sponsor = new Repository($sponsor);

        $this->request = $request;


    }

    /**
     * Get all the data depending on the request paramaters
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $relationship = ['sponsors','minister'];

        $get = $this->baptism->getPaginatedData($this->request->input(),$relationship);


        return response()->json(['count' => $get['count'],'data' => $get['data']],200);

    }

    /**
     * Create a new record for baptism and baptism sponsors
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
            'birthdate' => 'required|date',
            'baptismDate' => 'required|date',
            'birthPlace' => 'max:150',
            'fatherName' => 'required|max:150',
            'motherName' => 'required|max:150',
            'minister_id' => 'required|integer',
            'sponsors.*.sponsor' => 'sometimes|max:150'
        ]);

        DB::transaction(function() {

            $data = [
              'firstName' => $this->request->input('firstName'),
              'middleName' => $this->request->input('middleName'),
              'lastName' => $this->request->input('lastName'),
              'nameExt' => $this->request->input('nameExt'),
              'birthdate' => $this->request->input('birthdate'),
              'birthPlace' => $this->request->input('birthPlace'),
              'baptismDate' => $this->request->input('baptismDate'),
              'book' => $this->request->input('book'),
              'page' => $this->request->input('page'),
              'entry' => $this->request->input('entry'),
              'fatherName' => $this->request->input('fatherName'),
              'motherName' => $this->request->input('motherName'),
              'minister_id' => $this->request->input('minister_id')
            ];

            $create = $this->baptism->create($data);


            foreach ($this->request->input('sponsors') as $sponsor)
            {
                $sponsorData = ['sponsor' => $sponsor['sponsor'], 'baptism_id' => $create->id];

                $this->sponsor->create($sponsorData);
            }

        });

        return response()->json(['isCreated' => true],201);


    }


    /**
     * Update the baptism data
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
            'birthdate' => 'required|date',
            'baptismDate' => 'required|date',
            'birthPlace' => 'max:150',
            'fatherName' => 'required|max:150',
            'motherName' => 'required|max:150',
            'minister_id' => 'required|integer'
        ]);

        $data = [
            'firstName' => $this->request->input('firstName'),
            'middleName' => $this->request->input('middleName'),
            'lastName' => $this->request->input('lastName'),
            'nameExt' => $this->request->input('nameExt'),
            'birthdate' => $this->request->input('birthdate'),
            'birthPlace' => $this->request->input('birthPlace'),
            'baptismDate' => $this->request->input('baptismDate'),
            'book' => $this->request->input('book'),
            'page' => $this->request->input('page'),
            'entry' => $this->request->input('entry'),
            'fatherName' => $this->request->input('fatherName'),
            'motherName' => $this->request->input('motherName'),
            'minister_id' => $this->request->input('minister_id')
        ];

        $this->baptism->update($data,$id);

        return response()->json(['isUpdated' => true],200);
    }


    /**
     * Add New Baptism Sponsor
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addSponsor($id)
    {

        $this->baptism->show($id);

        $this->validate($this->request,[
           'sponsor' => 'required|max:150'
        ]);

        $data = ['sponsor' => $this->request->input('sponsor'), 'baptism_id' => $id];

        $this->sponsor->create($data);


        return response()->json(['isCreated' => true],201);
    }


    /**
     * Update the baptism sponsor data
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateSponsor($id)
    {
        $this->validate($this->request,[
           'sponsor' => 'required|max:150'
        ]);

        $data = ['sponsor' => $this->request->input('sponsor')];

        $this->sponsor->update($data,$id);

        return response()->json(['isUpdated' => true],200);
    }


    /**
     * Remove or Delete the sponsor of baptism
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeSponsor($id)
    {
        $this->sponsor->show($id);

        $this->sponsor->destroy($id);

        return response()->json(['isDeleted' => true],200);
    }

}