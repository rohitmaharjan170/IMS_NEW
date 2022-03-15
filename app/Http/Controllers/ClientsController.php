<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Order;
use App\Product;
use App\Rate;
use DB;

class ClientsController extends Controller
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
        $clients = Client::orderBy('client_name', 'asc')->paginate(5);
        return view('clients.index')->with('clients', $clients);
    }

    // public function is_admin(){
    //     $user = User::all();
    //     return View::make('finances.index')->withFinances($finances);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_list = Product::select('name', 'id', 'rate')->get();
        // $product_list = ['0' => 'Pick a Product..'] + collect($product_list)->toArray();
        // $product_list = collect($product_list)->toArray();

        // $client = Client::get()->pluck('id');
        // $client = collect($id);

        // dd($product_list);
        return view('clients.create')->with('product_list', $product_list);
        // ->with('client_id', $id)
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // public function store(Request $request, Client $client, Rate $rate)
    public function store(Request $request)
    {
        $this->validate($request, [
            'client_name' => 'required',
            'client_address' => 'required',
            'client_contact' => 'required'
        ]);
        // $product = Product::select('id','name', 'rate')->where('id', $request->product_id)->get();

        $client = new Client;
        $client->client_name = $request->input('client_name');
        $client->client_address = $request->input('client_address');
        $client->client_contact = $request->input('client_contact');
        $client->email = $request->input('email');
        $client->user_id = auth()->user()->id;

        // dd($client);
        $client->save();

        $data =[];
        // dd($request);
        foreach($request->product_id as $item=>$v){
            // $client = Client::select('id')->where('id', $request->client_id[$item])->first();
            // $product = Product::select('id', 'name')->where('name', $request->product_id[$item])->first();
            $data[]=array(
                // 'id' => $client->id,
                'client_id' => $client->id,
                'product_id' => $request->product_id[$item],
                'client_rate' => $request->input('client_rate')[$item],

                'created_at' => date('Y-m-d H:i:s'),
                'user_id' => auth()->user()->id
            );
        }
        // dd($data);

        Rate::insert($data);

        return redirect('/clients')->with('success', 'Client Added!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $client = Client::find($id);
        // $rate = Rate::find($client_id);
		// // $order = Order::select('client_name')->where('id',$request->id)->first();
        // return view('clients.show')->with('client', $client)->with('rate', $rate);

        $client = Client::where('id', $id)->first();
        // dd($client);
        // $rate = Rate::with('product')->get();

        $ratelist = DB::table('clients')
                    // ->where('id', $id) //this doesnt work because you have multiple possible id fields
                    ->where('clients.id', $id)
                    ->join('rates', 'rates.client_id', '=', 'clients.id')
                    ->join('products', 'products.id', '=', 'rates.product_id')
                    ->select('clients.id', 'clients.client_name', 'clients.client_address', 'clients.client_contact', 'clients.email', 'clients.user_id','rates.client_id', 'rates.product_id', 'rates.client_rate', 'products.name')
                    ->get();
        // dd($ratelist);

        return view('clients.show')->with('client', $client)->with('clients', $ratelist);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $client = Client::find($id);
        $client = DB::table('clients')
                // ->where('id', $id) //this doesnt work because you have multiple possible id fields
                ->where('clients.id', $id)
                ->select('clients.*')
                ->first();
        // dd($client);

        $rate = Rate::select('rates.id as id','products.name','client_id', 'product_id', 'client_rate')
                ->where('client_id', $id)
                ->join('products', 'products.id', '=', 'rates.product_id')
                ->get();


        // // >>CHECK FOR CORRECT USER<<
        // if(auth()->user()->id !== $client->user_id){
        //     return redirect('/clients')->with('error', 'Unauthorized Page');
        // }

        return view('clients.edit')->with('client', $client)->with('rate', $rate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Rate $client_id)
    {
        $this->validate($request, [
            'client_name' => 'required',
            'client_address' => 'required',
            'client_contact' => 'required'
        ]);

        $client = Client::find($id);
        $client->client_name = $request->input('client_name');
        $client->client_address = $request->input('client_address');
        $client->client_contact = $request->input('client_contact');
        $client->email = $request->input('email');
        $client->user_id = auth()->user()->id;
        // dd($client);
        $client->save();

        // $product = Product::where('product_id', Rate::find($product_id))->exists();
        // dd($product);

        // foreach($request->product_id as $item=>$v){
        //     $rate = Rate::find($client_id);
        //     $rate->product_id = $request->input('product_id')[$item];
        //     $rate->client_rate = $request->input('client_rate')[$item];
        //     // dd($rate);
        //     $rate->save();
        // }

        // $ids = $request->id[0];
        // $product_ids = $request->product_id[0];
        // $client_ids = $request->client_id[0];
        // $client_rates = $request->client_rate[0];
        // DB::table('rates')->where('id', $id)->update(['product_id' => $product_ids, 'client_id' => $client_id, 'client_rates' => $client_rates ]);

        // foreach($request->product_id as $i => $id)
        // {
        //     $rate = Rate::findOrFail($client_id);
        //     $rate->fill(['client_rate' => $request->client_rate[$i]])->save();
        // }

        // $data =[];
        // dd($request);
        foreach($request->id as $item=>$v){
            // $client = Client::select('id')->where('id', $request->client_id[$item])->first();
            // $product = Product::select('id', 'name')->where('name', $request->product_id[$item])->first();
            $u= Rate::find($v);

            $u->client_id=$client->id;
            $u->product_id= $request->product_id[$item];
            $u->client_rate= $request->client_rate[$item];

            $u->updated_at = date('Y-m-d H:i:s');
            // 'user_id' => auth()->user()->id
            // dd($v);
            $u->save();
        }
        // $data =[];
        // foreach($request->product_id as $item=>$v){
        //     $rate = Rate::select('id', 'product_id')->where('id', $request->product_id[$item])->first();
        //     $data=array(
        //         'client_id' => $client->id,
        //         'product_id' => $request->input('product_id')[$item],
        //         'client_rate' => $request->input('client_rate')[$item],
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         // 'user_id' => auth()->user()->id
        //         );
        //     dd($data);
        // }
        // Rate::where('client_id', $client->id)->update($data);

        return redirect('/clients')->with('success', 'Client Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($client_id)
    {
        // $client = Client::find($id);

        DB::table("clients")->where("id", $client_id)->delete();
        DB::table("rates")->where("client_id", $client_id)->delete();

        // if(auth()->user()->id !== $client->user_id){
        //     return redirect('/clients')->with('error', 'Unauthorized Page');
        // }

        // $client->delete();
        return redirect('/clients')->with('success', 'Client Deleted');
    }
}
