@extends('frontend.layouts.main')

@section('title')
    Scope 3 Activities
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
            <h2 class="main-title">Scope 3 Activities</h2>
        </div>
        <div class="col-md-6 col-12">
            <div class="export-line export-backend front-export">
                @if (array_sum($total) != 0)
                    <form method="POST" action="{{ route('dashboard.scope-three-pdf',['name' => $name]) }}" enctype="multipart/form-data"
                        id="graph-form">
                        @csrf
                        <input type="hidden" name="totalEmissions" id="totalEmissionsInput">
                        <input type="hidden" name="totalFuel" id="totalFuelInput">
                        <input type="hidden" name="totalEnergyUsed" id="totalEnergyUsedInput">
                        <div class="hidden-column"></div>
                        <button type="button" id="downloadBtn" title="export" class="export-button {{ frontendPermissionCheck('dashboard.download') === false ? 'd-none' : 'd-block' }}" value="downloadpdf">
                            <picture>
                                <img src="{{ asset('assets/images/export-icon.svg') }}" alt="export-icon" title="export-icon" width=""
                                    height="">
                            </picture>EXPORT</a>
                        </button>
                    </form>
                @endif
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
                                            <input type="radio" {{ $result == $filename ? 'checked' : '' }}
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
    @if (array_sum($total) == 0)
        <h5 class="text-center mt-4">No Data Found</h5>
    @else
        <section class="membercount-section">
            <ul>
                <li class="flex-column">
                    <div class="totle-text">TOTAL EMISSIONS </div>
                    <div class="totle-number" id="totalEmissions">
                        {{ number_format(array_sum($total), 2) }}<span>Kg-co2-eq</span></div>
                </li>
                <li class="flex-column">
                    <div class="totle-text">TOTAL ENERGY USED </div>
                    <div class="totle-number" id="totalEnergyUsed">
                        {{ number_format(array_sum($totalEnergy), 2) }}<span>Kwh</span></div>
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
                    @if (in_array('Freighting goods', $filteredArray))
                        @php
                            $filteredArray[] = 'Freighting goods vans and HGVs';
                            $filteredArray[] = 'Freighting goods flights, rail, sea tanker and cargo ship';
                            unset($filteredArray[array_search('Freighting goods', $filteredArray)]);

                        @endphp
                    @endif
                    @if (in_array('Flight and Accommodation', $filteredArray))
                        @php
                            $filteredArray[] = 'Flight';
                            $filteredArray[] = 'Hotel';
                            unset($filteredArray[array_search('Flight and Accommodation', $filteredArray)]);
                        @endphp
                    @endif
                    @php
                        // if (!empty($unsetlabels)) {
                        //     foreach ($unsetlabels as $label) {
                        //         $key = array_search('', array_column($scopeThree, 0.0));
                        //         if ($key !== false) {
                        //             unset($scopeThree[$key]);
                        //         }
                        //     }
                        // }
                        //unset($scopeThree[array_search('Home Office', $scopeThree)]);
                        //  dd($unsetlabels);
                    @endphp
                    @foreach ($filteredArray as $scope)
                        {{-- @if (!in_array($scope, ['Flight and Accommodation'])) --}}
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
                        {{-- @endif --}}
                    @endforeach
                </ul>
            </section>
        </div>
    @endif
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/Chart.min.js') }}"></script>
    <script  type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    @foreach ($newDataArray as $key => $value)
        @php
            $labels = array_filter($value['labels'], function ($label) {
                return $label !== null;
            });

            $labels = json_encode(array_values($labels));
            $datasets = array_filter($value['datasets'], function ($dataset) {
                return $dataset['label'] !== ' (0)' && $dataset['label'] !== '-' && $dataset['label'] !== 'null';
            });
            $height = 400;
            $datasetsCount = count(array_values($datasets));

            if ($datasetsCount > 25) {
                $height = 600;
            }

            $datasets = json_encode(array_values($datasets));
            $id = $key == 'T&D' ? 'transmission' : generateSlug($key);

            if ($id == 'freighting_goods_flights_rail_sea_tanker_and_cargo_ship' && $datasetsCount > 25) {
                $height = 1100;
            }
            // $mobile_height = $height;
            // if($id == 'material_use' && $datasetsCount > 25){
            //     $mobile_height = 1000;
            // }
        @endphp
        <script type="text/javascript">
            var height = "{{ $height }}";
            if (screen.width < 1280) {
                var graph_name = "{{ $id }}";
                var countOfActivity = "{{ $datasetsCount }}"
                if (graph_name == 'material_use' && countOfActivity > 15) {
                    height = 800;
                }
                // console.log(graph_name + '--'+countOfActivity);
            } else {
                // console.log('Nice!')
            }

            $('#{{ $id }}').attr('height', height)
            // $('#{{ $id }}').css('min-height',500)
            // $('#{{ $id }}').attr('style', 'height: 800px');
            // $('#{{ $id }}').css('cssText', 'height: 800px !important');
            if ($('#{{ $id }}').html() != undefined) {
                new Chart({{ $id }}, {
                    type: 'bar',
                    data: {
                        labels: {!! $labels !!},
                        datasets: {!! $datasets !!}
                    },
                    options: {
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
    @php
        $lablePie = json_encode(array_keys($piecahrtArr));
        $pieValuedata = array_values($piecahrtArr);
        $pieValuedata = json_encode($pieValuedata);
        $colorcodeObject = json_encode(colorCodeStaticArray());
    @endphp
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
    {{-- <script type="text/javascript">
        var data = [{
            data: {!! $pieValuedata !!},
            backgroundColor: [
                "#5DADE2",
                "#d21243",
                "#A569BD",
                "#76D7C4",
                "#CD6155",
                "#EB984E",
                "#AED6F1",
                "#85929E",
                "#7D3C98",
                "#28B463",
                "#C0392B",
                "#A6ACAF",
            ],
            borderColor: "#fff"
        }];

        var options = {
            responsive: true,
            maintainAspectRatio: false,
            position: 'right',
            scales: {

            },
            tooltips: {
                enabled: false
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        const total = {!! array_sum(json_decode($pieValuedata)) !!}
                        const percentage = value / total * 100
                        // return percentage.toFixed(2) + "%";
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
                        weight: 'bold'
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
            document.getElementById('loader').style.display = 'none';
        }, 2000);
    </script> --}}
    <script type="text/javascript">
        $("input[type='radio']").change(function() {
            var filename = $(this).data('name');
            if (filename != '' && filename != 'undefined') {
                var url = "{{ route('dashboard.scope3') }}";
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
            var totalEnergyUsed = document.getElementById('totalEnergyUsed').innerText;
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
                $("#totalEnergyUsedInput").val(totalEnergyUsed);
                setTimeout(function() {
                    document.getElementById('graph-form')
                        .submit();
                    document.getElementById('loader').style.display = 'none';
                }, 2000);
            });

        });
    </script>
@endsection
