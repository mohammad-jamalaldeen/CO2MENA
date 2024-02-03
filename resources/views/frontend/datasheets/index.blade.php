@extends('frontend.layouts.main')
@section('title')
    Activity Sheets
@endsection
@section('content')
    @if (!frontendPermissionCheck('frontend-datasheets.create'))
        @php
            $display = 'style=display:none';
            $classlist = 'button-header-hide';
        @endphp
    @else
        @php
            $display = '';
            $classlist = '';
        @endphp
    @endif
    <div class="table-header {{ $classlist }}">
        <div class="row align-items-center" {{ $display }}>
            <div class="col-12">
                <div class="dw-header">
                    <a class="download-btn" {{ $sampleDataSheetURL != '#!' ? 'download' : '' }}
                        href="{{ $sampleDataSheetURL }}">
                        <picture>
                            <img src="{{ asset('assets/images/document-download-icon.svg') }}" alt="document-download-icon"
                                width="" height="">
                        </picture>
                        DOWNLOAD SHEET
                    </a>
                    <button class="createsheet-btn" title="create-activity-sheet" data-bs-toggle="modal"
                        data-bs-target="#creatnewDataSheet-modal">
                        Create Activity Sheet
                    </button>
                </div>
            </div>
        </div>
        <div class="fillter-option">
            <div class="row">
                <div class="col-12">
                    <ul class="new-table-filter">
                        <li>
                            <input type="text" id="dateTimePicker" placeholder="Date & Time" class="datepicker newf-btn"
                                name="date_time_filter" autocomplete="off">
                        </li>
                        <li>
                            <input type="text" id="viewreportingDate" placeholder="Reporting Period" class="newf-btn"
                                name="reporting_period_filter" autocomplete="off">
                        </li>

                        <li>
                            <select class="form-control action-select" name="last_action_by" title="Last Action"
                                id="last_action_by" placeholder="Last Action by">
                                @for ($i = 0; $i < count($filterLastAction); $i++)
                                 <option title="{{ $filterLastAction[$i]['last_action_by']}}"
                                        value="{{ $filterLastAction[$i]['last_action_by'] }}">
                                        {{ $filterLastAction[$i]['last_action_by'] }}</option>
                                    {{-- <option title="{{ ucfirst($filterLastAction[$i]['last_action_by']) }}"
                                        value="{{ $filterLastAction[$i]['last_action_by'] }}">
                                        {{ ucfirst($filterLastAction[$i]['last_action_by']) }}</option> --}}
                                @endfor
                            </select>
                        </li>
                        <li>
                            <select class="form-control" name="status" title="Status" id="status">
                                <option value="0">Uploaded</option>
                                <option value="1">In Progress</option>
                                <option value="2">Completed</option>
                                <option value="3">Published</option>
                                <option value="4">Failed</option>
                                <option value="5">Drafted</option>
                            </select>
                        </li>
                        <li>
                            <button class="reset-btn" type="button" title="reset-all">Reset All</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table tb-filter-inner {{ $classlist }}">
        <div class="responsive-table">
            <table id="manage-customer" class="table custome-datatable manage-customer-table display">
                <thead>
                    <tr>
                        <th class="mw-100"></th>
                        <th class="mw-100">NAME</th>
                        <th class="mw-100">DATE & TIME</th>
                        <th class="mw-100">UPLOADED BY</th>
                        <th class="mw-100">STATUS</th>
                        <th class="mw-100">SOURCE ID</th>
                        <th class="mw-120">REPORTING PERIOD</th>
                        <th class="mw-100">Data Assessor</th>
                        <th class="mw-100">Last Action By</th>
                        <th class="action-th"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Creatnewe Sheet Modal -->
    <div class="modal fade common-modal datasheet-modal" id="creatnewDataSheet-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="close"></button>
                <div class="content-inner">
                    <h2 class="section-title">Create New Activity Sheet</h2>
                    <form id="datasheet-add-form" action="{{ route('frontend-datasheets.store') }}"
                        enctype="multipart/form-data" method="POST" class="input-form">
                        @csrf
                        <input type="hidden" id="save_as_draft" name="save_as_draft" value="0">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="calculated_file_name">Report Title <span
                                            class="mandatory-field">*</span></label>
                                    <input type="text" class="form-controal field-clear errorCalculatedFileNameCls"
                                        name="calculated_file_name" id="calculated_file_name" value=""
                                        placeholder="Report Title">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="uploaded_by">UPLOADED BY</label>
                                    <input type="text" class="form-controal" name="uploaded_by" id="uploaded_by"
                                        value="{{ Auth::guard('web')->user()->name }}" readonly
                                        placeholder="Joan Vargas">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="data_assessor">DATA ASSESSOR</label>
                                    <input type="text" class="form-controal field-clear errorDataAssessorCls"
                                        name="data_assessor" id="data_assessor" placeholder="Enter data assessor">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="date_time">DATE & TIME <span class="mandatory-field">*</span></label>
                                    <div class="input-group date-group errorDateTimeCls">
                                        <input type="text" class="form-controal datepicker field-clear"
                                            autocomplete="off" name="date_time" id="date_time"
                                            placeholder="Select Date & Time" aria-label=""
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">
                                                <picture>
                                                    <img src="{{ asset('assets/images/calendar-icon.svg') }}"
                                                        alt="calendar-icon" width="24" height="24">
                                                </picture>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="reportingDate">REPORTING PERIOD <span
                                            class="mandatory-field">*</span></label>
                                    <div class="input-group date-group errorReportingDateCls">
                                        <input type="text" class="form-controal field-clear" autocomplete="off"
                                            name="reporting_date" id="reportingDate"
                                            placeholder="Select Reporting Period" aria-label=""
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">
                                                <picture>
                                                    <img src="{{ asset('assets/images/calendar-icon.svg') }}"
                                                        alt="calendar-icon" width="24" height="24">
                                                </picture>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="file">UPLOAD SHEET <span class="mandatory-field">*</span></label>

                                    <div class="in-file form-controal errorDatasheetFileCls">
                                        <span id="filename">Select a xlsx file to upload</span>
                                        <input type="file" name="datasheet_file" class="field-clear" id="file"
                                            onchange="datasheetFileChange(this)" />
                                        <label for="file">UPLOAD</label>
                                    </div>
                                    <span class="error-note">Accepted File Types: Xlsx</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">DESCRIPTION</label>
                                    <input type="text" class="form-controal field-clear errorDescriptionCls"
                                        name="description" value="" id="description"
                                        placeholder="Enter description here">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="btn-wrap">
                                    <div class="btn-inner">
                                        <a data-bs-dismiss="modal" class="back-btn" title="back">back</a>
                                        <button class="draft" id="draftBtn" value="draft-button"
                                            title="save-as-draft">Save as draft</button>
                                    </div>
                                    <button class="create-btn" value="add-button" id="datasheet-add-form-btn"
                                        title="create">CREATE</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!---   Progress Bar   -->
    <div class="modal fade common-modal progress-modal" id="progress-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                    title="close"></button>
                <div class="content-inner">

                    <div class="progress-report">
                        <picture>
                            <img src="{{ asset('assets/images/prgress-bar.svg') }}" alt="prgress-bar" width=""
                                height="">
                        </picture>
                        <span id="progressBar"></span>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="para-14">
                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed rinvidunt ut labore et
                                    dolore</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-12">
                            <div class="btn-wrap">
                                <a class="btn-primary" href="">
                                    CONTINUE
                                    <picture>
                                        <img src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow"
                                            width="24" height="24">
                                    </picture>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Edit Datasheet Modal -->
    <div class="modal fade common-modal datasheet-modal" id="edit-datasheet-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                    title="close"></button>
                <div class="content-inner">
                    <h2 class="section-title">Edit Datasheet</h2>

                    <form id="datasheet-edit-form" method="POST" action="{{ route('frontend-datasheets.update') }}"
                        class="input-form">
                        @csrf
                        <input type="hidden" id="datasheet_id" name="datasheet_id">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="editDatasheetName">NAME OF DATA SHEET</label>
                                    <input type="text" class="form-controal errorEditCalculatedFileNameCls"
                                        id="editDatasheetName" name="calculated_file_name"
                                        placeholder="Activity sheet name">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="editSourceId">SOURCE ID</label>
                                    <input type="text" class="form-controal errorEditSourceIdCls" name="source_id"
                                        readonly id="editSourceId" placeholder="CMA0001">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="editUploadedBy">UPLOADED BY</label>
                                    <input type="text" class="form-controal" id="editUploadedBy" name="uploaded_by"
                                        readonly placeholder="Joan Vargas">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="editDateTime">DATE & TIME</label>
                                    <div class="input-group date-group">
                                        <input type="text" name="date_time" id="editDateTime" readonly
                                            placeholder="Select Date" class="form-controal" aria-label="Date & Time"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">
                                                <picture>
                                                    <img src="{{ asset('assets/images/calendar-icon.svg') }}"
                                                        alt="calendar-icon" width="24" height="24">
                                                </picture>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="editReportingDate">REPORTING PERIOD</label>
                                    <div class="input-group date-group">
                                        <input type="text" name="reporting_date" id="editReportingDate" readonly
                                            class="form-controal reporting_date" placeholder="Select Date" aria-label=""
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">
                                                <picture>
                                                    <img src="{{ asset('assets/images/calendar-icon.svg') }}"
                                                        alt="calendar-icon" width="24" height="24">
                                                </picture>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="data_assessor">DATA ASSESSOR</label>
                                    <input type="text" class="form-controal" name="data_assessor" readonly
                                        id="editDataAssessor" placeholder="Philip Estrada">
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="form-group">
                                    <label for="editDescription">DESCRIPTION</label>
                                    <textarea type="text" class="form-controal errorEditDescriptionCls" name="description" id="editDescription"
                                        placeholder="Enter here"></textarea>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>UPLOADED SHEET</label>
                                    <div class="file-icon" id="editUploadedSheet">
                                        <picture>
                                            <img src="{{ asset('assets/images/file-icon.png') }}" alt="file-icon"
                                                width="34" height="41">
                                        </picture>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>EMISSION CALCULATED</label>
                                    <div class="file-icon" id="editEmissionCalculated">
                                        <picture>
                                            <img src="{{ asset('assets/images/file-icon.png') }}" alt="file-icon"
                                                width="34" height="41">
                                        </picture>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="btn-wrap">
                                    <a data-bs-dismiss="modal" class="back-btn" title="back">back</a>
                                    <button class="create-btn" id="datasheet-edit-form-btn"
                                        title="update">UPDATE</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Viwe Datasheet Modal -->
    <div class="modal fade common-modal view-datasheet-modal" id="view-datasheet-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                    title="close"></button>
                <div class="content-inner">
                    <h2 class="section-title">Detailed View</h2>

                    <div class="row">
                        <div class="col-12">
                            <ul class="datasheet-view">
                                <li>
                                    <div class="view-lable">Report Title</div>
                                    <div class="view-name" id="viewSheetName"></div>
                                </li>
                                <li>
                                    <div class="view-lable">REPORTING PERIOD</div>
                                    <div class="view-name" id="viewReportingPeriod"></div>
                                </li>
                                <li>
                                    <div class="view-lable">DATE & TIME</div>
                                    <div class="view-name" id="viewDateTime"></div>
                                </li>
                                <li>
                                    <div class="view-lable">DATA ASSESSOR</div>
                                    <div class="view-name" id="viewDataAssessor"></div>
                                </li>
                                <li>
                                    <div class="view-lable">UPLOADED BY</div>
                                    <div class="view-name" id="viewUploadedBy"></div>
                                </li>
                                <li>
                                    <div class="view-lable">LAST ACTION BY</div>
                                    <div class="view-name" id="viewLastActionBy"></div>
                                </li>
                                <li>
                                    <div class="view-lable">STATUS</div>
                                    <div class="view-name"><span id="viewStatus" class="status upload"></span></div>
                                </li>
                                <li>
                                    <div class="view-lable">UPLOADED SHEET</div>
                                    <div class="view-name" id="viewUploadedSheet">
                                    </div>
                                </li>
                                <li>
                                    <div class="view-lable">SOURCE ID</div>
                                    <div class="view-name" id="viewSourceId"></div>
                                </li>
                                <li>
                                    <div class="view-lable">EMISSION CALCULATED</div>
                                    <div class="view-name" id="viewEmissionCalculated">
                                    </div>
                                </li>
                                <li>
                                    <div class="view-lable">DESCRIPTION</div>
                                    <div class="view-name" id="viewDescription"></div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="btn-wrap">
                                <a data-bs-dismiss="modal" class="back-btn" title="back">back</a>
                                <div id="viewFormBtn">
                                    <button class="create-btn" id="view-datasheet-modal-btn" data-id=""
                                        data-bs-toggle="modal" data-bs-target="#edit-datasheet-modal"
                                        title="edit">EDIT</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('common-modal/delete-modal')
    @include('common-modal/ds-publish-modal')
    <style>
        #out:focus #ccc {
            display: none;
        }
    </style>
