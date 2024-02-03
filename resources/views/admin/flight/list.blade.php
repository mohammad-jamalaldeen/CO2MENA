@extends('admin.layouts.app')
@section('title')
Flight Management
@endsection
@section('content')
    <div class="table-header">
        <div class="row align-items-center">
            <div class="col-md-5 col-12">

            </div>
            <div class="col-md-7 col-12">
                <div class="dw-header">
                    <a class="createsheet-btn" href="{{ route('flight.create') }}" title="create">
                        CREATE Flight
                    </a>
                </div>
            </div>
        </div>
        <div class="fillter-option">
            <div class="row">
                <div class="col-12">
                    <ul class="new-table-filter">
                        <li>
                            <select name="class" title="Class" id="class" data-live-search="true">
                                <option value="">Select Class</option>
                                @foreach (\App\Models\Flight::CLASS_TYPE as $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <select name="city" id="select" title="City" data-live-search="true">
                                <option value="">Select City</option>
                                @foreach ($cities as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <select name="single_way_and_return" title="Select Single way / return" id="single_way_and_return"
                            data-live-search="true">
                            <option value="">Select Single way / return</option>
                            @foreach (\App\Models\Flight::SINGLE_WAY_RETURN as $value)
                                <option value="{{ $value }}"> {{ $value }}</option>
                            @endforeach
                        </select>
                        </li>
                        <li>
                            <button type="button" class="reset-btn" onclick="resetValue()" title="reset-all">Reset All</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table tb-filter-inner">
        <div class="responsive-table">
            <table id="manage-flight" class="table custome-datatable manage-staff-table display"
                 >
                <thead>
                    <tr>
                        <th class="mw-120">Origin</th>
                        <th class="mw-120">Destination</th>
                        <th class="mw-120">distance</th>
                        <th class="mw-120">Class</th>
                        <th class="mw-120">Single way / return</th>
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
            var table = $("#manage-flight").DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "bLengthChange": false,
                "initComplete": function (settings, json) {  
                    $("#manage-flight").wrap("<div class='table-main-wrap manage-flight-wrap'></div>");            
                },
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" class="custom-loader" />'
                },
                order: [],
                ajax: {
                    url: "{{ route('flight.index') }}",
                    data: function(d) {
                        d.class = $('select[name="class"]').val();
                        d.city = $('select[name="city"]').val();
                        d.single_way_and_return = $('select[name="single_way_and_return"]').val();
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
                        data: 'origin.name',
                        name: 'origin.name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'destination.name',
                        name: 'destination.name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'distance',
                        name: 'distance',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'class',
                        name: 'class',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'single_way_and_return',
                        name: 'single_way_and_return',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        className:"action-th",
                        render: function(data, type, full, meta) {
                            var id = full.id;
                            var current_url_show = "{{ url('admin/flight/show') }}/" + id;
                            var current_url_edit = "{{ url('admin/flight/edit') }}/" + id;
                            var html = "";
                            html +=
                                '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                            html +=
                                "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' width='' height=''></picture></div>";
                            html +=
                                '<ul class="dropdown-menu edit-sheet"><li><a class="dropdown-item" href="' +
                                    current_url_show +
                                '">View</a></li><li><a class="dropdown-item" href="' +
                                    current_url_edit +
                                '">Edit</a></li><li><a class="dropdown-item deleteflight" href="#" data-id =' +
                                full.id + '>Delete</a></li></ul></div>';
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
                    $("#manage-flight_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#manage-flight_next").html(
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
            $('select[name="class"]').on('change', function() {
                $('#manage-flight').DataTable().draw();
            });
            $('select[name="city"]').on('change', function() {
                $('#manage-flight').DataTable().draw();
            });
            $('select[name="single_way_and_return"]').on('change', function() {
                $('#manage-flight').DataTable().draw();
            });

        });
        function resetValue() {
            $('select[name="class"], select[name="city"], select[name="single_way_and_return"]').val(null);
            $('select[name="class"], select[name="city"], select[name="single_way_and_return"]').selectpicker('refresh');
            $('#manage-flight').DataTable().draw();
        }
        $(document).on('click', ".deleteflight", function() {
            var id = $(this).attr('data-id');
            $(".deleterecordbtn").attr('data-id', id);
            $(".delete-modal-title").text("Flight Delete");
            $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
            $("#deleterecordModel").modal('show');
        });
        $(".deleterecordbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('admin/flight/delete') }}"+'/'+id;
            window.location.href = current_object;
        });
    </script>
@endsection
