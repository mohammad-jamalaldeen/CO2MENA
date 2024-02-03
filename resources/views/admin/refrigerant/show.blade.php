@extends('admin.layouts.app')
@section('title')
View Refrigerant
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('refrigerants.index')}}">Management Refrigerant</a></li>
    <li class="breadcrumb-item active">View</li>
</ul>
<div class="customer-support">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table  table-bordered detail-view detail-view-table">
                    <tbody>
                        <tr><th>Name</th><td>{{!empty($refrigerant->emission) ? $refrigerant->emission:"N/A" }}</td></tr>
                        <tr><th>Type</th><td>{{!empty($refrigerant->type) ? $refrigerant->type:"N/A" }}</td></tr>
                        <tr><th>Unit</th><td>{{!empty($refrigerant->unit) ? $refrigerant->unit:"N/A" }}</td></tr>
                        <tr><th>Emission Factor</th><td>{{!empty($refrigerant->factors) ? $refrigerant->factors:"N/A" }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection