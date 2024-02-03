@extends('admin.layouts.app')
@section('title')
    Waste disposal Management
@endsection
@section('content')
    @if (!adminPermissionCheck('waste-disposal.create'))
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
                    <a class="createsheet-btn" href="{{ route('waste-disposal.create') }}" title="create">
                        CREATE Waste disposal
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table {{ $classlist }} waste-disposal-table">
        <div class="responsive-table">
            <table id="manage-waste-disposal" class="table custome-datatable manage-customer-table display">
                <thead>
                    <tr>
                        <th class="mw-140">Activity</th>
                        <th class="mw-140">Type</th>
                        <th class="mw-140">Emission Factor</th>
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
            var table = $("#manage-waste-disposal").DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                lengthChange: true,
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function(settings, json) {
                    $("#manage-waste-disposal").wrap(
                        "<div class='table-no-padding manage-waste-disposal-wrap'></div>");
                },

                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="' + url + '" alt="loader" class="custom-loader" />'
                },
                order: [],
                ajax: {
                    url: "{{ route('waste-disposal.index') }}",
                    data: function(d) {
                        d.type = $('select[name="type"]').val();
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
                        data: 'waste_type',
                        name: 'waste_type',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'type',
                        name: 'type',
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
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: "action-th",
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            var current_url_show = "{{ url('admin/waste-disposal/show') }}/" + id;
                            var current_url_edit = "{{ url('admin/waste-disposal/edit') }}/" + id;

                            @if (adminMultiplePermissionCheck('waste-disposal', ['show', 'edit', 'delete']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' width='' height=''></picture></div>";
                                html += '<ul class="dropdown-menu edit-sheet">';
                                @if (adminPermissionCheck('waste-disposal.show'))
                                    html += '<li><a class="dropdown-item" href="' +
                                        current_url_show + '">View</a></li>';
                                @endif
                                @if (adminPermissionCheck('waste-disposal.edit'))
                                    html += '<li><a class="dropdown-item" href="' +
                                        current_url_edit + '">Edit</a></li>';
                                @endif
                                @if (adminPermissionCheck('waste-disposal.delete'))
                                    html +=
                                        '<li><a class="dropdown-item deletewastedisposal" href="#" data-id =' +
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
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#manage-waste-disposal_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#manage-waste-disposal_next").html(
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
                table.ajax.reload();
            });
        });

        function resetValue() {
            $('#type').val(null);
            $('#type').selectpicker('refresh');
            $('#manage-waste-disposal').DataTable().draw();
        }

        $(document).on('click', ".deletewastedisposal", function() {
            var id = $(this).attr('data-id');
            $(".deleterecordbtn").attr('data-id', id);
            $(".delete-modal-title").text("Waste disposals Delete");
            $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
            $("#deleterecordModel").modal('show');
        });
        $(".deleterecordbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('admin/waste-disposal/delete') }}" + '/' + id;
            window.location.href = current_object;
        });
    </script>
@endsection
