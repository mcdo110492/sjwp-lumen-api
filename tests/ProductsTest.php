<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ProductsTest extends TestCase
{

    use DatabaseTransactions;


    public function test_it_should_get_data()
    {
        factory(App\Products::class,5)->create();

        $params = ['page' => 1, 'limit' => 5, 'field' => 'description', 'filter' => '', 'order' => 'asc', 'category_id' => 0];

        $response = $this->json('GET','products',$params);

        $response->assertResponseStatus(200);

        $response->seeJson(['count' => 5]);

        $response->seeJsonStructure(['count','data']);
    }

    public function test_it_should_create_data()
    {
        $data = factory(App\Products::class)->make(['code' => null])->toArray();

        $response = $this->post('products',$data);

        $response->assertResponseStatus(201);

        $response->seeJsonEquals(['isCreated' => true]);

    }

    public function test_it_should_validate()
    {
        $data = ['description' => 'Sample Data', 'price' => 'hello world'];

        $response = $this->post('products',$data);

        $response->assertResponseStatus(422);

    }

    public function test_it_should_update()
    {
        $create = factory(App\Products::class)->create();

        $data = factory(App\Products::class)->make(['description' => 'Updated Data'])->toArray();

        $response = $this->put('products/'.$create->id, $data);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals(['isUpdated' => true]);

    }

    public function test_it_should_validate_if_the_data_exists_when_updating()
    {

        $response = $this->put('products/22',[]);

        $response->assertResponseStatus(404);
    }


}
