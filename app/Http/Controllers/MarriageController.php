<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Marriage;
use App\MarriageHusband;
use App\MarriageWife;
use App\MarriageSponsor;

class MarriageController extends Controller
{
    // Property for marriage Instance
    protected $marriage;

    //Property for marriage husband instance
    protected $husband;

    //Property for marriage wife instance
    protected $wife;

    //Property for marraige sponsor instance
    protected $sponsor;

    //Property for request instance
    protected $request;

    //Property for validation rules
    protected $rules;


    /**
     * MarriageController constructor.
     *
     * @param Marriage $marriage
     * @param MarriageHusband $husband
     * @param MarriageWife $wife
     * @param MarriageSponsor $sponsor
     * @param Request $request
     */
    public  function __construct(Marriage $marriage, MarriageHusband $husband, MarriageWife $wife, MarriageSponsor $sponsor, Request $request)
    {

        $this->marriage = new Repository($marriage);

        $this->husband = new Repository($husband);

        $this->wife = new Repository($wife);

        $this->sponsor = new Repository($sponsor);

        $this->request = $request;

        $this->rules = $marriage::$rules;

    }

    /**
     * Get all the data depending on the request paramaters
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $filter = $this->request['filter'];

        $relationship = [
            'husband' => function($q) use ($filter) {
                $q->where('firstName', 'LIKE', '%'.$filter.'%')->orWhere('middleName', 'LIKE', '%'.$filter.'%')
                    ->orWhere('lastName', 'LIKE', '%'.$filter.'%');
            }, 'wife' => function($q) use ($filter) {
                $q->where('firstName', 'LIKE', '%'.$filter.'%')->orWhere('middleName', 'LIKE', '%'.$filter.'%')
                    ->orWhere('lastName', 'LIKE', '%'.$filter.'%');
            },'minister', 'sponsors'];

        $get = $this->marriage->getPaginatedData($this->request->input(),$relationship);


        return response()->json(['count' => $get['count'],'data' => $get['data']],200);

    }

    /**
     * Create a new record
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {

        $this->validate($this->request,$this->rules);

        DB::transaction(function() {

            $husband = $this->request['husband'];

            $createHusband = $this->husband->create($husband);

            $wife = $this->request['wife'];

            $createWife = $this->wife->create($wife);

            $marriage = [
                'husband_id' => $createHusband->id,
                'wife_id' => $createWife->id,
                'dateMarried' => $this->request['dateMarried'],
                'book' => $this->request['book'],
                'page' => $this->request['page'],
                'entry' => $this->request['entry'],
                'minister_id' => $this->request['minister_id']
            ];

            $createMarriage = $this->marriage->create($marriage);


            foreach ($this->request['sponsors'] as $sponsor)
            {
                $sponsorData = ['sponsor' => $sponsor['sponsor'], 'marriage_id' => $createMarriage->id];

                $this->sponsor->create($sponsorData);
            }

        });

        return response()->json(['isCreated' => true],201);


    }

    /**
     * Update Husband
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateHusband($id)
    {

        $this->validate($this->request,Marriage::$husbandWifeRules);

        $this->husband->update($this->request->input(),$id);

        return response()->json(['isUpdated' => true],200);

    }

    /**
     * Update Wife
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateWife($id)
    {

        $this->validate($this->request,Marriage::$husbandWifeRules);

        $this->wife->update($this->request->input(),$id);

        return response()->json(['isUpdated' => true],200);

    }

    /**
     * Update Marriage
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateMarriage($id)
    {


        $this->validate($this->request,Marriage::$marriageRules);

        $this->marriage->update($this->request->input(),$id);

        return response()->json(['isUpdated' => true],200);

    }


    /**
     * Add New Marriage Sponsor
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addSponsor($id)
    {

        $this->marriage->show($id);

        $this->validate($this->request,[
            'sponsor' => 'required|max:150'
        ]);

        $data = ['sponsor' => $this->request['sponsor'], 'marriage_id' => $id];

        $this->sponsor->create($data);


        return response()->json(['isCreated' => true],201);
    }


    /**
     * Update the marriage sponsor data
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

        $data = ['sponsor' => $this->request['sponsor']];

        $this->sponsor->update($data,$id);

        return response()->json(['isUpdated' => true],200);
    }


    /**
     * Remove or Delete the sponsor of marriage
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