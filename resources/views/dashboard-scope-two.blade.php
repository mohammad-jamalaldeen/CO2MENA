@extends('frontend.layouts.main')

@section('title')
    Scope 2 Activities
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
            <img src="{{ asset('assets/loader.gif') }}" alt="loader" title="loader" />
        </div>
    </div>
    <div class="row align-items-center mt-4">
        <div class="col-sm-6 col-12">
            <h2 class="main-title">Scope 2 Activities</h2>
        </div>
        <div class="col-sm-6 col-12">
            <div class="export-line export-backend front-export">
                <form method="POST" action="{{ route('dashboard.scope-two-pdf',['name' => $name]) }}"
                    enctype="multipart/form-data" id="graph-form">
                    @csrf
                    <input type="hidden" name="totalemission" id="totalEmissionInput" value="{{ $totalEmission }}">
                    <input type="hidden" name="totalenergyused" id="totalEnergyusedInput" value="{{ $totalEnergyUsed }}">
                    <input type="hidden" name="totaltonofrefrigeration" id="totalTonofRefrigerationInput"
                        value="{{ $totalTonOfRefrigeration }}">
                    <div class="hidden-column"></div>
                    @if ($totalEmission != 0)
                        <button type="submit" id="downloadBtn" title="export" class="export-button {{ frontendPermissionCheck('dashboard.download') === false ? 'd-none' : 'd-block' }}" value="downloadpdf">
                            <picture>
                                <img src="{{ asset('assets/images/export-icon.svg') }}" alt="export-icon" title="export-icon" width=""
                                    height="">
                            </picture>EXPORT</a>
                        </button>
                    @endif
                </form>
                @if (!empty($publishSheetArr) && count($publishSheetArr) > 0)
                    <div class="year-filter">
                        <span class="calendar-icon">
                            <picture>
                                <img src="{{ asset('assets/images/export-icon.svg') }}" alt="export-icon" title="export-icon" width=""
                                    height="">
                            </picture>
                        </span>
                        All Published Sheets
                        <span class="down-arrow">
                            <picture>
                                <img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-arrow" title="back-arrow" width="6"
                                    height="10">
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
                                            <input type="radio" {{ $datasheetNew == $filename ? 'checked' : '' }}
                                                data-name="{{ $filename }}">{{ $uploadsheetname }},
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
    @if ($totalEmission == 0)
        <h5 class="text-center mt-4">No Data Found</h5>
    @else
        <section class="membercount-section dashboard-scope-two">
            {{-- <div class="export-line export-backend">
            <a href="{{ route('dashboard.generate-pdf', ['download' => 'pdf']) }}" class="export-button" id="downloadBtn">
                Download PDF
            </a> 
            <a href="{{ route('dashboard.index') }}" class="export-button">
                Overview
            </a>
            <a href="{{ route('dashboard.scope1') }}" class="export-button">
                Scope 1
            </a>
            <a href="{{ route('dashboard.scope2') }}" class="export-button">
                Scope 2
            </a>
            <a href="{{ route('dashboard.scope3') }}" class="export-button">
                Scope 3
            </a> 
        </div> --}}
            <ul>
                <li class="flex-column">
                    <div class="totle-text">TOTAL EMISSIONS </div>
                    <div class="totle-number" id="totalemission">
                        {{ number_format($totalEmission, 2) }}<span>Kg-co2-eq</span></div>
                </li>
                <li class="flex-column">
                    <div class="totle-text">TOTAL ENERGY USED </div>
                    <div class="totle-number" id="totalenergyused">
                        {{ number_format($totalEnergyUsed, 2) }}<span>Kwh</span></div>
                </li>
                <li class="flex-column">
                    <div class="totle-text">TON Of REFRIGERATION USED</div>
                    <div class="totle-number" id="totaltonofrefrigeration">{{ number_format($totalTonOfRefrigeration, 2) }}</div>
                </li>
            </ul>
        </section>
        <div id="dashboard">
            <section class="graph-section">
                <ul>
                    @if (count($electricityPieChartArray) > 0)
                        <li>
                            <div class="graph-headding">
                                <h4>Overview</h4>
                            </div>
                            <div id="doughnutChartContainer">
                                <canvas id="myDoughnutChart" width="400" height="400"></canvas>
                            </div>
                        </li>
                    @endif
                    @foreach ($scopeTwo as $scope)
                        @if ($scope != 'Electricity, heat, cooling')
                            <li>
                                <div class="graph-headding">
                                    <h4>{{ $scope }}</h4>
                                </div>
                                <div id="barChartContainer">
                                    <canvas id="{{ $scope == 'T&D' ? 'transmission' : $scope }}" width="400"
                                        height="400"></canvas>
                                </div>
                            </li>
                        @else
                            @if (array_key_exists('Electricity, heat, cooling', $dataArray))
                                @if (count($dataArray['Electricity, heat, cooling']) > 0)
                                    @foreach ($dataArray['Electricity, heat, cooling'] as $key => $value)
                                        @if (array_values($value)[0] != '-')
                                            <li>
                                                <div class="graph-headding">
                                                    <h4>{{ $key }}</h4>
                                                </div>
                                                <div id="barChartContainer">
                                                    <canvas id="{{ generateSlug($key) }}" width="400"
                                                        height="400"></canvas>
                                                </div>
                                            </li>
                                        @endif
                                        {{-- @if (isset($value['Electricity'], $value['District heat and steam'], $value['District cooling']) && $value['Electricity'] !== '-' && $value['District heat and steam'] !== '-' && $value['District cooling'] !== '-') --}}

                                        {{-- @endif --}}
                                    @endforeach
                                @endif
                            @endif
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
    @foreach ($dataArray as $key => $data)
        @if ($key != 'Electricity, heat, cooling')
            @php
                $datakey = json_encode(array_keys($data));
                $datavalue = json_encode(array_values($data));
                $colorValue = json_encode(colorCodeArray(count(array_values($data))));
                $id = $key == 'T&D' ? 'transmission' : $key;
            @endphp
            <script type="text/javascript">
                document.getElementById('loader').style.display = 'block';
                document.addEventListener('DOMContentLoaded', function() {
                    var emissionChart;
                    var data_emission = {!! $datavalue !!};
                    var labels_emission = {!! $datakey !!};
                    var color = {!! $colorValue !!};

                    function emissionChart(dataemisssion, labels_emission) {
                        var ctxBar = document.getElementById("{{ $id }}").getContext('2d');
                        var barData = {
                            labels: labels_emission,
                            datasets: [{
                                data: dataemisssion,
                                backgroundColor: color,
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
                                    stepSize: 1,
                                    max: 40
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        };
                        emissionChart = new Chart(ctxBar, {
                            type: 'bar',
                            data: barData,
                            options: barOptions
                        });
                    }

                    setTimeout(function() {
                        document.getElementById('loader').style.display = 'none';
                        emissionChart(data_emission, labels_emission);
                    }, 2000);
                });
            </script>
        @else
            @foreach ($data as $electriKey => $electriValue)
                @php

                    $labels = json_encode($electriValue['labels']);
                    $datasets = json_encode($electriValue['datasets']);

                    // $datakey = json_encode(array_keys($electriValue));
                    // $datavalue = json_encode(array_values($electriValue));
                    // $colorCodeValue = json_encode(colorCodeArray(count(array_values($electriValue))));
                    // $title = $electriKey;
                    $id = generateSlug($electriKey);

                @endphp
                <script type="text/javascript">
                    document.getElementById('loader').style.display = 'block';
                    document.addEventListener('DOMContentLoaded', function() {
                        var emissionChart;
                        // var labels = {!! $labels !!};
                        // var datasets = {!! $datasets !!};
                        function emissionChart() {
                            var chart = new Chart('{{ $id }}', {
                                type: 'bar',
                                data: {
                                    labels: {!! $labels !!}, // responsible for how many bars are gonna show on the chart
                                    // create 12 datasets, since we have 12 items
                                    // data[0] = labels[0] (data for first bar - 'Standing costs') | data[1] = labels[1] (data for second bar - 'Running costs')
                                    // put 0, if there is no data for the particular bar
                                    datasets: {!! $datasets !!}
                                },
                                options: {
                                    responsive: false,
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


                        // function emissionChart(labels, datasets) {
                        //     var ctxBar = document.getElementById("{{ $id }}");
                        //     // if (ctxBar) {
                        //     //     ctxBar = ctxBar.getContext('2d');
                        //     // }
                        //     // var barData = {
                        //     //     labels: labels_emission,
                        //     //     datasets: [{
                        //     //         data: dataemisssion,
                        //     //         backgroundColor: [
                        //     //             'rgb(169, 169, 169)',
                        //     //             'rgb(50, 174, 89)',
                        //     //             'rgb(169, 169, 169)',
                        //     //             'rgb(50, 174, 89)',
                        //     //             'rgb(169, 169, 169)',
                        //     //             'rgb(50, 174, 89)',
                        //     //             'rgb(169, 169, 169)'
                        //     //         ],
                        //     //         borderWidth: 1
                        //     //     }]
                        //     // };
                        //     // var barOptions = {
                        //     //     scales: {
                        //     //         x: {
                        //     //             grid: {
                        //     //                 display: false
                        //     //             }
                        //     //         },
                        //     //         y: {
                        //     //             beginAtZero: true,
                        //     //             grid: {
                        //     //                 display: false
                        //     //             },
                        //     //             stepSize: 1,
                        //     //             max: 40
                        //     //         }
                        //     //     },
                        //     //     plugins: {
                        //     //         legend: {
                        //     //             display: false
                        //     //         }
                        //     //     }
                        //     // };
                        //     // emissionChart = new Chart(ctxBar, {
                        //     //     type: 'bar',
                        //     //     data: barData,
                        //     //     options:
                        //     // });

                        //     var chart = new Chart({{ $id }}, {
                        //         type: 'bar',
                        //         data: {
                        //             labels: labels ,
                        //             datasets:  datasets
                        //         },
                        //         options: {
                        //             responsive: true,
                        //             legend: {
                        //                 position: 'top' // place legend on the right side of chart
                        //             },
                        //             scales: {
                        //                 xAxes: [{
                        //                     stacked: true // this should be set to make the bars stacked
                        //                 }],
                        //                 yAxes: [{
                        //                     stacked: true // this also..
                        //                 }]
                        //             }
                        //         }
                        //     });
                        // }
                        setTimeout(function() {
                            emissionChart();
                            document.getElementById('loader').style.display = 'none';
                        }, 2000);
                    });
                </script>
            @endforeach
        @endif
    @endforeach

    {{-- Pie Chart --}}
    @php
        $electricityPieChartKey = json_encode(array_keys($electricityPieChartArray));
        $electricityPieChartValue = json_encode(array_values($electricityPieChartArray));
        $colorcodeObject = json_encode(colorCodeStaticArray());
    @endphp
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            let labels = {!! $electricityPieChartKey !!};
            let dataValues = {!! $electricityPieChartValue !!};
            let total = eval(dataValues.join('+'))
            let percentages = dataValues.map(value => ((value / total) * 100).toFixed(2));
            if (document.getElementById('myDoughnutChart') != null) {
                let ctx = document.getElementById('myDoughnutChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels.map((label, i) => `${label} (${percentages[i]}%)`),
                        datasets: [{
                            data: dataValues,
                            backgroundColor: {!! $colorcodeObject !!}
                        }]
                    }
                });
            }
        });
    </script>
    {{-- @php
        $electricityPieChartKey = json_encode(array_keys($electricityPieChartArray));
        $electricityPieChartValue = json_encode(array_values($electricityPieChartArray));
    @endphp --}}
    <script type="text/javascript">
        // x

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

        if (document.getElementById('downloadBtn') != null) {
            document.getElementById('downloadBtn').addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('loader').style.display = 'block';
                var promises = chartData();
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
                    $("#totalEmissionInput").val();
                    $("#totalEnergyusedInput").val();
                    $("#totalTonofRefrigerationInput").val();
                    setTimeout(function() {
                        document.getElementById('graph-form')
                            .submit();
                        document.getElementById('loader').style.display = 'none';
                    }, 2000);
                });
            });

        }

        $("input[type='radio']").change(function() {
            var filename = $(this).data('name');
            if (filename != '' && filename != 'undefined') {
                var url = "{{ route('dashboard.scope2') }}";
                window.location.href = url + '?datasheet=' + filename;
            }
        });
    </script>
@endsection
