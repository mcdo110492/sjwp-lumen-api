<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BaptismTest extends TestCase
{
    use DatabaseTransactions;


    protected $params = ['page' => 1, 'limit' => 5, 'field' => 'firstName', 'filter' => '', 'order' => 'asc'];


    public function test_it_should_get_data_depending_with_specified_parameter()
    {

        factory(App\Baptism::class,10)
            ->create()
            ->each(function ($s) {
                 $s->sponsors()->save(factory(App\BaptismSponsor::class)->make());
            });


        $response = $this->json('GET','/baptism',$this->params);

        $response->assertResponseStatus(200);

        $response->seeJson(['count' => 10]);

        $response->seeJsonStructure(['count','data']);

    }

    public function test_it_should_create_new_baptism()
    {

        $data = factory(App\Baptism::class)->make([
            'sponsors' => factory(App\BaptismSponsor::class,5)->make()->toArray()
        ])->toArray();

        $response = $this->post('/baptism',$data);

        $response->assertResponseStatus(201);

        $response->seeJsonEquals([
            'isCreated' => true
        ]);


    }


    public function test_it_should_update_baptism()
    {
        $data = factory(App\Baptism::class)->create();

        $updatedData = factory(App\Baptism::class)->make([
            'firstName' => 'Updated Name',
            'middleName' => 'Updated Middle Name'
        ])->toArray();


        $response = $this->put('/baptism/'.$data->id,$updatedData);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals([
            'isUpdated' => true
        ]);


    }


    public function test_it_should_validate_the_fields_and_return_422_error()
    {

        $data = factory(App\Baptism::class)->make([
           'firstName' => null
        ])->toArray();

        $create = $this->post('/baptism',$data);

        $create->assertResponseStatus(422);


        $update = $this->put('/baptism/1',$data);

        $update->assertResponseStatus(422);

    }


    public function test_it_should_failed_if_the_data_is_not_found_when_updating()
    {
        $data = factory(App\Baptism::class)->make()->toArray();

        $response = $this->put('/baptism/1',$data);

        $response->assertResponseStatus(404);

    }


    public function test_it_should_add_new_sponsor_for_baptism()
    {

        $baptism = factory(App\Baptism::class)->create();

        $sponsor = factory(App\BaptismSponsor::class)->make()->toArray();

        $response = $this->post('/baptism/sponsor/'.$baptism->id,$sponsor);

        $response->assertResponseStatus(201);

        $response->seeJsonEquals(['isCreated' => true]);

    }

    public function test_it_should_update_baptism_sponsor()
    {

        $sponsor = factory(App\BaptismSponsor::class)->create(['baptism_id' => 1]);

        $data = factory(App\BaptismSponsor::class)->make(['sponsor' => 'Updated Sponsor'])->toArray();

        $response = $this->put('/baptism/sponsor/'.$sponsor->id,$data);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals(['isUpdated' => true]);

    }

    public function test_it_should_delete_baptism_sponsor()
    {
        $sponsor = factory(App\BaptismSponsor::class)->create(['baptism_id' => 1]);

        $response = $this->post('/baptism/sponsor/remove/'.$sponsor->id);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals(['isDeleted' => true]);
    }

    public function test_it_should_return_404_if_baptism_sponsor_does_not_exists()
    {
        $baptism = factory(App\BaptismSponsor::class)->make()->toArray();

        //Creating
        $create = $this->post('/baptism/sponsor/2',$baptism);

        $create->assertResponseStatus(404);


        //Updating
        $update = $this->put('/baptism/sponsor/2',$baptism);

        $update->assertResponseStatus(404);

        //Deleting

        $delete = $this->post('/baptism/sponsor/2');

        $delete->assertResponseStatus(404);

    }


}
