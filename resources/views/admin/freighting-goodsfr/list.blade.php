@extends('admin.layouts.app')
@section('title')
    Freighting Goods
@endsection
@section('content')
@if (!adminPermissionCheck('freighting-goodsfr.create'))
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
    <div class="table-header" {{$classlist}}>
        <div class="row align-items-center" {{$display}}>
            <div class="col-md-5 col-12">

            </div>
            <div class="col-md-7 col-12">
                <div class="dw-header">
                    <a class="createsheet-btn" href="{{ route('freighting-goodsfr.create') }}" title="create">
                        Create Freighting Good
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
                            <select name="vehicle" id="getvehicle" title="Vehicle" class="form-control">
                                <option value="">Select Vehicle</option>
                                @foreach (\App\Models\FreightingGoodsFlightsRails::VEHICLE as $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <select class="col-md-4 col-12" name="unit" title="Unit" id="getunit">
                                <option value="">Select Unit</option>
                                @foreach (\App\Models\FreightingGoodsFlightsRails::UNIT as $value)
                                    <option value="{{ $value }}" {{ old('unit') == $value ? 'selected' : '' }}>
                                        {{ $value }}</option>
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
            <table id="fg" class="table custome-datatable display" width="100%">
                <thead>
                    <tr>
                        <th class="mw-140">Vehicle</th>
                        <th class="mw-140">Type</th>
                        <th class="mw-140">Unit</th>
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
            var table = $("#fg").DataTable({
                // scrollX: true,
                processing: true,
                serverSide: true,
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" class="custom-loader" />'
                },
                // "pageLength":"{{config('constants.perPageRecords')}}",
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function (settings, json) {  
                    $("#fg").wrap("<div class='table-main-wrap fg-wrap'></div>");            
                },
                order: [ ],
                ajax: {
                    url: "{{ route('freighting-goodsfr.index') }}",
                    data: function(d) {
                        d.getvehicle = $('#getvehicle').val();
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
                columns: [{
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
                        orderable: false,
                        searchable: false,
                        className:"action-th",
                        render: function(data, type, full, meta) {
                            var fg_show_url ="{{ url('admin/freighting-goodsfr/show') }}"+'/'+full.id;
                            var fg_edit_url ="{{ url('admin/freighting-goodsfr/edit') }}"+'/'+full.id;
                            var html = "";
                            @if(adminMultiplePermissionCheck('freighting-goodsfr', ['show', 'edit', 'delete']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' width='' height=''></picture></div>";
                                html += '<ul class="dropdown-menu edit-sheet">';    
                                @if(adminPermissionCheck('freighting-goodsfr.show'))
                                    html += '<li><a class="dropdown-item" href="' + fg_show_url + '">View</a></li>';    
                                @endif
                                @if(adminPermissionCheck('freighting-goodsfr.edit'))
                                    html += '<li><a class="dropdown-item" href="' + fg_edit_url + '">Edit</a></li>';    
                                @endif
                                @if(adminPermissionCheck('freighting-goodsfr.delete'))
                                    html += '<li><a class="dropdown-item deleteemployeescommuting" href="#" data-id =' + full.id + '>Delete</a></li>';
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
                    $("#fg_previous").html('<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#fg_next").html('<img src="{{ asset('assets/images/arrow-next.svg') }}" alt="next-icon">');
                    var pageInfo = table.page.info();
                    var currentPage = pageInfo.page + 1;
                    if (currentPage == 1 && recordsTotal  <= 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                }
            });
            $('#getvehicle, #getunit').change(function() {
                $("#fg").DataTable().draw();
            });
            $(document).on('click', ".deleteemployeescommuting", function() {
                var id = $(this).attr('data-id');
                $(".deleterecordbtn").attr('data-id', id);
                $(".delete-modal-title").text("Freighting Goods Flight, Rail, Sea Tenker And Cargo Ship");
                $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
                $("#deleterecordModel").modal('show');
            });
            $(".deleterecordbtn").click(function() {
                var id = $(this).attr('data-id');
                var current_object = "{{ url('admin/freighting-goodsfr/delete') }}"+'/'+id;
                window.location.href = current_object;
            });

            $('select[name="vehicle"]').on('change', function() {
                table.ajax.reload();
            });
            $('select[name="unit"]').on('change', function() {
                table.ajax.reload();
            });
        });

        function resetValue() {
            $('select[name="vehicle"], select[name="unit"]').val(null);
            $('select[name="vehicle"], select[name="unit"]').selectpicker('refresh');
            $('#fg').DataTable().draw();
        }

        $(".reset-btn").click(function() {
            $('select[name="vehicle"], select[name="unit"]').val(null);
            $('select[name="vehicle"], select[name="unit"]').selectpicker('refresh');
            $('#fg').DataTable().draw();
        });
    </script>
@endsection
