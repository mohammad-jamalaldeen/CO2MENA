@extends('admin.layouts.app')
@section('title')
    Staff Members
@endsection
@section('content')
@if (!adminPermissionCheck('companystaff.create'))
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
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{!empty($companyName['company_name']) ?  route('customer.show',$companyName['user_id']): route('customer.index')}}">{{!empty($companyName['company_name']) ? $companyName['company_name']:"Customer"}}</a></li>
    <li class="breadcrumb-item active">Staff Members</li>
</ul>
<div class="table-header {{$classlist}}">
    <div class="row align-items-center" {{$display}}>
        <div class="col-md-5 col-12">
            
        </div>
        <div class="col-md-7 col-12">
            <div class="dw-header">
                <a class="createsheet-btn" href="{{ route('companystaff.create', Request()->id) }}">
                    CREATE Staff Member
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
    <div class="datasheet-table tb-filter-inner {{$classlist}}">
        <div class="responsive-table">
            <table id="manage-staff" class="table custome-datatable manage-staff-table display"  >
                <thead>
                    <tr>
                        <th class="mw-120">Member Name</th>
                        <th class="mw-120">Role</th>
                        <th class="mw-120">Conatct Number</th>
                        <th class="mw-120">Email Address</th>
                        <th class="mw-120">Status</th>
                        <th class="mw-120">Date Of Joined</th>
                        <th class="mw-120">Profile</th>
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
            var table = $("#manage-staff").DataTable({
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
                    $("#manage-staff").wrap("<div class='table-main-wrap manage-staff-wrap'></div>");            
                },
                ajax: {
                    url: "{{ route('companystaff.index', Request()->id) }}",
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
                        data: 'user.name',
                        name: 'user.name',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'user.role.role',
                        name: 'user.role.role',
                        orderable: false,
                        searchable: true,
                    },
                    {
                        data: 'user.contact_number',
                        name: 'user.contact_number',
                        orderable: false,
                        searchable: true,
                    },
                    {
                        data: 'user.email',
                        name: 'user.email',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'user.status',
                        name: 'user.status',
                        orderable: false,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            if (data == '1') {
                                var checked = "checked";
                                var value = "Active";
                            } else {
                                var checked = "";
                                var value = "InActive";
                            }
                            html +=
                                '<div class="table-switch"><input type="checkbox" data-id="' +
                                full.user_id + '" class="switchstatus" type="checkbox" ' + checked +
                                '/><label for="' +full.user_id + '" class="statuslabel">'+value+'</label></div>';
                            return html;
                        }
                    },
                    {
                        data: 'user.created_at',
                        name: 'user.created_at',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'user.profile_picture',
                        name: 'user.profile_picture',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            var html = "";
                            if (data != "") {
                                html += '<img class="imagepop" src=' + data +
                                    ' style="max-width: 80px; width:80px;">';
                            } else {
                                html += "-";
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
                            var id = full.user.id;
                            var showurl = "{{ url('admin/companystaff/show/') }}" +
                                '/{{ Request()->id }}/' + id;
                            var editurl = "{{ url('admin/companystaff/edit/') }}" +
                                '/{{ Request()->id }}/' + id;
                            @if(adminMultiplePermissionCheck('companystaff', ['edit', 'show',  'delete']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' width='' height=''></picture></div>";
                                html += '<ul class="dropdown-menu edit-sheet">';
                                @if(adminPermissionCheck('companystaff.show'))
                                    html += '<li><a class="dropdown-item" href="' + showurl + '">View</a></li>';
                                @endif
                                @if(adminPermissionCheck('companystaff.edit'))
                                    html += '<li><a class="dropdown-item" href="' + editurl + '">Edit</a></li>';
                                @endif
                                @if(adminPermissionCheck('companystaff.delete'))
                                    html += '<li><a class="dropdown-item deleteStaff" href="#" data-id =' + full.user.id + '>Delete</a></li>';
                                @endif
                                html += '</ul></div>';
                            @else
                                html += '-';
                            @endif
                            return html;
                        },
                    },
                ],
                columnDefs: [{
                    targets: '_all',
                    defaultContent: '-'
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#manage-staff_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#manage-staff_next").html(
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
            $("#status").change(function(){
                $("#manage-staff").DataTable().draw();
            });
        });
        $(document).on('click', ".deleteStaff", function() {
            var id = $(this).attr('data-id');
            $(".deleterecordbtn").attr('data-id', id);
            $(".delete-modal-title").text("Staff Delete");
            $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
            $("#deleterecordModel").modal('show');
        });
        $(".deleterecordbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('admin/companystaff/delete/') }}" + '/{{ Request()->id }}/' + id;
            window.location.href = current_object;
        });
        $(document).on("change", ".switchstatus", function() {
            var user_id = $(this).data('id');
            if ($(this).is(":checked")) {
                var status = '1';
                $("label[for='" + user_id + "']").text('Active');
            } else {
                var status = '0';
                $("label[for='" + user_id + "']").text('InActive');
            }
            $.ajax({
                url: "{{ route('customer.status-change') }}",
                type: "POST",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'user_id': user_id,
                    'status': status,
                },
                success: function(data) {
                    if(data.status == true){
                        setReturnMsg("success","Status has been updated successfully.")
                    }else{
                        setReturnMsg("danger","Status has been updated notsuccessfully.")
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle the HTTP status code here
                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    } 
                },
            });
        });

        function setReturnMsg(title, message){
            var title = title;
            var lowercaseString = title.toLowerCase();
            if(lowercaseString== "danger")
            {
                title = 'Error';
            }
            $.notify({
                title: '<strong>'+title+'</strong>',
                message: "<br>"+message+"",
            }, {
                element: 'body',
                position: null,
                type: lowercaseString,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 999999,
                delay: 2000,
                timer: 1000,
                mouse_over: null,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutRight'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
            });
        }
        $(".reset-btn").click(function(){
            $('select[name="status"]').val(null);
            $('select[name="status"]').selectpicker('refresh');
            $("#manage-staff").DataTable().draw();
        });
    </script>
@endsection
