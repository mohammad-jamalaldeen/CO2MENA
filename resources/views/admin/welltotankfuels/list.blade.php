@extends('admin.layouts.app')
@section('title')
    Well To Tank Fuels Management
@endsection
@section('content')
    @if (!adminPermissionCheck('welltotankfuels.create'))
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
            <div class="col-md-5 col-12">

            </div>
            <div class="col-md-7 col-12">
                <div class="dw-header">
                    <a class="createsheet-btn" href="{{ route('welltotankfuels.create') }}" title="create">
                        CREATE Well To Tank Fuels
                    </a>
                </div>
            </div>
        </div>
        <div class="fillter-option">
            <div class="row">
                <div class="col-12">
                    <ul class="new-table-filter">
                        <li>
                            <select name="type" id="type" title="Type">
                                <option value="">Select Type</option>
                                @foreach (\App\Models\WttFules::TYPE as $value)
                                    <option value="{{ $value }}">
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <select name="unit" id="unit" title="Unit">
                                <option value="">Select Unit</option>
                                @foreach (\App\Models\WttFules::UNIT as $key => $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <button type="button" class="reset-btn" onclick="resetValue()" title="reset-all">Reset
                                All</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table tb-filter-inner {{ $classlist }}">
        <div class="responsive-table">
            <table id="manage-welltotankfuels" class="table custome-datatable manage-staff-table display">
                <thead>
                    <tr>
                        <th class="mw-120">TYPE</th>
                        <th class="mw-120">FUEL</th>
                        <th class="mw-120">Unit</th>
                        <th class="mw-120">Emission Factor</th>
                        <th class="action-th"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @include('common-modal.delete-modal')
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var url = "{{ asset('assets/loader.gif') }}";
            var table = $("#manage-welltotankfuels").DataTable({
                processing: true,
                serverSide: true,
                lengthChange: true,
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function(settings, json) {
                    $("#manage-welltotankfuels").wrap(
                        "<div class='table-main-wrap manage-welltotankfuels-wrap'></div>");
                },
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="' + url + '" alt="loader" class="custom-loader" />'
                },
                order: [],
                ajax: {
                    url: "{{ route('welltotankfuels.index') }}",
                    data: function(d) {
                        d.type = $('select[name="type"]').val();
                        d.unit = $('select[name="unit"]').val();
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
                columns: [{
                        data: 'type',
                        name: 'type',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'fuel',
                        name: 'fuel',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'unit',
                        name: 'unit',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'factors',
                        name: 'factors',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        className: "action-th",
                        render: function(data, type, full, meta) {
                            var id = full.id;
                            var current_url_show = "{{ url('admin/welltotankfuels/show') }}/" + id;
                            var current_url_edit = "{{ url('admin/welltotankfuels/edit') }}/" + id;
                            var html = "";

                            @if (adminMultiplePermissionCheck('welltotankfuels', ['show', 'edit', 'delete']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' width='' height=''></picture></div>";
                                html += '<ul class="dropdown-menu edit-sheet">';
                                @if (adminPermissionCheck('welltotankfuels.show'))
                                    html += '<li><a class="dropdown-item" href="' +
                                        current_url_show + '">View</a></li>';
                                @endif
                                @if (adminPermissionCheck('welltotankfuels.edit'))
                                    html += '<li><a class="dropdown-item" href="' +
                                        current_url_edit + '">Edit</a></li>';
                                @endif
                                @if (adminPermissionCheck('welltotankfuels.delete'))
                                    html +=
                                        '<li><a class="dropdown-item deletewelltotankfuel" href="#" data-id =' +
                                        full.id + '>Delete</a></li>';
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
                }, ],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#manage-welltotankfuels_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#manage-welltotankfuels_next").html(
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
            $('select[name="type"]').on('change', function() {
                $('#manage-welltotankfuels').DataTable().ajax.reload();
            });
            $('select[name="unit"]').on('change', function() {
                $('#manage-welltotankfuels').DataTable().ajax.reload();
            });

        });

        function resetValue() {
            $('select[name="type"], select[name="unit"]').val(null);
            $('select[name="type"], select[name="unit"]').selectpicker('refresh');
            $('#manage-welltotankfuels').DataTable().draw();
        }

        $(document).on('click', ".deletewelltotankfuel", function() {
            var id = $(this).attr('data-id');
            $(".deleterecordbtn").attr('data-id', id);
            $(".delete-modal-title").text("Well To Tank Fuels Delete");
            $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
            $("#deleterecordModel").modal('show');
        });
        $(".deleterecordbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('admin/welltotankfuels/delete') }}" + '/' + id;
            window.location.href = current_object;
        });
    </script>
@endsection
