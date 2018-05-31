<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Carbon\Carbon;

class SalesTest extends TestCase
{

    use DatabaseTransactions;


  public function test_it_should_get_sales_between_start_and_end_date()
  {
        factory(App\Sales::class,5)->create()
            ->each(function($s) {
                $s->products()->save(factory(App\SalesProduct::class)->make());
            });

        $startDate = Carbon::now()->toDateString();
        $endDate = Carbon::now()->addDay(3)->toDateString();
        $orderBy = 'asc';
        $params = compact('startDate','endDate','orderBy');

       $response = $this->json('GET','sales', $params);

       $response->seeJsonStructure(['data']);

  }

  public function test_it_should_create_the_sales()
  {
      $products = factory(App\SalesProduct::class,5)->make()->toArray();

      $sales = ['referenceNumber' => 231312312312, 'products' => $products];

      $response = $this->post('sales', $sales);

      $response->assertResponseStatus(201);

      $response->seeJsonEquals(['isCreated' => true]);

  }

  public function test_it_should_change_status()
  {
      $sales = factory(App\Sales::class)->create();

      $data = ['status' => 0];

      $response = $this->put('sales/'.$sales->id, $data);

      $response->assertResponseStatus(200);

      $response->seeJsonEquals(['isUpdated' => true]);

  }

  public function test_it_should_check_if_the_data_exists_before_updating()
  {
      $response = $this->put('sales/2', []);

      $response->assertResponseStatus(404);
  }

  public function test_it_should_validate_required_fields()
  {
      $data = ['referenceNumber' => null];

      $response = $this->post('sales', $data);

      $response->assertResponseStatus(422);
  }


}
