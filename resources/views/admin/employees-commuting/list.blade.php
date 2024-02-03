@extends('admin.layouts.app')
@section('title')
    Employees Commuting
@endsection
@section('content')
@if (!adminPermissionCheck('employees-commuting.create'))
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
    <div class="table-header {{$classlist}}">
        <div class="row align-items-center" {{$display}}>
            <div class="col-md-5 col-12">

            </div>
            <div class="col-md-7 col-12">
                <div class="dw-header">
                    <a class="createsheet-btn" href="{{ route('employees-commuting.create') }}" title="create">
                        Create Employees Commuting
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
                            <select name="selectedValue" id="getvehicle" placeholder="Select Vehicle" title="Vehicle"
                                class="form-control">
                                <option value="">Select Vehicle</option>
                                @foreach (\App\Models\BusinessTravels::VEHICLE as $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <select class="col-md-4 col-12" name="type" placeholder="Select Type" title="Type"
                                id="gettype">
                                <option value="">Select Type</option>
                                @foreach (\App\Models\BusinessTravels::TYPE as $value)
                                    <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <select class="col-md-4 col-12" name="fuel" placeholder="Select Fuel" title="Fuel"
                                id="getfuel">
                                <option value="">Select Fuel</option>
                                @foreach (\App\Models\BusinessTravels::FUEL as $value)
                                    <option value="{{ $value }}" {{ old('fuel') == $value ? 'selected' : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <select class="col-md-4 col-12" name="unit" title="Unit" placeholder="Select Unit"
                                id="getunit">
                                <option value="">Select Unit</option>
                                @foreach (\App\Models\BusinessTravels::UNIT as $value)
                                    <option value="{{ $value }}" {{ old('unit') == $value ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <button type="button" class="reset-btn" onclick="resetValue()" title="reset-all">Reset All</button>
                        </li>
                    </ul>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table tb-filter-inner {{$classlist}}">
        <div class="responsive-table">
            <table id="employees-commuting" class="table custome-datatable manage-customer-table display"
                 >
                <thead>
                    <tr>
                        <th class="mw-140">Vehicle</th>
                        <th class="mw-140">Type</th>
                        <th class="mw-140">Fuel</th>
                        <th class="mw-140">Emission Factor</th>
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
            var url ="{{ asset('assets/loader.gif') }}";
            var table = $("#employees-commuting").DataTable({
                processing: true,
                serverSide: true,
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" class="custom-loader" />'
                },
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function(settings, json) {
                    $("#employees-commuting").wrap(
                        "<div class='table-main-wrap employees-commuting-wrap'></div>");
                },
                order: [],
                ajax: {
                    url: "{{ route('employees-commuting.index') }}",
                    data: function(d) {
                        d.getvehicle = $('#getvehicle').val();
                        d.gettype = $('#gettype').val();
                        d.getfuel = $('#getfuel').val();
                        d.getunit = $('#getunit').val();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        } 
                    },
                },
                columns: [
                    // {
                    //     data: 'row_id',
                    //     name: 'row_id',
                    //     orderable: true,
                    //     searchable: true

                    // },
                    {
                        data: 'vehicle',
                        name: 'vehicle',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: true,
                        searchable: true
                    },
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
                        orderable: false,
                        searchable: false,
                        className:"action-th",
                        render: function(data, type, full, meta) {
                            var empcom_show_url =
                                "{{ url('admin/employees-commuting/show') }}" + '/' + full.id;
                            var bussinesstravel_edit_url =
                                "{{ url('admin/employees-commuting/edit') }}" + '/' + full.id;

                            var html = "";
                            @if(adminMultiplePermissionCheck('employees-commuting', ['show', 'edit', 'delete']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' width='' height=''></picture></div>";
                                html += '<ul class="dropdown-menu edit-sheet">';
                                @if(adminPermissionCheck('employees-commuting.show'))
                                    html += '<li><a class="dropdown-item" href="' +empcom_show_url +'">View</a></li>';
                                @endif
                                @if(adminPermissionCheck('employees-commuting.edit'))
                                    html += '<li><a class="dropdown-item" href="' +bussinesstravel_edit_url +'">Edit</a></li>';
                                @endif
                                @if(adminPermissionCheck('employees-commuting.delete'))
                                    html += '<li><a class="dropdown-item deleteemployeescommuting" href="#" data-id =' +full.id + '>Delete</a></li>';
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
                }, ],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#employees-commuting_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#employees-commuting_next").html(
                        '<img src="{{ asset('assets/images/arrow-next.svg') }}" alt="next-icon">');
                    var pageInfo = table.page.info();
                    var currentPage = pageInfo.page + 1;
                    if (currentPage == 1 && recordsTotal  <= 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                }
            });



            $('#getvehicle, #gettype, #getfuel, #getunit').change(function() {
                table.ajax.reload();
            });


            $(document).on('click', ".deleteemployeescommuting", function() {
                var id = $(this).attr('data-id');
                $(".deleterecordbtn").attr('data-id', id);
                $(".delete-modal-title").text("Employees Commuting");
                $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
                $("#deleterecordModel").modal('show');
            });
            $(".deleterecordbtn").click(function() {
                var id = $(this).attr('data-id');
                var current_object = "{{ url('admin/employees-commuting/delete') }}" + '/' + id;
                window.location.href = current_object;
            });
        });

        function resetValue() {
            $('select[name="selectedValue"]').val(null);
            $('select[name="selectedValue"]').selectpicker('refresh');
            $('select[name="type"]').val(null);
            $('select[name="type"]').selectpicker('refresh');
            $('select[name="fuel"]').val(null);
            $('select[name="fuel"]').selectpicker('refresh');
            $('select[name="unit"]').val(null);
            $('select[name="unit"]').selectpicker('refresh');
            $('#employees-commuting').DataTable().draw();
        }
    </script>
@endsection
