@extends('admin.layouts.app')
@section('title')
    Backup Reports
@endsection
@section('content')
@if (!adminPermissionCheck('backup-report.create'))
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
                    <a class="createsheet-btn" href="{{ route('backup-report.create') }}" title="create">Create Backup Reports</a>
                </div>
            </div>
        </div>
        <div class="fillter-option">
            <div class="row">
                <div class="col-12">
                    {{-- <form action="" method="GET"> --}}
                        <ul class="new-table-filter">
                            <li>
                                <select class="form-control backup-report-company" name="company" title="Select Company" id="company">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{$company['id']}}">{{$company['company_name']}}</option>
                                    @endforeach
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
        <table id="manage-backup-report" class="table custome-datatable display" width="100%">
            <thead>
                <tr>
                    <th class="mw-120">COMPANY Name</th>
                    <th class="mw-120">CREATED DATE</th>
                    <th class="mw-100">STATUS</th>
                    <th class="action-th"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>    
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var url ="{{ asset('assets/loader.gif') }}";
            var table = $("#manage-backup-report").DataTable({
                bInfo: true,
                lengthChange: true,
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function(settings, json) {
                    $("#manage-backup-report").wrap(
                        "<div class='table-main-wrap manage-backup-report-wrap'></div>");
                },
                processing: true,
                serverSide: true,
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" title="loader" class="custom-loader" />'
                },
                ajax: {
                    url: "{{ route('backup-report.index') }}",
                    dataType: "json",
                    data: function(d) {
                        d.company_filter = $('#company').val();
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
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'company.company_name',
                        name: 'company.company_name',
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
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            if (data == '2') {
                                html += '<span class="status complet">Complete</span>';
                            } else if (data == '1') {
                                html += '<span class="status inprogress">In Progress</span>';
                            } else if (data == '3') {
                                html += '<span class="status faile">Fail</span>';
                            } else {
                                html += '<span class="status publish">Pending</span>';
                            }
                            return html;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: "action-th",
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            var current_url_show = "{{url('admin/backup-report/show')}}"+'/'+id;
                            @if(adminMultiplePermissionCheck('backup-report', ['download','show']) > 0)
                                if (full.file != "" && full.file != '-') {
                                    html +=
                                        '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                    html +=
                                        "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' title='sheet-dots' width='' height=''></picture></div>";
                                    html += '<ul class="dropdown-menu edit-sheet">';
                                    @if(adminPermissionCheck('backup-report.download'))
                                        html += '<li><a class="dropdown-item" href="' +full.file + '" download>Download</a></li>';
                                    @endif
                                    @if(adminPermissionCheck('backup-report.show'))
                                        html += '<li><a class="dropdown-item" href="'+current_url_show+'" >View</a></li>';
                                    @endif
                                    html += '</div></div>';
                                } else 
                                {
                                    html += '-';
                                }
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
                    $("#manage-backup-report_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="previous" title="previous">');
                    $("#manage-backup-report_next").html(
                        '<img src="{{ asset('assets/images/arrow-next.svg') }}" alt="next" title="next">');
                    var pageInfo = table.page.info();
                    var currentPage = pageInfo.page + 1;
                    if (currentPage == 1 && recordsTotal  <= 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                },
            });
            $("#company").change(function(){
                table.draw();
            });
            $(".reset-btn").click(function(){
                $('select[name="company"]').val(null);
                $('select[name="company"]').selectpicker('refresh');
                table.draw();
            });
        });
    </script>
@endsection
