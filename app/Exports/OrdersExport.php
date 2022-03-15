<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class OrdersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $request;

    public function __construct($request)       //constructor
    {
       $this->request = $request;
    } 

    public function collection()
    {
        // return Order::all();
        $from_date = $this->request->from_date;
        $to_date = $this->request->to_date;
        $orders = DB::table('orders')
                ->join('bills', 'bills.id', '=', 'orders.bill_id')
                ->select('orders.bill_id', 'orders.order_date', 'orders.client_name', 'orders.product_name', 'orders.quantity', 'orders.rate', 'orders.sub_amount', 'orders.discount', 'orders.grand_total', 'bills.paid_amount', 'bills.due_amount')
                ->whereBetween('orders.order_date', [$from_date, $to_date])
                ->orderBy('bill_id', 'asc')->get();
        // dd($orders);
        return $orders;
    }
    
    public function headings(): array
    {
        return [
            'Bill Id',
            'Order Date',
            'Client Name',
            'Product Name',
            'Quantity',
            'Rate',
            'Sub Amount',
            'Discount',
            'Grand Total',
            'Paid Amount',
            'Due Amount'
        ];
    }

    // function index(Request $request)
    // {
    //  if(request()->ajax())
    //  {
    //   if(!empty($request->from_date))
    //   {
    //    $data = DB::table('tbl_order')
    //      ->whereBetween('order_date', array($request->from_date, $request->to_date))
    //      ->get();
    //   }
    //   else
    //   {
    //    $data = DB::table('tbl_order')
    //      ->get();
    //   }
    //   return datatables()->of($data)->make(true);
    //  }
    //  return view('daterange');
    // }
}
