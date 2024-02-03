@extends('admin.layouts.app')
@section('title')
View Food Cosumption
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('foodcosumption.index') }}">Food Cosumption Management</a></li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="customer-support">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <table id="w0" class="table  table-bordered detail-view detail-view-table">
                        <tbody>
                            <tr>
                                <th>Food</th>
                                <td>{{ !empty($foodcosumption->vehicle) ? $foodcosumption->vehicle : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ !empty($foodcosumption->type) ? $foodcosumption->type : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td>{{ !empty($foodcosumption->unit) ? $foodcosumption->unit : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Emission Factor</th>
                                <td>{{ !empty($foodcosumption->factors) ? $foodcosumption->factors : 'N/A' }}</td>
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