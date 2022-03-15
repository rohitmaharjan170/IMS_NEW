<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Product;
use App\Client;
use App\Rate;
use DB; // TO USE SQL QUERIES

class ProductsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = Product::all(); //this is gonna fetch all the data in this table
        // return Product::where('name', 'Shirt')->get(); 
        // $products = DB::select('SELECT * FROM products'); //SQL QUERY
        // $products = Product::orderBy('name', 'desc')->take(1)->get();        
        // $products = Product::orderBy('name', 'desc')->get(); //if we are gonna add clauses like ('name', 'desc'), we need to at get()
        
        $products = Product::orderBy('quantity', 'asc')->paginate(5);
        return view('products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client_list = Client::select('id')->get();
        // dd($client);
        return view('products.create')->with('client_list', $client_list);
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
            'name' => 'required',           //This is validation
            'quantity' => 'required',
            'rate' => 'required'
            // 'product_image' => 'image|nullable|max:1999'     //UPLOADING IMAGE
        ]);

        //UPLOADING IMAGE

        // // Handle File Upload
        // if($request->hasFile('product_image')){
        //     // Get filename with the extension
        //     $filenameWithExt = $request->file('product_image')->getClientOriginalName();
        //     // Get just filename
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get just ext
        //     $extension = $request->file('product_image')->getClientOriginalExtension();
        //     // Filename to store
        //     $fileNameToStore= $filename.'_'.time().'.'.$extension;
        //     // Upload Image
        //     $path = $request->file('product_image')->storeAs('public/product_images', $fileNameToStore);
        // } else {
        //     $fileNameToStore = 'noimage.jpg';
        // }
        
        
        //Add Product (same steps as in tinker)
        $product = new Product;
        $product->name = $request->input('name');
        $product->quantity = $request->input('quantity');
        $product->rate = $request->input('rate');
        $product->user_id = auth()->user()->id;
        // $product->product_image = $fileNameToStore; //UPLOADING IMAGE
        $product->save();
        
        // $client = Client::all();
        // dd($client->id);

        // $rate = new Rate;
        // $rate->client_id = $client->id;
        // $rate->product_id = $product->id;
        // $rate->client_rate = $product->rate;
        // dd($rate);

        $datas = DB::table('clients')->get();
        // dd($datas);

        foreach($datas as $data){
            DB::table('rates')->insert(['client_id' => $data->id, 'product_id'=>$product->id, 'client_rate'=>$product->rate, 'user_id'=>auth()->user()->id]);
            // dd($data);
        }

        // $data =[];
        // foreach($clients->id as $item=>$v){
        //     $client = Client::select('id')->where('id', $request->client_id[$item])->first();
        //     $data[]=array(
        //         'client_id' => $client->id,
        //         'product_id' => $product->id,
        //         'client_rate' => $product->rate,
        //         'user_id' => auth()->user()->id,
        //     );
        // }
        // dd($data);
        // Rate::insert($data);

        // $data = [];
        // foreach($request->client_id as $item=>$v){
        //     $client = Client::select('id')->where('id',$request->client_id[$item])->first();
        //     $data[]=array(
                
        //         'client_id' => $client->id,
        //         'product_id' => $product->id,
        //         'client_rate' => $product->rate,

        //         'created_at' => date('Y-m-d H:i:s'),
        //         'user_id' => auth()->user()->id
        //     );
        // }

        // Rate::insert($data);

        return redirect('/products')->with('success', 'Product Added!!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

        // >>CHECK FOR CORRECT USER<<
        if(auth()->user()->id !== $product->user_id){
            return redirect('/products')->with('error', 'Unauthorized Page');
        }

        return view('products.edit')->with('product', $product); 
        
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
        $this->validate($request, [
            'name' => 'required',           //This is validation
            'quantity' => 'required',
            'rate' => 'required'
        ]);
        
        //UPLOADING IMAGE

        // // Handle File Upload
        // if($request->hasFile('product_image')){
        //     // Get filename with the extension
        //     $filenameWithExt = $request->file('product_image')->getClientOriginalName();
        //     // Get just filename
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get just ext
        //     $extension = $request->file('product_image')->getClientOriginalExtension();
        //     // Filename to store
        //     $fileNameToStore= $filename.'_'.time().'.'.$extension;
        //     // Upload Image
        //     $path = $request->file('product_image')->storeAs('public/product_image', $fileNameToStore);
        // }

        //Add Product (same steps as in tinker)
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->quantity = $request->input('quantity');
        $product->rate = $request->input('rate');
        // if($request->hasFile('product_image')){
        //     $product->product_image = $fileNameToStore;          //UPLOADING IMAGE
        // }
        $product->save();

        return redirect('/products')->with('success', 'Product Updated!!');
    }

    public function stock($id)
    {
        $stock = Product::find($id);

        // >>CHECK FOR CORRECT USER<<
        if(auth()->user()->id !== $stock->user_id){
            return redirect('/products')->with('error', 'Unauthorized Page');
        }

        return view('products.stock')->with('stock', $stock); 
        
    }

    public function addStock(Request $request, $id){
        
        $this->validate($request, [                                        
            'quantity' => 'required',
        ]);
        
        $stock = Product::find($id);
        $stock->quantity = $stock->quantity + $request->input('quantity');
        $stock->save();

        return redirect('/products')->with('success', 'Stock Added!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        // $product = Product::find($id);

        DB::table("products")->where("id", $product_id)->delete();
        DB::table("rates")->where("product_id", $product_id)->delete();

        // >>CHECK FOR CORRECT USER<<
        // if(auth()->user()->id !== $product->user_id){
        //     return redirect('/products')->with('error', 'Unauthorized Page');
        // }

        // if($product->product_image != 'noimage.jpg'){
        //     //Delete Image
        //     Storage::delete('public/product_images/'.$product->product_image);
        // }
        
        // $product->delete();
        return redirect('/products')->with('success', 'Product Removed!!');
    }
}
