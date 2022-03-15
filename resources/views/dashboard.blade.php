@extends('layouts.admin')

@section('content')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        var salesdata = new Array();
        salesdata[0] = ['Date', 'Sales'];
        @foreach($datewisesale as $item=>$value)
          salesdata[{{$item+1}}]=['{{$value->bill_date}}',{{$value->amount}}];
        @endforeach
  
        function drawChart() {
          var data = google.visualization.arrayToDataTable(
            salesdata
          );
  
          var options = {
            title: '',
            curveType: 'function',
            legend: { position: 'bottom' }
          };
  
          var chart = new google.visualization.AreaChart(document.getElementById('curve_chart'));
  
          chart.draw(data, options);
        }
      </script>
<!-- Content Header (Page header) -->
<div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-1 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              {{-- <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol> --}}
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          @if (Auth::user()->is_admin == 1)
              
          <div class="row">
              {{-- <div class="col-lg-3 col-6">
                <!-- small box -->
                
              </div> --}}
              <!-- ./col -->

              {{-- today'collection --}}
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    {{-- <h3>31<sup style="font-size: 20px">%</sup></h3> --}}
                    
                    <h3>Rs. {{$todays_collection}}</h3>
    
                    <p>Today's Collection</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-money-bill"></i>
                  </div>
                  <a href="/order_date/{{$mytime}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->

              {{-- todays due --}}
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box" style="background-color:#FAC428; color:white;">
                  <div class="inner">
                    {{-- <h3>31<sup style="font-size: 20px">%</sup></h3> --}}
                    
                    <h3>Rs. {{$todays_due}}</h3>
    
                    <p>Today's Due</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-credit-card"></i>
                  </div>
                  <a href="/order_date/{{$mytime}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->

              {{-- total collection --}}
              {{-- i added this --}}
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    {{-- <h3>31<sup style="font-size: 20px">%</sup></h3> --}}
                    {{-- @if($todays_sold_product[0]->count == 0)
                    <h3>0</h3>
                    @else
                    <h3>{{$todays_sold_product[0]->count}}</h3>
                    @endif --}}
                    <h3>Rs. {{$total_collection}}</h3>
                    <p>Total Collection</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                  </div>
                  <a href="/orders" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->

              {{-- Total Due --}}
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>Rs. {{$total_due}}</h3>
    
                    <p>Total Due</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-credit-card"></i>
                  </div>
                  <a href="/orders/due" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->

              {{-- <div class="col-lg-3 col-6">
                <!-- small box -->
                
              </div> --}}
              <!-- ./col -->
            </div>
            <!-- /.row -->
          <!-- Small boxes (Stat box) -->

          {{-- tala ko boxes --}}
          <div class="row">
            

            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box" style="background-color:#7B56EE; color:white;">
                <div class="inner">
                  {{-- <h3>31<sup style="font-size: 20px">%</sup></h3> --}}
                  
                  <h3>Rs. {{$total_cost}}</h3>
  
                  <p>Total Cost</p>
                </div>
                <div class="icon">
                  <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <a href="/purchases" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->


            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box" style="background-color:#FA7E28; color:white;">
                <div class="inner">
                  <h3>Rs. {{$my_due}}</h3>
  
                  {{-- <p>Total Sales Till Date</p> --}}
                  <p>My Due</p>

                </div>
                <div class="icon">
                  <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="/purchases/due" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            {{-- low stock --}}
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>{{$low_stock}}</h3>
  
                  <p>Low Stock</p>
                </div>
                <div class="icon">
                  <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="/products" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            {{-- total clients --}}
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner" style="color:white">
                  <h3>{{$clients}}</h3>
  
                  <p>Total Clients</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person"></i>
                </div>
                <a href="/clients" class="small-box-footer"><font color="white">More info <i class="fas fa-arrow-circle-right"></i> </font></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->

          
          
          <!-- solid sales graph -->
              <div class="card bg-gradient-info">
                <div class="card-header border-0">
                  <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>
                    Sales Graph
                  </h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn bg-light btn-sm" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart" id="curve_chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                </div>
                <!-- /.card-body -->
                {{-- <div class="card-footer bg-transparent">
                  <div class="row">
                    <div class="col-4 text-center">
                      <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                             data-fgColor="#39CCCC">
  
                      <div class="text-white">Mail-Orders</div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4 text-center">
                      <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                             data-fgColor="#39CCCC">
  
                      <div class="text-white">Online</div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4 text-center">
                      <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                             data-fgColor="#39CCCC">
  
                      <div class="text-white">In-Store</div>
                    </div>
                    <!-- ./col -->
                  </div>
                  <!-- /.row -->
                </div> --}}
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
              {{-- {{!! $chart->render() !!}} didnt work --}}
              <!-- Calendar -->
              {{-- <div class="card bg-gradient-success">
                <div class="card-header border-0">
  
                  <h3 class="card-title">
                    <i class="far fa-calendar-alt"></i>
                    Calendar
                  </h3>
                  <!-- tools card -->
                  <div class="card-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                      <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-bars"></i></button>
                      <div class="dropdown-menu float-right" role="menu">
                        <a href="#" class="dropdown-item">Add new event</a>
                        <a href="#" class="dropdown-item">Clear events</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">View calendar</a>
                      </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                  <!-- /. tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body pt-0">
                  <!--The calendar -->
                  <div id="calendar" style="width: 100%"></div>
                </div>
                <!-- /.card-body -->
              </div> --}}
              <!-- /.card -->
              {{-- <div id="curve_chart" style="width: 900px; height: 500px"></div> --}}

            </section>
            <!-- right col -->
          </div>
          @else
             <p>Only admin can access this page.</p> 
          @endif
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

      
@endsection