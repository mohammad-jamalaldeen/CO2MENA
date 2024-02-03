@extends('admin.layouts.app')
@section('title')
    CMS Management
@endsection
@section('content')
    <div class="table-header">
        <div class="row align-items-center">
            <div class="col-md-5 col-12">

            </div>
            <div class="col-md-7 col-12">
                <div class="dw-header">
                    {{-- <a class="createsheet-btn" href="{{ route('cms.create') }}">
                        CREATE CMS
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table cms-tabel-mr">
        <div class="responsive-table">
            <table id="manage-cms" class="table custome-datatable manage-staff-table display">
                <thead>
                    <tr>
                        <th class="mw-120">Title</th>
                        <th class="mw-120">Slug</th>
                        <th class="mw-120">Status</th>
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
            var url ="{{ asset('assets/loader.gif') }}";
            var table = $("#manage-cms").DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                lengthChange: true,
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function (settings, json) {  
                    $("#manage-cms").wrap("<div class='table-no-padding manage-cms-wrap'></div>");            
                },
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" title="loader" class="custom-loader" />'

                },
                order: [],
                ajax: {
                    url: "{{ route('cms.index') }}",
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
                        data: 'title',
                        name: 'title',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'slug',
                        name: 'slug',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            var html = "";
                            if (data == '1') {
                                html += '<span class="status complet">Active</span>'
                            } else {
                                html += '<span class="status faile">In Active</span>'
                            }
                            return html;
                        }
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        className:"action-th",
                        render: function(data, type, full, meta) {
                            var wttf_show_url = "{{ url('admin/cms/show') }}" + '/' + full.id;
                            var wttf_edit_url = "{{ url('admin/cms/edit') }}" + '/' + full.id;
                            var html = "";
                            @if(adminMultiplePermissionCheck('cms', ['show', 'edit']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' title='sheet-dots' width='' height=''></picture></div>";
                                html +='<ul class="dropdown-menu edit-sheet">';
                                @if (adminPermissionCheck('cms.show'))
                                html += '<li><a class="dropdown-item" href="' +wttf_show_url +'">View</a></li>';
                                @endif
                                @if (adminPermissionCheck('cms.edit'))
                                html += '<li><a class="dropdown-item" href="' +wttf_edit_url +'">Edit</a></li>';
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
                    $("#manage-cms_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon" title="back">');
                    $("#manage-cms_next").html(
                        '<img src="{{ asset('assets/images/arrow-next.svg') }}" alt="next-icon" title="next">');
                    var pageInfo = table.page.info();
                    var currentPage = pageInfo.page + 1;
                    if (currentPage == 1 && recordsTotal  <= 20) {
                        $('.dataTables_paginate').hide();
                    } else {
                        $('.dataTables_paginate').show();
                    }
                }
            });

        });

        $(document).on('click', ".deletecms", function() {
            var id = $(this).attr('data-id');
            $(".deleterecordbtn").attr('data-id', id);
            $(".delete-modal-title").text("CMS Delete");
            $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
            $("#deleterecordModel").modal('show');
        });
        $(".deleterecordbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('admin/cms/delete') }}" + '/' + id;
            window.location.href = current_object;
        });
    </script>
@endsection
