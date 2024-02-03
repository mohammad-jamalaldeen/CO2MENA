@extends('admin.layouts.app')
@section('title')
    Emission Factor Management
@endsection
@section('content')
    <div class="table-header">
        <div class="row align-items-center">
            <div class="col-md-6 col-12">
                {{-- <div class="table-filterserch">
                    <div class="data-filter">
                        <picture>
                            <img src="{{ asset('assets/images/filter-icon.svg') }}" alt="filter-icon" width=""
                                height="">
                        </picture>
                          FILTER
                        <picture>
                            <img class="down-arrow" src="{{ asset('assets/images/arrow-down.svg') }}" alt="arrow-down"
                                width="" height="">
                        </picture>

                        <div class="filter-list">
                            <div class="custome-checkbox">
                                <label class="checkbox">
                                    <input type="checkbox">Date & Time<span class="checkmark"></span>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox">Reporting Period<span class="checkmark"></span>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox">Last Action<span class="checkmark"></span>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox">Status<span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="col-md-6 col-12">
                <div class="dw-header">
                    <a class="createsheet-btn" href="{{ route('emission-factors.create') }}">
                        CREATE Emission Factor
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="datasheet-table">

        <table id="manage-emission-factors" class="table custome-datatable manage-staff-table display"  >
            <thead>
                <tr>
                    <th class="mw-100">Name</th>
                    <th class="mw-100">Created Date</th>
                    <th class="mw-100">Last Updated By</th>
                    <th class="mw-100">IP Address</th>
                    <th class="action-th"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>

    @include('common-modal.delete-modal')
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var url ="{{ asset('assets/loader.gif') }}";
            $("#manage-emission-factors").DataTable({
                // scrollX: true,
                processing: true,
                serverSide: true,
                lengthChange: true,
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function (settings, json) {  
                    $("#manage-emission-factors").wrap("<div class='table-no-padding manage-emission-factors-wrap'></div>");            
                },
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" class="custom-loader" />'
                },
                ajax: {
                    url: "{{ route('emission-factors.index') }}",
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
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'Username',
                        name: 'Username',
                        orderable: true,
                        searchable: false,
                    },
                    {
                        data: 'ip_address',
                        name: 'ip_address',
                        orderable: true,
                        searchable: false,
                    },
                    {
                        data: 'action',
                        searchable: false,
                        orderable: false,
                        className:"action-th",
                        render: function(data, type, full, meta) {
                            var id = full.id;
                            var current_url_show = "{{ url('admin/emission-factors/show', '') }}/" +
                                id;
                            var current_url_edit = "{{ url('admin/emission-factors/edit', '') }}/" +
                                id;
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
                                '">Edit</a></li><li><a class="dropdown-item deleteemssionfactor" href="#" data-id =' +
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
                    $("#manage-emission-factors_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="beck-icon">');
                    $("#manage-emission-factors_next").html(
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

            $(document).on('click', ".deleteemssionfactor", function() {
                var id = $(this).attr('data-id');
                $(".deleterecordbtn").attr('data-id', id);
                $(".delete-modal-title").text("Emission Factor Delete");
                $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
                $("#deleterecordModel").modal('show');
            });
            $(".deleterecordbtn").click(function() {
                var id = $(this).attr('data-id');
                var current_object = "{{ url('admin/emission-factors/delete') }}" + '/' + id;
                window.location.href = current_object;
            });
        });
    </script>
@endsection
