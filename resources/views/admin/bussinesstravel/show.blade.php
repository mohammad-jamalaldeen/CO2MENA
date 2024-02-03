@extends('admin.layouts.app')
@section('title')
View Business Travel View
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('bussinesstravel.index') }}">Business Travel</a></li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="customer-support">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <table id="w0" class="table  table-bordered detail-view detail-view-table">
                        <tbody>
                            {{-- <tr>
                                <th>Row ID</th>
                                <td>{{ !empty($bussinessshow->row_id) ? $bussinessshow->row_id : 'N/A' }}</td>
                            </tr> --}}
                            <tr>
                                <th>Vehicles</th>
                                <td>{{ !empty($bussinessshow->vehicles) ? $bussinessshow->vehicles : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ !empty($bussinessshow->type) ? $bussinessshow->type : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Fuel</th>
                                <td>{{ !empty($bussinessshow->fuel) ? $bussinessshow->fuel : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td>{{ !empty($bussinessshow->unit) ? $bussinessshow->unit : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Emission Factor</th>
                                <td>{{ !empty($bussinessshow->factors) ? $bussinessshow->factors : 'N/A' }}</td>
                            </tr>
                            {{-- <tr>
                                <th>Formula</th>
                                <td>{{ !empty($bussinessshow->formula) ? $bussinessshow->formula : 'N/A' }}</td>
                            </tr> --}}
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12">
                            <div class="btn-wrap">
                                {{-- <a href="{{ route('bussinesstravel.index') }}" class="back-btn">back</a> --}}
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
@endsection
