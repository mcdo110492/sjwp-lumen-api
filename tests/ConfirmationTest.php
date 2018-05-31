<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ConfirmationTest extends TestCase
{
    use DatabaseTransactions;


    protected $params = ['page' => 1, 'limit' => 5, 'field' => 'firstName', 'filter' => '', 'order' => 'asc'];


    public function test_it_should_get_data_depending_with_specified_parameter()
    {

         factory(App\Confirmation::class,10)
            ->create()
            ->each(function ($s) {
                $s->sponsors()->save(factory(App\ConfirmationSponsor::class)->make());
            });


        $response = $this->json('GET','/confirmation',$this->params);

        $response->assertResponseStatus(200);

        $response->seeJson(['count' => 10]);

        $response->seeJsonStructure(['count','data']);

    }

    public function test_it_should_create_new_confirmation()
    {

        $data = factory(App\Confirmation::class)->make([
            'sponsors' => factory(App\ConfirmationSponsor::class,5)->make()->toArray()
        ])->toArray();


        $response = $this->post('/confirmation',$data);


        $response->assertResponseStatus(201);

        $response->seeJsonEquals([
            'isCreated' => true
        ]);


    }


    public function test_it_should_update_confirmation()
    {
        $data = factory(App\Confirmation::class)->create();

        $updatedData = factory(App\Confirmation::class)->make([
            'firstName' => 'Updated Name',
            'middleName' => 'Updated Middle Name'
        ])->toArray();


        $response = $this->put('/confirmation/'.$data->id,$updatedData);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals([
            'isUpdated' => true
        ]);


    }


    public function test_it_should_validate_the_fields_and_return_422_error()
    {

        $data = factory(App\Confirmation::class)->make([
            'firstName' => null
        ])->toArray();

        $create = $this->post('/confirmation',$data);

        $create->assertResponseStatus(422);


        $update = $this->put('/confirmation/1',$data);

        $update->assertResponseStatus(422);

    }


    public function test_it_should_failed_if_the_data_is_not_found_when_updating()
    {
        $data = factory(App\Confirmation::class)->make()->toArray();

        $response = $this->put('/confirmation/1',$data);

        $response->assertResponseStatus(404);

    }


    public function test_it_should_add_new_sponsor_for_confirmation()
    {

        $confirmation = factory(App\Confirmation::class)->create();

        $sponsor = factory(App\ConfirmationSponsor::class)->make()->toArray();

        $response = $this->post('/confirmation/sponsor/'.$confirmation->id,$sponsor);

        $response->assertResponseStatus(201);

        $response->seeJsonEquals(['isCreated' => true]);

    }

    public function test_it_should_update_confirmation_sponsor()
    {

        $sponsor = factory(App\ConfirmationSponsor::class)->create(['confirmation_id' => 1]);

        $data = factory(App\ConfirmationSponsor::class)->make(['sponsor' => 'Updated Sponsor'])->toArray();

        $response = $this->put('/confirmation/sponsor/'.$sponsor->id,$data);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals(['isUpdated' => true]);

    }

    public function test_it_should_delete_confirmation_sponsor()
    {
        $sponsor = factory(App\ConfirmationSponsor::class)->create(['confirmation_id' => 1]);

        $response = $this->post('/confirmation/sponsor/remove/'.$sponsor->id);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals(['isDeleted' => true]);
    }

    public function test_it_should_return_404_if_confirmation_sponsor_does_not_exists()
    {
        $confirmation = factory(App\ConfirmationSponsor::class)->make()->toArray();

        //Creating
        $create = $this->post('/confirmation/sponsor/2',$confirmation);

        $create->assertResponseStatus(404);


        //Updating
        $update = $this->put('/confirmation/sponsor/2',$confirmation);

        $update->assertResponseStatus(404);

        //Deleting

        $delete = $this->post('/confirmation/sponsor/2');

        $delete->assertResponseStatus(404);

    }


}
