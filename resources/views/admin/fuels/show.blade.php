@extends('admin.layouts.app')
@section('title')
View Fuel
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('fuels.index')}}">Fuel Management</a></li>
    <li class="breadcrumb-item active">View</li>
</ul>
<div class="customer-support">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table  table-bordered detail-view detail-view-table">
                    <tbody>
                        <tr>
                            <th>Type</th>
                            <td>{{!empty($fuels->type) ? $fuels->type:"N/A" }}</td>
                        </tr>
                        <tr>
                            <th>Fuel</th>
                            <td>{{!empty($fuels->fuel) ? $fuels->fuel:"N/A" }}</td>
                        </tr>
                        <tr>
                            <th>Unit</th>
                            <td>{{!empty($fuels->unit) ? $fuels->unit:"N/A" }}</td>
                        </tr>
                        <tr>
                            <th>Emission Factor</th>
                            <td>{{!empty($fuels->factor) ? $fuels->factor:"N/A" }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection