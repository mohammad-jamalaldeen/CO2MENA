@extends('frontend.layouts.main')
@section('title')
    {{ $title ?? 'Staff Member Activity' }}
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" title="Dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('staff.index') }}" title="Staff Member">Staff Member</a></li>
        <li class="breadcrumb-item active">{{ $title ?? 'Staff Member Activity' }}</li>
    </ul>
    <div class="member-details">
        <div class="detail-wrapper">
            <div class="recent-activity">
                <div class="dl-header">
                    <h4 class="semi-title">Recent Activity</h4>
                    <div class="anydate-wrapper">
                        <a href="#!" class="any-date" title="Any date">
                            <picture>
                                <img src="{{ asset('assets/images/calendar-icon.svg') }}" alt="calendar-icon" width=""
                                    height="">
                            </picture>
                            Any date
                        </a>
                        <div class="date-picker">
                            <div class="input">
                                <div class="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dat2day-activity custome-scrollbar-m">
                    <div id="activity_log_list">
                    </div>
                </div>
                <div id="loader_activity" class="loader_activity"></div>
            </div>
            <div class="employee-details">
                <div class="dl-header">
                    <h4 class="semi-title">Employee Details</h4>
                </div>
                <ul class="em-detail-list">
                    <li>
                        <div class="em-label">Employee ID</div>
                        <div class="em-text em-email">{{ $user->employee_id ?? '' }}</div>
                    </li>
                    <li>
                        <div class="em-label">EMAIL ADDRESS</div>
                        <div class="em-text em-email">{{ $user->email ?? '' }}</div>
                    </li>
                    <li>
                        <div class="em-label">CONTACT NUMBER</div>
                        <div class="em-text">{{ $user->contact_number ?? '' }}</div>
                    </li>
                    <li>
                        <div class="em-label">ROLE</div>
                        <div class="em-text">{{ optional($user->role)->role ?? '' }}</div>
                    </li>
                    <li>
                        <div class="em-label">STATUS</div>
                        @if ($user->status == 1)
                            <div class="em-text em-status">Active</div>
                        @else
                            <div class="em-text em-status">Inactive</div>
                        @endif
                    </li>
                </ul>
                <div class="emoloyee-button">
                    @if ($user->id != Auth::guard('web')->user()->id)
                        <button type="button" class="delete-button" data-bs-toggle="modal"
                            data-bs-target="#delete-employee" title="delete">delete</button>
                    @endif
                    <button type="button" class="create-btn" data-id="{{ $user->id }}" data-bs-toggle="modal"
                        data-bs-target="#editMember-modal" title="edit">EDIT</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="selected_date" name="selected_date">
    <!-- Edit Member Modal -->
    <div class="modal fade common-modal add-member-modal" id="editMember-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="close"></button>
                <div class="content-inner">
                    <h2 class="section-title">Edit Member</h2>

                    <form id="staff-member-edit" method="POST" action="{{ route('staff.update') }}" class="input-form">
                        @csrf
                        <input type="hidden" id="member_id" name="member_id" value="{{ $user->id }}">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label for="editMemberName">MEMBER NAME</label>
                                    <input type="text" id="editMemberName" name="name"
                                        value="{{ $user->name ?? old('name') }}" placeholder="Enter member name"
                                        class="form-controal errorEditNameCls">
                                </div>
                            </div>

                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label for="editEmail">EMAIL ADDRESS</label>
                                    <input type="text" name="email" id="editEmail"
                                        value="{{ $user->email ?? old('email') }}" placeholder="Enter email address"
                                        class="form-controal errorEditEmailCls">
                                </div>
                            </div>

                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label for="editContactNumber">CONTACT NUMBER</label>
                                    <input type="text" id="editContactNumber" name="contact_number"
                                        value="{{ $user->contact_number ?? old('contact_number') }}"
                                        placeholder="Enter contact number"
                                        class="form-controal errorEditContactNumberCls">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group number-of-employee">
                                    <label for="editRole">ROLE</label>
                                    <div class="errorEditRoleCls">
                                        <select name="role" id="editRole" class="test">
                                            <option value="0" disabled>Select Role</option>
                                            @if ($staffrole)
                                                @foreach ($staffrole as $role)
                                                    <option {{ $role->id == $user->user_role_id ? 'Selected' : '' }}
                                                        value="{{ $role->id }}">{{ $role->role }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group number-of-employee">
                                    <label for="editStatus">STATUS</label>
                                    <select name="status" id="editStatus">
                                        @php
                                            $active = '';
                                            if ($user->status == '1') {
                                                $active = 'Selected';
                                            }
                                            $inactive = '';
                                            if ($user->status == '0') {
                                                $inactive = 'Selected';
                                            }
                                        @endphp
                                        <option {{ $active }} value="1">Active</option>
                                        <option {{ $inactive }} value="0">Inactive</option>
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
    <!--    Delete Modal-->
    <div class="modal fade common-modal delete-modal" id="delete-employee">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                    title="close"></button>
                <div class="content-inner">
                    <h2 class="section-title">Are you sure you want to remove this staff member?</h2>

                    <div class="para-14">
                        <p>This will delete staff member permanently. You cannot undo this action.</p>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="btn-wrap">
                                <a data-bs-dismiss="modal" class="back-btn" title="cancel">CANCEL</a>
                                <button type="button" class="delete-button deletestaffbtn"
                                    data-id="{{ $user->id }}" title="delete">delete</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.css') }}">
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <style>
        /* activity-list-style-start */
        div#loader_activity {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }

        ul.ul-remove-bp {
            padding-bottom: 0px !important;
        }

        /* activity-list-style-end */

        .anydate-wrapper {
            position: relative;
        }

        .date-picker {
            height: auto;
            max-height: 0px;
            background: white;
            overflow: hidden;
            transition: all 0.3s 0s ease-in-out;
            position: absolute;
            top: 26px;
            right: -20px;
            z-index: 999;
            padding: 0 20px
        }

        .date-picker .input {
            width: 100%;
            height: 450px;
            font-size: 0;
            cursor: pointer;
        }

        .date-picker.open {
            max-height: 400px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            var page = 1;
            var isLoading = false;
            var originalPage = page;
            var noMoreData = false;
            var scrollTimeout;
            var scrollThreshold = 100;

            function loadMoreData() {
                var userId = $('#member_id').val();
                var selectedDate = $('#selected_date').val();
                if (!isLoading && !noMoreData) {
                    isLoading = true;
                    $.ajax({
                        url: "{{ url('staff/load-more-data') }}" + '?userId=' + userId + '&page=' + page +
                            '&selectedDate=' + selectedDate,
                        method: 'GET',
                        success: function(response) {
                            if (response) {
                                $('#activity_log_list').append(response);
                                removeDuplicateDates();
                                page++;
                                isLoading = false;
                                noMoreData = false;
                            } else {
                                var $myDiv = $('#activity_log_list');
                                if ($myDiv.is(':empty') || $.trim($myDiv.html()) === '') {
                                    $('#activity_log_list').append(
                                        '<div class="activity-day no-data-msg"><ul><li><div class="activity-list"><span class="activity-name">No activities found.</span></div></li></ul></div>'
                                    );
                                }
                                noMoreData = true;
                                isLoading = false;
                            }
                        },
                        beforeSend: function() {
                            $('#loader_activity').show();
                            var image = "{{ asset('assets/loader.gif') }}";
                            $('#loader_activity').html("<img src='" + image + "' alt='loader' />");
                        },
                        complete: function() {
                            $('#loader_activity').hide();
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            isLoading = false;
                            // Handle the HTTP status code here
                            if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401) {
                                location.reload();
                                // Redirect to the new location
                                // window.location.href = xhr.getResponseHeader('Location');
                            }
                        },
                    });
                } else {
                    noMoreData = false;
                    isLoading = false;
                }
            }

            function handleScroll() {
                var $activityList = $('#activity_log_list');
                var $container = $('.recent-activity');

                if ($activityList.scrollTop() + $activityList.innerHeight() >= $container.height() -
                    scrollThreshold) {
                    var selectedDate = $('#selected_date').val();
                    if (selectedDate != "") {
                        if (page == 1) {
                            $('#activity_log_list').empty();
                            noMoreData = false;
                        }
                        if (page == '1') {
                            page = 1;
                            // page = 2;
                        } else {
                            page = page++;
                        }
                    }
                    if (noMoreData != true) {
                        loadMoreData();
                    }
                    $(".dat2day-activity").mCustomScrollbar("update");
                }
            }

            $('#activity_log_list').scroll(handleScroll);

            loadMoreData();

            var specificElement = $("#activity_log_list");

            if (specificElement.length > 0) {

                $(window).on("load", function() {
                    $(".dat2day-activity").mCustomScrollbar({
                        scrollInertia: 50,
                        theme: "dark-3",
                        scrollButtons: {
                            enable: false
                        },
                        callbacks: {
                            onTotalScroll: function() {
                                handleScroll();
                            },
                            onTotalScrollOffset: 100,
                            alwaysTriggerOffsets: false
                        }
                    });
                });
            }

            $(".calendar").datepicker({
                dateFormat: 'yy-mm-dd',
            });

            $(document).on('click', '.any-date', function(e) {
                var $me = $(this),
                    $parent = $me.next("div.date-picker");

                if (!$parent.hasClass('open')) {
                    $parent.addClass('open');
                } else {
                    $parent.removeClass('open');
                }
            });

            $(".calendar").on("change", function() {
                var $me = $(this),
                    $selected = $me.val(),
                    $parent = $me.parents('.date-picker');
                $parent.removeClass('open');
                var selectedDate = $selected;
                var userId = $('#member_id').val();
                $('#selected_date').val(selectedDate);
                $('#activity_log_list').empty();
                if (page !== originalPage) {
                    page = originalPage;
                    noMoreData = false;
                }
                noMoreData = false;
                loadMoreData();
            });
        });

        $(document).on('click', ".deleteStaff", function() {
            var id = $(this).attr('data-id');
            $(".deletestaffbtn").attr('data-id', id);
            $("#delete-employee").modal('show');
        });

        $(".deletestaffbtn").click(function() {
            var id = $(this).attr('data-id');
            var current_object = "{{ url('staff/delete') }}" + "/" + id;
            window.location.href = current_object;
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
                        button.prop('disabled', false);
                        $('.error-mgs').html('');
                        editValidationReset();
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
                        setReturnMsg("success", response.success);
                        setTimeout(location.reload(), 6000);
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

        function removeDuplicateDates() {
            var dates = {};
            $('.activity-date').each(function() {
                var dataId = $(this).data('id');
                if (dates[dataId]) {
                    var $previousDiv = $(this).parent().prev('.activity-day');
                    if ($previousDiv.length > 0) {
                        $previousDiv.find('ul').addClass('ul-remove-bp');
                    }
                    $(this).remove();
                } else {
                    dates[dataId] = true;
                }
            });
        }
    </script>
    {{-- <script type="text/javascript" src="{{ asset('assets/js/contact-number-validation.js') }}"></script> --}}
@endsection
