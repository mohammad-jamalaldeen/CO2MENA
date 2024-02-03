@extends('admin.layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <style>
        .loader {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid #000;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -20px;
            margin-left: -20px;
            display: none;
            /* Initially hide the loader */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div class="export-line export-backend">
        {{-- <a href="#" class="export-button" id="download-button">
            Download as PDF
        </a> --}}
        <form action="{{ route('dashboard.print-chart') }}" method="post" enctype="multipart/form-data" id="graph-form">
            @csrf
            {{-- <input type="hidden" name="ChartData" id="chartInputData"> --}}
            <input type="hidden" name="totalDatasheets" id="totalDatasheetsInput">
            <input type="hidden" name="totalSubAdminMembers" id="totalSubAdminMembersInput">
            <input type="hidden" name="totalCustomereMembers" id="totalCustomereMembersInput">
            {{-- <input type="hidden" name="doughnutImageData" id="chartInputData">
            <input type="hidden" name="barImageData" id="chartInputData2">
            <input type="hidden" name="lineImageData" id="chartInputData3"> --}}
            <div class="hidden-column"></div>
            {{-- <input  value="Download PDF" class="export-button"> --}}

            <button type="submit" title="export" class="export-button {{ adminPermissionCheck('dashboard.print-chart') === false ? 'd-none' : 'd-block' }}">
                <picture>
                    <img src="{{ asset('assets/images/export-icon.svg') }}" alt="export-icon" title="export-icon" width="" height="">
                </picture>EXPORT</a>
            </button>

        </form>
    </div>
    <div id="dashboard">
        <section class="membercount-section">
            <ul>
                <li>
                    <a href="{{ route('datasheet.index') }}" class="totle-text">Activity Sheets</a>
                    <div class="totle-number" id="totalDatasheets">
                        {{ isset($totalDatasheetsCount) ? $totalDatasheetsCount : '0' }}</div>
                </li>
                <li>
                    <a href="{{ route('sub-admin.index') }}" class="totle-text">TOTAL SUB ADMIN MEMBERS</a>
                    <div class="totle-number" id="totalSubAdminMembers">
                        {{ isset($totalSubAdminCount) ? $totalSubAdminCount : '0' }}</div>
                </li>
                <li>
                    <a href="{{ route('customer.index') }}" class="totle-text">TOTAL CUSTOMER MEMBERS</a>
                    <div class="totle-number" id="totalCustomereMembers">
                        {{ isset($totalCustomerCount) ? $totalCustomerCount : '0' }}</div>
                </li>
            </ul>
        </section>

        <section class="graph-section">
            <ul>
                @if($totalDatasheetsCount > 0)
                <li>
                    <div class="graph-headding">
                        <h4>UPLOADED Activity Sheets</h4>
                    </div>
                    <div id="doughnutChartContainer">
                        <canvas id="uploaded datasheets" width="400" height="400"></canvas>
                    </div>
                </li>
                 @endif
                 @if($totalCustomerCount > 0)
                <li>
                    <div class="graph-headding">
                        <h4>NEW Customer MEMBERS</h4>
                        <select id="time_period_customer" class="graph-filter" name="time_period_customer">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div id="barChartContainer">
                        <canvas id="new customer members" width="320px" height="320px"></canvas>
                    </div>
                </li>
                @endif
                @if($totalSubAdminCount > 0)
                <li>
                    <div class="graph-headding">
                        <h4>New Sub Admin Members</h4>
                        <select id="time_period_subadmin" class="graph-filter" name="time_period_subadmin">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div id="lineChartContainer">
                        <canvas id="new sub admin members" width="320px" height="320px"></canvas>
                    </div>
                </li>
                @endif
            </ul>
        </section>
    </div>
    <div id="loader">
        <div class="loader-inner">
            <img src="{{asset('assets/loader.gif')}}" alt="loader" title="loader"/>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/chart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/chartjs-plugin-datalabels.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/html2canvas.min.js') }}"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            let labels = ['Completed', 'In Progress', 'Uploded', 'Published', 'Failed', 'Draft'];
            let dataValues = [
                        {{ $doughnutData->completedCount }},
                        {{ $doughnutData->inProgressCount }},
                        {{ $doughnutData->uploadedCount }},
                        {{ $doughnutData->publishedCount }},
                        {{ $doughnutData->failedCount }},
                        {{ $doughnutData->draftCount }}
                    ];
            let total = dataValues.reduce((acc, val) => acc + val, 0);
            let percentages = dataValues.map(value => ((value / total) * 100).toFixed(2));
            let ctx = document.getElementById('uploaded datasheets').getContext('2d');
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
            var promises = chartData();

            $('#time_period_subadmin').change(function() {
                var timePeriodSubAdmin = $(this).val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: 'dashboard',
                    type: 'post',
                    //contentType: 'application/json;charset=UTF-8',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        time_period_subadmin: timePeriodSubAdmin
                    },
                    success: function(responseData) {
                        if (responseData.success) {
                            var dataChartSubAdmin = responseData.dataChartSubAdmin;
                            var labels_subadmin = responseData.labels_subadmin;
                            updateChartSubAdmin(dataChartSubAdmin, labels_subadmin);
                            var promises = chartData();
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        } 
                    }
                });
            });
            var myCurvedLineChartSubadmin;
            var dataChartSubAdmin = {!! json_encode($dataChartSubAdmin) !!};
            var labels_subadmin = {!! json_encode($labels_subadmin) !!};


            function updateChartSubAdmin(dataChartSubAdmin, labels_subadmin) {
                if (myCurvedLineChartSubadmin) {
                    myCurvedLineChartSubadmin.destroy();
                }
                var ctxCurvedLineSubAdmin = document.getElementById('new sub admin members');
                if (ctxCurvedLineSubAdmin) {
                    ctxCurvedLineSubAdmin = ctxCurvedLineSubAdmin.getContext('2d');
                }
                var curvedLineData = {
                    labels: labels_subadmin,
                    datasets: [{
                        label: 'Data Series 1',
                        data: dataChartSubAdmin,
                        borderColor: '#4A708B',
                        borderWidth: 2,
                        fill: false,
                        lineTension: 0.4,
                        pointHoverRadius: 10
                    }]
                };
                var curvedLineOptions = {
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            min: 0,
                            max: 10,
                            stepSize: 1,
                            position: 'right',
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                };

                myCurvedLineChartSubadmin = new Chart(ctxCurvedLineSubAdmin, {
                    type: 'line',
                    data: curvedLineData,
                    options: curvedLineOptions
                });
            }
            updateChartSubAdmin(dataChartSubAdmin, labels_subadmin);
            // Pie Chart
            // const data = {
            //     labels: ['Completed', 'In Progress', 'Uploded', 'Published', 'Failed', 'Draft'],
            //     datasets: [{
            //         data: [
            //             {{ $doughnutData->completedCount }},
            //             {{ $doughnutData->inProgressCount }},
            //             {{ $doughnutData->uploadedCount }},
            //             {{ $doughnutData->publishedCount }},
            //             {{ $doughnutData->failedCount }},
            //             {{ $doughnutData->draftCount }}
            //         ],
            //         backgroundColor: ['rgb(50, 174, 89)', '#204C65', '#93BDB9',
            //             '#5A6EDC', '#d35f5f', '#A5B6C1'
            //         ]
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
            //             datalabels: {
            //                 formatter: function(value, context) {
            //                     var dataset = context.chart.data.datasets[context.datasetIndex];
            //                     var total = dataset.data.reduce(function(previousValue, currentValue) {
            //                         return previousValue + currentValue;
            //                     });
            //                     var currentValue = dataset.data[context.dataIndex];

            //                     // Check if the current value is non-zero before calculating percentage
            //                     if (currentValue !== 0) {
            //                         var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
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
            // const myDoughnutChart = new Chart(
            //     document.getElementById('uploaded datasheets'),
            //     config
            // );
            // Bar Chart
            // Define variables globally
            var myBarChart;
            var dataChartCustomer = {!! json_encode($dataChartCustomer) !!};
            var labels_customer = {!! json_encode($labels_customer) !!};

            // Function to update the bar chart
            function updateChartCustomer(dataChartCustomer, labels_customer) {
                if (myBarChart) {
                    myBarChart.destroy(); // Destroy the existing chart
                }

                var ctxBar = document.getElementById('new customer members');
                if (ctxBar) {
                    ctxBar = ctxBar.getContext('2d');
                }
                var barData = {
                    labels: labels_customer,
                    datasets: [{
                        data: dataChartCustomer,
                        backgroundColor: {!! $colorcodeObject !!},
                        borderWidth: 1
                    }]
                };
                var barOptions = {
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            },
                            stepSize: 20,
                            max: 50
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Hide the legend
                        }
                    }
                };

                myBarChart = new Chart(ctxBar, {
                    type: 'bar',
                    data: barData,
                    options: barOptions
                });
            }

            // Bar Chart Update on Time Period Change
            $('#time_period_customer').change(function() {
                var timePeriodCustomer = $(this).val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: 'dashboard',
                    type: 'post',
                    //contentType: 'application/json;charset=UTF-8',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        time_period_customer: timePeriodCustomer
                    },
                    success: function(responseData) {
                        if (responseData.success) {
                            var dataChartCustomer = responseData.dataChartCustomer;
                            var labels_customer = responseData.labels_customer;
                            updateChartCustomer(dataChartCustomer, labels_customer);
                            var promises = chartData();
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        } 
                    }
                });
            });
            updateChartCustomer(dataChartCustomer, labels_customer);
        });

        // function chartData(param) {
        //     var promises = [
        //         html2canvas(document.getElementById('myDoughnutChart')),
        //         html2canvas(document.getElementById('myBarChart')),
        //         html2canvas(document.getElementById('myCurvedLineChartSubadmin'))
        //     ];
        //     return promises;
        // }
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
            var totalDatasheets = document.getElementById('totalDatasheets').innerText;
            var totalSubAdminMembers = document.getElementById('totalSubAdminMembers').innerText;
            var totalCustomereMembers = document.getElementById('totalCustomereMembers').innerText;
            var chart = [];
            // Promise.all(promises).then(function([doughnutCanvas, barCanvas, lineCanvas]) {
            //     var doughnutImageData = doughnutCanvas.toDataURL();
            //     var barImageData = barCanvas.toDataURL();
            //     var lineImageData = lineCanvas.toDataURL();
            Promise.all(promises).then(function([allChartcanvas, inputname]) {
                $(allChartcanvas).each(function(key, index) {
                    var imageData = index.toDataURL();
                    chart.push({
                        [inputname[key]]: imageData
                    });
                });

                // $("#chartInputData").val(doughnutImageData);
                // $("#chartInputData2").val(barImageData);
                // $("#chartInputData3").val(lineImageData);
                $(".hidden-column").html('<input type="hidden" name="allchart">');
                $('[name="allchart"]').attr('value', JSON.stringify(chart));

                $("#totalDatasheetsInput").val(totalDatasheets);
                $("#totalSubAdminMembersInput").val(totalSubAdminMembers);
                $("#totalCustomereMembersInput").val(totalCustomereMembers);

                setTimeout(function() {
                    document.getElementById('loader').style.display = 'none';
                    document.getElementById('graph-form')
                        .submit();
                }, 1000);
            });
        });
    </script>
@endsection
