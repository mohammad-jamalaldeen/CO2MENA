@extends('admin.layouts.app')
@section('title')
View City
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('city.index')}}">City Management</a></li>
    <li class="breadcrumb-item active">View</li>
</ul>
<div class="customer-support">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table   table-bordered detail-view">
                    <tbody>
                        <tr><th>Origin (city or IATA code)</th><td>{{!empty($city->name) ? $city->name:"N/A" }}</td><tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection