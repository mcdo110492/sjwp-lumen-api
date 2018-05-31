<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Sales;
use App\SalesProduct;

class SalesController extends Controller
{
    /**
     * The sales reqpository instance
     */
    protected  $sales;

    /**
     * The sales products instance
     */
    protected $products;

    /**
     * The request repository instance
     */
    protected  $requests;

    /**
     * SalesController constructor.
     *
     * @param Sales $sales
     * @param SalesProduct $products
     * @param Request $requests
     */
    public function __construct(Sales $sales, SalesProduct $products, Request $requests)
    {
        $this->sales = $sales;

        $this->products = $products;

        $this->requests = $requests;
    }

    /**
     * Get all the number of data and the data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $startDate = $this->requests['startDate'];

        $endDate = $this->requests['endDate'];

        $orderBy = strtoupper($this->requests['orderBy']);

        $get = $this->sales->with('products.product')
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
           'referenceNumber' => 'required|numeric',
           'products.*.product_id' => 'required|integer',
           'products.*.price' => 'required|numeric',
           'products.*.quantity' => 'required|numeric'
        ]);

        DB::transaction(function() {

            $now = Carbon::now()->toDateString();

            $salesData = ['refNumber' => $this->requests['referenceNumber'], 'dateIssued' => $now];

            $salesCreate = $this->sales->create($salesData);

            foreach($this->requests['products'] as $product)
            {
                $productData = ['product_id' => $product['product_id'], 'price' => $product['price'], 'quantity' => $product['quantity'], 'sales_id' => $salesCreate->id];

                $this->products->create($productData);
            }

        });

        return response()->json(['isCreated' => true],201);
    }

    /**
     * Update the  status of the sales
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $sales = $this->sales->findOrFail($id);

        $this->validate($this->requests, [
           'status' => 'required|integer'
        ]);

        $data = ['status' => $this->requests['status']];

        $sales->update($data);

        return response()->json(['isUpdated' => true]);
    }
}
