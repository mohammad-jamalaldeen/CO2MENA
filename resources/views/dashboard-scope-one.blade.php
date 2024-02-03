@extends('frontend.layouts.main')

@section('title')
    Scope 1 Activities
@endsection
@foreach ($publishSheetArr as $sheet)
    @if (!empty($sheet['datasheets']['emission_calculated']) && $sheet['datasheets']['emission_calculated'] != '-')
            @php
                $uploadsheet = explode('calculated_datasheet/', $sheet['datasheets']['emission_calculated']);
                $filename = $uploadsheet[1];
                $uploadsheetname = $sheet['datasheets']['calculated_file_name'];
                $reportingDate = date('d-m-Y', strtotime($sheet['datasheets']['reporting_start_date'])) . '-' . date('d-m-Y', strtotime($sheet['datasheets']['reporting_end_date']));
                $name = $uploadsheetname . '-' . $reportingDate;
            @endphp
    @endif
@endforeach
@section('content')
    <div id="loader">
        <div class="loader-inner">
            <img src="{{ asset('assets/loader.gif') }}" alt="loader" title="loader"/>
        </div>
    </div>
    <div class="row align-items-center mt-4">
        <div class="col-md-6 col-12">
            <h2 class="main-title">Scope 1 Activities</h2>
        </div>
        <div class="col-md-6 col-12">

            <div class="export-line export-backend front-export">
                @if (array_sum($total) != 0)
                    <form method="POST" action="{{ route('dashboard.scope-one-pdf', ['name' => $name]) }}"
                        enctype="multipart/form-data" id="graph-form">
                        @csrf
                        <input type="hidden" name="totalEmissions" id="totalEmissionsInput">
                        <input type="hidden" name="totalFuel" id="totalFuelInput">
                        <div class="hidden-column"></div>
                        <button type="button" title="export" id="downloadBtn" class="export-button {{ frontendPermissionCheck('dashboard.download') === false ? 'd-none' : 'd-block' }}" value="downloadpdf">
                            <picture>
                                <img src="{{ asset('assets/images/export-icon.svg') }}" alt="export-icon" width=""
                                    height="" title="export-icon">
                            </picture>EXPORT</a>
                        </button>
                    </form>
                @endif
                @if (!empty($publishSheetArr) && count($publishSheetArr) > 0)
                    <div class="year-filter">
                        <span class="calendar-icon">
                            <picture>
                                <img src="{{ asset('assets/images/export-icon.svg') }}" alt="export-icon" width=""
                                    height="" title="export-icon">
                            </picture>
                        </span>
                        All Published Sheets
                        <span class="down-arrow">
                            <picture>
                                <img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-arrow" width="6"
                                    height="10" title="back-arrow">
                            </picture>
                        </span>
                        <div class="year-filter-list">
                            <div class="custome-checkbox">
                                @foreach ($publishSheetArr as $sheet)
                                    @if (!empty($sheet['datasheets']['emission_calculated']) && $sheet['datasheets']['emission_calculated'] != '-')
                                        <label class="checkbox">
                                            @php
                                                $uploadsheet = explode('calculated_datasheet/', $sheet['datasheets']['emission_calculated']);
                                                $filename = $uploadsheet[1];
                                                $uploadsheetname = $sheet['datasheets']['calculated_file_name'];
                                                $reportingDate = date('d-m-Y', strtotime($sheet['datasheets']['reporting_start_date'])) . ' - ' . date('d-m-Y', strtotime($sheet['datasheets']['reporting_end_date']));
                                            @endphp
                                            <input type="radio" {{ $result == $filename ? 'checked' : '' }}
                                                data-name="{{ $filename }}" id="{{ $filename }}">
                                            {{ $uploadsheetname }},
                                            {{ $reportingDate }}<span class="checkmark"></span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if (array_sum($total) == 0)
        <h5 class="text-center mt-4">No Data Found</h5>
    @else
        <section class="membercount-section front-membercount-section">

            <ul>
                <li class="flex-column">
                    <div class="totle-text">TOTAL EMISSIONS</div>
                    <div class="totle-number" id="totalEmissions">{{ number_format(array_sum($total), 2) }}<span>Kg CO2-eq</span></div>
                </li>
                <li class="flex-column">
                    <div class="totle-text">ALL TYPES OF FUEL USED</div>
                    <div class="totle-number" id="totalFuel">{{ number_format(array_sum($totalFuel), 2) }}<span>LITERS</span></div>
                </li>
            </ul>
        </section>
        <div id="dashboard">
            <section class="graph-section">
                <ul>
                    <li>
                        <div class="graph-headding">
                            <h4>Overview</h4>
                        </div>
                        <div id="doughnutChartContainer">
                            <canvas id="myDoughnutChart" width="400" height="400"></canvas>
                        </div>
                    </li>
                    @if (in_array('Owned vehicles', $filteredArray))
                        @php
                            $filteredArray[] = 'Passenger Vehicles';
                            $filteredArray[] = 'Delivery Vehicles';
                            unset($filteredArray[array_search('Owned vehicles', $filteredArray)]);
                        @endphp
                    @endif
                    @foreach ($filteredArray as $scope)
                        @if (!in_array($scope, $unsetlabels))
                            <li>
                                <div class="graph-headding">
                                    <h4>{{ $scope }}</h4>
                                </div>
                                <div id="barChartContainer">
                                    <canvas id="{{ $scope == 'T&D' ? 'transmission' : generateSlug($scope) }}"
                                        width="400" height="400"></canvas>

                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </section>
        </div>
    @endif
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/Chart.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    @php
        $datakey = $datavalue = '';

    @endphp

    {{-- @foreach ($dataArray as $key => $data)
        @php
            $datakey = json_encode(array_keys($data));
            $datavalue = json_encode(array_values($data));
            $id = $key == 'T&D' ? 'transmission' : $key;
        @endphp
        <script type="text/javascript">
            document.getElementById('loader').style.display = 'block';
            document.addEventListener('DOMContentLoaded', function() {
                var emissionChart;
                var data_emission = {!! $datavalue !!};
                var labels_emission = {!! $datakey !!};

                function emissionChart(dataemisssion, labels_emission) {
                    var ctxBar = document.getElementById("{{ $id }}");
                    if (ctxBar) {
                        ctxBar = ctxBar.getContext('2d');
                    }
                    var barData = {
                        labels: labels_emission,
                        datasets: [{
                            data: dataemisssion,
                            backgroundColor: [
                                'rgb(169, 169, 169)',
                                'rgb(50, 174, 89)',
                                'rgb(169, 169, 169)',
                                'rgb(50, 174, 89)',
                                'rgb(169, 169, 169)',
                                'rgb(50, 174, 89)',
                                'rgb(169, 169, 169)'
                            ],
                            borderWidth: 2,
                        }]
                    };
                    var barOptions = {
                        responsive: true,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                stacked: true,
                                grid: {
                                    display: true
                                },
                                stepSize: Math.min(dataemisssion),
                                max: Math.max(dataemisssion),
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        y: {
                            stacked: true,
                            grid: {
                                display: true
                            },
                            stepSize: Math.min(dataemisssion),
                            max: Math.max(dataemisssion),
                        }
                    };
                    emissionChart = new Chart(ctxBar, {
                        type: 'bar',
                        data: barData,
                        options: barOptions
                    });
                }
                setTimeout(function() {
                    emissionChart(data_emission, labels_emission);
                    document.getElementById('loader').style.display = 'none';
                }, 2000);
            });
        </script>
    @endforeach --}}
    @if (!empty($piecahrtArr) && count($piecahrtArr) > 0)
        @php
            $lablePie = json_encode(array_keys($piecahrtArr));
            $pieValuedata = array_values($piecahrtArr);
            $pieValuedata = json_encode($pieValuedata);
            $colorcodeObject = json_encode(colorCodeStaticArray());
            // $colorArray = [];
            // for($i = 0; $i < count(array_values($piecahrtArr)); $i++)
            // {
            //     array_push($colorArray, colorCodeArray($i));
            // }
            // $colorCodeObject = json_encode($colorArray);
        @endphp
        {{-- <script>
            var data = [{
                data: {!! $pieValuedata !!},
                backgroundColor: [
                    "#4b77a9",
                    "#5f255f",
                    "#d21243",
                    "#FF7F50",
                    '#6f42c1',
                    '#0dcaf0',
                    '#20c997'
                ],
                borderColor: "#fff"
            }];

            var options = {
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    enabled: false
                },
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            const datapoints = ctx.chart.data.datasets[0].data;
                            const total = datapoints.reduce((total, datapoint) => total + datapoint, 0);
                            const percentage = value / total * 100;
                            if (percentage != 0 || percentage != 0.00) {
                                return percentage.toFixed(2) + "%";
                            } else {
                                return '';
                            }
                        },
                        color: 'white',
                        anchor: 'center',
                        align: 'center',
                        offset: 5,

                        font: {
                            size: 16,
                            weight: 'bold',
                            color: '#204C65',
                        }
                    },
                    legend: {
                        position: 'right',
                        font: {
                            size: 16,
                            weight: 'bold',
                            color: '#204C65',
                        }
                    }
                }
            };


            setTimeout(function() {
                var ctx = document.getElementById("myDoughnutChart");
                if (ctx) {
                    ctx = ctx.getContext('2d');
                }
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! $lablePie !!},
                        datasets: data
                    },
                    options: options,
                    plugins: [ChartDataLabels],
                });
            }, 2000);
        </script> --}}

        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                let labels = {!! $lablePie !!};
                let dataValues = {!! $pieValuedata !!};
                let total = dataValues.reduce((acc, val) => acc + val, 0);
                let percentages = dataValues.map(value => ((value / total) * 100).toFixed(2));
                let ctx = document.getElementById('myDoughnutChart').getContext('2d');
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
    @endif
    <script type="text/javascript">
        $("input[type='radio']").change(function() {
            var filename = $(this).data('name');
            if (filename != '' && filename != 'undefined') {
                var url = "{{ route('dashboard.scope1') }}";
                window.location.href = url + '?datasheet=' + filename;
            }
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
        document.getElementById('downloadBtn').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('loader').style.display = 'block';
            var promises = chartData();
            var totalEmissions = document.getElementById('totalEmissions').innerText;
            var totalFuel = document.getElementById('totalFuel').innerText;
            var html = "";
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
                $("#totalFuelInput").val(totalFuel);
                setTimeout(function() {

                    document.getElementById('graph-form')
                        .submit();
                    document.getElementById('loader').style.display = 'none';
                }, 2000);
            });
        });
    </script>
    @foreach ($newDataArray as $key => $value)
        @php
            $labels = json_encode($value['labels']);
            $datasets = json_encode($value['datasets']);
            $datasets1 = array_filter($value['datasets'], function ($dataset) {
                return $dataset['label'] !== ' (0)' && $dataset['label'] !== '-' && $dataset['label'] !== 'null';
            });
            $height = 400;
            if (count(array_values($datasets1)) > 25 && count(array_values($datasets1)) < 35) {
                $height = 600;
            } elseif (count(array_values($datasets1)) > 35) {
                $height = 1000;
            }
            $id = $key == 'T&D' ? 'transmission' : generateSlug($key);
        @endphp
        <script type="text/javascript">
            var height = "{{ $height }}";
            $('#{{ $id }}').attr('height', height)
            if ($('#{{ $id }}').html() != undefined) {
                new Chart({{ $id }}, {
                    type: 'bar',
                    data: {
                        labels: {!! $labels !!},
                        datasets: {!! $datasets !!}
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
        </script>
    @endforeach
@endsection
