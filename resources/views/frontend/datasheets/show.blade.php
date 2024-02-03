@extends('frontend.layouts.main')
@section('title')
    Activity Sheet Details
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend-datasheets.index') }}" title="Activity Sheets">Activity Sheets</a>
        </li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <table id="w0" class="table table-bordered detail-view">
                    <tbody>
                        <tr>
                            <th>Activity SHEET NAME</th>
                            <td>{{ pathinfo($get_details->calculated_file_name, PATHINFO_FILENAME) }}</td>
                        </tr>
                        <tr>
                            <th>DATE & TIME</th>
                            <td>{{ date('M j, Y h:m A', strtotime($get_details->date_time)) }}</td>
                        </tr>
                        <tr>
                            <th>UPLOADED BY</th>
                            <td>{{ $get_details->uploaded_by }}</td>
                        </tr>
                        <tr>
                            <th>STATUS</th>
                            <td>
                                @if ($get_details->status == 0)
                                    {{ $status = 'Uploded' }}
                                @elseif($get_details->status == 1)
                                    {{ $status = 'In Progress' }}
                                @elseif($get_details->status == 2)
                                    {{ $status = 'Completed' }}
                                @elseif($get_details->status == 3)
                                    {{ $status = 'Published' }}
                                @elseif($get_details->status == 4)
                                    {{ $status = 'Failed' }}
                                @else
                                    {{ $gender = 'Drafted' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>SOURCE ID</th>
                            <td>{{ $get_details->source_id }}</td>
                        </tr>
                        <tr>
                            <th>DESCRIPTION</th>
                            <td> {{ $get_details->description }}</td>
                        </tr>
                        <tr>
                            <th>REPORTING PERIOD</th>
                            <td>
                                @php
                                    $start_date = date('d/m/Y', strtotime($get_details->reporting_start_date));
                                    $end_date = date('d/m/Y', strtotime($get_details->reporting_end_date));
                                @endphp

                                {{ $start_date . ' - ' . $end_date }}
                        </tr>
                        <tr>
                            <th>DATA ASSESSOR</th>
                            <td>{{ $get_details->data_assessor }}</td>
                        </tr>
                        <tr>
                            <th>LAST ACTION BY</th>
                            <td>{{ $get_details->uploaded_by }}</td>
                        </tr>
                        <tr>
                            <th>UPLODED SHEET</th>
                            <td>
                                @if ($get_details instanceof \App\Models\Datasheet && !empty($get_details->uploded_sheet && $get_details->uploded_sheet && $get_details->uploded_sheet != '-'))
                                        <a href="{{ asset($get_details->uploded_sheet) }}" target="_blank" title="View Sheet">
                                            View Sheet
                                        </a>
                                @else
                                    <p> No Sheet available </p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>EMISSION CALCULATED</th>
                            <td>
                                @if ($get_details->emission_calculated && $get_details->emission_calculated != '-')
                                    <a href="{{ asset($get_details->emission_calculated) }}" target="_blank" title="View Sheet">
                                        View Sheet
                                    </a>
                                @else
                                    <p> No Sheet available </p>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-12">
                        <div class="btn-wrap">
                            <a href="{{ route('frontend-datasheets.index') }}" class="back-btn" title="back">back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
