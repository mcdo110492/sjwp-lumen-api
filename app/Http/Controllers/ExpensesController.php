<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Expenses;
use App\ExpenseDetails;

class ExpensesController extends Controller
{
    /**
     * The expenses reqpository instance
     */
    protected  $expenses;

    /**
     * The expense details instance
     */
    protected $details;

    /**
     * The request repository instance
     */
    protected  $requests;

    /**
     * Controller constructor.
     *
     * @param Expenses $expenses
     * @param ExpenseDetails $details
     * @param Request $requests
     */
    public function __construct(Expenses $expenses, ExpenseDetails $details, Request $requests)
    {
        $this->expenses = $expenses;

        $this->details = $details;

        $this->requests = $requests;
    }

    /**
     * Get all the number of data and the data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $startDate = $this->requests->input('startDate');

        $endDate = $this->requests->input('endDate');

        $orderBy = strtoupper($this->requests->input('orderBy'));

        $get = $this->expenses->with('details.categories')
            ->whereBetween('dateIssued',[$startDate, $endDate])
            ->orderBy('dateIssued', $orderBy)
            ->get();

        $response = ['data' => $get];

        return response()->json($response,200);
    }

    /**
     * Store the  data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $this->validate($this->requests, [
            'referenceNumber' => 'required|numeric|unique:expenses,refNumber',
            'details.*.category_id' => 'required|integer',
            'details.*.amount' => 'required|numeric',
        ]);

        DB::transaction(function() {

            $now = Carbon::now()->toDateString();

            $expensesData = ['refNumber' => $this->requests->input('referenceNumber'), 'dateIssued' => $now];

            $expensesCreate = $this->expenses->create($expensesData);

            foreach($this->requests->input('details') as $category)
            {
                $expenseDetails = ['category_id' => $category['category_id'], 'price' => $category['amount'], 'sales_id' => $expensesCreate->id];

                $this->details->create($expenseDetails);
            }

        });

        return response()->json(['isCreated' => true],201);
    }

    /**
     * Update the  status of the expenses
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $expenses = $this->expenses->findOrFail($id);

        $this->validate($this->requests, [
            'status' => 'required|integer',
            'remarks' => 'max:150'
        ]);

        $data = ['status' => $this->requests->input('status'), 'remarks' => $this->requests->input('remarks')];

        $expenses->update($data);

        return response()->json(['isUpdated' => true]);
    }
}