@endsection
@section('footer_scripts')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.timepicker.min.css') }}">
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.timepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.datetimepicker.min.css') }}" />
    <script type="text/javascript" src="{{ asset('assets/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var url = "{{ asset('assets/loader.gif') }}";
            var table = $("#manage-customer").DataTable({
                // scrollX: true,
                processing: true,
                serverSide: true,
                searching: true,
                stateSave: true,
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function(settings, json) {
                    $("#manage-customer").wrap(
                        "<div class='table-main-wrap manage-customer-wrap'></div>");
                },
                "bLengthChange": false,
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="' + url + '" alt="loader" class="custom-loader" />'
                },
                ajax: {
                    url: "{{ route('frontend-datasheets.ajax') }}",
                    dataType: "json",
                    data: function(d) {
                        if(d.draw != '1')
                        {
                            d.status_filter = $('#status').val();
                            d.last_action_by_filter = $('#last_action_by').val();
                            d.dateTimePicker_filter = $('#dateTimePicker').val();
                            d.viewreportingDate_filter = $('#viewreportingDate').val();
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        }
                    },
                },
                order: [
                    [0, 'Desc']
                ],

                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false,
                        orderable: true,
                    },
                    {
                        data: 'calculated_file_name',
                        name: 'calculated_file_name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            html += '<a href="" data-id="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#view-datasheet-modal" title="calculate file name">' +
                                full.calculated_file_name + '</a>';
                            return html;
                        }
                    },
                    {
                        data: 'date_time',
                        name: 'date_time',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            html += '<a href="" data-id="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#view-datasheet-modal" title="date time">' +
                                full.date_time + '</a>';
                            return html;
                        }
                    },
                    {
                        data: 'uploaded_by',
                        name: 'uploaded_by',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            html += '<a href="" data-id="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#view-datasheet-modal" title="uploaded by">' +
                                full.uploaded_by + '</a>';
                            return html;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            html += '<a href="" data-id="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#view-datasheet-modal" title="status">' +
                                full.status + '</a>';
                            return html;
                        }
                    },
                    {
                        data: 'source_id',
                        name: 'source_id',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            html += '<a href="" data-id="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#view-datasheet-modal" title="source id">' +
                                full.source_id + '</a>';
                            return html;
                        }
                    },
                    {
                        data: 'reporting_start_date',
                        name: 'reporting_start_date',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            html += '<a href="" data-id="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#view-datasheet-modal" title="reporting start date">' +
                                full.reporting_start_date + '</a>';
                            return html;
                        }

                    },
                    {
                        data: 'data_assessor',
                        name: 'data_assessor',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            html += '<a href="" data-id="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#view-datasheet-modal" title="data assessor">' +
                                full.data_assessor + '</a>';
                            return html;
                        }
                    },
                    {
                        data: 'last_action_by',
                        name: 'last_action_by',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            html += '<a href="" data-id="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#view-datasheet-modal" title="last action by">' +
                                full.last_action_by + '</a>';
                            return html;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'action-th',
                    },
                ],
                columnDefs: [{
                        "targets": [4], // Replace 0 with the column index where you want to set the id
                        "createdCell": function(td, cellData, rowData, row, col) {
                            console.log();
                            $(td).attr('id', 'status' + rowData.id);
                        },
                        defaultContent: '-',
                    },
                    // Add more targets and createdCell callbacks for other columns as needed
                ],
                // columnDefs: [{
                //     targets: '_all',
                //     defaultContent: '-'
                // }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#manage-customer_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#manage-customer_next").html(
                        '<img src="{{ asset('assets/images/arrow-next.svg') }}" alt="next-icon">');
                    var pageInfo = table.page.info();
                    var currentPage = pageInfo.page + 1;
                    if (currentPage == 1 && settings.aoData.length < 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                }
            });

            $("#status, #last_action_by, #dateTimePicker").change(function() {
                table.draw();
            });
            $("#viewreportingDate").on("change", function() {
                var selectedDateRange = $(this).val();
                $("#viewreportingDate").val(selectedDateRange);
                table.draw();
            });

            $('.reset-btn').on('click', function() {
                $('#status, #last_action_by').prop('selectedIndex', 0).trigger('change');
                $('#status, #last_action_by').selectpicker('deselectAll');
                $('#status, #last_action_by').selectpicker('refresh');
                $('#dateTimePicker').val('');
                $('#viewreportingDate').val('');
                table.ajax.reload();
            });

            //delete datasheet
            $(document).on('click', ".deleteDatasheet", function() {
                var id = $(this).attr('data-id');
                $(".deleterecordbtn").attr('data-id', id);
                $(".delete-modal-title").text("Are you sure you want to remove this datasheet?");
                $(".delete-modal-body").html(
                    "<p>This will delete datasheet permanently. You cannot undo this action.</p>");
                $("#deleterecordModel").modal('show');
            });

            $(".deleterecordbtn").click(function() {
                var id = $(this).attr('data-id');
                var current_object = "" + '/' + id;
                window.location.href = current_object;
            });

            //update status to publish
            $(document).on('click', ".publish-datasheet", function() {
                var id = $(this).attr('data-id');
                $(".publish-btn").attr('data-id', id);
                $(".publish-modal-title").text("Are you sure you want to publish this datasheet?");
                $(".publish-modal-body").html(
                    "<p>This will publish datasheet file.</p>");
                $("#publishRecordModel").modal('show');
            });

            $(".publish-btn").click(function() {
                var id = $(this).attr('data-id');
                var current_object = "{{ url('front/datasheet/publish-datasheet/') }}" + '/' + id;
                window.location.href = current_object;
            });

            //view datasheet data modal
            $('#view-datasheet-modal').on('show.bs.modal', function(e) {
                $('#creatnewDataSheet-modal').modal('hide');
                $('#progress-modal').modal('hide');
                $('#edit-datasheet-modal').modal('hide');
                let btn = $(e
                    .relatedTarget
                );
                let id = btn.data('id');
                let userUrl = "{{ url('/front/datasheet/show') }}/" + id;
                $.ajax({
                    url: userUrl,
                    type: 'GET',
                    success: function(result) {
                        if (result.status == 'true') {
                            $('#view-datasheet-modal-btn').data('id', result.data['id']);
                            var dateTimeString = result.data['date_time'];
                            var inputDateTime = new Date(dateTimeString);
                            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
                                "Aug", "Sep", "Oct", "Nov", "Dec"
                            ];
                            var month = monthNames[inputDateTime.getMonth()];
                            var day = inputDateTime.getDate();
                            var hour = inputDateTime.getHours();
                            var minute = inputDateTime.getMinutes();
                            var year = inputDateTime.getFullYear();

                            var inputTime = hour + ':' + (minute < 10 ? '0' : '') + minute;
                            var parts = inputTime.split(':');
                            var hours = parseInt(parts[0]);
                            var minutes = parseInt(parts[1]);
                            var ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12;
                            hours = hours ? hours : 12;
                            var formattedHourMinuteTime = hours + ':' + (minutes < 10 ? '0' :
                                '') + minutes + ' ' + ampm;

                            // var formattedDateTime = month + ' ' + day + ', '+ year +' ' + formattedHourMinuteTime;
                            // var formattedDateTime = month + ' ' + day + ', '+ year +' ' + hour + ':' + (minute < 10 ? '0' : '') + minute + (hour >= 12 ? ' pm' : ' am');
                            var formattedDateTime = month + ' ' + day + ', ' + year + ' ' +
                                hour + ':' + (minute < 10 ? '0' : '') + minute;

                            var inputReportStartDateString = result.data[
                                'reporting_start_date'];
                            var inputDateRS = new Date(inputReportStartDateString);
                            var newMonthRS = inputDateRS.getMonth() + 1;
                            var monthRS = (newMonthRS < 10 ? '0' : '') + newMonthRS;
                            var formattedReportingStartDate = inputDateRS.getDate() + '/' +
                                monthRS + '/' + inputDateRS.getFullYear();

                            var inputReportEndDateString = result.data['reporting_end_date'];
                            var inputDateRE = new Date(inputReportEndDateString);
                            var newMonthRE = inputDateRE.getMonth() + 1;
                            var monthRe = (newMonthRE < 10 ? '0' : '') + newMonthRE;
                            var formattedReportingEndDate = inputDateRE.getDate() + '/' +
                                monthRe + '/' + inputDateRE.getFullYear();

                            var reportingPeriod = formattedReportingStartDate + ' - ' +
                                formattedReportingEndDate;
                            $("#viewSheetName").html(result.data['calculated_file_name']);
                            $("#viewDataAssessor").html(result.data['data_assessor']);
                            $("#viewDateTime").html(formattedDateTime);
                            $("#viewReportingPeriod").html(reportingPeriod);
                            $("#viewUploadedBy").html(result.data['uploaded_by']);
                            $("#viewLastActionBy").html(result.data['last_action_by']);
                            var datasheetStatus = '';
                            if (result.data['status'] == "0") {
                                datasheetStatus = 'Uploded';
                                $("#viewStatus").removeAttr("class");
                                $("#viewStatus").attr("class", "status upload");
                            } else if (result.data['status'] == "1") {
                                datasheetStatus = 'In Progress';
                                $("#viewStatus").removeAttr("class");
                                $("#viewStatus").attr("class", "status inprogress");
                            } else if (result.data['status'] == "2") {
                                datasheetStatus = 'Completed';
                                $("#viewStatus").removeAttr("class");
                                $("#viewStatus").attr("class", "status complet");
                            } else if (result.data['status'] == "3") {
                                datasheetStatus = 'Published';
                                $("#viewStatus").removeAttr("class");
                                $("#viewStatus").attr("class", "status publish");
                            } else if (result.data['status'] == "4") {
                                datasheetStatus = 'Failed';
                                $("#viewStatus").removeAttr("class");
                                $("#viewStatus").attr("class", "status faile");
                            } else if (result.data['status'] == "5") {
                                datasheetStatus = 'Drafted';
                                $("#viewStatus").removeAttr("class");
                                $("#viewStatus").attr("class", "status draft");
                            } else {
                                datasheetStatus = '';
                            }
                            $("#viewStatus").html(datasheetStatus);
                            $("#viewSourceId").html(result.data['source_id']);
                            $("#viewDescription").html(result.data['description']);
                            var uploadSheetUrlHtml = "";
                            if (result.data['uploadedSheetUrl'] != "-") {
                                uploadSheetUrlHtml =
                                    '<a title="Uploaded sheet url" target="_blank" href="' +
                                    result.data[
                                        'uploadedSheetUrl'] +
                                    '"><span class="file-icon"><picture><img src="{{ asset('assets/images/file-icon.png') }}" alt="file-icon" width="34" height="41"></picture></span></a>';
                            } else {
                                uploadSheetUrlHtml = '-';
                            }
                            var emissionCalculatedHtml = "";
                            if (result.data['emissionCalculatedSheetUrl'] != "-") {
                                emissionCalculatedHtml =
                                    '<a title="Emission calculate sheet url" target="_blank" href="' +
                                    result
                                    .data['emissionCalculatedSheetUrl'] +
                                    '"><span class="file-icon"><picture><img src="{{ asset('assets/images/file-icon.png') }}" alt="file-icon" width="34" height="41"></picture></span></a>';
                            } else {
                                emissionCalculatedHtml = '-';
                            }
                            $("#viewUploadedSheet").html(uploadSheetUrlHtml);
                            $("#viewEmissionCalculated").html(emissionCalculatedHtml);
                            if (result.data['status'] != "5") {
                                $("#view-datasheet-modal-btn").remove();
                            } else {
                                $("#view-datasheet-modal-btn").remove();
                                $("#viewFormBtn").append(
                                    '<button class="create-btn" id="view-datasheet-modal-btn" data-id="' +
                                    result.data['id'] +
                                    '" data-bs-toggle="modal" data-bs-target="#edit-datasheet-modal" title="edit">EDIT</button>'
                                );
                            }
                        } else {
                            setReturnMsg("Danger", "Something went wrong!");
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        }
                    },
                });
            });

            //edit datasheet data modal
            $('#edit-datasheet-modal').on('show.bs.modal', function(e) {
                $('#creatnewDataSheet-modal').modal('hide');
                $('#progress-modal').modal('hide');
                $('#view-datasheet-modal').modal('hide');
                $('#view-datasheet-modal').modal('hide');
                let btn = $(e
                    .relatedTarget
                );
                let id = btn.data('id');
                let userUrl = "{{ url('/front/datasheet/edit') }}/" + id;
                $.ajax({
                    url: userUrl,
                    type: 'GET',
                    success: function(result) {
                        if (result.status == 'true') {
                            var dateTimeString = result.data['date_time'];
                            var inputDateTime = new Date(dateTimeString);
                            var newMonth = inputDateTime.getMonth() + 1;
                            var month = (newMonth < 10 ? '0' : '') + newMonth;
                            var day = inputDateTime.getDate();
                            var hour = inputDateTime.getHours();
                            var minute = inputDateTime.getMinutes();
                            var year = inputDateTime.getFullYear();

                            var inputTime = hour + ':' + (minute < 10 ? '0' : '') + minute;
                            var parts = inputTime.split(':');
                            var hours = parseInt(parts[0]);
                            var minutes = parseInt(parts[1]);
                            var ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12;
                            hours = hours ? hours : 12;
                            var formattedHourMinuteTime = hours + ':' + (minutes < 10 ? '0' :
                                '') + minutes;
                            // var formattedDateTime = year + '/' + month + '/'+ day +' ' + formattedHourMinuteTime;
                            var formattedDateTime = year + '-' + month + '-' + day + ' ' +
                                hour + ':' + (minute < 10 ? '0' : '') + minute;

                            var inputReportStartDateString = result.data[
                                'reporting_start_date'];
                            var inputDateRS = new Date(inputReportStartDateString);
                            var newMonthRs = inputDateRS.getMonth() + 1;
                            var monthRS = (newMonthRs < 10 ? '0' : '') + newMonthRs;
                            var formattedReportingStartDate = inputDateRS.getFullYear() + '/' +
                                monthRS + '/' + inputDateRS.getDate();

                            var inputReportEndDateString = result.data['reporting_end_date'];
                            var inputDateRE = new Date(inputReportEndDateString);
                            var newMonthRE = inputDateRE.getMonth() + 1;
                            var monthRe = (newMonthRE < 10 ? '0' : '') + newMonthRE;
                            var formattedReportingEndDate = inputDateRE.getFullYear() + '/' +
                                monthRe + '/' + inputDateRE.getDate();

                            var reportingPeriod = formattedReportingStartDate + ' to ' +
                                formattedReportingEndDate;
                            $("#datasheet_id").val(result.data['id']);
                            $("#editDatasheetName").val(result.data['calculated_file_name']);
                            $("#editSourceId").val(result.data['source_id']);
                            $("#editUploadedBy").val(result.data['uploaded_by']);
                            $("#editDateTime").val(formattedDateTime);
                            $("#editReportingDate").val(reportingPeriod);
                            $("#editDataAssessor").val(result.data['data_assessor']);
                            $("#editDescription").val(result.data['description']);
                            var uploadSheetUrlHtml = "";
                            if (result.data['uploadedSheetUrl'] != "-") {
                                uploadSheetUrlHtml =
                                    '<a  title="uploaded sheet url" target="_blank" href="' +
                                    result.data[
                                        'uploadedSheetUrl'] +
                                    '"><span class="file-icon"><picture><img src="{{ asset('assets/images/file-icon.png') }}" alt="file-icon" width="34" height="41"></picture></span></a>';
                            } else {
                                uploadSheetUrlHtml = '-';
                            }
                            var emissionCalculatedHtml = "";
                            if (result.data['emissionCalculatedSheetUrl'] != "-") {
                                emissionCalculatedHtml =
                                    '<a title="emission calculate sheet url" target="_blank" href="' +
                                    result
                                    .data['emissionCalculatedSheetUrl'] +
                                    '"><span class="file-icon"><picture><img src="{{ asset('assets/images/file-icon.png') }}" alt="file-icon" width="34" height="41"></picture></span></a>';
                            } else {
                                emissionCalculatedHtml = '-';
                            }
                            $("#editUploadedSheet").html(uploadSheetUrlHtml);
                            $("#editEmissionCalculated").html(emissionCalculatedHtml);
                        } else {
                            setReturnMsg('Danger', 'Something went wrong!');
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 || xhr.status === 401) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        }
                    },
                });
            })

            $('#edit-datasheet-modal').on('hidden.bs.modal', function(e) {
                $('.error-mgs').html('');
                $("#errorEditCalculatedFileName").remove();
                $("#errorEditDescription").remove();
            });

            $('#datasheet-edit-form').submit(function(e) {
                e.preventDefault();
                var formAction = $(this).attr('action');
                var formdata = new FormData(this)
                var button = $('#datasheet-edit-form-btn');
                button.prop('disabled', true);
                $.ajax({
                    url: formAction,
                    type: 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.errors) {
                            button.prop('disabled', false);
                            $('.error-mgs').html('');
                            $("#errorEditCalculatedFileName").remove();
                            $("#errorEditDescription").remove();
                            if (response.errors.calculated_file_name) {
                                $('.errorEditCalculatedFileNameCls').after(
                                    '<span class="error-mgs" id="errorEditCalculatedFileName">' +
                                    response.errors.calculated_file_name[0] + '</span>');
                            }
                            if (response.errors.description) {
                                $('.errorEditDescriptionCls').after(
                                    '<span class="error-mgs" id="errorEditDescription">' +
                                    response.errors.description[0] + '</span>');
                            }
                        }
                        if (response.no_data_error) {
                            button.prop('disabled', false);
                            setReturnMsg("danger", response.no_data_error);
                        }
                        if (response.updatation_error) {
                            button.prop('disabled', false);
                            setReturnMsg("danger", response.updatation_error);
                        }
                        if (response.success) {
                            button.prop('disabled', false);
                            setReturnMsg("success", response.success);
                            $('#editMember-modal').modal('hide');
                            setTimeout(location.reload(), 5000);
                        }
                    },
                    beforeSend: function() {
                        $('#loader').css('display', 'inline-flex');
                    },
                    complete: function() {
                        $('#loader').css('display', 'none');
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        }
                    },
                });
            });

            $('#creatnewDataSheet-modal').on('hidden.bs.modal', function(e) {
                $('.error-mgs').html('');
                $('.field-clear').val("");
                $('#filename').html('Select a xlsx file to upload');
            });

            $.datetimepicker.setLocale('en-IN');

            $("#reportingDate").dateRangePicker({
                showOn: "focus",
                rangeSeparator: " to ",
                dateFormat: "yy/mm/dd",
                useHiddenAltFields: true,
                constrainInput: true
            });

            $("#viewreportingDate").dateRangePicker({
                showOn: "focus",
                rangeSeparator: " to ",
                dateFormat: "yy/mm/dd",
                useHiddenAltFields: true,
                constrainInput: true
            });

        });

        $(".datepicker").datetimepicker({
            format: 'Y-m-d H:i',
            step: 1,
            yearStart: 2000
        });

        (function($) {
            function compareDates(startDate, endDate, format) {
                var temp, dateStart, dateEnd;
                try {
                    dateStart = $.datepicker.parseDate(format, startDate);
                    dateEnd = $.datepicker.parseDate(format, endDate);
                    if (dateEnd < dateStart) {
                        temp = startDate;
                        startDate = endDate;
                        endDate = temp;
                    }
                } catch (ex) {}
                return {
                    start: startDate,
                    end: endDate
                };
            }

            $.fn.dateRangePicker = function(options) {
                options = $.extend({
                    "changeMonth": false,
                    "changeYear": false,
                    "numberOfMonths": 2,
                    "rangeSeparator": " - ",
                    "useHiddenAltFields": false
                }, options || {});

                var myDateRangeTarget = $(this);
                var onSelect = options.onSelect || $.noop;
                var onClose = options.onClose || $.noop;
                var beforeShow = options.beforeShow || $.noop;
                var beforeShowDay = options.beforeShowDay;
                var lastDateRange;

                function storePreviousDateRange(dateText, dateFormat) {
                    var start, end;
                    dateText = dateText.split(options.rangeSeparator);
                    if (dateText.length > 0) {
                        start = $.datepicker.parseDate(dateFormat, dateText[0]);
                        if (dateText.length > 1) {
                            end = $.datepicker.parseDate(dateFormat, dateText[1]);
                        }
                        lastDateRange = {
                            start: start,
                            end: end
                        };
                    } else {
                        lastDateRange = null;
                    }
                }

                options.beforeShow = function(input, inst) {
                    var dateFormat = myDateRangeTarget.datepicker("option", "dateFormat");
                    storePreviousDateRange($(input).val(), dateFormat);
                    beforeShow.apply(myDateRangeTarget, arguments);
                };

                options.beforeShowDay = function(date) {
                    var out = [true, ""],
                        extraOut;
                    if (lastDateRange && lastDateRange.start <= date) {
                        if (lastDateRange.end && date <= lastDateRange.end) {
                            out[1] = "ui-datepicker-range";
                        }
                    }

                    if (beforeShowDay) {
                        extraOut = beforeShowDay.apply(myDateRangeTarget, arguments);
                        out[0] = out[0] && extraOut[0];
                        out[1] = out[1] + " " + extraOut[1];
                        out[2] = extraOut[2];
                    }
                    return out;
                };

                options.onSelect = function(dateText, inst) {
                    var textStart;
                    if (!inst.rangeStart) {
                        inst.inline = true;
                        inst.rangeStart = dateText;
                    } else {
                        inst.inline = false;
                        textStart = inst.rangeStart;
                        if (textStart !== dateText) {
                            var dateFormat = myDateRangeTarget.datepicker("option", "dateFormat");
                            var dateRange = compareDates(textStart, dateText, dateFormat);
                            myDateRangeTarget.val(dateRange.start + options.rangeSeparator + dateRange.end);
                            inst.rangeStart = null;
                            if (options.useHiddenAltFields) {
                                var myToField = myDateRangeTarget.attr("data-to-field");
                                var myFromField = myDateRangeTarget.attr("data-from-field");
                                $("#" + myFromField).val(dateRange.start);
                                $("#" + myToField).val(dateRange.end);
                            }
                            onSelect.apply(myDateRangeTarget, [
                                dateRange
                            ]); // Pass the selected date range to the onSelect callback
                            // Trigger the change event on the input field
                            myDateRangeTarget.trigger("change");
                        }
                    }
                };

                options.onClose = function(dateText, inst) {
                    inst.rangeStart = null;
                    inst.inline = false;
                    onClose.apply(myDateRangeTarget, [
                        lastDateRange
                    ]); // Pass the last selected date range to the onClose callback
                    myDateRangeTarget.trigger("change");
                };

                return this.each(function() {
                    if (myDateRangeTarget.is("input")) {
                        myDateRangeTarget.datepicker(options);
                    }
                    myDateRangeTarget.wrap("<div class=\"dateRangeWrapper\"></div>");
                });
            };
        }(jQuery));

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var fileName = input.files[0].name;
                    $("#filename").text(fileName);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#file").change(function() {
            readURL(this);
        });

        $("#draftBtn").on('customSubmitEvent', function() {
            $("#save_as_draft").val('1');
        });

        $("#datasheet-add-form-btn").on('customSubmitEventAdd', function() {
            $("#save_as_draft").val('0');
        });
        $('#creatnewDataSheet-modal').on('hidden.bs.modal', function(e) {
            addDSValidationReset();
        });

        function addDSValidationReset() {
            $("#errorCalculatedFileName").remove();
            // $("#errorDataAssessor").remove();
            $("#errorDatasheetFile").remove();
            $("#errorDateTime").remove();
            // $("#errorDescription").remove();
            $("#errorReportingDate").remove();
        }
        $("#datasheet-add-form button").click(function(ev) {
            ev.preventDefault()
            if ($(this).attr("value") == "add-button") {
                $(this).trigger('customSubmitEventAdd');
            } else if ($(this).attr("value") == "draft-button") {
                $(this).trigger('customSubmitEvent');
            }

            var formAction = $("#datasheet-add-form").attr('action');
            // var formdata = new FormData(this);
            var formdata = new FormData($("#datasheet-add-form")[0]);
            var button = $('#datasheet-add-form-btn');
            var buttonD = $('#draftBtn');
            button.prop('disabled', true);
            buttonD.prop('disabled', true);
            $.ajax({
                url: formAction,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.errors) {
                        button.prop('disabled', false);
                        buttonD.prop('disabled', false);
                        $('.error-mgs').html('');
                        addDSValidationReset();
                        if (response.errors.calculated_file_name) {
                            $('.errorCalculatedFileNameCls').after(
                                '<span class="error-mgs" id="errorCalculatedFileName">' + response
                                .errors.calculated_file_name[0] + '</span>');
                        }
                        // if (response.errors.data_assessor) {
                        //     $('.errorDataAssessorCls').after(
                        //         '<span class="error-mgs" id="errorDataAssessor">' + response.errors
                        //         .data_assessor[0] + '</span>');
                        // }
                        if (response.errors.datasheet_file) {
                            $('.errorDatasheetFileCls').after(
                                '<span class="error-mgs" id="errorDatasheetFile">' + response.errors
                                .datasheet_file[0] + '</span>');
                        }
                        if (response.errors.date_time) {
                            $('.errorDateTimeCls').after('<span class="error-mgs" id="errorDateTime">' +
                                response.errors.date_time[0] + '</span>');
                        }
                        // if (response.errors.description) {
                        //     $('.errorDescriptionCls').after(
                        //         '<span class="error-mgs" id="errorDescription">' + response.errors
                        //         .description[0] + '</span>');
                        // }
                        if (response.errors.reporting_date) {
                            $('.errorReportingDateCls').after(
                                '<span class="error-mgs" id="errorReportingDate">' + response.errors
                                .reporting_date[0] + '</span>');
                        }
                    }
                    if (response.success) {
                        button.prop('disabled', false);
                        buttonD.prop('disabled', false);
                        $('#creatnewDataSheet-modal').modal('hide');
                        $('.field-clear').val("");
                        $('#filename').html('Select a xlsx file to upload');
                        setReturnMsg("success", response.success);
                        // setTimeout(location.reload(), 5000);
                        setTimeout(() => location.reload(), 1000);

                    }
                    if (response.add_error) {
                        button.prop('disabled', false);
                        buttonD.prop('disabled', false);
                        setReturnMsg("danger", response.add_error);
                    }
                },
                beforeSend: function() {
                    $('#loader').css('display', 'inline-flex');
                },
                complete: function() {
                    $('#loader').css('display', 'none');
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle the HTTP status code here
                    if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    }
                },
            });
        });

        function datasheetFileChange(input) {
            const maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
            const fileSize = input.files[0].size;
            $('#error-datasheet').remove();
            $('#errorDatasheetFile').remove();
            if (fileSize > maxFileSize) {
                $('.errorDatasheetFileCls').after(
                    '<span class="error-mgs" id="error-datasheet">File size exceeds 5MB. Please choose a smaller file and re-upload.</span>'
                )
                $('#file').val('');
                $('#filename').text('Select a xlsx file to upload');
                return;
            }
        }

        function setReturnMsg(title, message) {
            var title = title;
            var lowercaseString = title.toLowerCase();
            if (lowercaseString == "danger") {
                title = 'Error';
            }
            $.notify({
                title: '<strong>' + title + '</strong>',
                message: "<br>" + message + "",
            }, {
                element: 'body',
                position: null,
                type: lowercaseString,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 999999,
                delay: 2000,
                timer: 1000,
                mouse_over: null,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutRight'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
            });
        }
        


        function updateStatus() {

            // $('ul[data-id]').find('[data-id]').each(function() {
            //     var dataIdValue = $(this).data('id');
               
            //     // console.log(dataIdValue);
            //     console.log( $(this).html());
            // });
            // console.log($('ul[data-id="16"] li').length)
            // console.log(  $('ul[data-id]').find('li').length);
        
            // $('ul[data-id]').html();
            // if($('ul[data-id]') == '16')
            // {
                
            //     console.log('ankit', $('ul[data-id]').find('li > ul').length)
            // }
            // console.log('ankit', $('ul[data-id]').html());

            // if($('ul[data-id="16"] li').length == '1')
            // {
            //     $('ul[data-id="16"]').append('<li><a href="#!" data-id="16" data-bs-toggle="modal" data-bs-target="#view-datasheet-modal">publish</a></li>');
            // }
         
            // setTimeout(updateStatus, 1000);
            $.ajax({
                url: "{{ route('frontend-datasheets.update-status') }}",
                type: 'get',
                processData: false,
                contentType: false,
                success: function(response) {
                    for (var i = 0; i < response.data.length; i++) {
                        $('#status' + response.data[i].id + '> a').html(getStatusName(response.data[i].status));
                        if(response.data[i].status == '2')   
                        {
                            if($('ul[data-id="'+response.data[i].id+'"] li').length == '1')
                            {
                                $('ul[data-id="'+response.data[i].id+'"]').append('<li><a class="publish-datasheet" data-id="'+response.data[i].id+'">Publish</a></li>');
                            }
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 302 || jqXHR.status === 419 ||  jqXHR.status === 401) {
                        // Redirect to the new location or reload the page
                        location.reload();
                    } else {
                        console.error("Error in Ajax call:", textStatus, errorThrown);
                    }
                },
                complete: function() {
                    // After the request is complete, set a new timeout to call the function again after 5 seconds
                    setTimeout(updateStatus, 5000);
                }
            });
        }

        // Call the function for the first time
        updateStatus();

        function getStatusName(value) {
            switch (value) {
                case '0':
                    return '<span class="status upload">Uploaded</span>';
                case '1':
                    return '<span class="status inprogress">In Progress</span>';
                case '2':
                    return '<span class="status complet">Completed</span>';
                case '3':
                    return '<span class="status publish">Published</span>';
                case '4':
                    return '<span class="status faile">Failed</span>';
                case '5':
                    return '<span class="status draft">Drafted</span>';
                default:
                    return '<span class="status upload">Uploaded</span>';
            }
        }


        // setTimeout(function () {
        //     $.ajax({
        //         url: "{{ route('frontend-datasheets.update-status') }}",
        //         type: 'get',
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             for(var i = 0; i< response.data.length;i++)
        //             {
        //                 $('#status'+response.data[i].id + '> a').html(getStatusName(response.data[i].status));
        //             }
        //         },

        //         // error: function(xhr, textStatus, errorThrown) {
        //         //     // Handle the HTTP status code here
        //         //     if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
        //         //         location.reload();
        //         //         // Redirect to the new location
        //         //         // window.location.href = xhr.getResponseHeader('Location');
        //         //     }
        //         // },
        //     });
        // }, 5000); 

        // function getStatusName(value)
        // {
        //     switch (value) {
        //         case '0':
        //             return '<span class="status upload">Uploaded</span>';
        //             break;
        //         case '1':
        //             return '<span class="status inprogress">In Progress</span>';
        //             break;
        //         case '2':
        //             return '<span class="status complet">Completed</span>';
        //             break;
        //         case '3':
        //             return '<span class="status publish">Published</span>';
        //             break;
        //         case '4':
        //             return '<span class="status faile">Failed</span>';
        //             break;
        //         case '5':
        //             return '<span class="status draft">Drafted</span>';
        //             break;
        //         default:
        //             return '<span class="status upload">Uploaded</span>';
        //             break;
        //     }
        // }
    </script>
@endsection
