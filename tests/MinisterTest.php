<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MinisterTest extends TestCase
{

    use DatabaseTransactions;

    protected $params = ['page' => 1, 'limit' => 5, 'field' => 'name', 'filter' => '', 'order' => 'asc'];

    public function testGetRequest()
    {


        $response = $this->call('GET','/ministers',$this->params);

        $this->assertEquals(200,$response->status());

        $ministers = factory('App\Ministers')->create();

        $this->json('GET','/ministers',$this->params)
            ->seeJsonEquals(['count' => 1, 'data' => [$ministers]]);

    }

    public function testPostStore()
    {

        $data1 = factory('App\Ministers')->make()->toArray();

        $response = $this->call('POST','/ministers',$data1);

        $this->assertEquals(200,$response->status());

        $data2 = factory('App\Ministers')->make([
            'name' => 'Fr. Donato Ofelia'
        ])->toArray();

        $this->post('/ministers',$data2)
            ->seeJsonEquals([
                'isCreated' => true ]);

    }

    public function testPutStore()
    {

        factory('App\Ministers')->create();

        $updatedData = factory('App\Ministers')->make([
            'name' => 'Fr. Donato Ofelia',
            'active' => 1
        ])->toArray();

        $response = $this->call('PUT','/ministers/1',$updatedData);

        $this->assertEquals(200,$response->status());



        $this->put('/ministers/1',$updatedData)
            ->seeJsonEquals([
                'isUpdated' => true ]);

    }
}
