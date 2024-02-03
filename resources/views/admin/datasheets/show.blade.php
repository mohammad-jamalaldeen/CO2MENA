@extends('admin.layouts.app')
@section('title')
    View Activity Sheet
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('datasheet.index') }}">Activity Sheets</a>
        </li>
        <li class="breadcrumb-item active">View</li>
    </ul>
    <div class="customer-support">
        <div class="row">
            <div class="col-md-12">
                
                    <table id="w0" class="table  table-bordered detail-view detail-view-table">
                        <tbody>
                            <tr>
                                <th>Activity Sheet Name</th>
                                <td>{{ pathinfo($get_details->calculated_file_name, PATHINFO_FILENAME) }}</td>
                            </tr>
                            <tr>
                                <th>Date & Time</th>
                                <td>{{ date('M j, Y h:m A', strtotime($get_details->date_time)) }}</td>
                            </tr>
                            <tr>
                                <th>Uoloaded by</th>
                                <td>{{ $get_details->uploaded_by }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
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
                                <th>Company Name</th>
                                <td>{{ $get_details->company->company_name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td> {{ $get_details->description }}</td>
                            </tr>
                            <tr>
                                <th>Reporting Period</th>
                                <td>
                                    @php
                                        $start_date = date('d/m/Y', strtotime($get_details->reporting_start_date));
                                        $end_date = date('d/m/Y', strtotime($get_details->reporting_end_date));
                                    @endphp

                                    {{ $start_date . ' - ' . $end_date }}
                            </tr>
                            <tr>
                                <th>Data Assessor</th>
                                <td>{{ $get_details->data_assessor }}</td>
                            </tr>
                            <tr>
                                <th>Last Action By</th>
                                <td>{{ $get_details->uploaded_by }}</td>
                            </tr>
                            <tr>
                                <th>Uploaded Sheet</th>
                                <td>
                                    @if ($get_details instanceof \App\Models\Datasheet && !empty($get_details->uploded_sheet && $get_details->uploded_sheet && $get_details->uploded_sheet != '-'))
                                            <a href="{{ asset($get_details->uploded_sheet) }}" target="_blank">
                                                View Sheet
                                            </a>
                                    @else
                                        <p> No Sheet available </p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Emission Calculated</th>
                                <td>
                                    @if ($get_details->emission_calculated && $get_details->emission_calculated != '-')
                                        <a href="{{ asset($get_details->emission_calculated) }}" target="_blank">
                                            View Sheet
                                        </a>
                                    @else
                                        <p> No Sheet available </p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>System Generated Sheet</th>
                                <td>
                                    @if (!empty($get_details->company->sample_datasheet))
                                        <a href="{{ $get_details->company->sample_datasheet }}" target="_blank">
                                            View Sheet
                                        </a>
                                    @else
                                        <p> No Sheet available </p>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    {{-- <div class="row towbutton-row">
                        <div class="col-md-6 col-6">
                            <a href="{{ route('datasheet.index') }}" class="back-btn">back</a>
                        </div>
                    </div> --}}
                
            </div>
        </div>
    </div>
@endsection