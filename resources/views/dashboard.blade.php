@extends('frontend.layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
        <div id="full-dashboard-overview">
            <div class="row align-items-center mt-4">
                <div class="col-md-6 col-12">
                    <h2 class="main-title ">Dashboard</h2>
                </div>
                <div class="col-md-6 col-12">
                    <div class="export-line">
                        <form method="POST" action="{{ route('dashboard.generate-pdf') }}" enctype="multipart/form-data"
                            id="graph-form">
                            @csrf
                            <input type="hidden" name="totalEmissions" id="totalEmissionsInput">
                            <input type="hidden" name="totalfuelused" id="totalfuelusedInput">
                            <input type="hidden" name="totalenergyused" id="totalenergyusedInput">
                            <div class="hidden-column"></div>
                            <button type="submit" title="export" id="downloadBtn" class="export-button {{ frontendPermissionCheck('dashboard.download') === false ? 'd-none' : 'd-block' }}" value="downloadpdf">
                                <picture>
                                    <img src="{{ asset('assets/images/export-icon.svg') }}" alt="export-icon" title="export-icon" width=""
                                        height="">
                                </picture>EXPORT</a>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <section class="membercount-section front-membercount-section">
                <ul>
                    <li class="flex-column"> 
                        <div class="totle-text">TOTAL EMISSIONS</div>
                        <div class="totle-number" id="totalEmissions">
                            <!-- {{ isset($totalSum) ? number_format($totalSum, 2) : '0' }} -->
                            25,817
                            <span>kgCO2e</span><div>
                    </li>
                    {{-- <li>
                        <div class="totle-text">ALL TYPE OF FUEL USED</div>
                        <div class="totle-number" id="totalfuelused">
                            {{ isset($totalFuel) ? $totalFuel : '0' }}</div>
                    </li> --}}
                    <li class="flex-column">
                        <div class="totle-text">TOTAL ENERGY USED</div>
                        <div class="totle-number" id="totalenergyusedcount">
                        232,898    
                        <!-- {{ isset($totalEnergy) ? number_format($totalEnergy, 2) : '' }} -->
                            <span>kWh</span>
                        </div>
                    </li>
                </ul>
            </section>
            <div id="dashboard">
                <section class="graph-section">
                    <ul>
                        <li>
                            <div class="graph-headding">
                                <h4>TOTAL EMISSIONS</h4>
                            </div>
                            <div id="doughnutChartContainer" >
                                <!-- <canvas id="total emissions" width="400" height="400"></canvas> -->
                                <!-- image('assets/images/abc.png', 'a picture') }} -->
                                <!-- <picture> -->
                                    <img src="{{ asset('assets/images/1.png') }}" alt="export-icon" title="export-icon" width="1000" height="1000">
                                <!-- </picture>  -->
                            </div>
                        </li>
                        {{-- @if ($totalFuel > 0)
                            <li>
                                <div class="graph-headding">
                                    <h4>ALL TYPE OF FUEL USED</h4>
                                </div>

                                <div id="barChartContainer">
                                    <canvas id="all type of fuel used" width="400" height="400"></canvas>
                                </div>
                            </li>
                        @endif --}}
                        @if ($totalEnergy > 0)
                            <li>
                                <div class="graph-headding">
                                    <h4>TOTAL ENERGY USED</h4>
                                </div>
                                <div id="lineChartContainer">
                                    <canvas id="total energy used" width="400" height="400"></canvas>
                                </div>
                            </li>
                        @endif
                    </ul>
                </section>
            </div>
        </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/Chart.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    @php
        $datakey = json_encode(array_keys($sumtotalFuelArray));
        $datavalue = json_encode(array_values($sumtotalFuelArray));
        $dataEnergyKey = json_encode($sumtotalEnerygArray['labels']);
        $dataEnergyValue = json_encode(array_values($sumtotalEnerygArray['datasets']));
        $colorcodeObject = json_encode(colorCodeStaticArray());
    @endphp
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            let labels = ['Scope One', 'Scope Two', 'Scope Three'];
            let dataValues = [
                {{ $sumTotal1 }},
                {{ $sumTotal2 }},
                {{ $sumTotal3 }}
            ];
            let total = dataValues.reduce((acc, val) => acc + val, 0);
            let percentages = dataValues.map(value => ((value / total) * 100).toFixed(2));
            let ctx = document.getElementById('total emissions').getContext('2d');
            let chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels.map((label, i) => `${label} (${percentages[i]}%)`),
                    datasets: [{
                        data: dataValues,
                        backgroundColor: {!! $colorcodeObject !!}
                    }]
                }
            });
        });
    </script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {

            // var promises = chartData();
            // // Doughnut Chart
            // const data = {
            //     labels: ['Scope One', 'Scope Two', 'Scope Three'],
            //     datasets: [{
            //         data: [
            //             {{ $sumTotal1 }},
            //             {{ $sumTotal2 }},
            //             {{ $sumTotal3 }}
            //         ],
            //         backgroundColor: ['#4b77a9', '#5f255f', '#d21243']
            //     }]
            // };
            // const config = {
            //     type: 'doughnut',
            //     data,
            //     options: {
            //         responsive: true,
            //         maintainAspectRatio: false,
            //         position: 'right',
            //         scales: {

            //         },
            //         plugins: {
            //             tooltip: {
            //                 enabled: true
            //             },
            //             datalabels: {
            //                 formatter: function(value, context) {
            //                     var dataset = context.chart.data.datasets[context.datasetIndex];
            //                     var total = dataset.data.reduce(function(previousValue, currentValue) {
            //                         return previousValue + currentValue;
            //                     });
            //                     var currentValue = dataset.data[context.dataIndex];

            //                     // Check if the current value is non-zero before calculating percentage
            //                     if (currentValue !== 0) {
            //                         var percentage = ((currentValue / total) * 100).toFixed(
            //                             2); // Set the number of decimal places here
            //                         return percentage + "%";
            //                     } else {
            //                         return ''; // Return an empty string if the value is zero
            //                     }
            //                 },

            //                 color: 'white',
            //                 anchor: 'center',
            //                 align: 'center',
            //                 offset: 5,

            //                 font: {
            //                     size: 16,
            //                     weight: 'bold',
            //                     color: '#204C65',
            //                 }
            //             },
            //             legend: {
            //                 position: 'right',
            //                 font: {
            //                     size: 16,
            //                     weight: 'bold',
            //                     color: '#204C65',
            //                 }
            //             }
            //         },
            //     },

            //     plugins: [ChartDataLabels]
            // };
            // const totalemissions = new Chart(
            //     document.getElementById('total emissions'),
            //     config
            // );
            // Bar chart
            var myBarChart;
            var dataChartUser = {!! $datavalue !!};
            var labels_user = {!! $datakey !!};
            // function TotalFuelChart(dataChartUser, labels_user) {
            //     if (myBarChart) {
            //         myBarChart.destroy(); // Destroy the existing chart
            //     }
            //     var ctxBar = document.getElementById('all type of fuel used');
            //     if (ctxBar) {
            //         ctxBar = ctxBar.getContext('2d');
            //     }
            //     var barData = {
            //         labels: labels_user,
            //         datasets: [{
            //             data: dataChartUser,
            //             backgroundColor: [
            //                 'rgb(169, 169, 169)',
            //                 'rgb(50, 174, 89)',
            //                 'rgb(169, 169, 169)',
            //                 'rgb(50, 174, 89)',
            //                 'rgb(169, 169, 169)',
            //                 'rgb(50, 174, 89)',
            //                 'rgb(169, 169, 169)'
            //             ],
            //             borderWidth: 1
            //         }]
            //     };
            //     var barOptions = {
            //         scales: {
            //             x: {
            //                 grid: {
            //                     display: false
            //                 }
            //             },
            //             y: {
            //                 beginAtZero: true,
            //                 grid: {
            //                     display: false
            //                 },
            //                 stepSize: Math.min(dataChartUser),
            //                 max: Math.max(dataChartUser),
            //             }
            //         },
            //         plugins: {
            //             legend: {
            //                 display: false
            //             }
            //         }
            //     };
            //     myBarChart = new Chart(ctxBar, {
            //         type: 'bar',
            //         data: barData,
            //         options: barOptions
            //     });
            // }
            // TotalFuelChart(dataChartUser, labels_user);

            // Energy Bar Chart
            var totalenergyused;

            function TotalEnergyChart() {
                new Chart('total energy used', {
                    type: 'bar',
                    data: {
                        labels: {!! $dataEnergyKey !!}, // responsible for how many bars are gonna show on the chart
                        // create 12 datasets, since we have 12 items
                        // data[0] = labels[0] (data for first bar - 'Standing costs') | data[1] = labels[1] (data for second bar - 'Running costs')
                        // put 0, if there is no data for the particular bar
                        datasets: {!! $dataEnergyValue !!}
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top' // place legend on the right side of chart
                        },
                        scales: {
                            xAxes: [{
                                stacked: true // this should be set to make the bars stacked
                            }],
                            yAxes: [{
                                stacked: true // this also..
                            }]
                        }
                    }
                });

            }
            TotalEnergyChart()
        });

        function chartData(param) {


            var inputname = [];
            var canvasData = [];
            var html = "";
            $('.graph-section ul li canvas').each(function(key, index) {
                var idname = $(index).attr('id');
                canvasData.push(html2canvas(document.getElementById(idname)));
                inputname.push(idname);
            });
            var promises = [
                Promise.all(canvasData),
                inputname
            ];
            return promises;
        }

        document.getElementById('graph-form').addEventListener('submit', function(event) {

            event.preventDefault(); // Prevent the form from submitting

            // Show the loader
            document.getElementById('loader').style.display = 'block';
            var promises = chartData();
            var totalEmissions = document.getElementById('totalEmissions').innerText;
            //var totalfuelused = document.getElementById('totalfuelused').innerText;
            var totalenergyusedcount = document.getElementById('totalenergyusedcount').innerText;
            var chart = [];

            Promise.all(promises).then(function([allChartcanvas, inputname]) {
                $(allChartcanvas).each(function(key, index) {
                    var imageData = index.toDataURL();
                    chart.push({
                        [inputname[key]]: imageData
                    });
                });

                $(".hidden-column").html('<input type="hidden" name="allchart">');
                $('[name="allchart"]').attr('value', JSON.stringify(chart));

                $("#totalEmissionsInput").val(totalEmissions);
                //$("#totalfuelusedInput").val(totalfuelused);
                $("#totalenergyusedInput").val(totalenergyusedcount);

                setTimeout(function() {
                    document.getElementById('loader').style.display = 'none';
                    document.getElementById('graph-form')
                        .submit();
                }, 1000);
            });
        });
    </script>
@endsection
