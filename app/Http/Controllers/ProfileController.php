<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Profile;

class ProfileController extends Controller
{
    /**
     * The minister reqpository instance
     */
    protected  $profile;

    /**
     * The request repository instance
     */
    protected  $requests;

    /**
     * Constructor method to create a new controller instance
     *
     * @param Profile $profile
     * @param Request $requests
     */
    public function __construct(Profile $profile, Request $requests)
    {
        $this->profile = $profile;

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

        $query = $this->profile->where($field, 'LIKE', '%'.$filter.'%');
        $count = $query->count();
        $data = $query->take($limit)->skip($offset)->orderBy($field,$order)->get();

        return response()->json(compact('count','data'));
    }

    /**
     * Store the  data in the database
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $this->validate($this->requests, [
            'name' => 'required|max:50|unique:minister'
        ]);


        $data = ['name' => $this->requests['name'], 'active' => 0];

        $this->ministers->create($data);

        return response()->json(['isCreated' => true]);
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
            'name' => ['required', Rule::unique('minister')->ignore($id)],
            'active' => 'required|integer'
        ]);

        $data = ['name' => $this->requests['name'], 'active' => $this->requests['active']];

        $minister = $this->ministers->findOrFail($id);

        $minister->update($data);

        return response()->json(['isUpdated' => true]);
    }
}
