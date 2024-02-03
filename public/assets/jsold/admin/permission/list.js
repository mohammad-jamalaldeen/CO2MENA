$('#role').change(function () {
    const $tbody = $('tbody').empty();
    const userRole = ($(this).val() === 'company_admin') ? '3' : '2';
    const role = ($(this).val() === 'company_admin') ? 'frontend' : 'admin';

    $('#userrole').val(userRole);
    $('#role_type').val(role);

    $.ajax({
        type: 'POST',
        url: route,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { role },
        success: function (response) {
            if (response.data.length > 0) {
                const html = response.data.map((item, index) => (
                    `<tr>
                        <td>${item.module_name}</td>
                        <td><input type="checkbox" name="create[${index}]"  ></td>
                        <td><input type="checkbox" name="index[${index}]" ></td>
                        <td><input type="checkbox" name="view[${index}]" ></td>
                        <td><input type="checkbox" name="edit[${index}]" ></td>
                    </tr>`
                )).join('');
                $tbody.html(html);
            }
        },
        error: function (jqXHR, exception) {
            $('.custom-pre-loader-container .loader').addClass('d-none');
            console.error('Something went wrong during the AJAX request');
        }
    });
});

function checkValue(item, action) {
    return item.permissions.some(permission => permission.action === action);
}


// const doubledNumbers = item.permissions.map(function(item){
//     return item.action == action
// })

// console.log(doubledNumbers);
// debugger;
