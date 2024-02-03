@extends('admin.layouts.app')
@section('title')
    View Backup Report
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('backup-report.index') }}">Backup-Report</a></li>
    <li class="breadcrumb-item active">View</li>
</ul>
<div class="customer-support">
    <div class="row">
        <div class="col-md-12">
            <table id="w0" class="table table-bordered detail-view detail-view-table">
                <tbody>
                    <tr><th>Company Name</th><td>{{!empty($backupReport['company']['company_name']) ? $backupReport['company']['company_name']:"N/A" }}</td></tr>
                    <tr><th>Created Date</th><td>{{!empty($backupReport['created_at']) ? $backupReport['created_at']:"N/A" }}</td></tr>
                    @if(isset($backupReport['status']))
                        @if($backupReport['status'] == \App\Models\CompanyBackup::IS_PENDING)
                            @php  $badgename = "Pending"; $badge="status upload" @endphp
                        @elseif($backupReport['status'] == \App\Models\CompanyBackup::IS_PROGRESS)
                            @php  $badgename = "In Progress"; $badge="status inprogress" @endphp
                        @elseif($backupReport['status'] == \App\Models\CompanyBackup::IS_COMPLETE)
                            @php  $badgename = "Complete"; $badge="status complet" @endphp
                        @elseif($backupReport['status'] == \App\Models\CompanyBackup::IS_FAIL)
                            @php  $badgename = "Fail"; $badge="status fail" @endphp
                        @else
                            @php  $badgename = "N/A"; $badge="status draft" @endphp
                        @endif
                    @else
                        @php  $badgename = "N/A"; $badge="status draft" @endphp
                    @endif
                    <tr><th>Status</th><td><span class="info-detail {{$badge}}">{{$badgename}}</span></td></tr> 
                    <tr><th>Backup Report</th><td><a target="_blank" href="{{$backupReport['file']}}"><span class="file-icon"><picture><img src="{{ asset('assets/images/file-icon.png') }}" alt="file-icon" title="file-icon" width="34" height="41"></picture></span></a></td></tr> 
                </tbody>
            </table>
        </div>
    </div>
</div>
@if(!empty($jsonBackup) && count($jsonBackup) > 0)
<div class="row align-items-center mt-3">
    <div class="col-md-6 col-12">
        <h2 class="section-title">Backup Sheet List</h2>
    </div>
    <div class="col-md-12 mt-4">
        <div class="row">
            <table id="reportsheetdata" class="table custome-datatable reportsheetdata-table display">
                <thead>
                    <tr>
                        <th>Uploded Sheet Name</th>
                        <th>Emssion Calculated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection
@section("footer_scripts")
<script type="text/javascript">
    $(document).ready(function(){
        var url ="{{ asset('assets/loader.gif') }}";
        var table = $("#reportsheetdata").DataTable({
                processing: false,
                serverSide: true,
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" title="loader" class="custom-loader" />'

                },
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function(settings, json) {
                    $("#reportsheetdata").wrap(
                        "<div class='table-main-wrap reportsheetdata-wrap'></div>");
                },
                ajax: {
                    url: "{{ route('backup-report.show', Request()->id) }}",
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        } 
                    },
                },
                columns: [

                    {
                        data: 'uploded_sheet',
                        name: 'uploded_sheet',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'emission_calculated',
                        name: 'emission_calculated',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ],
                columnDefs: [{
                    targets: '_all',
                    defaultContent: '-'
                }, ],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#reportsheetdata_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon" title="back">');
                    $("#reportsheetdata_next").html(
                        '<img src="{{ asset('assets/images/arrow-next.svg') }}" alt="next-icon" title="next">');
                    var pageInfo = table.page.info();
                    var currentPage = pageInfo.page + 1;
                    if (currentPage == 1 && recordsTotal  <= 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                }
        });
    })
</script>
@endsection