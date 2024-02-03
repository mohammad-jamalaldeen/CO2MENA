@extends('admin.layouts.app')
@section('title')
    Electricity Heat Cooling Management
@endsection
@section('content')
@if (!adminPermissionCheck('electricity-heat-cooling.create'))
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
                    <a class="createsheet-btn" href="{{ route('electricity-heat-cooling.create') }}" title="create">
                        CREATE Electricity Heat Cooling
                    </a>
                </div>
            </div>
        </div>
        <div class="fillter-option">
            <div class="row">
                <div class="col-12">
                    <ul class="new-table-filter">
                        <li>
                            {{-- <select name="electricity_type" id="electricity_type" title="Eletricity Type">
                                <option value="1">
                                    Electricity Grid
                                </option>
                                <option value="2">
                                    Heat And Steam
                                </option>
                                <option value="3">
                                    District Cooling
                                </option>
                            </select> --}}
                            <select class="form-control" name="electricity_type" id="electricity_type"
                                title="Eletricity Type">
                                <option value="">Select Eletricity Type</option>
                                @foreach (\App\Models\Electricity::TYPE as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <select name="country" id="select" title="Country" data-live-search="true">
                                <option value="">Select Country</option>
                                @foreach ($countries as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <select name="unit" id="unit" title="Unit">
                                <option value="">Select Unit</option>
                                @foreach (\App\Models\Electricity::UNIT as $value)
                                    <option value="{{ $value }}"
                                        @if (isset($electricity_heat_cooling) && $electricity_heat_cooling->unit === $value) selected @elseif(old('unit') == $value) selected @endif>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <button type="button" title="reset-all" class="reset-btn" onclick="resetValue()">Reset All</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table tb-filter-inner {{$classlist}}">
        <div class="responsive-table">
            <table id="manage-electricityheatcooling" class="table custome-datatable manage-customer-table display"
                 >
                <thead>
                    <tr>
                        <th class="mw-120">Electricity Type</th>
                        <th class="mw-120">Country</th>
                        <th class="mw-120">Type</th>
                        <th class="mw-120">ACTIVITY</th>
                        <th class="mw-120">Unit</th>
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
            var url ="{{ asset('assets/loader.gif') }}";
            var table = $("#manage-electricityheatcooling").DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                lengthChange: true,
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function (settings, json) {  
                    $("#manage-electricityheatcooling").wrap("<div class='table-main-wrap manage-electricityheatcooling-wrap'></div>");            
                },
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" class="custom-loader" />'
                },
                order: [],
                ajax: {
                    url: "{{ route('electricity-heat-cooling.index') }}",
                    data: function(d) {
                        //var electricity_type = $('input[name="electricity_type"]:checked').val();
                        //d.electricity_type = electricity_type !== '0' ? electricity_type : null;
                        d.electricity_type = $('select[name="electricity_type"]').val();
                        d.unit = $('select[name="unit"]').val();
                        d.country = $('select[name="country"]').val();
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
                columns: [{
                        data: 'electricity_type',
                        name: 'electricity_type',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            if (data == "1") {
                                return 'Electricity Grid';
                            } else if (data == "2") {
                                return 'Heat And Steam';
                            } else if (data == "3") {
                                return 'District Cooling';
                            } else {
                                return 'Unknown Type';
                            }
                        }
                    },
                    {
                        data: 'country',
                        name: 'country.name',
                        render: function(data, type, full, meta) {
                            return (data != null) ? data.name : 'N/A';                            
                        },
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
                        data: 'activity',
                        name: 'activity',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'unit',
                        name: 'unit',
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
                        className:"action-th",
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            var current_url_show = "{{ url('admin/electricity-heat-cooling/show', '') }}/" + id;
                            var current_url_edit = "{{ url('admin/electricity-heat-cooling/edit', '') }}/" + id;
                            @if(adminMultiplePermissionCheck('electricity-heat-cooling', ['show', 'edit', 'delete']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' width='' height=''></picture></div>";
                                html += '<ul class="dropdown-menu edit-sheet">';
                                @if(adminPermissionCheck('electricity-heat-cooling.show'))
                                    html += '<li><a class="dropdown-item" href="' +current_url_show +'">View</a></li>';
                                @endif
                                @if(adminPermissionCheck('electricity-heat-cooling.edit'))
                                    html += '<li><a class="dropdown-item" href="' +current_url_edit +'">Edit</a></li>';
                                @endif
                                @if(adminPermissionCheck('electricity-heat-cooling.delete'))
                                    html += '<li><a class="dropdown-item deleteelectricityheatcooling" href="#" data-id =' +full.id + '>Delete</a></li>';
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
                    $("#manage-electricityheatcooling_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#manage-electricityheatcooling_next").html(
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
            $('select[name="electricity_type"]').on('change', function() {
                table.ajax.reload();
            });
            $('select[name="unit"]').on('change', function() {
                table.ajax.reload();
            });
            $('select[name="country"]').on('change', function() {
                table.ajax.reload();
            });
        });

        function resetValue() {
            $('select[name="electricity_type"], select[name="unit"], select[name="country"]').val(null);
            $('select[name="electricity_type"], select[name="unit"], select[name="country"]').selectpicker('refresh');
            $('#manage-electricityheatcooling').DataTable().draw();
        }

        $(document).on('click', ".deleteelectricityheatcooling", function() {
            var id = $(this).attr('data-id');
            $(".deleterecordbtn").attr('data-id', id);
            $(".delete-modal-title").text("Electricity Heat Cooling Delete");
            $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
            $("#deleterecordModel").modal('show');
        });
        $(".deleterecordbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('admin/electricity-heat-cooling/delete') }}"+'/'+id;
            window.location.href = current_object;
        });
    </script>
@endsection
