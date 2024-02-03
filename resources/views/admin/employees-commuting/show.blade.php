@extends('admin.layouts.app')
@section('title')
View Employees Commuting 
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('employees-commuting.index') }}">Employees Commuting</a></li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="customer-support">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <table id="w0" class="table table-bordered detail-view detail-view-table">
                        <tbody>
                            {{-- <tr>
                                <th>Row ID</th>
                                <td>{{ !empty($empcomshow->row_id) ? $empcomshow->row_id : 'N/A' }}</td>
                            </tr> --}}
                            <tr>
                                <th>Vehicles</th>
                                <td>{{ !empty($empcomshow->vehicle) ? $empcomshow->vehicle : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ !empty($empcomshow->type) ? $empcomshow->type : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Fuel</th>
                                <td>{{ !empty($empcomshow->fuel) ? $empcomshow->fuel : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td>{{ !empty($empcomshow->unit) ? $empcomshow->unit : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Emission Factor</th>
                                <td>{{ !empty($empcomshow->factors) ? $empcomshow->factors : 'N/A' }}</td>
                            </tr>
                            {{-- <tr>
                                <th>Formula</th>
                                <td>{{ !empty($empcomshow->formula) ? $empcomshow->formula : 'N/A' }}</td>
                            </tr> --}}
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
@endsection
