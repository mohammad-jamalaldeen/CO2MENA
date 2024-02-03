@extends('admin.layouts.app')
@section('title')
    Customer Management
@endsection
@section('content')
@if (!adminPermissionCheck('customer.create'))
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
                <a class="createsheet-btn" href="{{ route('customer.create') }}" title="create">
                    CREATE Customer
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
                            <select class="form-control" name="status" title="Select Status" id="status" placeholder="Select Status">
                                <option value="">Select Status</option> 
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </li>
                        <li>
                            <select class="form-control industry-select" name="industry" title="Select Industry" id="industry" placeholder="Select Industry">
                                <option value="">Select Industry</option>
                                @if (!empty($industryarr))
                                    @foreach ($industryarr as  $industry)
                                        <option value="{{$industry['id']}}">{{$industry['name']}}</option>        
                                    @endforeach
                                @endif
                            </select>
                        </li>
                        <li>
                            <button type="button" title="Reset-all" class="reset-btn">Reset All</button>
                        </li>
                    </ul>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>
    <div class="datasheet-table tb-filter-inner {{$classlist}}">
        <div class="responsive-table">
            <table id="manage-customer" class="table custome-datatable manage-customer-table display" width="100%">
                <thead>
                    <tr>
                        <th>COMPANY ADMIN NAME</th>
                        <th>COMPANY ADMIN EMAIL</th>
                        <th>ORGANIZATION NAME</th>
                        <th>COMPANY INDUSTRY</th>
                        <th>COMPANY LOGO</th>
                        <th class="mw-100">STATUS</th>
                        <th class="action-th"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal common-modal fade" id="pendingdocument" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" title="close" aria-label="Close"></button>
                <div class="content-inner">
                    <h2 class="section-title">Pending Document</h2>

                    <form id="pendingdocumentform" class="input-form" action="{{ route('customer.pending-document') }}"
                        enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="hidden" name="company_id" id="company_id" value="">
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <div class="form-group">
                            <label for="document" class="col-form-label">Document:</label>
                            <textarea class="form-controal" rows="10" name="document" id="document"></textarea>
                        </div>
                        <div class="btn-wrap">
                            <a href="javascript:void(0);" title="close" class="back-btn" data-bs-dismiss="modal">Close</a>
                            <button type="submit" title="send-message" class="create-btn">Send message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('common-modal.delete-modal')
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var url ="{{ asset('assets/loader.gif') }}";
            var table = $("#manage-customer").DataTable({
                // scrollX: true,
                autoWidth: true,
                bInfo: true,
                processing: true,
                serverSide: true,
                lengthChange: true,
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" title="loader" class="custom-loader" />'
                },
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function (settings, json) {  
                    $("#manage-customer").wrap("<div class='table-main-wrap manage-customer-wrap'></div>");            
                },
                ajax: {
                    url: "{{ route('customer.index') }}",
                    dataType: "json",
                    data: function(d) {
                        d.status_filter = $('#status').val();
                        d.industry_filter = $('#industry').val();
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
                        data: 'user.email',
                        name: 'user.email',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'company_name',
                        name: 'company_name',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'industry.name',
                        name: 'industry.name',
                        orderable: false,
                        searchable: true,
                    },
                    {
                        data: 'company_logo',
                        name: 'company_logo',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            var html = "";
                            if (data != "") {
                                html += '<img alt="company-logo-image" title="company-logo" class="imagepop" src=' + data +
                                    ' style="max-width: 80px; width:80px; max-height:80px; height:80px; object-fit: cover; object-position: center center;">';
                            } else {
                                html += "-";
                            }
                            return html;
                        },
                    },
                    {
                        data: 'user.status',
                        name: 'user.status',
                        orderable: false,
                        searchable: false,
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
                        data: 'action',
                        name: 'action',
                        className: 'hello',
                        orderable: false,
                        searchable: false,
                        className:"action-th",
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            var current_url_show = "{{url('admin/customer/show')}}"+'/'+full.user_id;
                            var current_url_edit = "{{url('admin/customer/edit')}}"+'/'+full.user_id ;
                            var current_emission_url = "{{url('admin/customer/manage/emission')}}"+'/'+full.user_id;
                            @if(adminMultiplePermissionCheck('customer', ['edit', 'show', 'manageemission', 'pending-document', 'delete']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' title='sheet-dots' width='' height=''></picture></div>";
                                html +='<ul class="dropdown-menu edit-sheet">';
                                @if(adminPermissionCheck('customer.show'))
                                    html += '<li><a class="dropdown-item" href="' +current_url_show +'">View</a></li>';
                                @endif
                                @if(adminPermissionCheck('customer.edit'))
                                    html += '<li><a class="dropdown-item" href="' +current_url_edit +'">Edit</a></li>';
                                @endif
                                @if(adminPermissionCheck('customer.delete'))
                                    html += '<li><a class="dropdown-item deletecompany" href="#" data-id =' +full.id + '>Delete</a></li>';
                                @endif
                                @if(adminPermissionCheck('customer.manageemission'))
                                    html += '<li><a class="dropdown-item" href="'+current_emission_url+'">Manage Activities</a></li>';
                                @endif
                                @if(adminPermissionCheck('customer.pending-document'))
                                    html += '<li><a class="dropdown-item pendingdocument" data-comapny_id="' +id + '" data-user_id="' + full.user_id +'" href="#">Pending Document</a></li>';
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
                }, ],

                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#manage-customer_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon" title="back">');
                    $("#manage-customer_next").html(
                        '<img src="{{ asset('assets/images/arrow-next.svg') }}" alt="next-icon" title="next">');
                    var pageInfo = table.page.info();
                    var currentPage = pageInfo.page + 1;                  
                    if (currentPage == 1 && recordsTotal  <= 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                },
            });

            $("#industry").change(function(){
                table.draw();
            });
            
            $("#status").change(function(){
                table.draw();
            });

            $("#pendingdocumentform").validate({
                rules: {
                    document: {
                        required: true,
                        maxlength: 250,
                        minlength: 5,
                    },
                },
                messages: {
                    document: {
                        required: "Please enter document."
                    }
                },
                errorClass: "text-danger",
                errorElement: "span"
            });
        });
        $(document).on('click', ".deletecompany", function() {
            var id = $(this).attr('data-id');
            $(".deleterecordbtn").attr('data-id', id);
            $(".delete-modal-title").text("Customer Delete");
            $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
            $("#deleterecordModel").modal('show');
        });
        $(".deleterecordbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('admin/customer/delete') }}"+'/'+id;
            window.location.href = current_object;
        });

        $(document).on("click", ".pendingdocument", function() {
            var company_id = $(this).data('comapny_id');
            var user_id = $(this).data('user_id');
            $("#pendingdocumentform").find("#company_id").val(company_id);
            $("#pendingdocumentform").find("#user_id").val(user_id);
            $("#pendingdocument").modal("show");
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
                        setReturnMsg("danger","Status has been updated not successfully.")
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
        $(document).on("click", ".datasheetbackup", function() {
            var companyId = $(this).data('company_id');
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
            $('select[name="status"], select[name="industry"]').val(null);
            $('select[name="industry"], select[name="status"]').selectpicker('refresh');
            $("#manage-customer").DataTable().draw();
        });
    </script>
@endsection
