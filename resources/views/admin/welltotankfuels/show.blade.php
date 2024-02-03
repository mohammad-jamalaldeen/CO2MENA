@extends('admin.layouts.app')
@section('title')
View Well To Tank Fuels
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('welltotankfuels.index') }}">Well To Tank Fuels Management</a></li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="customer-support">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <table id="w0" class="table  table-bordered detail-view detail-view-table">
                        <tbody>
                            <tr>
                                <th>TYPE</th>
                                <td>{{ !empty($wttfules->type) ? $wttfules->type : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>FUEL</th>
                                <td>{{ !empty($wttfules->fuel) ? $wttfules->fuel : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td>{{ !empty($wttfules->unit) ? $wttfules->unit : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Emission Factor</th>
                                <td>{{ !empty($wttfules->factors) ? $wttfules->factors : 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
@endsection
