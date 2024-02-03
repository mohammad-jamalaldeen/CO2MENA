@extends('admin.layouts.app')
@section('title')
    Activity Sheets
@endsection
@section('content')
    <div class="table-header manage-datasheet-header">
        <div class="fillter-option">
            <div class="row">
                <div class="col-12">
                    <ul class="new-table-filter datasheet-filter">
                        <li class="datasheet-list-filter">
                            <input type="text" placeholder="Date & Time" class="newf-btn datepicker" name="getdatetime"
                                id="getdatetime">
                        </li>
                        <li class="datasheet-daterangepicker">
                            <input type="text" id="viewreportingDate" placeholder="Reporting Period" class="newf-btn"
                                name="reporting_period_filter" autocomplete="off">
                        </li>
                        <li>
                            <select class="form-control" name="getlastaction" title="Last Action" id="getlastaction">
                                <option value="">Select Last Action</option>
                                @for ($i = 0; $i < count($filterLastAction); $i++)
                                    <option value="{{ $filterLastAction[$i] }}">
                                        {{ ucfirst($filterLastAction[$i]) }}</option>
                                @endfor
                            </select>
                        </li>
                        <li>
                            <select class="form-control status-select" name="getstatus" title="Select Status"
                                id="getstatus">
                                <option value="">Select Status</option>
                                <option value="0">Uploaded</option>
                                <option value="1">In Progress</option>
                                <option value="2">Completed</option>
                                <option value="3">Published</option>
                                <option value="4">Failed</option>
                                <option value="5">Drafted</option>
                            </select>
                        </li>
                        <li>
                            <select class="form-control company-select" name="company" title="Select Company" id="company"
                                data-live-search="true">
                                <option value="">Select Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company['id'] }}">{{ $company['company_name'] }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <button type="button" title="reset-all" class="reset-btn" onclick="resetValue()">Reset All</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table tb-filter-inner datasheet-table-new">
        <table id="manage-datasheet" class="table custome-datatable manage-datasheet-table display"  >
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>DATE & TIME</th>
                    <th>UPLOADED BY</th>
                    <th>COMPANY NAME</th>
                    <th>REPORTING PERIOD</th>
                    <th>STATUS</th>
                    <th class="action-th"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
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
            var url ="{{ asset('assets/loader.gif') }}";
            var table = $("#manage-datasheet").DataTable({
                autoWidth: true,
                bInfo: true,
                processing: true,
                serverSide: true,
                lengthChange: true,
                "bLengthChange": false,
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" title="loader" class="custom-loader" />'
                },
                order: [
                    // [1, 'desc']
                ],
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function(settings, json) {
                    $("#manage-datasheet").wrap(
                        "<div class='table-main-wrap manage-datasheet-wrap'></div>");
                },
                ajax: {
                    url: "{{ route('datasheet.index') }}",
                    data: function(d) {
                        d.getstatus = $('#getstatus').val();
                        d.getdatetime = $('#getdatetime').val();
                        d.getlastaction = $('#getlastaction').val();
                        // d.date_range = getDateRange(); 
                        d.viewreportingDate_filter = $('#viewreportingDate').val();
                        d.company_filter = $('#company').val();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        } 
                    }
                },
                columns: [{
                        data: 'calculated_file_name',
                        name: 'calculated_file_name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'date_time',
                        name: 'date_time',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'uploaded_by',
                        name: 'uploaded_by',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'company.company_name',
                        name: 'company.company_name',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'reporting_start_date',
                        name: 'reporting_start_date',
                        orderable: true,
                        searchable: true

                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true,
                        render:function(data, type, full, meta){
                            var statusLabel = "";
                            if (full.status == 0) {
                                statusLabel = '<span class="status upload">Uploaded</span>';
                            } else if (full.status == 1) {
                                statusLabel = '<span class="status inprogress">In Progress</span>';
                            } else if (full.status == 2) {
                                statusLabel = '<span class="status complet">Completed</span>';
                            } else if (full.status == 3) {
                                statusLabel = '<span class="status publish">Published</span>';
                            } else if (full.status == 4) {
                                statusLabel = '<span class="status faile">Failed</span>';
                            } else if (full.status == 5) {
                                statusLabel = '<span class="status draft">Drafted</span>';
                            }else{
                                statusLabel = '';
                            }
                            return statusLabel;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: "action-th",
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            var current_url_show = "{{ url('admin/datasheet/show') }}" + '/' + id;
                            var uplodedSheetUrl =
                                "{{ url('admin/datasheet/uploded-sheet') }}" + '/' + id;
                            var emissionCalculatedUrl =
                                "{{ url('admin/datasheet/emission-calculated') }}" +
                                '/' + id;
                            var isFileExists =
                            true; // Replace with your logic to check file existence
                            @if (adminMultiplePermissionCheck('datasheet', ['show', 'uploded-sheet', 'emission_calculated']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' title='sheet-dots' width='' height=''></picture></div>";

                                var uplodedSheet = full.uploded_sheet;
                                var emissionCalculated = full.emission_calculated;
                                var samplesheet = full.company.sample_datasheet;
                                var uplodedSheetLink = (full.uploded_sheet !== '-') ?
                                    '<li><a target="_blank" class="dropdown-item" href="' +
                                        full.uploded_sheet + '">Uploded Sheet</a></li>' :
                                    '<li><a class="dropdown-item" href="javascript:void(0);" onclick="return false;">Uploded Sheet</a></li>';
                                var emissionCalculatedLink = (full.emission_calculated != '-') ?
                                    '<li><a target="_blank" class="dropdown-item deletecompany" href="' +
                                        full.emission_calculated + '" data-id=' + full.id +
                                    '>Emission Calculated</a></li>' :
                                    '<li><a class="dropdown-item deletecompany" href="javascript:void(0);" data-id=' +
                                    full.id +
                                    ' onclick="return false;">Emission Calculated</a></li>';
                                var sampleSheetLink = (full.company.sample_datasheet != '') ?
                                    '<li><a class="dropdown-item" href="' +
                                        full.company.sample_datasheet +
                                    '" target="_blank">System Generated Sheet</a></li>' :
                                    '<li><a class="dropdown-item" href="javascript:void(0);" onclick="return false;">System Generated Sheet</a></li>';

                                html += '<ul class="dropdown-menu edit-sheet">';
                                @if (adminPermissionCheck('datasheet.show'))
                                    html += '<li><a class="dropdown-item" href="' +
                                        current_url_show + '">View</a></li>';
                                    html += sampleSheetLink;
                                @endif
                                @if (adminPermissionCheck('datasheet.uploded-sheet'))
                                        if(full.status != '1' && full.status != '4' && full.status != '3'){
                                            html += uplodedSheetLink;
                                        }
                                @endif

                                @if (adminPermissionCheck('datasheet.emission_calculated'))
                                if(full.status != '1' && full.status != '4' && full.status != '5'&& full.status != '3'){
                                    html += emissionCalculatedLink;
                                }
                                @endif
                                html += '</ul></div>';
                            @else
                                html += '-';
                            @endif
                            return html;
                        }
                    },
                ],
                columnDefs: [{
                    targets: '_all',
                    defaultContent: '-'
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#manage-datasheet_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#manage-datasheet_next").html(
                        '<img src="{{ asset('assets/images/arrow-next.svg') }}" alt="next-icon">');
                    var pageInfo = table.page.info();
                    var currentPage = pageInfo.page + 1;
                    if (currentPage == 1 && recordsTotal <= 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                }
            });
            $('#getstatus, #getdatetime, #getlastaction, #dateTimePicker, #viewreportingDate').change(function() {
                table.draw();
            });
            $("#company").change(function() {
                $("#manage-datasheet").DataTable().draw();
            });

            $(".datepicker").datetimepicker({
                format: 'Y-m-d H:i',
                step: 1,
            });

            $('.reset-btn').on('click', function() {
                $('#status, #last_action_by').prop('selectedIndex', 0).trigger('change');
                $('#dateTimePicker').val('');
                $('#getdatetime').val("");
                $('#viewreportingDate').val('');
                table.ajax.reload();
            });




            $("#viewreportingDate").on("change", function() {
                var selectedDateRange = $(this).val();
                $("#viewreportingDate").val(selectedDateRange);
                table.draw();
            });

            function getDateRange() {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                return from_date && to_date ? from_date + ',' + to_date : '';
            }
            $("#viewreportingDate").dateRangePicker({
                showOn: "focus",
                rangeSeparator: " to ",
                dateFormat: "yy/mm/dd",
                useHiddenAltFields: true,
                constrainInput: true
            });
        });

        function resetValue() {
            $('select[name="getdatetime"]').val(null);
            $('select[name="getdatetime"]').selectpicker('refresh');
            $('select[name="dateTimePicker"]').val(null);
            $('select[name="dateTimePicker"]').selectpicker('refresh');
            $('select[name="viewreportingDate"]').val(null);
            $('select[name="viewreportingDate"]').selectpicker('refresh');
            $('select[name="getlastaction"]').val(null);
            $('select[name="getlastaction"]').selectpicker('refresh');
            $('select[name="getstatus"]').val(null);
            $('select[name="getstatus"]').selectpicker('refresh');
            $('select[name="company"]').val(null);
            $('select[name="company"]').selectpicker('refresh');
            $('#manage-datasheet').DataTable().draw();
        }

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

        $(".reset-btn").click(function() {
            $('select').prop('selectedIndex', 0).trigger('change');
        });
    </script>
@endsection
