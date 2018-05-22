<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ProductCategoriesTest extends TestCase
{

    use DatabaseTransactions;


    public function testPostStore()
    {

        $data = ['name' => 'Confirmation'];

        $response = $this->json('POST','/product/category',$data);

        $response->assertResponseStatus(201);

        $response->seeJsonEquals(['isCreated' => true]);
    }


}
