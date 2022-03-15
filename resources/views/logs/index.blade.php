@extends('layouts.admin')

@section('content')
    <div class="container">
      
        <h1 align="center">History</h1>
        <hr>
        <br>
        <div class="table-responsive">
            <table class="table table-responsive table-bordered table-hover table-condensed table-sm">
                <thead>
                    <tr bgcolor = "lightblue">
                        <th>Type</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Cost Price</th>
                        <th>Rate</th>
                        <th>Supplier</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Grand Total</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($log as $row)
                        @if ($row->type == "Sale")
                        <tr class = "table-success">
                            <td>{{$row->type}}</td>

                            
                                <td>{{$row->order_date}}</td>
                            

                            
                                <td>{{$row->product_name}}</td>
                            

                           
                                <td>{{$row->quantity}}</td>
                            

                            
                                <td>{{$row->cost_price}}</td>
                            

                           
                                <td>{{$row->rate}}</td>
                                                      

                         
                                <td>{{$row->supplier}}</td>
                            
                                <td>{{$row->client_name}}</td>
                           
                            
                                <td>{{$row->sub_amount}}</td>
                          

                                <td>{{$row->discount}}</td>
                           

                           
                                <td>{{$row->grand_total}}</td>
                           

                                <td>{{$row->paid_amount}}</td>
                           

                                <td>{{$row->due_amount}}</td>
                           
                        </tr>
                        @else
                        <tr class = "table-danger">
                                <td>{{$row->type}}</td>
    
                                
                                    <td>{{$row->order_date}}</td>
                                
    
                                
                                    <td>{{$row->product_name}}</td>
                                
    
                               
                                    <td>{{$row->quantity}}</td>
                                
    
                                
                                    <td>{{$row->cost_price}}</td>
                                
    
                               
                                    <td>{{$row->rate}}</td>
                                                          
    
                             
                                    <td>{{$row->supplier}}</td>
                                
                                    <td>{{$row->client_name}}</td>
                               
                                
                                    <td>{{$row->sub_amount}}</td>
                              
    
                                    <td>{{$row->discount}}</td>
                               
    
                               
                                    <td>{{$row->grand_total}}</td>
                               
    
                                    <td>{{$row->paid_amount}}</td>
                               
    
                                    <td>{{$row->due_amount}}</td>
                               
                            </tr>
                        @endif

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection