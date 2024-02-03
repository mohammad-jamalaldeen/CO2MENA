@extends('admin.layouts.app')
@section('title')
View Staff Member
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Manage Customer</a></li>
        <li class="breadcrumb-item"><a href="{{ route('companystaff.index', Request()->companyid) }}">Staff Member</a></li>
        <li class="breadcrumb-item active">Staff Member Detail</li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table table-bordered detail-view detail-view-table">
                    <tbody>
                        <tr><th>Employee ID</th><td>{{!empty($user->employee_id) ? $user->employee_id:"N/A" }}</td></tr>
                        <tr><th>Name</th><td>{{!empty($user->name) ? $user->name:"N/A" }}</td></tr>
                        <tr><th>Email Address</th><td>{{!empty($user->email) ? $user->email:"N/A" }}</td></tr>
                        <tr><th>User Name</th><td>{{!empty($user->username) ? $user->username:"N/A" }}</td></tr>
                        <tr><th>Contact Number</th><td>{{!empty($user->contact_number) ? $user->contact_number:"N/A" }}</td></tr>
                        <tr><th>User Role</th><td>{{!empty($user->role->role) ? $user->role->role:"N/A" }}</td></tr>
                        @if(!empty($user->status))
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
                        <tr> 
                            <th>Profile Image</th>
                            <td>
                            @if($user instanceof \App\Models\User && !empty($user->profile_picture))
                                <img src="{{$user->profile_picture}}" alt="profile-icon" class="imagepop preview-customer-profile" style="max-width:123px; max-height:123px;">
                            @else
                                <img src="{{asset('/assets/images') . '/profile.png'}}" alt="profile-icon" class="preview-customer-profile" style="max-width:123px; max-height:123px;">
                            @endif
                            </td>
                        </tr>
                        <tr><th>Date Of Joined</th><td>{{!empty($user->created_at) ? date('Y-m-d',strtotime($user->created_at)):"N/A" }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
@endsection
