@extends('admin.layouts.app')
@section('title')
    Sub Admin Management
@endsection
@section('content')
<div class="table-header">
    <div class="row align-items-center">
        <div class="col-md-5 col-12">
            
        </div>
        <div class="col-md-7 col-12">
            <div class="dw-header">
                <a class="createsheet-btn" href="{{ route('sub-admin.create') }}" title="create">
                    CREATE Sub Admin
                </a>
            </div>
        </div>
    </div>
    <div class="fillter-option">
        <div class="row">
            <div class="col-12">
                {{-- <form action="" method="GET"> --}}
                    <ul class="new-table-filter sub-admin-filter">
                        <li>
                            <select class="form-control" name="status" title="Select Status" id="status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="reset-btn" title="reset-all">Reset All</button>
                        </li>
                    </ul>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>
    <div class="datasheet-table tb-filter-inner">
        <table id="manage-sub-admin" class="table custome-datatable display" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Conatct Number</th>
                    <th>Username</th>                    
                    <th>Profile</th>
                    <th>Status</th>
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
            var table = $("#manage-sub-admin").DataTable({
                // scrollX: true,
                bInfo: true,
                processing: true,
                serverSide: true,
                lengthChange: true,
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" class="custom-loader" />'
                },
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function (settings, json) {  
                    $("#manage-sub-admin").wrap("<div class='table-main-wrap manage-sub-admin-wrap'></div>");            
                },
                ajax: {
                    url: "{{ route('sub-admin.index') }}",
                    dataType: "json",
                    data: function(d) {
                        d.status_filter = $('#status').val();
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
                order: [],
                columns: [{
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'contact_number',
                        name: 'contact_number',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'username',
                        name: 'username',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'profile_picture',
                        name: 'profile_picture',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            var html = "";
                            if (data != "") {
                                html += '<img alt="profile-icon" class="imagepop" src=' + data +
                                    ' style="max-width: 80px; width:80px; max-height: 80px; height: 80px; object-fit: cover; object-position: center center;">';
                            } else {
                                html += "-";
                            }
                            return html;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            var html = "";
                            if (data == '1') {
                                html += '<span class="status complet">Active</span>'
                            } else {
                                html += '<span class="status faile">In Active</span>'
                            }
                            return html;
                        }
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
                            var current_object_edit ="{{ url('admin/sub-admin/edit') }}"+'/'+id;
                            var current_object_show ="{{ url('admin/sub-admin/show') }}"+'/'+id;
                            html +=
                                '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                            html +=
                                "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' width='' height=''></picture></div>";
                            html +=
                                '<ul class="dropdown-menu edit-sheet"><li><a class="dropdown-item" href="' +
                                current_object_show +
                                '">View</a></li><li><a class="dropdown-item" href="' +
                                current_object_edit +
                                '">Edit</a></li><li><a class="dropdown-item deletesubadmin" href="#" data-id =' +
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
                    $("#manage-sub-admin_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#manage-sub-admin_next").html(
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

            $("#status").change(function() {
                table.draw();
            });
        });
        $(document).on('click', ".deletesubadmin", function() {
            var id = $(this).attr('data-id');
            $(".deleterecordbtn").attr('data-id', id);
            $(".delete-modal-title").text("Sub Admin Delete");
            $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
            $("#deleterecordModel").modal('show');
        });
        $(".deleterecordbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('admin/sub-admin/delete') }}"+'/'+id;
            window.location.href = current_object;
        });
        $(".reset-btn").click(function(){
            $('select[name="status"]').val(null);
            $('select[name="status"]').selectpicker('refresh');
            $("#manage-sub-admin").DataTable().draw();    
        });
    </script>
@endsection
