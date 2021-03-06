<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Confirmation;
use App\ConfirmationSponsor;

class ConfirmationController extends Controller
{
    // Property for confirmation Instance
    protected $confirmation;

    //Property for confirmation sponsor instance
    protected $sponsor;

    //Property for request instance
    protected $request;



    /**
     * ConfirmationController constructor.
     *
     * @param Confirmation $confirmation
     * @param ConfirmationSponsor $sponsor
     * @param Request $request
     */
    public  function __construct(Confirmation $confirmation, ConfirmationSponsor $sponsor, Request $request)
    {

        $this->confirmation = new Repository($confirmation);

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

        $get = $this->confirmation->getPaginatedData($this->request->input(),$relationship);


        return response()->json(['count' => $get['count'],'data' => $get['data']],200);

    }

    /**
     * Create a new record for confirmation and confirmation sponsors
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
            'confirmationDate' => 'required|date',
            'baptismDate' => 'required|date',
            'baptizedAt' => 'max:150',
            'minister_id' => 'required|integer',
            'sponsors.*.sponsor' => 'max:150'
        ]);

        DB::transaction(function() {

            $data = [
                'firstName' => $this->request->input('firstName'),
                'middleName' => $this->request->input('middleName'),
                'lastName' => $this->request->input('lastName'),
                'nameExt' => $this->request->input('nameExt'),
                'confirmationDate' => $this->request->input('confirmationDate'),
                'baptizedAt' => $this->request['baptizedAt'],
                'baptismDate' => $this->request->input('baptismDate'),
                'book' => $this->request->input('book'),
                'page' => $this->request->input('page'),
                'minister_id' => $this->request->input('minister_id')
            ];

            $create = $this->confirmation->create($data);


            foreach ($this->request->input('sponsors') as $sponsor)
            {
                $sponsorData = ['sponsor' => $sponsor['sponsor'], 'confirmation_id' => $create->id];

                $this->sponsor->create($sponsorData);
            }

        });

        return response()->json(['isCreated' => true],201);


    }


    /**
     * Update the confirmation data
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
            'confirmationDate' => 'required|date',
            'baptismDate' => 'required|date',
            'baptizedAt' => 'max:150',
            'minister_id' => 'required|integer',
        ]);

        $data = [
            'firstName' => $this->request->input('firstName'),
            'middleName' => $this->request->input('middleName'),
            'lastName' => $this->request->input('lastName'),
            'nameExt' => $this->request->input('nameExt'),
            'confirmationDate' => $this->request->input('confirmationDate'),
            'baptizedAt' => $this->request['baptizedAt'],
            'baptismDate' => $this->request->input('baptismDate'),
            'book' => $this->request->input('book'),
            'page' => $this->request->input('page'),
            'minister_id' => $this->request->input('minister_id')
        ];

        $this->confirmation->update($data,$id);

        return response()->json(['isUpdated' => true],200);
    }


    /**
     * Add New Confirmation Sponsor
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addSponsor($id)
    {

        $this->confirmation->show($id);

        $this->validate($this->request,[
            'sponsor' => 'required|max:150'
        ]);

        $data = ['sponsor' => $this->request->input('sponsor'), 'confirmation_id' => $id];

        $this->sponsor->create($data);


        return response()->json(['isCreated' => true],201);
    }


    /**
     * Update the confirmation sponsor data
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
     * Remove or Delete the sponsor of confirmation
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