@extends('admin.layouts.app')
@section('title')
    Backend Permission
@endsection
@section('content')
    <div class="table-header">
        <div class="fillter-option">
            <div class="row">
                <div class="col-12">
                    <ul class="new-table-filter admin-permission-filter">
                        <li>
                            <select name="permission_type" id="permission_type" data-live-search="true" class="permission-filter-select"
                                title="Select Permission">
                                <option value="1">Role Wise Permission</option>
                                <option value="2">User Wise Permission</option>
                            </select>
                            <span class="error-mgs" id="permission-type-error-msg"></span>
                        </li>
                        <li id="roleli" style="display:none">
                            <select name="role" id="role" data-live-search="true" class="permission-filter-select" title="Select Role">
                                @foreach ($userRoleData as $value)
                                    <option value="{{ $value['id'] }}">{{ $value['role'] }}</option>
                                @endforeach
                            </select>
                            <span class="error-mgs" id="role-error-msg"></span>
                        </li>
                        <li id="userli" style="display:none">
                            <select name="user" id="user" data-live-search="true" class="permission-filter-select" title="Select User">
                                @foreach ($userData as $value)
                                    <option value="{{ $value['id'] }}">
                                        {{ $value['name'] . ' - ' . optional($value['user_role'])['role'] }}</option>
                                @endforeach
                            </select>
                            <span class="error-mgs" id="user-error-msg"></span>
                        </li>
                        <li>
                            <button type="button" id="filtersubmit" class="btn-primary" title="apply">Apply</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div>
        <form method="post" class="table-form permission-table-form" action="{{ route('backend-permission.update') }}"
            style="display:none">
            <input type="hidden" name="userrole" id="userrole">
            <input type="hidden" name="role_type" id="role_type">
            <input type="hidden" name="user_id" id="user_id">
            <input type="hidden" name="filter_permission_type" id="filter_permission_type">
            <input type="hidden" name="page" id="page" value="admin-permission">
            @csrf
            <div class="table-responsive">
                <table class="table custome-datatable simple-table permission-table" width="100%">
                    <thead>
                        <tr>
                            <th>
                                <label class="checkbox">
                                    <input type="checkbox"   id="allcheck" name="allcheck">
                                    <span class="checkmark"></span>
                                </label>
                            </th>
                            <th>Module</th>
                            <th>Create</th>
                            <th>List</th>
                            <th>show</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Download</th>
                            <th>Manage Activity</th>
                            <th>Pending Document</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="button-row">
                <input class="btn-primary" value="SUBMIT" type="submit">
            </div>
        </form>
        <input type="hidden" name="permissiondata" id="permissiondata">
        <input type="hidden" name="moduleNameData" id="moduleNameData">
        <input type="hidden" name="moduleidData" id="moduleidData">
    </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        var moduleWiseArray = {
            'dashboard': ['', 'index', '', '', '', 'download', '', ''],
            'customer_management': ['create', 'index', 'show', 'edit', 'delete', '', 'manageemission',
                'pendingdocument'
            ],
            'manage_datasheet': ['', 'index', 'show', '', '', '', '', ''],
            'backup_reports': ['create', 'index', 'show', '', '', 'download', '', ''],
            'cms_management': ['', 'index', 'show', 'edit', '', '', '', ''],
            'contact_request_data_management': ['', 'index', 'show', '', '', '', '', ''],
            'backend_permission': ['', 'index', '', '', '', '', '', ''],
            'frontend_permission': ['', 'index', '', '', '', '', '', ''],
            'default': ['create', 'index', 'show', 'edit', 'delete', '', '', '']
        };

        $(document).ready(function() {
            var previousURL = document.referrer;
            var currentURL = window.location.href;

            if (previousURL != currentURL) {
                sessionStorage.setItem('permission_type', '');
                sessionStorage.setItem('role', '');
                sessionStorage.setItem('user', '');
            } else {
                const permission_type = sessionStorage.getItem('permission_type');
                const role = sessionStorage.getItem('role');
                const user = sessionStorage.getItem('user');
                roleUserSelectBoxHideShow(permission_type);
                $('select[name="permission_type"]').val(permission_type);
                $('select[name="permission_type"]').selectpicker('refresh');
                $('select[name="role"]').val(role);
                $('select[name="role"]').selectpicker('refresh');
                $('select[name="user"]').val(user);
                $('select[name="user"]').selectpicker('refresh');
                listPermission();
            }
        });
        var route = "{{ route('backend-permission.list-module') }}"
        $('#permission_type').change(function() {
            sessionStorage.setItem('permission_type', $(this).val());
            $('#permission-type-error-msg').text('')
            roleUserSelectBoxHideShow($(this).val());
        });

        $('#role').change(function() {
            sessionStorage.setItem('role', $(this).val());
            $('#role-error-msg').text('')
        });

        $('#user').change(function() {
            sessionStorage.setItem('user', $(this).val());
            $('#user-error-msg').text('');
        });

        $('#filtersubmit').click(function() {
            $('#permission-type-error-msg').text('')
            $('#role-error-msg').text('')
            $('#user-error-msg').text('')
            if ($('#permission_type').val() == '') {
                $('#permission-type-error-msg').text('Please select permission')
                return;
            }

            if ($('#role').val() == '' && $('#permission_type').val() === '1') {
                $('#role-error-msg').text('Please select role')
                return;
            }

            if ($('#user').val() == '' && $('#permission_type').val() === '2') {
                $('#user-error-msg').text('Please select user');
                return;
            }
            $('#allcheck').prop("checked", false);
            listPermission();
        });

        function listPermission() {
            const $tbody = $('tbody').empty();
            const data = {
                role: 'admin',
                submitType: $('#permission_type').val() === '1' ? 'Role' : 'User',
            };
            $('#permission_type').val() === '1' ? $('#filter_permission_type').val('Role') : $('#filter_permission_type')
                .val('User')

            if (data.submitType === 'Role') {
                data.userRole = $('#role').val();
            } else {
                data.userId = $('#user').val();
                $('#user_id').val($('#user').val());
            }

            $('#role_type').val(data.role);
            $('#userrole').val(data.userRole);

            $.ajax({
                type: 'POST',
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(response) {
                    $('#permissiondata').val(JSON.stringify(response.data));
                    $('.permission-table-form').css("display", 'block');
                    if (response.data.length > 0) {
                        let html = '';
                        var moduleNameArray = [];
                        var moduleIdArray = [];
                        for (let i = 0; i < response.data.length; i++) {
                            if (response.data[i].module_name != "Profiles") {
                                moduleIdArray.push(response.data[i].id);
                                moduleNameArray.push(response.data[i].module_name);

                                html += `<tr>`
                                
                                switch (response.data[i].module_name) {
                                    case 'Dashboard':
                                        html += moduleTdGenrate(response.data[i], response.data[i].id, response
                                            .data[i].module_name,
                                            moduleWiseArray
                                            .dashboard);
                                        html += tdGenrate(response.data[i].id, response.data[i], moduleWiseArray
                                            .dashboard, response.data[i].module_name);
                                        break;
                                    case 'Customer Management':
                                        html += moduleTdGenrate(response.data[i], response.data[i].id, response
                                            .data[i].module_name,
                                            moduleWiseArray
                                            .customer_management);
                                        html += tdGenrate(response.data[i].id, response.data[i], moduleWiseArray
                                            .customer_management, response.data[i].module_name);
                                        break;
                                    case 'Manage DataSheets':
                                        html += moduleTdGenrate(response.data[i], response.data[i].id, response
                                            .data[i].module_name, moduleWiseArray.manage_datasheet);
                                        html += tdGenrate(response.data[i].id, response.data[i], moduleWiseArray
                                            .manage_datasheet, response.data[i].module_name);
                                        break;
                                    case 'Backup Reports':
                                        html += moduleTdGenrate(response.data[i], response.data[i].id, response
                                            .data[i].module_name, moduleWiseArray.backup_reports);
                                        html += tdGenrate(response.data[i].id, response.data[i], moduleWiseArray
                                            .backup_reports, response.data[i].module_name);
                                        break;
                                    case 'CMS Management':
                                        html += moduleTdGenrate(response.data[i], response.data[i].id, response
                                            .data[i].module_name, moduleWiseArray.cms_management);
                                        html += tdGenrate(response.data[i].id, response.data[i], moduleWiseArray
                                            .cms_management, response.data[i].module_name);
                                        break;
                                    case 'Contact Request Data Management':
                                        html += moduleTdGenrate(response.data[i], response.data[i].id, response
                                            .data[i].module_name, moduleWiseArray
                                            .contact_request_data_management);
                                        html += tdGenrate(response.data[i].id, response.data[i], moduleWiseArray
                                            .contact_request_data_management, response.data[i].module_name);
                                        break;
                                    case 'Backend Permission':
                                        html += moduleTdGenrate(response.data[i], response.data[i].id, response
                                            .data[i].module_name, moduleWiseArray
                                            .backend_permission);
                                        html += tdGenrate(response.data[i].id, response.data[i], moduleWiseArray
                                            .backend_permission, response.data[i].module_name);
                                        break;
                                    case 'Frontend Permission':
                                        html += moduleTdGenrate(response.data[i], response.data[i].id, response
                                            .data[i].module_name, moduleWiseArray
                                            .frontend_permission);
                                        html += tdGenrate(response.data[i].id, response.data[i], moduleWiseArray
                                            .frontend_permission, response.data[i].module_name);
                                        break;
                                    default:
                                        html += moduleTdGenrate(response.data[i], response.data[i].id, response
                                            .data[i].module_name, moduleWiseArray.default);
                                        html += tdGenrate(response.data[i].id, response.data[i], moduleWiseArray
                                            .default, response.data[i].module_name);
                                        break;
                                }

                            html += `</tr>`;
                            }
                        }
                    $tbody.html(html);
                    $('#moduleNameData').val(JSON.stringify(moduleNameArray));
                    $('#moduleidData').val(JSON.stringify(moduleIdArray));
                    allCheckboxCheck(moduleNameArray);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                $('.custom-pre-loader-container .loader').addClass('d-none');
                console.error('Something went wrong during the AJAX request');
                // Handle the HTTP status code here
                if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                    location.reload();
                    // Redirect to the new location
                    // window.location.href = xhr.getResponseHeader('Location');
                }
            }
        });
    }

    function checkValue(item, action) {
        return item.permissions.some(permission => permission.action === action);
    }

    function disabledvalue(item, action) {
        return item.permissions.some(permission => permission.action == 'index');
    }

    function tdGenrate(id, data, actionArray, modulename) {
        return `<td>${inputCheckBox(actionArray[0], data, id,modulename, actionArray)}</td>
                <td>${inputCheckBox(actionArray[1], data, id,modulename, actionArray)}</td>
                <td>${inputCheckBox(actionArray[2], data, id,modulename, actionArray)}</td>
                <td>${inputCheckBox(actionArray[3], data, id,modulename, actionArray)}</td>
                <td>${inputCheckBox(actionArray[4], data, id,modulename, actionArray)}</td>
                <td>${inputCheckBox(actionArray[5], data, id,modulename, actionArray)}</td>
                <td>${inputCheckBox(actionArray[6], data, id,modulename, actionArray)}</td>
                <td>${inputCheckBox(actionArray[7], data, id,modulename, actionArray)}</td>`;
    }

    function inputCheckBox(action, data, id, modulename, actionArray) {
        if (modulename == 'Company Staff') {
            if (!disabledvalue(data, action)) {
                var disabled = "disabled";
            } else {
                var disabled = "";
            }
        } else {
            var disabled = "";
        }
        return (action == '') ? '' :
            `<label class="checkbox">
                <input type="checkbox" data-datas='${JSON.stringify(data)}' data-moduleArray='${JSON.stringify(actionArray)}' data-modulename="${modulename}"  class="${modulename == "Company Staff" && action == 'index' ? 'showstaff':''} ${modulename == "Company Staff" ? 'disabledstaff':''} ${modulename == "Customer Management" && action == 'show' ? 'showcustomer':''} ${modulename == "Customer Management" ? 'customershow':""} ${action != 'index' ? 'inputcheckboxpermission':'inputindexcheckbox'}" 
                data-name="${action}" data-id="${id}" name="${action}[${id}]" ${checkValue(data, action) ? 'checked' : ''} ${disabled} onclick="moduleCheckBoxCheck(this)">
                <span class="checkmark"></span>
            </label>`;

    }

    $(document).on("click", ".inputcheckboxpermission", function() {
        var name = $(this).data('name');
        var id = $(this).data('id');
        var checkboxes = $('input[data-id="' + id + '"].inputcheckboxpermission');
        var checkedCount = 0;

        checkboxes.each(function() {
            if ($(this).is(":checked")) {
                checkedCount++;
            }
        });
        if ($(this).hasClass('showcustomer')) {
            if ($(this).is(':checked')) {
                $(".showstaff").prop('disabled', false);
                $(".showstaff").prop("checked", true);
                $(".disabledstaff").prop('disabled', false);
            } else {
                $(".showstaff").prop("checked", false);
                if ($(".showstaff").is(':checked') == false) {
                    $("input:checkbox[name='Company Staff']").prop("checked", false);
                    $(".disabledstaff").prop('disabled', true);
                    $(".disabledstaff").prop("checked", false);
                    $(".showstaff").prop('disabled', true);
                }
            }
        }
        if (checkedCount >= 1) {
            $("input[name = 'index[" + id + "]']").prop("checked", true);
        }

    });

    $(document).on("click", ".inputindexcheckbox", function() {
        var name = $(this).data('name');
        var id = $(this).data('id');
        if ($("input[name = 'index[" + id + "]']").is(':checked') == false) {
            if ($(this).hasClass('customershow')) {
                $("input:checkbox[name='Company Staff']").prop("checked", false);
                $(".showstaff").prop("checked", false);
                $(".disabledstaff").prop('disabled', true);
                $(".disabledstaff").prop("checked", false);
                $(".showstaff").prop('disabled', true);
            }
            var checkboxes = $('input[data-id="' + id + '"].inputcheckboxpermission');
            var checkedCount = 0;
            checkboxes.each(function() {
                if ($(this).is(":checked")) {
                    $(this).prop('checked', false);
                    checkedCount++;
                }
            });
        }
    });

    function roleUserSelectBoxHideShow(input) {
        if (input == '1') {
            $('#roleli').css("display", "flex");
            $('#userli').css("display", "none");
        } else {
            $('#roleli').css("display", "none");
            $('#userli').css("display", "flex");
        }
    }

    function allCheckboxCheck(moduleNameArray) {
        let allModuleCheckFlag = true;

        for (let i = 0; i < moduleNameArray.length; i++) {
            if (!$("input:checkbox[name='" + moduleNameArray[i] + "']").prop('checked')) {
                allModuleCheckFlag = false;
                break;
            }
        }

        if (allModuleCheckFlag) {
            $('#allcheck').prop("checked", true);
        }
    }

    $(document).on("click", "#allcheck", function() {
        var permissiondata = $('#permissiondata').val();

        if (this.checked == true) {
            if (permissiondata != '') {
                $('input:checkbox').removeAttr("disabled");
                permissiondata = JSON.parse(permissiondata);
                allPermissionSet(permissiondata, true);
            }
        } else {
            $('input:checkbox[data-modulename="Company Staff"]').prop("disabled", true);
            permissiondata = JSON.parse(permissiondata);
            allPermissionSet(permissiondata, false);
        }
    });

    function allPermissionSet(permissiondata, checkValue) {
        for (let i = 0; i < permissiondata.length; i++) {
            switch (permissiondata[i].module_name) {
                case 'Dashboard':
                    propertyCheckvalue = removedBlankValue(moduleWiseArray.dashboard);
                    allModuleCheckBoxCheck(propertyCheckvalue, permissiondata[i].id, permissiondata[i]
                        .module_name, checkValue)
                    break;
                case 'Customer Management':
                    propertyCheckvalue = removedBlankValue(moduleWiseArray.customer_management);
                    allModuleCheckBoxCheck(propertyCheckvalue, permissiondata[i].id, permissiondata[i]
                        .module_name, checkValue)
                    break;
                case 'Manage DataSheets':
                    propertyCheckvalue = removedBlankValue(moduleWiseArray.manage_datasheet);
                    allModuleCheckBoxCheck(propertyCheckvalue, permissiondata[i].id, permissiondata[i]
                        .module_name, checkValue)
                    break;
                case 'Backup Reports':
                    propertyCheckvalue = removedBlankValue(moduleWiseArray.backup_reports);
                    allModuleCheckBoxCheck(propertyCheckvalue, permissiondata[i].id, permissiondata[i]
                        .module_name, checkValue)
                    break;
                case 'CMS Management':
                    propertyCheckvalue = removedBlankValue(moduleWiseArray.cms_management);
                    allModuleCheckBoxCheck(propertyCheckvalue, permissiondata[i].id, permissiondata[i]
                        .module_name, checkValue)
                    break;
                case 'Contact Request Data Management':
                    propertyCheckvalue = removedBlankValue(moduleWiseArray.contact_request_data_management);
                    allModuleCheckBoxCheck(propertyCheckvalue, permissiondata[i].id, permissiondata[i]
                        .module_name, checkValue)
                    break;
                case 'Backend Permission':
                    propertyCheckvalue = removedBlankValue(moduleWiseArray.backend_permission);
                    allModuleCheckBoxCheck(propertyCheckvalue, permissiondata[i].id, permissiondata[i]
                        .module_name, checkValue)
                    break;
                case 'Frontend Permission':
                    propertyCheckvalue = removedBlankValue(moduleWiseArray.frontend_permission);
                    allModuleCheckBoxCheck(propertyCheckvalue, permissiondata[i].id, permissiondata[i]
                        .module_name, checkValue)
                    break;
                default:
                    propertyCheckvalue = removedBlankValue(moduleWiseArray.default);
                    allModuleCheckBoxCheck(propertyCheckvalue, permissiondata[i].id, permissiondata[i]
                        .module_name, checkValue)
                    break;
            }
        }
    }

    function removedBlankValue(value) {
        return value.filter(function(value) {
            return value;
        });
    }

    function allModuleCheckBoxCheck(propertyCheckvalue, id, moduleName, checked) {
        var checkboxesToCheck = propertyCheckvalue.map(function(property) {
            return 'input:checkbox[name="' + property + '[' + id + ']"]';
        }).join(', ');

        $("input[name='" + moduleName + "']").prop("checked", checked);
        $(checkboxesToCheck).prop('checked', checked);
    }

    function moduleTdGenrate(data, id, moduleName, moduleArray) {
        return `<td>
                    <label class="checkbox">
                        <input type="checkbox" class="all-module-check" data-id="${id}" name="${moduleName}" ${allPropertyModuleCheck(data,id, moduleArray) ? 'checked' : ''}>
                        <span class="checkmark"></span>
                    </label></td><td>
                    ${moduleName}
                </td>`;
    }

    $(document).on("change", ".all-module-check", function() {
        var actionArray = ['create', 'index', 'show', 'edit', 'delete', 'download',
            'manageemission', 'pendingdocument'
        ];

        if (this.checked) {
            let moduleNameArray = JSON.parse($('#moduleNameData').val());
            allCheckboxCheck(moduleNameArray);
        }

        for (let i = 0; i < actionArray.length; i++) {
            if (this.checked) {
                if(this.name == "Company Staff")
                {
                    $(".showcustomer").prop('checked',true);
                    $(".inputindexcheckbox[data-modulename='Customer Management']").prop('checked', true);
                }
                $("input:checkbox[name='" + actionArray[i] + "[" + $(this).data('id') + "]']").prop('checked',
                    true);
                $("input:checkbox[name='" + actionArray[i] + "[" + $(this).data('id') + "]']").removeAttr("disabled");
            } else {
                $("input:checkbox[name='" + actionArray[i] + "[" + $(this).data('id') + "]']").prop('checked',
                    false);
                $('#allcheck').prop('checked', false);
            }
        }
    });

    function allPropertyModuleCheck(data, id, moduleArray) {
        const moduleFinalArray = moduleArray.filter(function(value) {
            return value;
        });

        var moduleCheckFlag = true;
        for (var i = 0; i < moduleFinalArray.length; i++) {
            if (!checkValue(data, moduleFinalArray[i])) {
                moduleCheckFlag = false;
                break;
            }
        }

        return moduleCheckFlag;
    }

    function moduleCheckBoxCheck(input) {
        if (input.checked == false) {
            $("input[name='" + input.getAttribute('data-modulename') + "']").prop("checked", false);
            $('#allcheck').prop("checked", false);
        } else {
            const moduleFinalArray = JSON.parse(input.getAttribute('data-moduleArray')).filter(function(value) {
                return value;
            });

            var moduleCheckFlag = true;
            if ((input.getAttribute('data-modulename') == 'Dashboard' && input.getAttribute('data-name') ==
                    'download') || (input.getAttribute('data-modulename') == 'Customer Support' && input.getAttribute(
                    'data-name') == 'create') || (input.getAttribute('data-modulename') == 'Profile' && input
                    .getAttribute('data-name') == 'edit')) {
                moduleCheckFlag = true;
            } else {
                for (var i = 0; i < moduleFinalArray.length; i++) {
                    if ($('input:checkbox[name="' + moduleFinalArray[i] + '[' + input.getAttribute('data-id') + ']"]')
                        .prop('checked') === false) {
                        moduleCheckFlag = false;
                        break;
                    }
                }
            }

            if (moduleCheckFlag == true) {
                $("input[name='" + input.getAttribute('data-modulename') + "']").prop("checked", true);
            }

            const moduleNameArray = JSON.parse($('#moduleNameData').val());
            const moduleIdArray = JSON.parse($('#moduleidData').val());
            var moduleCheckOrnotFlag = true
            for (var i = 0; i < moduleNameArray.length; i++) {
                switch (moduleNameArray[i]) {
                    case 'Dashboard':
                        propertyCheckvalueArray = removedBlankValue(moduleWiseArray.dashboard);
                        moduleCheckOrnotFlag = moduleWiseAllCheckBoxCheck(propertyCheckvalueArray, moduleIdArray[i]);
                        break;
                    case 'Customer Management':

                        propertyCheckvalueArray = removedBlankValue(moduleWiseArray.customer_management);
                        moduleCheckOrnotFlag = moduleWiseAllCheckBoxCheck(propertyCheckvalueArray, moduleIdArray[i]);
                        break;
                    case 'Manage DataSheets':
                        propertyCheckvalueArray = removedBlankValue(moduleWiseArray.manage_datasheet);
                        moduleCheckOrnotFlag = moduleWiseAllCheckBoxCheck(propertyCheckvalueArray, moduleIdArray[i]);
                        break;
                    case 'Backup Reports':
                        propertyCheckvalueArray = removedBlankValue(moduleWiseArray.backup_reports);
                        moduleCheckOrnotFlag = moduleWiseAllCheckBoxCheck(propertyCheckvalueArray, moduleIdArray[i]);
                        break;
                    case 'CMS Management':
                        propertyCheckvalueArray = removedBlankValue(moduleWiseArray.cms_management);
                        moduleCheckOrnotFlag = moduleWiseAllCheckBoxCheck(propertyCheckvalueArray, moduleIdArray[i]);
                        break;
                    case 'Contact Request Data Management':
                        propertyCheckvalueArray = removedBlankValue(moduleWiseArray.contact_request_data_management);
                        moduleCheckOrnotFlag = moduleWiseAllCheckBoxCheck(propertyCheckvalueArray, moduleIdArray[i]);
                        break;
                    case 'Permission':
                        propertyCheckvalueArray = removedBlankValue(moduleWiseArray.permission);
                        moduleCheckOrnotFlag = moduleWiseAllCheckBoxCheck(propertyCheckvalueArray, moduleIdArray[i]);
                        break;
                    default:
                        propertyCheckvalueArray = removedBlankValue(moduleWiseArray.default);
                        moduleCheckOrnotFlag = moduleWiseAllCheckBoxCheck(propertyCheckvalueArray, moduleIdArray[i]);
                        break;
                }

                if (moduleCheckOrnotFlag == false)
                    break;
            }

            if (moduleCheckOrnotFlag) {
                $('#allcheck').prop("checked", true);
            }
        }
    }


    function moduleWiseAllCheckBoxCheck(moduleCheckBoxArray, moduleId) {
        let moduleCheckFlag = true;

        for (let i = 0; i < moduleCheckBoxArray.length; i++) {
            if ($('input:checkbox[name="' + moduleCheckBoxArray[i] + '[' + moduleId + ']"]').prop('checked') ===
                false) {
                moduleCheckFlag = false;
                break;
            }
        }

        return moduleCheckFlag;
    }
</script>
@endsection
