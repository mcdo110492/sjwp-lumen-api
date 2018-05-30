<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class DeathTest extends TestCase
{
    use DatabaseTransactions;


    protected $params = ['page' => 1, 'limit' => 5, 'field' => 'firstName', 'filter' => '', 'order' => 'asc'];


    public function test_it_should_get_data_depending_with_specified_parameter()
    {

        factory(App\Death::class,10)
            ->create();


        $response = $this->json('GET','/death',$this->params);

        $response->assertResponseStatus(200);

        $response->seeJson(['count' => 10]);

        $response->seeJsonStructure(['count','data']);


    }

    public function test_it_should_create_new_death()
    {

        $data = factory(App\Death::class)->make()->toArray();

        $response = $this->post('/death',$data);

        $response->assertResponseStatus(201);

        $response->seeJsonEquals([
            'isCreated' => true
        ]);


    }


    public function test_it_should_update_baptism()
    {
        $data = factory(App\Death::class)->create();

        $updatedData = factory(App\Death::class)->make([
            'firstName' => 'Updated Name',
            'middleName' => 'Updated Middle Name'
        ])->toArray();


        $response = $this->put('/death/'.$data->id,$updatedData);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals([
            'isUpdated' => true
        ]);


    }


    public function test_it_should_validate_the_fields_and_return_422_error()
    {

        $data = factory(App\Death::class)->make([
            'firstName' => null
        ])->toArray();

        $create = $this->post('/death',$data);

        $create->assertResponseStatus(422);


        $update = $this->put('/death/1',$data);

        $update->assertResponseStatus(422);

    }


    public function test_it_should_failed_if_the_data_is_not_found_when_updating()
    {
        $data = factory(App\Death::class)->make()->toArray();

        $response = $this->put('/death/1',$data);

        $response->assertResponseStatus(404);

    }





}
