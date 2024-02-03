@extends('admin.layouts.app')
@section('title')
View Water Supply Treatment
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('water-supply-treatment.index')}}">Water Supply Treatment Management</a></li>
    <li class="breadcrumb-item active">View</li>
</ul>
<div class="customer-support">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table  table-bordered detail-view detail-view-table">
                    <tbody>
                        <tr><th>Type</th><td>{{!empty($watersupplytreatment->type) ? $watersupplytreatment->type:"N/A" }}</td></tr>
                        <tr><th>Unit</th><td>{{!empty($watersupplytreatment->unit) ? $watersupplytreatment->unit:"N/A" }}</td></tr>
                        <tr><th>Emission Factor</th><td>{{!empty($watersupplytreatment->factors) ? $watersupplytreatment->factors:"N/A" }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection