<?php

namespace App\Http\Controllers;
use App\Purchase;
use App\Product;
use App\User;
use App\Type;
use App\Pbill;
use App\Ppayment;
use DB;

use Illuminate\Http\Request;

class PurchasesController extends Controller
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
        $purchases = Purchase::orderBy('purchase_date', 'desc')->paginate(5);
        return view('purchases.index')->with('purchases', $purchases);
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
        $type_list = Type::get()->pluck('type_name', 'id');
        $type_list = ['1' => 'Purchase'] + collect($type_list)->toArray();
        return view('purchases.create')->with('product_list', $product_list)->with('type_list', $type_list);
    }

    // public function findQuantity(Request $request){
	
	// 	//it will get price if its id match with product id
	// 	$stock = Product::select('quantity')->where('id',$request->id)->first(); //first picks only one item whereas get() picks array of item
		
    // 	return $stock->quantity;
    // }

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
            'stock' => 'required',
            'purchase_date' => 'required',
            'supplier' => 'nullable',
            'cost_price' => 'required',
            'total_cost' => 'required',
             'paid_amount' => 'required',
            'due_amount' => 'required'
        ]);

        $type = Type::select('type_name')->where('id', $request->type)->first();

        $pbill = new Pbill;
        // $pbill->bill_number = $request->input('bill_number');
        $pbill->supplier = $request->supplier;
        $pbill->bill_date = $request->purchase_date;
        $pbill->total_cost = $request->total_cost;
        $pbill->paid_amount = $request->paid_amount;
        $pbill->due_amount = $request->due_amount;
        $pbill->user_id = auth()->user()->id;
        $pbill->save();    

        //For Ppayment table
        $payment = new Ppayment;
        $payment->payment_date = $request->purchase_date;
        $payment->pbill_id = $pbill->id;
        $payment->paid_amount = $request->paid_amount;
        $payment->prev_due_amount = $request->due_amount;
        $payment->user_id = auth()->user()->id;
        // dd($payment);
        $payment->save();

        // $purchase = new Purchase;
        // $purchase->product = $product->name;
        // $purchase->type = $type->type_name;
        // $purchase->purchase_date = $request->input('purchase_date');
        // $purchase->stock = $product->quantity + $request->input('stock'); //ADDING TO STOCK OF PRODUCT TABLE
        // $purchase->supplier = $request->input('supplier');
        // $purchase->cost_price = $request->input('cost_price');
        // $purchase->total_cost = $request->input('total_cost');
        // $purchase->paid_amount = $request->input('paid_amount');
        // $purchase->due_amount = $request->input('due_amount');
        // $purchase->user_id = auth()->user()->id;

        // $purchase->save();
        
        $data =[];
        foreach($request->product as $item=>$v){
            $product = Product::select('id', 'name')->where('id', $request->product[$item])->first();
            $data[]=array(
                'type' => $type->type_name,
                'purchase_date'=> $request->input('purchase_date'),
                'supplier' => $request->input('supplier'),
                'product' => $product->name,
                'product_id' => $product->id,
                'stock' => $request->input('stock')[$item],
                'cost_price' => $request->input('cost_price')[$item],
                'total_cost' => $request->input('total_cost'),
                'paid_amount' => $request->input('paid_amount'),
                'due_amount' => $request->input('due_amount'),
        
                'user_id' => auth()->user()->id,
                'pbill_id' => $pbill->id

            );            
            DB::table('products')->where('name', $product->name)->increment('quantity', $request->input('stock')[$item]); //ADDING TO STOCK OF PRODUCT TABLE
        }
        Purchase::insert($data);       
        return redirect('/purchases')->with('success', 'Purchase Added!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::find($id);
        return view('purchases.show')->with('purchase', $purchase);
    }

    public function purchaseBill($pbill_id)
    {
        $purchaseBill = Purchase::where('pbill_id', $pbill_id)->first();
        $plist = Purchase::where('pbill_id', $pbill_id)->get();

        return view('purchases.purchaseBill')->with('purchase', $purchaseBill)->with('purchases', $plist);
    }

    public function purchaseDate($purchase_date)
    {
        $pDate = Purchase::where('purchase_date', $purchase_date)->first();
        $purchaseDate = Purchase::where('purchase_date', $purchase_date)->get();
        return view('purchases.purchaseDate')->with('purchases', $purchaseDate)->with('purchase', $pDate);
    }

    public function supplierReport($supplier)
    {
        $supplierReport = Purchase::where('supplier', $supplier)->get();
        $sName = Purchase::where('supplier', $supplier)->first(); //get client name at top
        return view('purchases.show')->with('purchases', $supplierReport)->with('purchase', $sName);
    }

    public function due()
    {
        $purchases = DB::table('purchases')
                ->select('pbill_id', 'purchase_date', 'supplier', 'product', 'stock', 'cost_price', 'total_cost', 'paid_amount', 'due_amount', 'user_id')
                ->where('due_amount', '>=', '1')
                ->orderBy('pbill_id', 'desc')
                ->paginate(5);
                
        return view('purchases.due')->with('purchases', $purchases);
    }

    //Show ppayments table
    public function payUp()
    {
        $payments = DB::table('ppayments')
                // ->join('orders', 'orders.bill_id', '=', 'payments.bill_id')
                ->join('pbills', 'pbills.id', '=', 'ppayments.pbill_id')
                // ->join('clients', 'clients.id', '=', 'bills.client_id')
                // ->select('orders.id', 'orders.type', 'orders.bill_id', 'orders.order_date', 'orders.client_name', 'orders.product_name', 'orders.quantity', 'orders.rate', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'orders.user_id', 'payments.payment_date', 'payments.paid_amount')
                ->select('ppayments.id', 'ppayments.payment_date', 'ppayments.pbill_id', 'ppayments.paid_amount', 'ppayments.prev_due_amount', 'ppayments.user_id', 'pbills.bill_date',           'pbills.total_cost', 'pbills.supplier', 'pbills.due_amount')
                ->orderBy('payment_date', 'desc')
                ->paginate(10);
        // dd($payments);
        // return View::make('orders.payUp', compact('bills', 'clients'))->with('payments', $payments);

        return view('purchases.payUp')->with('payments', $payments);
    }

    public function payDate($payment_date)
    {
        $pDate = Ppayment::where('payment_date', $payment_date)->first();
        // $orderDate = Order::where('order_date', $order_date)->get();
        $payDate = DB::table('ppayments')
                    ->where('payment_date', $payment_date) //mathy ko where condition
                    ->join('pbills', 'pbills.id', '=', 'ppayments.pbill_id')
                    // ->join('clients', 'clients.id', '=', 'bills.client_id')
                    ->select('ppayments.payment_date', 'ppayments.pbill_id', 'ppayments.paid_amount', 'ppayments.prev_due_amount', 'ppayments.user_id', 'pbills.bill_date', 'pbills.total_cost', 'pbills.supplier', 'pbills.due_amount')
                    ->orderBy('pbill_id', 'desc')
                    ->paginate(10);
        return view('purchases.payDate')->with('payments', $payDate)->with('payment', $pDate);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($pbill_id)
    {
        // $purchase = Purchase::find($id);
        $purchase = Purchase::where('pbill_id',$pbill_id)->get();
        $product_list = Product::get()->pluck('name', 'id');
        // $product_list = [$purchase->product] + collect($product_list)->toArray();
        $product_list = ['0' => 'Pick a Product..'] + collect($product_list)->toArray();

        $type_list = Type::get()->pluck('type_name', 'id');
        // $type_list = ['1' => 'Purchase'] + collect($type_list)->toArray();

        // if(auth()->user()->id !== $purchase->user_id){
        //     return redirect('/purchases')->with('error', 'Unauthorized Page');
        // }

        return view('purchases.edit')->with('purchase', $purchase)->with('product_list', $product_list)->with('type_list', $type_list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pbill_id)
    {
        $this->validate($request, [   
            'type' => 'required',         
            'product' => 'required',
            'stock' => 'required',
            'purchase_date' => 'required',
            'supplier' => 'nullable',
            'cost_price' => 'required',
            'total_cost' => 'required',
            'paid_amount' => 'required',
            'due_amount' => 'required'
        ]);

        $type = Type::select('type_name')->where('id', $request->type)->first();
        
        $pbill = Pbill::find($pbill_id);
        // $pbill->bill_number = $request->input('bill_number');
        $pbill->supplier = $request->supplier;
        $pbill->bill_date = $request->purchase_date;
        $pbill->total_cost = $request->total_cost;
        $pbill->paid_amount = $request->paid_amount;
        $pbill->due_amount = $request->due_amount;
        $pbill->save();   
        
        $data =[];
        foreach($request->product as $item=>$v){
            $product = Product::select('id', 'name')->where('id',$request->product[$item])->first();
            // dd($product);
            if($request->purchase_id[$item] > 0)
            {
            $data=array(
                'type' => $type->type_name,
                // 'type_id' => $type->id,
                'purchase_date'=> $request->input('purchase_date'),
                'supplier' => $request->input('supplier'),
                'product_id' => $product->id,
                'product' => $product->name,
                'stock' => $request->input('stock')[$item],
                'cost_price' => $request->input('cost_price')[$item],
                // 'discount' => $request->input('discount'),
                'total_cost' => $request->input('total_cost'),
                'paid_amount' => $request->input('paid_amount'),
                'due_amount' => $request->input('due_amount'),
        
                'user_id' => auth()->user()->id,
                // 'bill_id' => $bill->id
            );
            // dd($data);
            Purchase::where('id', $request->purchase_id[$item])->update($data);
        }
        else{ 
            // naya product edit garda thapyo vane yesto garni
            $data=array(
                'type' => $type->type_name,
                'purchase_date'=> $request->input('purchase_date'),
                'supplier' => $request->input('supplier'),
                'product_id' => $product->id,
                'product' => $product->name,
                'stock' => $request->input('stock')[$item],
                'cost_price' => $request->input('cost_price')[$item],
                'total_cost' => $request->input('total_cost'),
                'paid_amount' => $request->input('paid_amount'),
                'due_amount' => $request->input('due_amount'),
        
                'user_id' => auth()->user()->id,
                // 'pbill_id' => $request->bill_number 
                'pbill_id' => $pbill->id //bill_number remove gareko le yo line thapiyo

            );

            Purchase::insert($data);
        }

        // $purchase = Purchase::find($id);
        // $purchase->product_id = $product->id;
        // $purchase->product = $product->name;
        // $purchase->type = $type->type_name;
        // $purchase->purchase_date = $request->input('purchase_date');
        // $purchase->stock = $request->input('stock');
        // $purchase->supplier = $request->input('supplier');
        // $purchase->cost_price = $request->input('cost_price');
        // $purchase->total_cost = $request->input('total_cost');
        // $purchase->paid_amount = $request->input('paid_amount');
        // $purchase->due_amount = $request->input('due_amount');
        // $purchase->user_id = auth()->user()->id;
        // $purchase->save();
    }

        return redirect('/purchases')->with('success', 'Purchase Updated!!');
    }

    //BELOW CODE WAS FOR EDITING PAYMENT.. LATER PAYMENT TABLE WAS MADE
    public function payment($pbill_id)
    {
        //edit payment
        $purchase = Purchase::where('pbill_id',$pbill_id)->get();
        $pbill = Pbill::find($pbill_id);


        // print_r($payment);
        // dd("here");

        // >>CHECK FOR CORRECT USER<<
        // if(auth()->user()->id !== $payment->user_id){
        //     return redirect('/orders')->with('error', 'Unauthorized Page');
        // }

        return view('purchases.payment')->with('purchase', $purchase)->with('pbill', $pbill);

    }

    public function addPayment(Request $request, $pbill_id){
        //store payment
        $this->validate($request, [
            // 'due_amount' => 'required',
            'paid_amount' => 'required',
        ]);


        $pbill = Pbill::find($pbill_id);
        $pbill->paid_amount = $pbill->paid_amount + $request->paid_amount;
        $pbill->due_amount = $pbill->due_amount - $request->paid_amount;
        $pbill->save();

        $p_id = Purchase::select('pbill_id')->where('pbill_id', $request->pbill_id)->first();

        $payment = new Ppayment();
        $payment->payment_date = $request->input('payment_date');
        $payment->pbill_id = $p_id->pbill_id;
        $payment->paid_amount = $request->input('paid_amount');
        $payment->prev_due_amount = $request->due_amount;
        $payment->user_id = auth()->user()->id;
        $payment->save();

        return redirect('/purchases')->with('success', 'Payment Edited!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pbill_id)
    {

        DB::table("purchases")->where("pbill_id", $pbill_id)->delete();
        DB::table("ppayments")->where("pbill_id", $pbill_id)->delete();
        DB::table("pbills")->where("id", $pbill_id)->delete();

        // $purchase = Purchase::find($id);
        // $purchase->delete();
        return redirect('/purchases')->with('success', 'Purchase Deleted');
    }
}
