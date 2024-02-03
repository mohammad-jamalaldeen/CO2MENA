@extends('admin.layouts.app')
@section('title')
View Vehicle
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('vehicles.index')}}">Vehicle Management</a></li>
    <li class="breadcrumb-item active">View</li>
</ul>
<div class="customer-support">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table  table-bordered detail-view detail-view-table">
                    <tbody>
                        <tr><th>Vehicle Type</th><td>@if(!empty($vehicles->vehicle_type)) @if($vehicles->vehicle_type == 1)Passenger Vehicles @elseif($vehicles->vehicle_type == 2)Delivery Vehicles @else N/A @endif @else N/A @endif</td></tr>
                        <tr><th>Vehicle</th><td>{{!empty($vehicles->vehicle) ? $vehicles->vehicle:"N/A" }}</td></tr>
                        {{-- <tr><th>Type</th><td>{{!empty($vehicles->type) ? $vehicles->type:"N/A" }}</td></tr> --}}
                        <tr><th>Fuel</th><td>{{!empty($vehicles->fuel) ? $vehicles->fuel:"N/A" }}</td></tr>
                        <tr><th>Emission Factor</th><td>{{!empty($vehicles->factors) ? $vehicles->factors:"N/A" }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection