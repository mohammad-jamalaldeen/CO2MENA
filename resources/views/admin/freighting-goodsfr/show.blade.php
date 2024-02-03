@extends('admin.layouts.app')
@section('title')
View Freighting Goods
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('freighting-goodsgvh.index') }}">Freighting Good</a></li>
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
                                <td>{{ !empty($fgshow->row_id) ? $fgshow->row_id : 'N/A' }}</td>
                            </tr> --}}
                            <tr>
                                <th>Vehicles</th>
                                <td>{{ !empty($fgshow->vehicle) ? $fgshow->vehicle : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ !empty($fgshow->type) ? $fgshow->type : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td>{{ !empty($fgshow->unit) ? $fgshow->unit : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Emission Factor</th>
                                <td>{{ !empty($fgshow->factors) ? $fgshow->factors : 'N/A' }}</td>
                            </tr>
                            {{-- <tr>
                                <th>Formula</th>
                                <td>{{ !empty($fgshow->formula) ? $fgshow->formula : 'N/A' }}</td>
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
