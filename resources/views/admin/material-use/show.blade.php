@extends('admin.layouts.app')
@section('title')
View Material Use
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('material-use.index')}}">Material Use Management</a></li>
    <li class="breadcrumb-item active">View</li>
</ul>
<div class="customer-support">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table table-bordered detail-view detail-view-table">
                    <tbody>
                        <tr><th>Activity</th><td>{{!empty($material_use->activity) ? $material_use->activity:"N/A" }}</td></tr>
                        <tr><th>Waste Type</th><td>{{!empty($material_use->waste_type) ? $material_use->waste_type:"N/A" }}</td></tr>
                        <tr><th>Emission Factor</th><td>{{!empty($material_use->factors) ? $material_use->factors:"N/A" }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection