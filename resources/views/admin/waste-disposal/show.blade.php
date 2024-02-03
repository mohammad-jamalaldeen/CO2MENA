@extends('admin.layouts.app')
@section('title')
View Waste disposal
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('waste-disposal.index')}}">Waste disposal Management</a></li>
    <li class="breadcrumb-item active">View</li>
</ul>
<div class="customer-support">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table  table-bordered detail-view detail-view-table">
                    <tbody>
                        <tr><th>Activity</th><td>{{!empty($waste_disposal->waste_type) ? $waste_disposal->waste_type:"N/A" }}</td></tr>
                        <tr><th>Type</th><td>{{!empty($waste_disposal->type) ? $waste_disposal->type:"N/A" }}</td></tr>
                        <tr><th>Emission Factor</th><td>{{!empty($waste_disposal->factors) ? $waste_disposal->factors:"N/A" }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection