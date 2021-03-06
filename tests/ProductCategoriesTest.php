<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ProductCategoriesTest extends TestCase
{

    use DatabaseTransactions;


    public function test_it_should_get_data()
    {
        factory(App\ProductCategories::class,10)->create();

        $params = ['page' => 1, 'limit' => 5, 'field' => 'name', 'filter' => '', 'order' => 'asc', 'parent_id' => 0];

        $response = $this->json('GET','product/category',$params);

        $response->assertResponseStatus(200);

        $response->seeJson(['count' => 10]);

        $response->seeJsonStructure(['count','data']);
    }

    public function test_it_should_create_data()
    {
        $data = factory(App\ProductCategories::class)->make()->toArray();

        $response = $this->post('product/category',$data);

        $response->assertResponseStatus(201);

        $response->seeJsonEquals(['isCreated' => true]);

    }

    public function test_it_should_validate()
    {
        $data = ['name' => null];

        $response = $this->post('product/category',$data);

        $response->assertResponseStatus(422);
    }

    public function test_it_should_update()
    {
        $create = factory(App\ProductCategories::class)->create();

        $data = factory(App\ProductCategories::class)->make(['name' => 'Updated Data'])->toArray();

        $response = $this->put('product/category/'.$create->id, $data);

        $response->assertResponseStatus(200);

        $response->seeJsonEquals(['isUpdated' => true]);

    }

    public function test_it_should_validate_if_the_data_exists_when_updating()
    {

        $response = $this->put('product/category/22',[]);

        $response->assertResponseStatus(404);
    }

    public function test_it_should_validate_unique_name()
    {
        $create = factory(App\ProductCategories::class)->create();

        $data = factory(App\ProductCategories::class)->make(['name' => $create->name])->toArray();

        $response = $this->post('product/category',$data);

        $response->assertResponseStatus(422);

    }


}
