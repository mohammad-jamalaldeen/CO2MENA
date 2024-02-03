@extends('admin.layouts.app')
@section('title')
    Contact Request Data    
@endsection
@section('content')
<div class="table-header contact-us-header">
    <div class="row align-items-center">
        <div class="col-md-6 col-12">
            <!-- <div class="table-filterserch">
                <div class="fillter-option">
                </div>
            </div> -->
        </div>
    </div>
</div>
    <div class="datasheet-table cms-tabel-mr">
        <div class="responsive-table">
            <table id="manage-contactus" class="table custome-datatable manage-contactus-table display nowrap" width="100%">
                <thead>
                    <tr>
                        <th class="mw-120">Sender Name</th>
                        <th class="mw-120">Sender Email</th>
                        <th class="mw-120">Sender Contact No.</th>
                        <th class="mw-120">Subject</th>
                        <th class="mw-120">Date Of Submission</th>
                        <th class="action-th"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var url ="{{ asset('assets/loader.gif') }}";
            var table = $("#manage-contactus").DataTable({
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
                    $("#manage-contactus").wrap("<div class='table-no-padding manage-contactus-wrap'></div>");            
                },

                ajax: {
                    url: "{{ route('contactus.index') }}",
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        } 
                    },
                },
                order: [
                    [4, 'desc']
                ],
                columns: [{
                        data: 'name',
                        name: 'name',
                        orderable: false,
                        searchable: true,
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: false,
                        searchable: true,
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number',
                        orderable: false,
                        searchable: true,
                    },
                    {
                        data: 'subject',
                        name: 'subject',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: true,
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
                            var current_url_show = "{{ url('admin/contactus/show') }}"+'/'+id;
                            @if(adminMultiplePermissionCheck('contactus', ['show']) > 0)
                                html +='<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +="<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' title='sheet-dots' width='' height=''></picture></div>";
                                html += '<ul class="dropdown-menu edit-sheet">';    
                                @if(adminPermissionCheck('contactus.show'))
                                html += '<li><a class="dropdown-item" href="' +current_url_show +'">View</a></li>';
                                @endif
                                html +=  '</ul></div>';
                            @else
                                html +=  '-';
                            @endif
                            return html;
                        },
                    }
                ],
                columnDefs: [{
                    targets: '_all',
                    defaultContent: '-'
                }, ],

                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#manage-contactus_previous").html("<img src='{{ asset('assets/images/back-arrow.svg') }}' alt='back-icon' title='back'>");
                    $("#manage-contactus_next").html("<img src='{{ asset('assets/images/arrow-next.svg') }}' alt='next-icon' title='next'>");
                    var pageInfo = table.page.info();
                    var currentPage = pageInfo.page + 1;
                    if (currentPage == 1 && recordsTotal  <= 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                },
            });
        });
    </script>
@endsection
