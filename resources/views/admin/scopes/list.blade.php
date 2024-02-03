@extends('admin.layouts.app')
@section('title')
    Scope Management
@endsection
@section('content')
    <div class="table-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="dw-header">
                    <a class="createsheet-btn" href="{{ route('scopes.create') }}" title="create">
                        CREATE Scope
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table">
        <div class="responsive-table">
            <table id="manage-scopes" class="table custome-datatable manage-scopes-table display" width="100%">
                <thead>
                    <tr>
                        <th>INDUSTRY</th>
                        <th>CREATE DATE</th>
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
            $("#manage-scopes").DataTable({
                bInfo: true,
                processing: true,
                serverSide: true,
                lengthChange: true,
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" class="custom-loader" />'
                },
                "initComplete": function (settings, json) {  
                    $("#manage-scopes").wrap("<div class='table-no-padding manage-scopes-wrap'></div>");            
                },
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                ajax:{
                    url:  "{{ route('scopes.index') }}",
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
                    [1, 'desc']
                ],
                rowsGroup: [0],
                columns: [{
                        data: 'industry.name',
                        name: 'industry.name',
                        orderable: false,
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
                            var indus_id = full.industry_id;
                            var current_url_edit = "{{ url('admin/scopes/edit') }}"+'/'+indus_id;
                            var current_url_show = "{{ url('admin/scopes/show') }}"+'/'+indus_id;
                            html +='<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                            html +="<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' width='' height=''></picture></div>";
                            html +='<ul class="dropdown-menu edit-sheet"><li><a class="dropdown-item" href="' +current_url_edit +'">Edit</a></li><li><a class="dropdown-item" href="' +current_url_show +'">View</a></li></ul>';
                            return html;
                        },
                    }
                ],

                columnDefs: [
                    {
                        targets: '_all',
                        defaultContent: '-'
                    },
                 ],
        //          createdRow: function(row, data, dataIndex) {
        //             console.log(data.industry_id);
        //             if (data.industry_id) {
        //                 $('td', row).eq(0).attr('rowspan', 3);
        //                 $('tr:eq(2)', row).css('display', 'none');
        //  $('td:eq(3)', row).css('display', 'none');
        // //  $('td:eq(3)', row).css('display', 'none');
        // //  $('td:eq(4)', row).css('display', 'none');
        //             }
        //         },
                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#manage-scopes_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#manage-scopes_next").html(
                        '<img src="{{ asset('assets/images/arrow-next.svg') }}" alt="next-icon">');
                    if (settings.aoData.length  < 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                },
            });
        });
    </script>
@endsection
