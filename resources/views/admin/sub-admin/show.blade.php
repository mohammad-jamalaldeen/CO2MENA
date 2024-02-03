@extends('admin.layouts.app')
@section('title')
View Sub Admin
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('sub-admin.index')}}">Sub Admin</a></li>
    <li class="breadcrumb-item active">View</li>
</ul>
<div class="customer-support">
    <div class="row">
        <div class="col-md-12">
            
            <table id="w0" class="table table-bordered detail-view detail-view-table">
                <tbody>
                    <tr><th>Name</th><td>{{!empty($user->name) ? $user->name:"N/A" }}</td></tr>
                    <tr><th>Email Address</th><td>{{!empty($user->email) ? $user->email:"N/A" }}</td></tr>
                    <tr><th>UserName</th><td>{{!empty($user->username) ? $user->username:"N/A" }}</td></tr>
                    <tr><th>Contact Number</th><td>{{!empty($user->contact_number) ? $user->contact_number:"N/A" }}</td></tr>
                    <tr><th>User Role</th><td>{{!empty($staffrole->role) ? $staffrole->role:"N/A" }}</td></tr>
                    <tr>
                        <th>Profile</th>
                        <td>
                                @if($user instanceof \App\Models\User && !empty($user->profile_picture))
                                    <img alt="profile-icon" src="{{$user->profile_picture}}" class="preview-customer-profile imagepop" style="max-width:123px; max-height:123px;">
                                @else
                                    <img alt="profile-icon" src="{{asset('/assets/images') . '/profile.png'}}" class="preview-customer-profile" style="max-width:123px; max-height:123px;">
                                @endif
                        </td>
                    @if(isset($user->status))
                        
                        @if($user->status == '1')
                            @php  $badgename = "Active"; $badge="status complet" @endphp
                        @elseif($user->status == '0')
                            @php  $badgename = "In Active"; $badge="status faile" @endphp
                        @else
                            @php  $badgename = "N/A"; $badge="status draft" @endphp
                        @endif
                    @else
                        @php  $badgename = "N/A"; $badge="status draft" @endphp
                    @endif
                    <tr><th>Status</th><td><span class="info-detail {{$badge}}">{{$badgename}}</span></td></tr>
                </tbody>
            </table>
           
        </div>
    </div>
</div>
<div class="row mt-5">
    <div class="col-12">
    <h2 class="mb-4 section-title">{{!empty($user->name) ? $user->name:""}} Activities</h2>
    <table  id="sub-admin-activity" class="table custome-datatable manage-customer-table display"  >
        <thead>
            <tr>
                <th class="mw-200">Description</th>
                <th class="mw-200">Activity</th>
                <th class="mw-200">Date</th>
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
    $(document).ready(function(){
        var table = $("#sub-admin-activity").DataTable({
            // scrollX: true,
            processing: true,
            serverSide: true,
            language: {
                searchPlaceholder: "Search"
            },
            "pageLength": <?php echo config('constants.perPageRecords'); ?>,
            ajax: {
                url: "{{route('sub-admin.show.list',Request()->id)}}",
                error: function(xhr, textStatus, errorThrown) {
                    // Handle the HTTP status code here
                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    } 
                },
            },
            "initComplete": function (settings, json) {  
                    $("#sub-admin-activity").wrap("<div class='table-view-activity sub-admin-activity'></div>");            
                },
            order: [[2, 'desc']],
            columns: [
                
                { 
                    data: 'description',
                    name:'description',
                    orderable:true,
                    searchable:true,
                    'width':"33%"
                },
                { 
                    data: 'action',
                    name:'action',
                    orderable:true,
                    searchable:true
                },
                { 
                    data: 'created_at',
                    name:'created_at',
                    orderable:true,
                    searchable:true
                },
            ],
            columnDefs: [
                {
                    targets: '_all',
                    defaultContent: '-'
                },
            ],
            "drawCallback": function (settings) {
                var api = this.api();
                var recordsTotal = api.page.info().recordsTotal;
                $("#sub-admin-activity_previous").html('<img src="{{asset("assets/images/back-arrow.svg")}}" alt="back-icon">');
                $("#sub-admin-activity_next").html('<img src="{{asset("assets/images/arrow-next.svg")}}" alt="next-icon">');
                var pageInfo = table.page.info();
                var currentPage = pageInfo.page + 1;
                if (currentPage == 1 && recordsTotal  <= 20) {
                    $('.dataTables_paginate').hide();
                } else {
                    $('.dataTables_paginate').show();
                }
            }
        });
    });
</script>
@endsection