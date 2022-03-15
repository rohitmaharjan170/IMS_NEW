<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockLog;
use App\Product;
use App\Client;
use App\User;
use App\Type;

class StockLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock_logs = StockLog::all();
        return view('stock_logs.index')->with('stock_logs', $stock_logs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_list = Product::get()->pluck('name', 'id');
        $product_list = ['0' => 'Pick a Product..'] + collect($product_list)->toArray();
        $client_list = Client::get()->pluck('client_name', 'id');
        $client_list = ['0' => 'Pick a Client..'] + collect($client_list)->toArray();
        $type_list = Type::get()->pluck('type_name', 'id');
        $type_list = ['0' => 'Trasaction Type'] + collect($type_list)->toArray();
        return view('stock_logs.create')->with('product_list', $product_list)->with('client_list', $client_list)->with('type_list', $type_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [            
            'product' => 'required',
            'quantity' => 'required',
            'date' => 'required',
            'client' => 'nullable',
            'supplier' => 'nullable',
            'cost_price' => 'nullable',
            'rate' => 'nullable',
            'type' => 'required'
        ]);

        $product = Product::select('name')->where('id', $request->product)->first();
        $client = Client::select('client_name')->where('id', $request->client)->first();
        $type = Type::select('type_name')->where('id', $request->type)->first();

        $stock_logs = new StockLog;
        $stock_logs->product = $product->name;
        $stock_logs->client = $client->client_name;
        $stock_logs->date = $request->input('date');
        $stock_logs->quantity = $request->input('quantity');
        $stock_logs->supplier = $request->input('supplier');
        $stock_logs->cost_price = $request->input('cost_price');
        $stock_logs->rate = $request->input('rate');
        $stock_logs->type = $type->type_name;
        $stock_logs->user_id = auth()->user()->id;

        $stock_logs->save();
        return redirect('/stock_logs')->with('success', 'Log Added!!');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
