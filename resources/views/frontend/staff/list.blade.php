@extends('frontend.layouts.main')
@section('title')
    Staff Members
@endsection
@section('content')
    @if (!frontendPermissionCheck('staff.create'))
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
                    <a class="createsheet-btn" data-bs-toggle="modal" data-bs-target="#addMember-modal" title="Add Member">
                        Add Member
                    </a>
                </div>
            </div>
        </div>
        <div class="fillter-option">
            <div class="row">
                <div class="col-12">
                    <ul class="new-table-filter">
                        <li>
                            <select class="form-control status-select" name="status" title="Select Status" id="status">
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </li>
                        <li>
                            <button class="reset-btn" title="reset">Reset</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="datasheet-table tb-filter-inner {{ $classlist }}">
        <div class="responsive-table">
            <table id="manage-staff" class="table custome-datatable manage-staff-table display">
                <thead>
                    <tr>
                        <th class="mw-100"></th>
                        <th class="mw-100">Member Name</th>
                        <th class="mw-100">Role</th>
                        <th class="mw-100">Contact Number</th>
                        <th class="mw-120">Email</th>
                        <th class="mw-100">Status</th>
                        <th class="action-th"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Add Member Modal -->
    <div class="modal fade common-modal add-member-modal" id="addMember-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="close"></button>
                <div class="content-inner">
                    <h2 class="section-title">Add Member</h2>

                    <form method="POST" id="staff-data-add-form" action="{{ route('staff.store') }}"
                        enctype="multipart/form-data" class="input-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="name">MEMBER NAME <span class="mandatory-field">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        placeholder="Enter member name"
                                        class="form-controal field-clear errorMemberNameCls">
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="email">EMAIL ADDRESS <span class="mandatory-field">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        placeholder="Enter email address" class="form-controal field-clear errorEmailCls">
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="contact_number">CONTACT NUMBER</label>
                                    <input type="text" id="contact_number" name="contact_number" value=""
                                        placeholder="Enter contact number" class="form-controal field-clear errorPhoneCls"
                                        maxlength="15">
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="form-group number-of-employee">
                                    <label for="role">ROLE <span class="mandatory-field">*</span></label>
                                    <div class="errorRoleCls">
                                        <select name="role" id="role" title="Select Role" class="">
                                            @if ($staffrole)
                                                @foreach ($staffrole as $role)
                                                    <option value="{{ $role['id'] }}">{{ $role['role'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-12">
                                <div class="form-group number-of-employee">
                                    <label for="status">STATUS</label>
                                    <select name="status" id="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="btn-wrap">
                                    <a class="back-btn" data-bs-dismiss="modal" title="close">Close</a>
                                    <button class="create-btn" id="addMember-modal-btn" type="submit"
                                        title="add">ADD</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Edit Member Modal -->
    <div class="modal fade common-modal add-member-modal" id="editMember-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                    title="edit-member"></button>
                <div class="content-inner">
                    <h2 class="section-title">Edit Member</h2>

                    <form id="staff-member-edit" method="POST" action="{{ route('staff.update') }}" class="input-form">
                        @csrf
                        <input type="hidden" id="member_id" name="member_id">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="editMemberName">MEMBER NAME <span class="mandatory-field">*</span></label>
                                    <input type="text" id="editMemberName" name="name"
                                        value="{{ $user->name ?? old('name') }}" placeholder="Enter member name"
                                        class="form-controal errorEditNameCls">
                                </div>
                            </div>

                            {{-- <div class="col-sm-6 col-12">
                                <div class="form-group"> --}}
                            {{-- <label for="editEmail">EMAIL ADDRESS</label> --}}
                            <input type="hidden" name="email" id="editEmail"
                                value="{{ $user->email ?? old('email') }}" placeholder="Enter email address"
                                class="form-controal errorEditEmailCls">
                            {{-- </div>
                            </div> --}}

                            <div class="col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="editContactNumber">CONTACT NUMBER</label>
                                    <input type="text" id="editContactNumber" name="contact_number"
                                        value="{{ $user->contact_number ?? old('contact_number') }}"
                                        placeholder="Enter contact number" class="form-controal errorEditContactNumberCls"
                                        maxlength='15'>
                                </div>
                            </div>

                            <div class="col-sm-6 col-12">
                                <div class="form-group number-of-employee">
                                    <label for="editRole">ROLE<span
                                        class="mandatory-field">*</span></label>
                                    <div class="errorEditRoleCls">
                                        <select name="role" id="editRole" class="test" title="Select Role">
                                            @if ($staffrole)
                                                @foreach ($staffrole as $role)
                                                    <option value="{{ $role['id'] }}">{{ $role['role'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-12">
                                <div class="form-group number-of-employee">
                                    <label for="editStatus">STATUS</label>
                                    <select name="status" id="editStatus" title="Select status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="btn-wrap">
                                    <a data-bs-dismiss="modal" class="back-btn" title="back">back</a>
                                    <button class="create-btn" id="staff-member-edit-btn" title="update">UPDATE</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- View details Modal -->
    <div class="modal fade common-modal view-details-modal" id="viewDetails-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                    title="close"></button>
                <div class="content-inner">
                    <h2 class="section-title" id="staffName">Adnan Khan</h2>
                    <span class="bottom-text" id="view_employee_id"></span>
                    <div class="row">
                        <div class="col-12">
                            <ul class="datasheet-view">
                                <li>
                                    <div class="view-lable">EMAIL ADDRESS</div>
                                    <div class="view-name" id="staffEmail">Adnan.khan@abcco.com</div>
                                </li>
                                <li>
                                    <div class="view-lable">CONTACT NUMBER</div>
                                    <div class="view-name" id="staffPhone">55 380 8759</div>
                                </li>
                                <li>
                                    <div class="view-lable">ROLE</div>
                                    <div class="view-name" id="staffRole">Marketing manager</div>
                                </li>
                                <li>
                                    <div class="view-lable">STATUS</div>
                                    <div class="view-name status-active" id="staffStatus">Active</div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="btn-wrap">
                                <a data-bs-dismiss="modal" class="back-btn" title="back">back</a>
                                <button class="create-btn" id="viewModalEditBtn" data-id="" data-bs-toggle="modal"
                                    data-bs-target="#editMember-modal" title="edit">EDIT</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    @include('common-modal/delete-modal')
@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var url = "{{ asset('assets/loader.gif') }}";
            $.validator.addMethod("customValidation", function(value, element) {
                var inputValue = value.trim();
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(inputValue)) {
                    return true;
                } else if (/^[a-zA-Z0-9_]+$/.test(inputValue)) {
                    return true;
                } else {
                    return false;
                }
            }, "Please enter a valid email.");

            $("#staff-data-add-form").validate({
                rules: {
                    email: {
                        customValidation: true,
                    },
                    // contact_number: {
                    //     required: true,
                    // },
                    name: {
                        required: true,
                    }, 
                    role: {
                        required: true,
                    }, 
                },

                messages: {
                    email: {
                        required: "Please enter a valid email.",
                    },
                    // contact_number: {
                    //     required: "Please enter contact number.",
                    // },
                    name: {
                        required: "Please enter name.",
                    },
                    role: {
                        required: "Please select role.",
                    }
                },
                errorElement: "span",
                errorPlacement: function(error, element) {
                    error.addClass('error-mgs');
                    error.insertAfter(element);
                }
            });

            $("#staff-data-add-form").on("submit", function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Check if the form is valid
                if ($(this).valid()) {
                    var formAction = $(this).attr('action');
                    var formdata = new FormData($(this)[0]);
                    var button = $('#addMember-modal-btn');
                    button.prop('disabled', true);
                    $.ajax({
                        url: formAction,
                        type: 'POST',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('.error-mgs').html('');
                            resetValidationError();
                            if (response.errors) {
                                button.prop('disabled', false);
                                $('.error-mgs').html('');
                                if (response.errors.name) {
                                    $('.errorMemberNameCls').after(
                                        '<span class="error-mgs" id="errorMemberName">' +
                                        response.errors.name[0] + '</span>');
                                }
                                if (response.errors.email) {
                                    $('.errorEmailCls').after(
                                        '<span class="error-mgs" id="errorEmail">' +
                                        response.errors.email[0] + '</span>');
                                }
                                // if (response.errors.contact_number) {
                                //     $('.errorPhoneCls').after(
                                //         '<span class="error-mgs" id="errorPhone">' +
                                //         response.errors.contact_number[0] + '</span>');
                                // }
                                if (response.errors.role) {
                                    $('.errorRoleCls').after(
                                        '<span class="error-mgs" id="errorRole">' + response
                                        .errors.role[0] + '</span>');
                                }
                            }
                            if (response.success) {
                                button.prop('disabled', false);
                                $('#addMember-modal').modal('hide');
                                setReturnMsg("success", response.success);
                                $("#manage-staff").DataTable().clear().draw();
                                // setTimeout(() => location.reload(), 1000);
                            }
                            if (response.add_error) {
                                button.prop('disabled', false);
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
                }
            });

            function resetValidationError() {
                $("#errorMemberName").remove();
                $("#errorEmail").remove();
                $("#errorPhone").remove();
                $("#errorRole").remove();
            }

            var table = $("#manage-staff").DataTable({
                bInfo: true,
                lengthChange: true,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                stateSave: true,
                "pageLength": <?php echo config('constants.perPageRecords'); ?>,
                "initComplete": function(settings, json) {
                    $("#manage-staff").wrap("<div class='table-main-wrap manage-staff-wrap'></div>");
                },
                language: {
                    searchPlaceholder: "Search",
                    'loadingRecords': '&nbsp;',
                    'processing': '<img src="' + url + '" alt="loader" class="custom-loader" />'
                },
                ajax: {
                    url: "{{ route('staff.index') }}",
                    dataType: "json",
                    data: function(d) {
                        if(d.draw != '1')
                        {
                            d.status_filter = $('#status').val();
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
                        data: 'user.id',
                        name: 'user.id',
                        visible: false,
                        orderable: true,
                    }, {
                        data: 'user.name',
                        name: 'user.name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.user.id;
                            var name = full.user.name;
                            var activityurl = "{{ url('staff/activity/') }}" + '/' + id;
                            html += '<a title="username" href="' + activityurl +
                                '"><span style="color:#204C65;">' +
                                name + '</span></a>';
                            return html;
                        }
                    },
                    {
                        data: 'user.role.role',
                        name: 'user.role.role',
                        orderable: false,
                        searchable: true,
                    },
                    {
                        data: 'user.contact_number',
                        name: 'user.contact_number',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'user.email',
                        name: 'user.email',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'user.status',
                        name: 'user.status',
                        orderable: false,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            var html = "";
                            if (data == '1') {
                                html += '<span class="status complet">Active</span>'
                            } else {
                                html += '<span class="status faile">Inactive</span>'
                            }
                            return html;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'action-th',
                        render: function(data, type, full, meta) {
                            var html = "";
                            var id = full.user.id;
                            var showurl = "{{ url('staff/show/') }}" + '/' + id;
                            var editurl = "{{ url('staff/edit/') }}" + '/' + id;
                            var deleteLi = '';

                            @if (frontMultiplePermissionCheck('staff', ['edit', 'delete', 'show']) > 0)
                                html +=
                                    '<div class="dropdown sheet-dots"><div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >';
                                html +=
                                    "<picture><img  src='{{ asset('assets/images/sheet-dots.svg') }}' alt='sheet-dots' width='' height=''></picture></div>";
                                html += '<ul class="dropdown-menu edit-sheet">';

                                @if (frontendPermissionCheck('staff.show'))
                                    html += '<li><a class="dropdown-item" href="' +
                                        showurl + '" data-id="' + id +
                                        '" data-bs-toggle="modal" data-bs-target="#viewDetails-modal" title="view">View</a></li>';
                                @endif
                                @if (frontendPermissionCheck('staff.edit'))
                                    html += '<li><a class="dropdown-item" href="' +
                                        editurl + '" data-id="' + id +
                                        '" data-bs-toggle="modal" data-bs-target="#editMember-modal" title="Edit">Edit</a></li>';
                                @endif
                                @if (frontendPermissionCheck('staff.delete'))
                                    html +=
                                        '<li><a title="Delete" class="dropdown-item deleteStaff" href="#" data-id =' +
                                        full.user.id + '>Delete</a></li>';
                                @endif
                                html += '</ul></div>';
                            @else
                                html += '-';
                            @endif
                            return html;
                        },
                    },
                ],
                columnDefs: [{
                    targets: '_all',
                    defaultContent: '-'
                }],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var recordsTotal = api.page.info().recordsTotal;
                    $("#manage-staff_previous").html(
                        '<img src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-icon">');
                    $("#manage-staff_next").html(
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

            $("#status").change(function() {
                table.draw();
            });

            $('.reset-btn').on('click', function() {
                $('#status').prop('selectedIndex', 0).trigger('change');
                $('#status').selectpicker('deselectAll');
                $('#status').selectpicker('refresh');
                table.ajax.reload();
            });

            $('#editMember-modal').on('show.bs.modal', function(e) {
                $('#addMember-modal').modal('hide');
                $('#viewDetails-modal').modal('hide');
                let btn = $(e
                    .relatedTarget
                );
                let id = btn.data('id');
                let userUrl = "{{ url('/staff/get-member-by-id') }}/" + id;
                $.ajax({
                    url: userUrl,
                    type: 'GET',
                    success: function(result) {
                        if (result.status == 'true') {
                            $("#member_id").val(result.data['id']);
                            $("#editMemberName").val(result.data['name']);
                            $("#editEmail").val(result.data['email']);
                            $("#editContactNumber").val(result.data['contact_number']);
                            $('#editStatus').selectpicker('val', result.data['status']);
                            $('#editRole').selectpicker('deselectAll');
                            $('#editRole').selectpicker('refresh');
                            $('#editRole').val(result.data['user_role_id']);
                            $('#editRole').selectpicker('refresh');
                        } else {
                            alert('Something went wrong!');
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

            $('#viewDetails-modal').on('show.bs.modal', function(e) {
                $('#addMember-modal').modal('hide');
                $('#editMember-modal').modal('hide');
                let btn = $(e
                    .relatedTarget
                );
                let id = btn.data('id');
                let userUrl = "{{ url('/staff/show') }}/" + id;
                $.ajax({
                    url: userUrl,
                    type: 'GET',
                    success: function(result) {
                        if (result.status == 'true') {
                            $('#viewModalEditBtn').data('id', result.data['id']);
                            $('#view_employee_id').html((result.data['employee_id'] != "") ?
                                result.data['employee_id'] : '');
                            $("#staffName").html(result.data['name']);
                            $("#staffEmail").html(result.data['email']);
                            $("#staffPhone").html(result.data['contact_number']);
                            $("#staffRole").html(result.data['role']['role']);
                            if (result.data['status'] == "0") {
                                $("#staffStatus").html('Inactive');
                            } else {
                                $("#staffStatus").html('Active');
                            }
                        } else {
                            alert('Something went wrong!');
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
        });

        $(document).on('click', ".deleteStaff", function() {
            var id = $(this).attr('data-id');
            $(".deleterecordbtn").attr('data-id', id);
            $(".delete-modal-title").text("Are you sure you want to remove this staff member?");
            $(".delete-modal-body").html(
                "<p>This will delete staff member permanently. You cannot undo this action.</p>");
            $("#deleterecordModel").modal('show');
        });

        $(".deleterecordbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('staff/delete/') }}" + '/' + id;
            window.location.href = current_object;
        });

        $('#addMember-modal').on('hidden.bs.modal', function(e) {
            $('.error-mgs').html('');
            $('.field-clear').val("");
            $("#errorMemberName").remove();
            $("#errorEmail").remove();
            $("#errorPhone").remove();
            $("#errorRole").remove();
            $('#role').val(null);
            $('#role').selectpicker('refresh');
        });

        $('#editMember-modal').on('hidden.bs.modal', function(e) {
            $('.error-mgs').html('');
            editValidationReset();
        });

        function editValidationReset() {
            $("#errorEditName").remove();
            $("#errorEditEmail").remove();
            $("#errorEditContactNumber").remove();
            $("#errorEditRole").remove();
        }

        $('#staff-member-edit').submit(function(e) {
            e.preventDefault();
            var formAction = $(this).attr('action');
            var formdata = new FormData(this)
            var button = $('#staff-member-edit-btn');
            button.prop('disabled', true);
            $.ajax({
                url: formAction,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.errors) {
                        editValidationReset();
                        button.prop('disabled', false);
                        $('.error-mgs').html('');
                        if (response.errors.name) {
                            // $( '#errorEditName' ).html( response.errors.name[0] );
                            $('.errorEditNameCls').after('<span class="error-mgs" id="errorEditName">' +
                                response.errors.name[0] + '</span>');
                        }
                        if (response.errors.email) {
                            // $( '#errorEditEmail' ).html( response.errors.email[0] );
                            $('.errorEditEmailCls').after(
                                '<span class="error-mgs" id="errorEditEmail">' + response.errors
                                .email[0] + '</span>');
                        }
                        if (response.errors.contact_number) {
                            // $( '#errorEditContactNumber' ).html( response.errors.contact_number[0] );
                            $('.errorEditContactNumberCls').after(
                                '<span class="error-mgs" id="errorEditContactNumber">' + response
                                .errors.contact_number[0] + '</span>');
                        }
                        if (response.errors.role) {
                            // $( '#errorEditRole' ).html( response.errors.role[0] );
                            $('.errorEditRoleCls').after('<span class="error-mgs" id="errorEditRole">' +
                                response.errors.role[0] + '</span>');
                        }
                    }
                    if (response.success) {
                        button.prop('disabled', false);
                        $('#addMember-modal').modal('hide');
                        $('#editMember-modal').modal('hide');
                        setReturnMsg("success", response.success);
                        $("#manage-staff").DataTable().clear().draw();
                        // setTimeout(() => location.reload(), 1000);
                    }
                    if (response.update_error) {
                        button.prop('disabled', false);
                        setReturnMsg("danger", response.update_error);
                    }
                    if (response.no_data_error) {
                        button.prop('disabled', false);
                        setReturnMsg("danger", response.no_data_error);
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
    </script>
    {{-- <script type="text/javascript" src="{{ asset('assets/js/contact-number-validation.js') }}"></script> --}}
@endsection
