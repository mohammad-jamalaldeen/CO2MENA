@extends('admin.layouts.app')
@section('title')
City Management
@endsection
@if (!adminPermissionCheck('city.create'))
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
@section('content')
    <div class="table-header {{$classlist}}">
        <div class="row align-items-center" {{$display}}>
            <div class="col-md-5 col-12">

            </div>
            <div class="col-md-7 col-12">
                <div class="dw-header">
                    <a class="createsheet-btn" href="{{ route('city.create') }}" title="create">
                        CREATE City
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table {{$classlist}} city-table">
        <div class="responsive-table">
            <table id="manage-city" class="table custome-datatable manage-customer-table display">
                <thead>
                    <tr>
                        <th class="mw-120">Origin (city or IATA code)</th>
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
            var table = $("#manage-city").DataTable({
                // scrollX: true,
                processing: true,
                serverSide: true,
                searching: true,
                "bLengthChange": false,
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="'+url+'" alt="loader" title="loader" class="custom-loader" />'
                },
                order: [],
                "initComplete": function (settings, json) {  
                    $("#manage-city").wrap("<div class='table-no-padding manage-city-wrap'></div>");            
                },
                ajax: {
                    url: "{{ route('city.index') }}",
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        } 
                    },
                },
                columns: [{
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className:"action-th",
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.id;
                            var current_url_edit = "{{ url('admin/city/edit') }}/" + id;
                            @if(adminMultiplePermissionCheck('city', ['edit', 'delete']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' title='sheet-dots' width='' height=''></picture></div><ul class='dropdown-menu edit-sheet'>";
                                @if (adminPermissionCheck('city.edit'))
                                html +=
                                    '<li><a class="dropdown-item" href="' +
                                    current_url_edit +
                                    '">Edit</a></li>';
                                @endif
                                @if (adminPermissionCheck('city.delete'))
                                html += '<li><a class="dropdown-item deletecity" href="#" data-id =' +
                                    full.id + '>Delete</a></li>';
                                @endif
                                html +='</ul></div>';
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
                    $("#manage-city_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon" title="back">');
                    $("#manage-city_next").html(
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
        $(document).on('click', ".deletecity", function() {
            var id = $(this).attr('data-id');
            $(".deleterecordbtn").attr('data-id', id);
            $(".delete-modal-title").text("City Delete");
            $(".delete-modal-body").html("<p>Are you sure? you want to delete this record.</p>");
            $("#deleterecordModel").modal('show');
        });
        $(".deleterecordbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('admin/city/delete') }}"+'/'+id;
            window.location.href = current_object;
        });
    </script>
@endsection
