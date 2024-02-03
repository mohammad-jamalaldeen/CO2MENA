@extends('admin.layouts.app')
@section('title')
View Emission Factor
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('emission-factors.index') }}">Emission Factor Management</a></li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="customer-support">
        <div class="row">
            <div class="col-md-12">
                    <table id="w0" class="table  table-bordered detail-view detail-view-table">
                        <tbody>
                            <tr>
                                <th>No</th>
                                <td>{{ !empty($scope->no) ? $scope->no : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ !empty($scope->name) ? $scope->name : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Created Date</th>
                                <td>{{ !empty($scope->created_at) ? $scope->created_at : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Updated Date</th>
                                <td>{{ !empty($scope->updated_at) ? $scope->updated_at : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated By</th>
                                <td>{{ !empty($user->name) ? $user->name : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>IP Address</th>
                                <td>{{ !empty($scope->ip_address) ? $scope->ip_address : 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
@endsection
