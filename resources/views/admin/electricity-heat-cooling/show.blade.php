@extends('admin.layouts.app')
@section('title')
View Electricity Heat Cooling
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('electricity-heat-cooling.index') }}">Electricity Heat
                Cooling Management</a></li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="customer-support">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <table id="w0" class="table table-bordered detail-view detail-view-table">
                        <tbody>
                            <tr>
                                <th>ELECTRICITY TYPE</th>
                                <td>
                                    @if (!empty($electricity_heat_cooling->electricity_type))@if ($electricity_heat_cooling->electricity_type == 1)Electricity Grid @elseif($electricity_heat_cooling->electricity_type == 2) Heat And Steam @elseif($electricity_heat_cooling->electricity_type == 3) District Cooling @else N/A @endif @else N/A @endif
                                </td>
                            </tr>
                            <tr>
                                <th>COUNTRY</th>
                                <td>
                                    @if(!empty($electricity_heat_cooling->country))@foreach($countries as $country)@if($country->id == $electricity_heat_cooling->country){{ $country->name }}@endif @endforeach @else N/A @endif
                                </td>
                            </tr>
                            <tr>
                                <th>ACTIVITY</th>
                                <td>{{ !empty($electricity_heat_cooling->activity) ? $electricity_heat_cooling->activity : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ !empty($electricity_heat_cooling->type) ? $electricity_heat_cooling->type : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td>{{ !empty($electricity_heat_cooling->unit) ? $electricity_heat_cooling->unit : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Emission Factor</th>
                                <td>{{ !empty($electricity_heat_cooling->factors) ? $electricity_heat_cooling->factors : 'N/A' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
