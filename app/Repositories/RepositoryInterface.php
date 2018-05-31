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
     * Get the Pagindated Data depends on the paramters and filters
     *
     * @param array $params
     * @param array $relationships
     * @param bool $withRelation
     * @return mixed
     */
    public function getPaginatedData(array $params, array $relationships = [], bool $withRelation = true);

    /**
     * Generate Random Numbers
     *
     * @return mixed
     */
    public function generateNumber();


}