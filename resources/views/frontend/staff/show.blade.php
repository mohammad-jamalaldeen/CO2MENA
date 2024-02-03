@extends('frontend.layouts.main')
@section('title')
    Staff Member View
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Staff Member</a></li>
        <li class="breadcrumb-item active">Staff Member Detail</li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table table-bordered detail-view">
                    <tbody>
                        <tr><th>Name</th><td>{{!empty($user->name) ? $user->name:"N/A" }}</td></tr>
                        <tr><th>Email</th><td>{{!empty($user->email) ? $user->email:"N/A" }}</td></tr>
                        <tr><th>User Name</th><td>{{!empty($user->username) ? $user->username:"N/A" }}</td></tr>
                        <tr><th>Phone Number</th><td>{{!empty($user->contact_number) ? $user->contact_number:"N/A" }}</td></tr>
                        <tr><th>Role</th><td>{{!empty($user->role->role) ? $user->role->role:"N/A" }}</td></tr>
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
                        <tr><td></td><td><a href="{{route('staff.index')}}" class="info-detail status" title="back">Back</a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
@endsection
