@extends('admin.layouts.app')
@section('title')
    Vehicle Management
@endsection
@section('content')
    @if (!adminPermissionCheck('vehicles.create'))
        @php
            $display = 'style=display:none';
            $classlist = 'button-header-hide';
        @endphp
    @else
        @php
            $display = '';
            $classlist = '';
        @endphp
    @endif
    <div class="table-header {{ $classlist }}">
        <div class="row align-items-center" {{ $display }}>
            <div class="col-md-5 col-12">

            </div>
            <div class="col-md-7 col-12">
                <div class="dw-header">
                    <a class="createsheet-btn" href="{{ route('vehicles.create') }}" title="create">
                        CREATE Vehicle
                    </a>
                </div>
            </div>
        </div>
        <div class="fillter-option">
            <div class="row">
                <div class="col-12">
                    {{-- <form action="" method="GET"> --}}
                    <ul class="new-table-filter">
                        <li>
                            <select class="form-control" name="vehicle_type" title="Vehicle Type" id="vehicle_type">
                                @foreach (\App\Models\Vehicle::VEHICLE_TYPE as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="id_field">
                            <select class="form-control" name="vehicle" id="vehicle" title="Vehicle" disabled>
                                <option value="">Select Vehicle</option>
                                @foreach (\App\Models\Vehicle::VEHICLE as $value)
                                    <option value="{{ $value }}">
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="delivery_vehicle_field">
                            <select name="vehicle1" id="delivery" title="Vehicle">
                                <option value="">Select Delivery Vehicle</option>
                                @foreach (\App\Models\Vehicle::DELIVERY_VEHICLE as $value)
                                    <option value="{{ $value }}">
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="id_field">
                            <select name="type" id="type" title="Type" disabled>
                                <option value="">Select Type</option>
                                @foreach (\App\Models\Vehicle::TYPE as $value)
                                    <option value="{{ $value }}">
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="delivery_vehicle_field">
                            <select name="type1" id="type" title="Type">
                                <option value="">Select Delivery Type</option>
                                @foreach (\App\Models\Vehicle::DELIVERY_TYPE as $value)
                                    <option value="{{ $value }}">
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="id_field">
                            <select name="fuel" id="fuel" title="Fuel" disabled>
                                <option value="">Select Fuel</option>
                                @foreach (\App\Models\Vehicle::FUEL as $value)
                                    <option value="{{ $value }}">
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="delivery_vehicle_field">
                            <select name="fuel1" id="fuel" title="Fuel">
                                <option value="">Select Delivery Fuel</option>
                                @foreach (\App\Models\Vehicle::DELIVERY_FUEL as $value)
                                    <option value="{{ $value }}">
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <button type="button" class="reset-btn" onclick="resetValue()" title="reset-all">Reset
                                All</button>
                        </li>
                    </ul>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table tb-filter-inner {{ $classlist }}">
        <div class="responsive-table">
            <table id="manage-vehicles" class="table custome-datatable manage-customer-table display">
                <thead>
                    <tr>
                        <th class="mw-120">Vehicle Type</th>
                        <th class="mw-120">Vehicle</th>
                        {{-- <th class="mw-120">Type</th> --}}
                        <th class="mw-120">Fuel</th>
                        <th class="mw-120">Emission Factor</th>
                        <th class="action-th"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @include('common-modal.delete-modal')
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var url = "{{ asset('assets/loader.gif') }}";
            var table = $("#manage-vehicles").DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                lengthChange: true,
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function(settings, json) {
                    $("#manage-vehicles").wrap(
                        "<div class='table-main-wrap manage-vehicles-wrap'></div>");
                },
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="' + url + '" alt="loader" class="custom-loader" />'
                },
                order: [],
                ajax: {
                    url: "{{ route('vehicles.index') }}",
                    data: function(d) {
                        d.vehicle_type = $('select[name="vehicle_type"]').val(); // Updated line
                        d.vehicle = $('select[name="vehicle"]').val();
                        d.vehicle1 = $('select[name="vehicle1"]').val();
                        d.type = $('select[name="type"]').val();
                        d.type1 = $('select[name="type1"]').val();
                        d.fuel = $('select[name="fuel"]').val();
                        d.fuel1 = $('select[name="fuel1"]').val();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        }
                    },
                },
                columns: [{
                        data: 'vehicle_type',
                        name: 'vehicle_type',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            return data == 1 ? 'Passenger Vehicles' : 'Delivery Vehicles';
                        }
                    },
                    {
                        data: 'vehicle',
                        name: 'vehicle',
                        orderable: true,
                        searchable: true
                    },
                    // {
                    //     data: 'type',
                    //     name: 'type',
                    //     orderable: true,
                    //     searchable: true
                    // },
                    {
                        data: 'fuel',
                        name: 'fuel',
                        orderable: true,
                        searchable: true

                    },
                    {
                        data: 'factors',
                        name: 'factors',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: "action-th",
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            var current_url_show = "{{ url('admin/vehicles/show') }}/" + id;
                            var current_url_edit = "{{ url('admin/vehicles/edit') }}/" + id;
                            @if (adminMultiplePermissionCheck('vehicles', ['show', 'edit', 'delete']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' width='' height=''></picture></div>";
                                html += '<ul class="dropdown-menu edit-sheet">';
                                @if (adminPermissionCheck('vehicles.show'))
                                    html += '<li><a class="dropdown-item" href="' +
                                        current_url_show + '">View</a></li>';
                                @endif
                                @if (adminPermissionCheck('vehicles.edit'))
                                    html += '<li><a class="dropdown-item" href="' +
                                        current_url_edit + '">Edit</a></li>';
                                @endif
                                @if (adminPermissionCheck('vehicles.delete'))
                                    html +=
                                        '<li><a class="dropdown-item deletevehicles" href="#" data-id =' +
                                        full.id + '>Delete</a></li>';
                                @endif
                                html += '</ul></div>';
                            @else
                                html += '-';
                            @endif
                            return html;
                        }
                    },
                ],
                columnDefs: [{
                    targets: '_all',
                    defaultContent: '-'
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#manage-vehicles_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#manage-vehicles_next").html(
                        '<img src="{{ asset('assets/images/arrow-next.svg') }}" alt="next-icon">');
                    var pageInfo = table.page.info();
                    var currentPage = pageInfo.page + 1;
                    if (currentPage == 1 && recordsTotal <= 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                }
            });
            $('.delivery_vehicle_field').hide();
            $('.id_field').show();
            $('select[name="vehicle_type"]').on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue == 1) {
                    $('.id_field').show();
                    $('.delivery_vehicle_field').hide();
                    $('.id_field select').prop('disabled', false).selectpicker('refresh');
                    $('.delivery_vehicle_field select').prop('disabled', true).selectpicker('refresh');
                    $('select[name="vehicle1"]').val('');
                    $('select[name="type1"]').val('');
                    $('select[name="fuel1"]').val('');
                } else if (selectedValue == 2) {
                    $('.id_field').hide();
                    $('.delivery_vehicle_field').show();
                    $('.id_field select').prop('disabled', true).selectpicker('refresh');
                    $('.delivery_vehicle_field select').prop('disabled', false).selectpicker('refresh');
                    $('select[name="vehicle"]').val('');
                    $('select[name="type"]').val('');
                    $('select[name="fuel"]').val('');
                } else {
                    $('.id_field select, .delivery_vehicle_field select').prop('disabled', true)
                        .selectpicker('refresh');
                }

                $('#manage-vehicles').DataTable().draw();
            });

            ['vehicle', 'type', 'fuel', 'vehicle1', 'type1', 'fuel1'].forEach(function(field) {
                $('select[name="' + field + '"]').on('change', function() {
                    $('#manage-vehicles').DataTable().draw();
                });
            });
        });

        function resetValue() {
            $('select[name^="vehicle_type"], select[name^="vehicle"], select[name^="type"], select[name^="fuel"]').val(
                null);
            $('select[name^="vehicle_type"], select[name^="vehicle"], select[name^="type"], select[name^="fuel"]')
                .selectpicker('refresh');
            $('.id_field select').prop('disabled', true).selectpicker('refresh');
            $('.delivery_vehicle_field select').prop('disabled', true).selectpicker('refresh');
            $('#manage-vehicles').DataTable().draw();
        }

        $(document).on('click', ".deletevehicles", function() {
            var id = $(this).attr('data-id');
            $(".deleterecordbtn").attr('data-id', id);
            $(".delete-modal-title").text("Vehicle Delete");
            $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
            $("#deleterecordModel").modal('show');
        });
        $(".deleterecordbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('admin/vehicles/delete') }}" + '/' + id;
            window.location.href = current_object;
        });
    </script>
@endsection
