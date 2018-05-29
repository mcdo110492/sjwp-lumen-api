<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
class MarriageTest extends TestCase
{
    use DatabaseTransactions;


    protected $params = ['page' => 1, 'limit' => 5, 'field' => 'book', 'filter' => '', 'order' => 'asc'];


    public function test_it_should_get_data_depending_with_specified_parameter()
    {
        $husband = factory(App\MarriageHusband::class)->create();

        $wife = factory(App\MarriageWife::class)->create();

        factory(App\Marriage::class)->create([
            'husband_id' => $husband->id,
            'wife_id' => $wife->id
        ])->each(function($s){
            $s->sponsors()->save(factory(App\MarriageSponsor::class)->make());
        });

        $response = $this->json('GET','/marriage',$this->params);

        $response->assertResponseStatus(200);

        $response->seeJson(['count' => 1]);


        $response->seeJsonStructure(['count','data']);

    }

    public function test_it_should_create_new_baptism()
    {

        $husband = factory(App\MarriageHusband::class)->make()->toArray();

        $wife = factory(App\MarriageWife::class)->make()->toArray();

        $marriage = factory(App\Marriage::class)->make()->toArray();

        $sponsors = factory(App\MarriageSponsor::class,3)->make()->toArray();

        $rawData = [
            'husband' => $husband,
            'wife' => $wife,
            'sponsors' => $sponsors
        ];

        $data = array_merge($rawData,$marriage);

        $response = $this->post('/marriage',$data);

        $response->assertResponseStatus(201);

        $response->seeJsonEquals([
            'isCreated' => true
        ]);


    }


    public function test_it_should_update_husband()
    {
        $data = factory(App\MarriageHusband::class)->create();

        $updatedData = factory(App\MarriageHusband::class)->make([
            'firstName' => 'Updated Name',
            'middleName' => 'Updated Middle Name'
        ])->toArray();


        $response = $this->put('/marriage/husband/'.$data->id,$updatedData);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals([
            'isUpdated' => true
        ]);

    }

    public function test_it_should_update_wife()
    {
        $data = factory(App\MarriageWife::class)->create();

        $updatedData = factory(App\MarriageWife::class)->make([
            'firstName' => 'Updated Name',
            'middleName' => 'Updated Middle Name'
        ])->toArray();


        $response = $this->put('/marriage/wife/'.$data->id,$updatedData);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals([
            'isUpdated' => true
        ]);

    }

    public function test_it_should_update_marriage()
    {
        $data = factory(App\Marriage::class)->create([
            'husband_id' => 1,
            'wife_id' => 1
        ]);

        $updatedData = factory(App\Marriage::class)->make([
            'book' => 1,
            'page' => 2,
            'entry' => 3
        ])->toArray();


        $response = $this->put('/marriage/'.$data->id,$updatedData);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals([
            'isUpdated' => true
        ]);

    }


    public function test_it_should_validate_the_fields_when_creating()
    {

        $husband = factory(App\MarriageHusband::class)->make()->toArray();

        $wife = factory(App\MarriageWife::class)->make()->toArray();

        $marriage = factory(App\Marriage::class)->make([
            'dateMarried' => null,
            'book' => null
        ])->toArray();

        $sponsors = factory(App\MarriageSponsor::class,3)->make()->toArray();

        $rawData = [
            'husband' => $husband,
            'wife' => $wife,
            'sponsors' => $sponsors
        ];

        $data = array_merge($rawData,$marriage);

        $create = $this->post('/marriage',$data);

        $create->assertResponseStatus(422);

    }

    public function test_it_should_validate_when_updating_husband()
    {
        $husband = factory(App\MarriageHusband::class)->create();

        $data = factory(App\MarriageHusband::class)->make(['firstName' => null])->toArray();

        $create = $this->put('/marriage/husband/'.$husband->id,$data);

        $create->assertResponseStatus(422);
    }

    public function test_it_should_validate_when_updating_wife()
    {
        $wife = factory(App\MarriageWife::class)->create();

        $data = factory(App\MarriageWife::class)->make(['firstName' => null])->toArray();

        $create = $this->put('/marriage/wife/'.$wife->id,$data);

        $create->assertResponseStatus(422);
    }


    public function test_it_should_validate_when_updating_marriage()
    {
        $marriage = factory(App\Marriage::class)->create([
            'husband_id' => 1,
            'wife_id' => 1
        ]);

        $data = factory(App\Marriage::class)->make(['book' => null])->toArray();

        $create = $this->put('/marriage/'.$marriage->id,$data);

        $create->assertResponseStatus(422);
    }


    public function test_it_should_add_new_sponsor()
    {

        $marriage = factory(App\Marriage::class)->create([
            'husband_id' => 1,
            'wife_id' => 1
        ]);

        $sponsor = factory(App\MarriageSponsor::class)->make()->toArray();

        $response = $this->post('/marriage/sponsor/'.$marriage->id,$sponsor);

        $response->assertResponseStatus(201);

        $response->seeJsonEquals(['isCreated' => true]);

    }

    public function test_it_should_update_sponsor()
    {

        $sponsor = factory(App\MarriageSponsor::class)->create(['marriage_id' => 1]);

        $data = factory(App\MarriageSponsor::class)->make(['sponsor' => 'Updated Sponsor'])->toArray();

        $response = $this->put('/marriage/sponsor/'.$sponsor->id,$data);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals(['isUpdated' => true]);

    }

    public function test_it_should_delete_sponsor()
    {
        $sponsor = factory(App\MarriageSponsor::class)->create(['marriage_id' => 1]);

        $response = $this->post('/marriage/sponsor/remove/'.$sponsor->id);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals(['isDeleted' => true]);
    }

    public function test_it_should_return_404_if_marriage_sponsor_does_not_exists()
    {
        $marriage = factory(App\MarriageSponsor::class)->make()->toArray();

        //Creating
        $create = $this->post('/marriage/sponsor/2',$marriage);

        $create->assertResponseStatus(404);


        //Updating
        $update = $this->put('/marriage/sponsor/2',$marriage);

        $update->assertResponseStatus(404);

        //Deleting

        $delete = $this->post('/marriage/sponsor/2');

        $delete->assertResponseStatus(404);

    }

    public function test_it_should_return_404_if_husband_does_not_exists()
    {

        $update = $this->put('marriage/husband/2',[]);

        $update->assertResponseStatus(404);

    }

    public function test_it_should_return_404_if_wife_does_not_exists()
    {

        $update = $this->put('marriage/wife/2',[]);

        $update->assertResponseStatus(404);

    }

    public function test_it_should_return_404_if_marriage_does_not_exists()
    {

        $update = $this->put('marriage/2',[]);

        $update->assertResponseStatus(404);

    }


}
