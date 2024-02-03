@extends('admin.layouts.app')
@section('title')
View Flight
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('flight.index') }}">Flight Management</a></li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="customer-support">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <table id="w0" class="table  table-bordered detail-view detail-view-table">
                        <tbody>
                            <tr>
                                <th>Origin</th>
                                <td>@if (!empty($flight->origin))@foreach ($cities as $origin)@if ($origin->id == $flight->origin){{ $origin->name }}@endif @endforeach @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>Destination</th>
                                <td>@if (!empty($flight->destination))@foreach ($cities as $destination)@if ($destination->id == $flight->destination){{ $destination->name }}@endif @endforeach @else N/A @endif</td>
                            </tr>
                            <tr>
                                <th>Distance</th>
                                <td>{{ !empty($flight->distance) ? $flight->distance : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Class</th>
                                <td>{{ !empty($flight->class) ? $flight->class : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Single way / return</th>
                                <td>{{ !empty($flight->single_way_and_return) ? $flight->single_way_and_return : 'N/A' }}
                                </td>
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
