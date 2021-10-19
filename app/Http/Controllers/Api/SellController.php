<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sell;
use App\Models\Customer;
use App\Models\Product;
use App\Http\Resources\SellResource;

class SellController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SellResource::collection(Sell::orderBy('id','DESC')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer_id = NULL;
        if (!$request->customer['customer_id']) {
            $customer = Customer::where([
                'name' => $request->customer['customer_name'],
                'address' => $request->customer['address'],
                'phone' =>  $request->customer['phone']
            ])->first();

            if(empty($customer)) {
                $customer = new Customer;
                $customer->name = $request->customer['customer_name'];
                $customer->address = $request->customer['address'];
                $customer->phone = $request->customer['phone'];
                $customer->save();
                $customer_id = $customer->id;
            } else {
                $customer_id = $customer->id;
            }
        } else {
            $customer_id = $request->customer['customer_id'];
        }
       

        $sell = new Sell;
        $sell->customer_id = $customer_id;
        $products = [];

        foreach($request->products as $product) {
            $item['id'] = $product['id'];
            $item['name'] = $product['product_name'];
            $item['quantity'] = $product['quantity'];
            $item['price'] = $product['unit'];
            $item['buying_price'] = $product['buying_price'];

            array_push($products, $item);
            $prod = Product::findOrFail($product['id']);
            $prod->product_quantity = $prod->product_quantity - $product['quantity'];
            $prod->update();
        }

        $payments = [
            'sub_total' => $request->calculation['sub_total'],
            'total_quantity' => $request->calculation['total_quantity'],
            'vat' => $request->calculation['vat'],
            'total' => $request->calculation['total'],
            'pay' => $request->customer['pay'],
            'back' => $request->customer['pay']-$request->calculation['total'],
        ];

        $sell->products = json_encode($products);
        $sell->payments = json_encode($payments);
        return $sell->save();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sell $sell)
    {
        return new SellResource($sell);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sell $sell)
    {
        return $sell->delete();
    }
}
