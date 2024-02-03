@extends('admin.layouts.app')
@section('title')
View Transmission And Distribution
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('transmission-and-distribution.index')}}">Transmission And Distribution Management</a></li>
    <li class="breadcrumb-item active">View</li>
</ul>
<div class="customer-support">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table table-bordered detail-view detail-view-table">
                    <tbody>
                        <tr><th>Activity</th><td>{{!empty($transmission_and_distribution->activity) ? $transmission_and_distribution->activity:"N/A" }}</td></tr>
                        <tr><th>Unit</th><td>{{!empty($transmission_and_distribution->unit) ? $transmission_and_distribution->unit:"N/A" }}</td></tr>
                        <tr><th>Emission Factor</th><td>{{!empty($transmission_and_distribution->factors) ? $transmission_and_distribution->factors:"N/A" }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection