<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Order;
use App\Client;
use App\Payment;
use App\Bill;
use App\Setting;
use Carbon\Carbon;
use Auth;
use DB;
use Charts;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $mytime = Carbon::now()->format('Y-m-d'); //format only takes date
        // dd($mytime);

        // $order = Order::all();
        // $total = 0;
        // foreach($order->id as $quantity) {
        //     $total += $quantity;
        // }
        // dd($total);

        // $data['todays_sale'] = Order::select('quantity')->where('order_date',$mytime)->get(); 
        // $data['todays_sold_product'] = DB::table('orders')->select(DB::raw("SUM(quantity) as count"))->where('order_date',$mytime)->get(); //last used
        // dd($data); 

        $data['todays_collection'] = DB::table("bills")->where('bill_date',$mytime)->get()->sum("paid_amount");
        $data['todays_due'] = DB::table("bills")->where('bill_date',$mytime)->get()->sum("due_amount");

        $data['total_collection'] = DB::table("bills")->get()->sum("paid_amount");
        $data['total_due'] = DB::table("bills")->get()->sum("due_amount");

        

        $data['todays_bill'] = Bill::select('id')->where('bill_date',$mytime)->count(); 

        $data['low_stock'] = Product::select('quanity')->where('quantity', '<=', '9')->count();
        
        // $paid = Payment::select('paid_amount')->get();
        // $data['todays_payment'] = Payment::all()->where('payment_date', $mytime)->count();
        $data['total_cost'] = DB::table("purchases")->get()->sum("total_cost");

        // dd($data);
        $data['clients'] = Client::all()->count();  

        // $data['total_sales'] = Order::all()->count();
        $data['my_due'] = DB::table("purchases")->get()->sum("due_amount");

        
        $date = \Carbon\Carbon::today()->subDays(7);
        $data['datewisesale'] = Bill::select(DB::raw('sum(grand_total) as amount,bill_date'))->where('created_at', '>=', $date)->groupBy('bill_date')->get();
        // dd($datewisesale);
        // $data['chart'] = Charts::new('line', 'highcharts')
        //                 ->setTitle("Sales Graph")
        //                 ->setLabels(["ES", "FR", "RU"])             didnt work
        //                 ->setValues([100, 50, 25])
        //                 ->setElementLabel("Total users");

        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        // $data['setting'] = Setting::all();
        // dd($data);
        
            // dd($result);

        // $data['staff'] = User::all();

        return view('dashboard', $data)->with('mytime', $mytime);
    }

    // public function span(){
    //     $result = DB::table('settings')
    //             ->where('user_id', '=', Auth::user()->id)
    //             ->exists();
    //             // dd($result);
    //     return view()->with('result', $result);
    // }

    //Staff
    public function staff(){
        $data['staff'] = User::orderBy('created_at', 'desc')->paginate(5);
        // dd($data);
        return view('staff', $data);
    }

    public function del($id){
        $staff = User::findOrFail($id);

        if (Auth::user()->id == $id) {
            return redirect('/staff')->with('error', 'Cannot delete yourself!!');            
        }

        $staff->delete();

        return redirect('/staff')->with('success', 'User Removed!!');
    }

    public function show_user($id){
        $user = User::find($id);
        return view('user')->with('user', $user);
    }

    public function edit_user($id)
    {
        $user = User::find($id);

        // >>CHECK FOR CORRECT USER<<
        if(auth()->user()->id !== $user->id){
            return redirect()->back()->with('error', 'Unauthorized Page');
        }

        return view('edit_user')->with('user', $user);         
    }

    public function update_user(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',           //This is validation
            'email' => 'required|email',
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
        $user->save();

        return view('user')->with(['user'=>$user, 'success'=>'User Updated!!' ]);
    }


    public function setting()
    {
        $vendor = Setting::all();
        // $user = Setting::select('user_id')->get();
        $user = Setting::where('user_id', Auth::user()->id)->exists();
        // dd($user);
        return view('vendor')->with('vendor', $vendor)->with('user', $user);
    }

    public function create()
    {
        return view('setting');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'vendor_name' => 'required',
            'address' => 'required',
            // 'user_id' => 'unique'
            
        ]);

        $vendor = new Setting;
        $vendor->vendor_name = $request->input('vendor_name');
        $vendor->address = $request->input('address');
        $vendor->user_id = auth()->user()->id;
        // dd($vendor);
        $vendor->save();
        return redirect('/setting')->with('success', 'Vendor Saved!!');
    }
    
    public function edit($id)
    {
        $vendor = Setting::find($id);

        // >>CHECK FOR CORRECT USER<<
        // if(auth()->user()->id == $vendor->user_id | auth()->user()->is_admin == 1){  this allows admin and logged in user to access
        if(auth()->user()->is_admin == 1){  // this allows only admin to access
            return view('edit_vendor')->with('vendor', $vendor);
        } else {
            return redirect('/setting')->with('error', 'Unauthorized Page');
        }

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'vendor_name' => 'required',           //This is validation
            'address' => 'required'
        ]);

        $vendor = Setting::find($id);
        $vendor->vendor_name = $request->input('vendor_name');
        $vendor->address = $request->input('address');
        
        $vendor->save();

        return redirect('/setting')->with('success', 'Vendor Updated!!');
    }

    public function destroy($id)
    {
        $vendor = Setting::find($id);

        // >>CHECK FOR CORRECT USER<<
        // if(auth()->user()->id !== $vendor->user_id){
        //     return redirect('/setting')->with('error', 'Unauthorized Page');
        // }
        
        $vendor->delete();
        return redirect('/setting')->with('success', 'Vendor Removed!!');
    }
}