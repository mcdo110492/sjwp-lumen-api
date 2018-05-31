<?php

namespace  App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;


class Repository implements RepositoryInterface
{
    // Model property of the instance of Model
    protected $model;

    /**
     * MainRepository constructor that bind model to repo
     * @param Model $model
     */
    public function __construct(Model $model)
    {

        $this->model = $model;

    }

    /**
     * Get all data of the model
     *
     * @return \Illuminate\Database\Eloquent\Collection|Model[]|mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Create a new model
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {

        return $this->model->create($data);

    }

    /**
     * Update the current model
     *
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {

        $record = $this->model->findOrFail($id);

        return $record->update($data);

    }

    public function destroy($id)
    {

        return $this->model->delete($id);

    }

    /**
     * Get the model by id
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {

        return $this->model->findOrFail($id);

    }

    /**
     * Get the Pagindated Data depends on the paramters and filters
     *
     * @param array $params
     * @param array $relationships
     * @param bool $withRelations
     * @return array|mixed
     */
    public function getPaginatedData(array $params, array $relationships = [], bool $withRelations = true)
    {
        //Validate the column field if exists in the table
       try {
           $page = $params['page'];
           $limit = $params['limit'];
           $field = $params['field'];
           $filter = $params['filter'];
           $order = strtoupper($params['order']);
           $limitPage = $page - 1;
           $offset = $limit * $limitPage;


           $query = $this->model->where($field, 'LIKE', '%'.$filter.'%');
           $count = $query->count();

       }
       catch (Exception $e)
       {
           //Throw an error 404 if the column field is not found in the table
           abort(404,'Incorrect Field Parameter.');

       }

       if($withRelations)
       {
           $data = $query->with($relationships)->take($limit)->skip($offset)->orderBy($field,$order)->get();
       }
       else
       {

           $data = $query->take($limit)->skip($offset)->orderBy($field,$order)->get();
       }

        $response = ['count' => $count, 'data' => $data];

        return $response;
    }


    public function generateNumber()
    {
        $padLength = 11;
        $padString = '0';
        $padType = STR_PAD_LEFT;
        $beginNumber = 0;
        $endNumber = 99999999999;
        $mtRand = mt_rand($beginNumber, $endNumber);

        $uniqueNum = str_pad($mtRand, $padLength, $padString, $padType);

        return $uniqueNum;
    }



}