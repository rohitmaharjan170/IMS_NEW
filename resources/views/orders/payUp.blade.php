@extends('layouts.admin')

@section('content')
<div class = "container">
    <h1 align="center">Payment Report</h1>
    <hr>
    <a href="/orders" class='btn btn-default'><i class="far fa-hand-point-left"></i> Go Back</a> <br>
    <hr>
    {{-- <h1 align="center">Bill Number: {{$payment->bill_id}}</h1> --}}

    <table class= "table table-responsive table-condensed table-hover table-striped table-bordered table-sm">
        <thead>
            <tr style="text-align:center">
                <th>Payment Date</th>
                <th>Bill Date</th>
                <th>Bill Id</th>
                <th>Client Name</th>
                <th>Discount</th>
                <th>Grand Total</th>
                <th>Previous Due Amount</th>

                <th>Paid Amount</th>
                <th>Current Due Amount</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($payments as $payment)

            <tr style="text-align:center">
                <td><a href="/pay_date/{{$payment->payment_date}}">{{$payment->payment_date}}</a></td>
                <td>{{$payment->bill_date}}</td>
                <td><a href="/bill_order/{{$payment->bill_id}}">{{$payment->bill_id}}</a></td>
                <td>{{$payment->client_name}}</td>
                <td>{{$payment->discount}}</td>
                <td>{{$payment->grand_total}}</td>
                <td>{{$payment->prev_due_amount}}</td>
                <td><b>{{$payment->paid_amount}}</b></td>
                <td>{{$payment->due_amount}}</td>
                <td>
                    <div class='row-fluid'>
                        @if(!Auth::guest())
                            @if(Auth::user()->id == $payment->user_id | Auth::user()->is_admin == 1)
                                <a href="/orders/{{$payment->bill_id}}/payment" class="btn btn-info"><i class="fas fa-dollar-sign"></i>  Edit Payment</a>
                                @else
                                <p>Not Authorized</p>
                            @endif
                        @endif
                    </div>
                </td>
                
            </tr>

            @endforeach
        </tbody>

            
            {{-- <tfoot>
                <tr>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td><b>Discount</b></td>
                    <td><b>{{$order->discount}}</b></td>
                </tr>
                <tr>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td><b>Grand Total</b></td>
                    <td><b>{{$order->grand_total}}</b></td>
                </tr>
            </tfoot> --}}


    </table>
    {{$payments->links()}} 
</div>
@endsection
