<?php

namespace  App\Repositories;

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
     * Get the model depending on the parameters
     *
     * @param array $params
     * @return array|mixed
     */
    public function getPaginatedData(array $params)
    {
        $page = $params['page'];
        $limit = $params['limit'];
        $field = $params['field'];
        $filter = $params['filter'];
        $order = strtoupper($params['order']);
        $limitPage = $page - 1;
        $offset = $limit * $limitPage;

        $query = $this->model->where($field, 'LIKE', '%'.$filter.'%');
        $count = $query->count();
        $data = $query->take($limit)->skip($offset)->orderBy($field,$order)->get();

        $response = ['count' => $count, 'data' => $data];

        return $response;
    }

    /**
     *  Get the model depending on the parameters with relationships
     *
     * @param array $params
     * @param array $relationships
     * @return array|mixed
     */
    public function getPaginatedDataWithRelationship(array $params, array $relationships)
    {
        $page = $params['page'];
        $limit = $params['limit'];
        $field = $params['field'];
        $filter = $params['filter'];
        $order = strtoupper($params['order']);
        $limitPage = $page - 1;
        $offset = $limit * $limitPage;

        $query = $this->model->with($relationships)->where($field, 'LIKE', '%'.$filter.'%');
        $count = $query->count();
        $data = $query->take($limit)->skip($offset)->orderBy($field,$order)->get();

        $response = ['count' => $count, 'data' => $data];

        return $response;
    }


}