<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MinisterTest extends TestCase
{

    use DatabaseTransactions;

    protected $params = ['page' => 1, 'limit' => 5, 'field' => 'name', 'filter' => '', 'order' => 'asc'];

    public function test_it_should_get_data_depending_with_specified_parameter()
    {


        $response = $this->call('GET','/ministers',$this->params);

        $this->assertEquals(200,$response->status());

        $ministers = factory('App\Ministers')->create();

        $this->json('GET','/ministers',$this->params)
            ->seeJsonEquals(['count' => 1, 'data' => [$ministers]]);

    }

    public function test_it_should_create_new_minister_and_save_to_database()
    {

        $data = factory('App\Ministers')->make()->toArray();

        $response = $this->post('/ministers',$data);

        $response->assertResponseStatus(201);

        $response->seeJsonEquals([
                'isCreated' => true
        ]);


    }


    public function test_it_should_update()
    {
        $data = factory('App\Ministers')->create();

        $updatedData = factory('App\Ministers')->make([
            'name' => 'Updated Data',
            'active' => 1
        ])->toArray();


        $response = $this->put('/ministers/'.$data->id,$updatedData);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals([
            'isUpdated' => true
        ]);


    }


    public function test_it_should_validate_the_fields_and_return_422_error()
    {

        $data = ['name' => null];

        $response = $this->post('/ministers',$data);

        $response->assertResponseStatus(422);

    }

    public function test_it_should_failed_if_the_data_is_not_found_when_updating()
    {
        $data = ['name' => 'Fr. Donato'];

        $response = $this->put('/ministers/1',$data);

        $response->assertResponseStatus(404);

    }

    public function test_it_should_be_unique_name()
    {

        $data = factory('App\Ministers')->create();

        $newData = ['name' => $data->name];

        $response = $this->post('/ministers',$newData);

        $response->assertResponseStatus(422);

    }

    public function test_it_should_ignore_the_unique_name_when_updating_with_the_same_id()
    {

        $data = factory('App\Ministers')->create();

        $updatedData = ['name' => $data->name, 'active' => 1];

        $response = $this->put('/ministers/'.$data->id,$updatedData);

        $response->assertResponseStatus(200);

    }

}
