@extends('layouts.external')

@section('title')

@endsection

@section('header-style')
  <style>
    .card-common {
      box-shadow: 1px 2px 5px #999;
      transition: all .3s;
    }
    .card-common:hover {
      box-shadow: 2px 3px 15px #999;
      transform: translateY(-1px);
    }
    /* .pie-chart {
      margin: 200px auto;
      width: 1000px;
      height: 500px;
    } */
  </style>


{{-- Pie Chart Start--}}
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Work',     11],
        ['Eat',      2],
        ['Commute',  2],
        ['Watch TV', 2],
        ['Sleep',    7]
      ]);

      var options = {
        title: 'My Daily Activities'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
  </script>
  {{-- Pie Chart End --}}


  {{-- Bar Chart Start --}}
  <script>
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawAxisTickColors);

  function drawAxisTickColors() {
      var data = google.visualization.arrayToDataTable([
        ['City', '2010 Population', '2000 Population'],
        ['Dhaka, NY', 8175000, 8008000],
        ['Los Angeles, CA', 3792000, 3694000],
        ['Chicago, IL', 2695000, 2896000],
        ['Houston, TX', 2099000, 1953000],
        ['Philadelphia, PA', 1526000, 1517000]
      ]);

      var options = {
        title: 'Population of Largest U.S. Cities',
        chartArea: {width: '50%'},
        hAxis: {
          title: 'Total Population',
          minValue: 0,
          textStyle: {
            bold: true,
            fontSize: 12,
            color: '#4d4d4d'
          },
          titleTextStyle: {
            bold: true,
            fontSize: 18,
            color: '#4d4d4d'
          }
        },
        vAxis: {
          title: 'City',
          textStyle: {
            fontSize: 14,
            bold: true,
            color: '#848484'
          },
          titleTextStyle: {
            fontSize: 14,
            bold: true,
            color: '#848484'
          }
        }
      };
      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
  </script>
  {{-- Bar Chart End --}}
@endsection
@section('content')
   {{-- Card Start --}}
<div class="container-fluid">
  <div class="row">
    <div class="col-xl-12 col-md-8 col-lg-12 ml-auto">
      <div class="row">
        <div class="col-xl-3 col-sm-3 p-2">
          <div class="card card-common">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <i class="fas fa-shopping-cart fa-3x text-warning"></i>  
                <div class="text-right text-secondary">
                  <h6>Sales</h6>
                  <h5>৳ 1550000</h5>
                </div>
              </div>
            </div>
            <div class="card-footer text-secondary">
              <i class="fas fa-sync mr-2"></i>
              <span>Updated Now</span>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-3 p-2">
          <div class="card card-common">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <i class="fas fa-money-bill-alt fa-3x text-success"></i>  
                <div class="text-right text-secondary">
                  <h6>Expenses</h6>
                  <h5>৳ 550000</h5>
                </div>
              </div>
            </div>
            <div class="card-footer text-secondary">
              <i class="fas fa-sync mr-2"></i>
              <span>Updated Now</span>
            </div>
          </div>
      </div>
        <div class="col-xl-3 col-sm-3 p-2">
          <div class="card card-common">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <i class="fas fa-users fa-3x text-info"></i>  
                <div class="text-right text-secondary">
                  <h6>Users</h6>
                  <h5>5000</h5>
                </div>
              </div>
            </div>
            <div class="card-footer text-secondary">
              <i class="fas fa-sync mr-2"></i>
              <span>Updated Now</span>
            </div>
          </div>
      </div>
        <div class="col-xl-3 col-sm-3 p-2">
          <div class="card card-common">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <i class="fas fa-chart-line fa-3x text-danger"></i>  
                <div class="text-right text-secondary">
                  <h6>Visitors</h6>
                  <h5>55000</h5>
                </div>
              </div>
            </div>
            <div class="card-footer text-secondary">
              <i class="fas fa-sync mr-2"></i>
              <span>Updated Now</span>
            </div>
          </div>
      </div>
      </div>
    </div>
  </div>
</div>
 {{-- Card End --}}
 
 {{-- Table Start --}}
 <div class="container-fluid">
   <div class="row mb-2">
     <div class="col-md-12 ml-auto">
      <div class="row">
        <div class="col-6">
          <h3 class="text-muted text-center mb-1">Staff Salary</h3>
          <table class="table  bg-light text-center">
            <thead>
              <tr class="text-muted">
                <th>#</th>
                <th>Name</th>
                <th>Salary</th>
                <th>Date</th>
                <th>Contact</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Rahul</td>
                <td>৳ 1500</td>
                <td>07-20</td>
                <td><button type="button" class="btn btn-primary btn-sm">Message</button></td>
              </tr>
              <tr>
                <td>2</td>
                <td>John</td>
                <td>৳ 1500</td>
                <td>07-20</td>
                <td><button type="button" class="btn btn-primary btn-sm">Message</button></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Soumi</td>
                <td>৳ 2500</td>
                <td>07-20</td>
                <td><button type="button" class="btn btn-primary btn-sm">Message</button></td>
              </tr>
            </tbody>
          </table>

          {{-- Pagination --}}
          <nav>
            <ul class="pagination justify-content-center">
              <li class="page-item">
                <a href="#" class="page-link py-1 px-2">
                  <span>&laquo;</span>
                </a>
              </li>
              <li class="page-item active">
                <a href="#" class="page-link py-1 px-2">1</a>
              </li>
              <li class="page-item">
                <a href="#" class="page-link py-1 px-2">2</a>
              </li>
              <li class="page-item">
                <a href="#" class="page-link py-1 px-2">3</a>
              </li>
              <li class="page-item">
                <a href="#" class="page-link py-1 px-2">
                  <span>&raquo;</span>
                </a>
              </li>

            </ul>
          </nav>
          {{-- End of Pagination --}}
        </div>

        <div class="col-6">
          <h3 class="text-muted text-center mb-1">Recent Payment</h3>
          <table class="table table-dark table-hover text-center">
            <thead>
              <tr class="text-muted">
                <th>#</th>
                <th>Name</th>
                <th>Salary</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Drabid</td>
                <td>৳ 1500</td>
                <td>07-20</td>
                <td><span class="badge badge-success w-75 py-.5">Approved</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td>Sohn</td>
                <td>৳ 2500</td>
                <td>07-20</td>
                <td><span class="badge badge-danger w-75 py-.5">Pending</span></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Milon</td>
                <td>৳ 6500</td>
                <td>07-20</td>
                <td><span class="badge badge-success w-75 py-.5">Approved</span></td>
              </tr>
              <tr>
                <td>4</td>
                <td>Milon</td>
                <td>৳ 3500</td>
                <td>07-20</td>
                <td><span class="badge badge-danger w-75 py-.5">Pending</span></td>
              </tr>
            </tbody>
          </table>
          {{-- 2nd Pagination --}}
          <nav>
            <ul class="pagination justify-content-center">
              <li class="page-item">
                <a href="#" class="page-link py-1 px-2">
                  <span>Previous</span>
                </a>
              </li>
              <li class="page-item active">
                <a href="#" class="page-link py-1 px-2">1</a>
              </li>
              <li class="page-item">
                <a href="#" class="page-link py-1 px-2">2</a>
              </li>
              <li class="page-item">
                <a href="#" class="page-link py-1 px-2">3</a>
              </li>
              <li class="page-item">
                <a href="#" class="page-link py-1 px-2">
                  <span>Next</span>
                </a>
              </li>

            </ul>
          </nav>
          {{-- End of Pagination --}}
        </div>
        
      </div>
     </div>
   </div>
 </div>

 {{-- Tale End--}}

{{-- Chart Start--}}
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6"> 
      <div id="piechart" class="card-common">
      </div>
      </div>
    <div class="col-md-6">
      <div id="chart_div" class="pie-chart  card-common"></div>
    </div>
  </div>
 {{-- Modal Start --}}
  <div class="row mt-3">
    <div class="col-md-4">
     


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Team Type
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Select Team Type</h5>
            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> --}}
          </div>

          {{-- Main Body --}}

          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6"><button type="button" class="btn btn-secondary" data-dismiss="modal">Team Type One</button></div>
                <div class="col-md-6 ml-auto">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Team Type Two</button>
                </div>
              </div>
              <div class="row">
               
                <div class="col-md-6">
                  <button type="button" class="btn btn-secondary mt-1" data-dismiss="modal">Team Type Three</button>
                </div>              
               
              </div>
              {{-- <div class="row">
                <div class="col-md-3 ml-auto">.col-md-3 .ml-auto</div>
                <div class="col-md-2 ml-auto">.col-md-2 .ml-auto</div>
              </div> --}}
            </div>
          </div>



          <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>



















    </div>
  </div>

 {{-- Modal End --}}
</div>

{{-- Chart End--}}

 {{-- Pie Chart Start--}}
 {{-- <div id="piechart" style="width: 900px; height: 500px;"></div> --}}




 {{-- Pie Chart End--}}






@endsection

@section('footer-script')


@endsection

