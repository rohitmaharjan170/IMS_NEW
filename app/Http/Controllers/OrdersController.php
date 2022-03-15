<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Client;
use App\Product;
use App\Type;
use App\Bill;
use App\Payment;
use App\User;
use App\Rate;
use App\Setting;
use DB;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $orders = Order::orderBy('bill_id', 'desc')->paginate(5);

        //THIS WILL JOIN ORDERS TABLE AND PAID AMOUNT AND DUE AMOUNT FROM BILLS TABLE
        $orders = DB::table('orders')
                ->join('bills', 'bills.id', '=', 'orders.bill_id')
                ->select('orders.id', 'orders.type', 'orders.bill_id', 'orders.order_date', 'orders.client_name', 'orders.product_name', 'orders.quantity', 'orders.rate', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'orders.user_id', 'bills.paid_amount', 'bills.due_amount')
                ->orderBy('bill_id', 'desc')
                ->paginate(5);

        return view('orders.index')->with('orders', $orders);
        //     $select = $request->get('select');
    }

    // public function fetch(Request $request)
    // {
    //     $value = $request->get('value');
    //     $dependent = $request->get('dependent');
    //     $data = DB::table('product_quantity_rate')->where($select, $value)->groupBy($dependent)->get();
    //     $output = '<option value="">Seclect '.ucfirst($dependent).'</option>';
    //     foreach($data as $row)
    //     {
    //         $output .= '<option value="'.$row->dependent.'">'.$row->$dependent.'</option>';
    //     }
    //     echo $output;
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //buliding dropdown list
        //$client_list = \DB::table('clients')->pluck('client_name', 'id');
        //$client_list = ['0' => 'Pick a Client..'] + collect($client_list)->toArray();

        // $product_list = \DB::table('products')->pluck('name', 'id');
        // $product_list = ['0' => 'Choose Product..'] + collect($product_list)->toArray();

        // return view('orders.create')->with('client_list', $client_list); // ->with('product_list', $product_list);

        $rate_list = Rate::select('product_id', 'client_id', 'client_rate')->get();

        $client_list = Client::get()->pluck('client_name', 'id');
        // $client_list = Client::select('client_name', 'id')->get();
        $client_list = ['0' => 'Pick a Client..'] + collect($client_list)->toArray();

        $product_list = Product::get()->pluck('name', 'id', 'quantity');
        $product_list = ['0' => 'Pick a Product..'] + collect($product_list)->toArray();

        $type_list = Type::get()->pluck('type_name', 'id');
        $type_list = ['2' => 'Sale'] + collect($type_list)->toArray();

        // $max_qty = Product::get()->pluck('name', 'quantity');

        // $max_qty = Product::select('quantity', 'id')->first();
        // $max_qty = collect($max_qty)->toArray();
        // $max_qty = Product::select('quantity', 'id')->where('id',$request->id)->first();
        // $max_qty = $max_qty->quantity;
        // $max_qty = DB::table('products')->select('*')->where('id','=',$sale_quantity)->max('quantity');
        // dd($max_qty);   


        // $rate_list = Product::get()->pluck('rate', 'id');
        // $rate_list = ['0'=> '0'] + collect($rate_list)->toArray();

        // $rate = Product::get('rate', 'name');
        // $rate = Product::where('rate', $product_list->rate);


        // return view('orders.create', $client_list);

        // $bill_id_number = Bill::first()->pluck('id');
        // $bill_id_number++;


        // $bill_id_number = DB::table('bills')->where('id', $bill_id)->pluck('id');
        // dd($rate_list);
        return view('orders.create')->with('client_list', $client_list)->with('product_list', $product_list)->with('type_list', $type_list)->with('rate_list', $rate_list);
    }

    public function findRate(Request $request){

		//it will get price if its id match with product id
        // $rate = Product::select('rate')->where('id',$request->id)->first();
        $rate = Rate::select('client_rate')->where('client_id', $request->client_id)->where('product_id', $request->id)->first(); //we need to select client_id and product_id to get rate so we have two where condition and 'client_id' and 'product_id' is the column name in rate table whereas client_id and id of $request is from the jquery code written in view which is variable and have same name
		// dd($rate);
    	return $rate->client_rate;
    }

    public function findQuantity(Request $request){

		//it will get price if its id match with product id
		$sale_quantity = Product::select('quantity')->where('id',$request->id)->first(); //first picks only one item whereas get() picks array of item

    	return $sale_quantity->quantity;
    }

    function fetch(Request $request)
    {
     $select = $request->get('select');
     $value = $request->get('value');
     $dependent = $request->get('dependent');
     $data = DB::table('orders')
       ->where($select, $value)
       ->groupBy($dependent)
       ->get();
     $output = '<option value="">Select '.ucfirst($dependent).'</option>';
     foreach($data as $row)
     {
      $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
     }
     echo $output;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $prod = Product::where('name', $request->product_name)->firstOrFail();
        // $qty = $prod->quantity;
        
        $this->validate($request, [
            'type' => 'required',
            'order_date' => 'required',
            // 'client_id' => 'required',
            'client_name' => 'required',
            // 'product_id' => 'required',
            'product_name' => 'required',
            // 'sale_quantity' => 'required|numeric|min:1|max:$max_qty',
            // 'sale_quantity' => 'required|numeric|min:1|max:\'.$product_list[\'quantity\']',
            'rate' => 'required',
            'sub_amount' => 'required',
            'discount' => 'required',
            'grand_total' => 'required',
            'paid_amount' => 'required',
            'due_amount' => 'required'
        ]);

        $client = Client::select('id','client_name')->where('id', $request->client_name)->first();
        $type = Type::select('id', 'type_name')->where('id', $request->type)->first();

        //FOR BILL TABLE
        $bill = new Bill;
        // $bill->bill_number = $request->input('bill_number');
        $bill->client_id = $client->id;
        $bill->bill_date = $request->order_date;
        $bill->discount = $request->discount;
        $bill->grand_total = $request->grand_total;
        $bill->paid_amount = $request->input('paid_amount');
        $bill->due_amount = $request->input('due_amount');
        // dd($bill);
        $bill->user_id = auth()->user()->id;
        $bill->save();

        //FOR PAYMENT TABLE
        $payment = new Payment;
        $payment->payment_date = $request->order_date;
        $payment->bill_id = $bill->id;
        $payment->paid_amount = $request->paid_amount;
        $payment->prev_due_amount = $request->due_amount;
        $payment->user_id = auth()->user()->id;
        // dd($payment);
        $payment->save();

        //FOR ORDER TABLE
        $data =[];
        // dd($request);
        foreach($request->product_name as $item=>$v){
            $product = Product::select('id', 'rate', 'name', 'quantity')->where('id',$request->product_name[$item])->first();
            $data[]=array(
                'type' => $type->type_name,
                'type_id' => $type->id,
                'order_date'=> $request->input('order_date'),
                'client_name' => $client->client_name,
                'client_id' => $client->id,
                'product_name' => $product->name,
                'product_id' => $product->id,
                'quantity' => $request->input('sale_quantity')[$item],
                'rate' => $request->input('rate')[$item],
                'sub_amount' => $request->input('sub_amount')[$item],
                'discount' => $request->input('discount'),
                'grand_total' => $request->input('grand_total'),
                // 'paid_amount' => $request->input('paid_amount'),
                // 'due_amount' => $request->input('due_amount'),
                'created_at' => date('Y-m-d H:i:s'),

                'user_id' => auth()->user()->id,
                'bill_id' => $bill->id
            );
            DB::table('products')->where('name', $product->name)->decrement('quantity', $request->input('sale_quantity')[$item]);
        }
        // dd($data);
        Order::insert($data);


        // $order->product_name = $request->get('product_name');
        // $product->product_name = $request->get('id');

        //Unused 2019/11/19 1.40pm
        // $order->discount = $request->input('discount');
        // $order->grand_total = $request->input('grand_total');
        // $order->paid_amount = $request->input('paid_amount');
        // $order->due_amount = $request->input('due_amount');

        // $order->user_id = auth()->user()->id;
        // $order->save();


        // dd($bill);
        return redirect('/orders')->with('success', 'Order Added!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('orders.show')->with('order', $order);
    }

    public function orderDate($order_date)
    {
        $oDate = Order::where('order_date', $order_date)->first();
        // $orderDate = Order::where('order_date', $order_date)->get();
        $orderDate = DB::table('orders')
                    ->where('order_date', $order_date) //mathy ko where condition
                    ->join('bills', 'bills.id', '=', 'orders.bill_id')
                    ->select('orders.id', 'orders.type', 'orders.bill_id', 'orders.order_date', 'orders.client_name', 'orders.product_name', 'orders.quantity', 'orders.rate', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'orders.user_id', 'bills.paid_amount', 'bills.due_amount')
                    ->orderBy('bill_id', 'desc')
                    ->get();
        return view('orders.orderDate')->with('orders', $orderDate)->with('order', $oDate);
    }

    public function clientOrder($client_name)
    {
        // $clientOrder = Order::where('client_name', $client_name)->get();
        $clientOrder = DB::table('orders')
                    ->where('client_name', $client_name) //mathy ko where condition
                    ->join('bills', 'bills.id', '=', 'orders.bill_id')
                    ->select('orders.id', 'orders.type', 'orders.bill_id', 'orders.order_date', 'orders.client_name', 'orders.product_name', 'orders.quantity', 'orders.rate', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'orders.user_id', 'bills.paid_amount', 'bills.due_amount')
                    ->orderBy('bill_id', 'desc')
                    ->get();
        $cName = Order::where('client_name', $client_name)->first(); //get client name at top(title)

        return view('orders.show')->with('orders', $clientOrder)->with('order', $cName);
    }

    public function productOrder($product_name)
    {
        $pName = Order::where('product_name', $product_name)->first();
        // $productOrder = Order::where('product_name', $product_name)->get();
        $productOrder = DB::table('orders')
                    ->where('product_name', $product_name) //mathy ko where condition
                    ->join('bills', 'bills.id', '=', 'orders.bill_id')
                    ->select('orders.id', 'orders.type', 'orders.bill_id', 'orders.order_date', 'orders.client_name', 'orders.product_name', 'orders.quantity', 'orders.rate', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'orders.user_id', 'bills.paid_amount', 'bills.due_amount')
                    ->orderBy('bill_id', 'desc')
                    ->get();
        return view('orders.productOrder')->with('orders', $productOrder)->with('order', $pName);
    }

    public function billOrder($bill_id)
    {
        $billOrder = Order::where('bill_id', $bill_id)->first();
        $plist = DB::table('orders')
                    ->where('bill_id', $bill_id) //mathy ko where condition
                    ->join('bills', 'bills.id', '=', 'orders.bill_id')
                    ->select('orders.id', 'orders.type', 'orders.bill_id', 'orders.order_date', 'orders.client_name', 'orders.product_name', 'orders.quantity', 'orders.rate', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'orders.user_id', 'bills.paid_amount', 'bills.due_amount')
                    ->orderBy('bill_id', 'desc')
                    ->get();
        // $plist = Order::where('bill_id', $bill_id)->get();
        $vendor = Setting::select('vendor_name', 'address')->first();
        // dd($vendor);

        return view('orders.billOrder')->with('order', $billOrder)->with('orders', $plist)->with('vendor', $vendor);
    }


    public function due()
    {
        $orders = DB::table('orders')
                ->join('bills', 'bills.id', '=', 'orders.bill_id')
                ->select('orders.id', 'orders.type', 'orders.bill_id', 'orders.order_date', 'orders.client_name', 'orders.product_name', 'orders.quantity', 'orders.rate', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'orders.user_id', 'bills.paid_amount', 'bills.due_amount')
                ->where('due_amount', '>=', '1')
                ->orderBy('bill_id', 'desc')
                ->paginate(5);

        return view('orders.due')->with('orders', $orders);

    }

    //show payment table
    public function payUp()
    {
        // $bills = Bill::all();

        // $payments = Payment::all();
        // $client = Client::get()->pluck('client_name', 'id');
        // dd($client_name);

        $payments = DB::table('payments')
                // ->join('orders', 'orders.bill_id', '=', 'payments.bill_id')
                ->join('bills', 'bills.id', '=', 'payments.bill_id')
                ->join('clients', 'clients.id', '=', 'bills.client_id')
                // ->select('orders.id', 'orders.type', 'orders.bill_id', 'orders.order_date', 'orders.client_name', 'orders.product_name', 'orders.quantity', 'orders.rate', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'orders.user_id', 'payments.payment_date', 'payments.paid_amount')
                ->select('payments.payment_date', 'payments.bill_id', 'payments.paid_amount', 'payments.prev_due_amount', 'payments.user_id', 'bills.bill_date', 'clients.client_name', 'bills.discount', 'bills.grand_total', 'bills.due_amount')
                ->orderBy('payment_date', 'desc')
                ->paginate(10);
        // dd($payments);
        // return View::make('orders.payUp', compact('bills', 'clients'))->with('payments', $payments);

        return view('orders.payUp')->with('payments', $payments);
    }

    //show payment on a specific date
    public function payDate($payment_date)
    {
        $pDate = Payment::where('payment_date', $payment_date)->first();
        // $orderDate = Order::where('order_date', $order_date)->get();
        $payDate = DB::table('payments')
                    ->where('payment_date', $payment_date) //mathy ko where condition
                    ->join('bills', 'bills.id', '=', 'payments.bill_id')
                    ->join('clients', 'clients.id', '=', 'bills.client_id')
                    ->select('payments.payment_date', 'payments.bill_id', 'payments.paid_amount', 'payments.prev_due_amount', 'bills.bill_date', 'clients.client_name', 'bills.discount', 'bills.grand_total', 'bills.due_amount')
                    ->orderBy('bill_id', 'desc')
                    ->paginate(10);
        return view('orders.payDate')->with('payments', $payDate)->with('payment', $pDate);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($bill_id)
    {
        // $order = Order::where('bill_id',$bill_id)->get();

        $order = DB::table('orders')
                ->where('bill_id',$bill_id)
                ->join('bills', 'bills.id', '=', 'orders.bill_id')
                ->select('orders.id','orders.type_id', 'orders.type', 'orders.bill_id', 'orders.order_date', 'orders.client_id', 'orders.client_name', 'orders.product_id', 'orders.product_name', 'orders.quantity', 'orders.rate', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'orders.user_id', 'bills.paid_amount', 'bills.due_amount')
                // ->orderBy('bill_id', 'desc')
                ->get();
        // print_r($order);
        // dd("here");
        $type_list = Type::get()->pluck('type_name', 'id');

        $product_list = Product::get()->pluck('name', 'id');

        $client_list = Client::get()->pluck('client_name', 'id');
        // $client_list = Client::select('id', 'client_name')->get();


        return view('orders.edit')->with('order', $order)->with('type_list', $type_list)->with('product_list', $product_list)->with('client_list', $client_list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bill_id)
    {
        $this->validate($request, [
            'type' => 'required',
            'order_date' => 'required',
            'client_name' => 'required',
            'product_name' => 'required',
            // 'sale_quantity' => 'required',
            'rate' => 'required',
            'sub_amount' => 'required',
            'discount' => 'required',
            'grand_total' => 'required',
            'paid_amount' => 'required',
            'due_amount' => 'required'
        ]);

        $client = Client::select('id','client_name')->where('id', $request->client_name)->first();
        $type = Type::select('id', 'type_name')->where('id', $request->type)->first();
        // dd($request);

        //FOR BILL TABLE
        $bill = Bill::find($bill_id);
        // $bill->bill_number = $request->input('bill_number');
        $bill->client_id = $client->id;
        $bill->bill_date = $request->order_date;
        $bill->discount = $request->discount;
        $bill->grand_total = $request->grand_total;
        $bill->paid_amount = $request->input('paid_amount');
        $bill->due_amount = $request->input('due_amount');
        $bill->save();

        $data =[];
        foreach($request->product_name as $item=>$v){
            $product = Product::select('id', 'rate', 'name', 'quantity')->where('id',$request->product_name[$item])->first();
            // dd($product);
            if($request->order_id[$item] > 0)
            {
            $data=array(
                'type' => $type->type_name,
                'type_id' => $type->id,
                'order_date'=> $request->input('order_date'),
                'client_id'=> $client->id,
                'client_name' => $client->client_name,
                'product_id' => $product->id,
                'product_name' => $product->name,
                // 'quantity' => $request->input('sale_quantity')[$item],
                'rate' => $request->input('rate')[$item],
                'sub_amount' => $request->input('sub_amount')[$item],
                'discount' => $request->input('discount'),
                'grand_total' => $request->input('grand_total'),
                // 'paid_amount' => $request->input('paid_amount'),
                // 'due_amount' => $request->input('due_amount'),
                'updated_at' => date('Y-m-d H:i:s'),
                'user_id' => auth()->user()->id,
                // 'bill_id' => $bill->id
            );
            Order::where('id', $request->order_id[$item])->update($data);
        }
        else{
            // naya product edit garda thapyo vane yesto garni
            $data=array(
                'type' => $type->type_name,
                'type_id' => $type->id,
                'order_date'=> $request->input('order_date'),
                'client_id'=> $client->id,
                'client_name' => $client->client_name,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $request->input('sale_quantity')[$item],
                'rate' => $request->input('rate')[$item],
                'sub_amount' => $request->input('sub_amount')[$item],
                'discount' => $request->input('discount'),
                'grand_total' => $request->input('grand_total'),
                // 'paid_amount' => $request->input('paid_amount'),
                // 'due_amount' => $request->input('due_amount'),

                'user_id' => auth()->user()->id,
                // 'bill_id' => $request->bill_number
                'bill_id' => $bill->id //bill_number remove gareko le yo line thapiyo

            );

            Order::insert($data);
        }
            // DB::table('products')->where('name', $product->name)->decrement('quantity', $request->input('sale_quantity')[$item]);
            // $quantity = Product::where('quantity', $product->quantity)->first();
            // if($quantity){
            //     $quantity->old_order = $quantity->getOriginal('quantity');
            //     $quantity->order = $new_order;

            // }
        }
        // dd($data);

        // Order::insert($data);


        return redirect('/orders')->with('success', 'Order Updated!!');
    }


    //BELOW CODE WAS FOR EDITING PAYMENT.. LATER PAYMENT TABLE WAS MADE
    public function payment($bill_id)
    {
        //edit payment
        $order = Order::where('bill_id',$bill_id)->get();
        $bill = Bill::find($bill_id);


        // print_r($payment);
        // dd("here");

        // >>CHECK FOR CORRECT USER<<
        // if(auth()->user()->id !== $payment->user_id){
        //     return redirect('/orders')->with('error', 'Unauthorized Page');
        // }

        return view('orders.payment')->with('order', $order)->with('bill', $bill);

    }

    public function addPayment(Request $request, $bill_id){
        //store payment
        $this->validate($request, [
            // 'due_amount' => 'required',
            'paid_amount' => 'required',
        ]);


        $bill = Bill::find($bill_id);
        $bill->paid_amount = $bill->paid_amount + $request->paid_amount;
        $bill->due_amount = $bill->due_amount - $request->paid_amount;
        $bill->save();

        $b_id = Order::select('bill_id')->where('bill_id', $request->bill_id)->first();

        $payment = new Payment();
        $payment->payment_date = $request->input('payment_date');
        $payment->bill_id = $b_id->bill_id;
        $payment->paid_amount = $request->input('paid_amount');
        $payment->prev_due_amount = $request->due_amount;
        $payment->user_id = auth()->user()->id;
        $payment->save();

        return redirect('/orders')->with('success', 'Payment Edited!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bill_id)
    {
        // $order = Order::find($id);
        // // $order = Payment::find($id);
        // // dd($order);
        // $order->delete();

        // // $payment = Payment::find($id);
        // // $payment->delete();

        DB::table("orders")->where("bill_id", $bill_id)->delete();
        DB::table("payments")->where("bill_id", $bill_id)->delete();
        DB::table("bills")->where("id", $bill_id)->delete();
        return redirect('/orders')->with('success', 'Order Deleted');
    }

    public function export(Request $request)
    {
        return Excel::download(new OrdersExport($request), 'orders.xlsx');
    }
}