<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

    //Property for the baptism table
    protected $table;


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

        $this->table = $baptism->getTable();

    }

    /**
     * Get all the data depending on the request paramaters
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $relationship = ['sponsors'];

        $get = $this->baptism->getPaginatedDataWithRelationship($this->request->all(),$relationship);


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
            'fatherName' => 'required|max:50',
            'motherName' => 'required|max:50',
            'minister_id' => 'required|integer',
            'sponsors.*.sponsor' => 'max:50'
        ]);

        DB::transaction(function() {

            $data = [
              'firstName' => $this->request['firstName'],
              'middleName' => $this->request['middleName'],
              'lastName' => $this->request['lastName'],
              'nameExt' => $this->request['nameExt'],
              'birthdate' => $this->request['birthdate'],
              'birthPlace' => $this->request['birthPlace'],
              'baptismDate' => $this->request['baptismDate'],
              'book' => $this->request['book'],
              'page' => $this->request['page'],
              'entry' => $this->request['entry'],
              'fatherName' => $this->request['fatherName'],
              'motherName' => $this->request['motherName'],
              'minister_id' => $this->request['minister_id']
            ];

            $create = $this->baptism->create($data);


            foreach ($this->request['sponsors'] as $sponsor)
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
            'fatherName' => 'required|max:50',
            'motherName' => 'required|max:50',
            'minister_id' => 'required|integer'
        ]);

        $data = [
            'firstName' => $this->request['firstName'],
            'middleName' => $this->request['middleName'],
            'lastName' => $this->request['lastName'],
            'nameExt' => $this->request['nameExt'],
            'birthdate' => $this->request['birthdate'],
            'birthPlace' => $this->request['birthPlace'],
            'baptismDate' => $this->request['baptismDate'],
            'book' => $this->request['book'],
            'page' => $this->request['page'],
            'entry' => $this->request['entry'],
            'fatherName' => $this->request['fatherName'],
            'motherName' => $this->request['motherName'],
            'minister_id' => $this->request['minister_id']
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
           'sponsor' => 'required|max:50'
        ]);

        $data = ['sponsor' => $this->request['sponsor'], 'baptism_id' => $id];

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
           'sponsor' => 'required|max:50'
        ]);

        $data = ['sponsor' => $this->request['sponsor']];

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