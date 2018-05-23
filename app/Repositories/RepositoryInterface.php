<?php

namespace App\Repositories;

interface RepositoryInterface
{

    /**
     * Get All the data
     *
     * @return mixed
     */
    public function all();


    /**
     * Create a new Data
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);


    /**
     * Update Data
     *
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Remove Data
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    /**
     * Get Data by id
     *
     * @param $id
     * @return mixed
     */
    public function show($id);


    /**
     * Get pagianted data by params
     *
     * @param array $params
     * @return mixed
     */
    public function getPaginatedData(array $params);

    /**
     * Get paginated data by params with relationship
     *
     * @param array $params
     * @param array $relationships
     * @return mixed
     */
    public function getPaginatedDataWithRelationship(array $params, array $relationships);

}