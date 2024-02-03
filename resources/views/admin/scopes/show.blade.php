@extends('admin.layouts.app')
@section('title')
    View Scope
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('scopes.index') }}">Scopes</a></li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="row">            
        <div class="col-md-12">
            <table id="w0" class="table  table-bordered detail-view detail-view-table">
                <tbody>
                    <tr>
                        <th>Industry</th>
                        <td>{{ !empty($datascope['industry']) ? $datascope['industry'] : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{{ !empty($datascope['date']) ? $datascope['date'] : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Scope 1</th>
                        <td>{{ !empty($datascope['scope1']) ? $datascope['scope1'] : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Scope 2</th>
                        <td>{{ !empty($datascope['scope2']) ? $datascope['scope2'] : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Scope 3</th>
                        <td>{{ !empty($datascope['scope3']) ? $datascope['scope3'] : 'N/A' }}</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection