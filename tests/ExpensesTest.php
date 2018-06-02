<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Carbon\Carbon;

class ExpensesTest extends TestCase
{

    use DatabaseTransactions;


  public function test_it_should_get_sales_between_start_and_end_date()
  {
        factory(App\Expenses::class,5)->create()
            ->each(function($s) {
                $s->details()->save(factory(App\ExpenseDetails::class)->make());
            });

        $startDate = Carbon::now()->toDateString();
        $endDate = Carbon::now()->addDay(3)->toDateString();
        $orderBy = 'asc';
        $params = compact('startDate','endDate','orderBy');

       $response = $this->json('GET','expenses', $params);

       $response->seeJsonStructure(['data']);
  }

  public function test_it_should_create_the_expenses()
  {
      $details = factory(App\ExpenseDetails::class,5)->make()->toArray();

      $expenses = ['referenceNumber' => 231312312312, 'details' => $details];

      $response = $this->post('expenses', $expenses);

      $response->assertResponseStatus(201);

      $response->seeJsonEquals(['isCreated' => true]);

  }

  public function test_it_should_change_status()
  {
      $expenses = factory(App\Expenses::class)->create();

      $data = ['status' => 0];

      $response = $this->put('expenses/'.$expenses->id, $data);

      $response->assertResponseStatus(200);

      $response->seeJsonEquals(['isUpdated' => true]);

  }

  public function test_it_should_check_if_the_data_exists_before_updating()
  {
      $response = $this->put('expenses/2', []);

      $response->assertResponseStatus(404);
  }

  public function test_it_should_validate_required_fields()
  {
      $data = ['referenceNumber' => ''];

      $response = $this->post('expenses', $data);

      $response->assertResponseStatus(422);
  }


}
