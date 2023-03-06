<x-layout>
    <x-item.pageheader> </x-item.pageheader>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        {{-- <h3>{{ nama }}</h3> --}}
                        <h3> 50 </h3>
                        <p>Pemasukan Qris</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        {{-- <h3>{{config('settings.currency_symbol')}}}</h3> --}}
                        <h3> 50 </h3>
                        <p>Pemasukan Cash</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        {{-- <h3>{{config('settings.currency_symbol')}} {{number_format(476, 2)}}</h3> --}}
                        <h3> 50 </h3>
                        <p>Barang Terjual</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ 5 }}</h3>

                        <p>Jumlah Pelanggan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    
                </div>
            </div>

        </div>
        <!-- ./col -->
        <div class="row">
            <div class="col-md-6">
                <!-- BAR CHART -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Grafik Penjualan</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">
              <!-- BAR CHART -->
              <div class="card card-success">
                  <div class="card-header">
                      <h3 class="card-title">Penjualan</h3>
                  </div>
                  <div class="card-body">
                    <form action="{{route('riwayat.filter')}}" method="post">
                      <div class="row">
                          @csrf
                          <input type="hidden" name="filter" value="1">
                          <div class="col-md-5">
                              <input type="date" name="start_date" class="form-control" value="{{date('Y-m-d')}}" required/>
                          </div>
                          <div class="col-md-5">
                              <input type="date" name="end_date" class="form-control" value="{{date('Y-m-d')}}" required/>
                          </div>
                          <div class="col-md-2">
                              <button class="btn btn-outline-primary" type="submit">Submit</button>
                          </div>
                      </div>
                  </form>
                      <table class="table mt-3">
                        <thead>
                          <td class="col-md-4">
                            
                          </td>
                          <td>
                            Cash
                          </td>
                          <td>
                            Qris
                          </td>
                          <td>
                            Total
                          </td>
                        </thead>
                        <tr>
                          <td class="col-md-4">
                            Filter
                          </td>
                          <td>
                            {{ number_format(20000, 0, '.', '.') }}
                          </td>
                          <td>
                            {{ number_format(30000, 0, '.', '.') }}
                          </td>
                          <td>
                            {{ number_format(50000, 0, '.', '.') }}
                          </td>
                        </tr>
                        <tr>
                          <td class="col-md-4">
                            7 Hari Terakhir
                          </td>
                          <td>
                            {{ number_format(20000, 0, '.', '.') }}
                          </td>
                          <td>
                            {{ number_format(30000, 0, '.', '.') }}
                          </td>
                          <td>
                            {{ number_format(50000, 0, '.', '.') }}
                          </td>
                        </tr>
                        <tr>
                          <td class="col-md-4">
                            Bulan ini
                          </td>
                          <td>
                            {{ number_format(20000, 0, '.', '.') }}
                          </td>
                          <td>
                            {{ number_format(30000, 0, '.', '.') }}
                          </td>
                          <td>
                            {{ number_format(50000, 0, '.', '.') }}
                          </td>
                        </tr>
                      </table>
                  </div>
                  <!-- /.card-body -->
              </div>
              <!-- /.card -->
          </div>
        </div>
    </div>


    @section('js')
        <script>
            $(function() {
                /* ChartJS
                 * -------
                 * Here we will create a few charts using ChartJS
                 */

                //--------------
                //- AREA CHART -
                //--------------

                // Get context with jQuery - using jQuery's .get() method.

                var areaChartData = {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                            label: 'Cash',
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: [28, 48, 40, 19, 86, 27, 90]
                        },
                        {
                            label: 'Qris',
                            backgroundColor: 'rgba(210, 214, 222, 1)',
                            borderColor: 'rgba(210, 214, 222, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(210, 214, 222, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data: [65, 59, 80, 81, 56, 55, 40]
                        },
                    ]
                }

                //-------------
                //- BAR CHART -
                //-------------
                var barChartCanvas = $('#barChart').get(0).getContext('2d')
                var barChartData = $.extend(true, {}, areaChartData)
                var temp0 = areaChartData.datasets[0]
                var temp1 = areaChartData.datasets[1]
                barChartData.datasets[0] = temp1
                barChartData.datasets[1] = temp0

                var barChartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false
                }

                new Chart(barChartCanvas, {
                    type: 'bar',
                    data: barChartData,
                    options: barChartOptions
                })
            })
        </script>
    @endsection
</x-layout>
