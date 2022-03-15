<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Type;
use Purchase;
use Order;
use DB;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function index()
    {
        // $log = DB::table('purchases')
        //         ->join('orders', 'orders.product_name', '=', 'purchases.product')
        //         ->select('orders.type', 'orders.order_date', 'orders.client_name', 'orders.product_name', 'orders.quantity', 'orders.rate', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'orders.paid_amount', 'orders.due_amount', 'purchases.type', 'purchases.date', 'purchases.product', 'purchases.stock', 'purchases.cost_price', 'purchases.supplier')
        //         ->get();
        
        // return view('logs.index')->with('log', $log); 
        
        //UNION OF TWO TABLES
        $first = DB::table('purchases')
                ->select('type', 'purchase_date', 'product', 'stock', 'cost_price', \DB::raw('0 as rate'), 'supplier', \DB::raw('0 as client_name'), 'total_cost',  \DB::raw('0 as discount'),  \DB::raw('0 as grand_total'), 'paid_amount', 'due_amount');
         
        $log = DB::table('orders')  
                ->join('bills', 'bills.id', '=', 'orders.bill_id')
                ->select('orders.type', 'orders.order_date', 'orders.product_name', 'orders.quantity',  \DB::raw('0 as cost_price'), 'orders.rate',  \DB::raw('0 as supplier'), 'orders.client_name', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'bills.paid_amount', 'bills.due_amount')
                ->union($first)
                ->orderBy('order_date', 'desc')
                ->get();
                // dd($log);

        return view('logs.index')->with('log', $log);
    }
} 
