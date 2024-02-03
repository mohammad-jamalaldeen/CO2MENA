$(function () {
    $(window).on("load", function () {
        $(".bac-menu").mCustomScrollbar({
            theme: "dark-3",
            scrollButtons: { enable: false }
        });
    });
});

////    Notification Js     /////
$(document).ready(function () {
    $('.notification').click(function (event) {
        event.stopPropagation();
        $(".notification-list").slideToggle("fast");
    });
    $(".notification-list").on("click", function (event) {
        event.stopPropagation();
    });
});

$(document).on("click", function () {
    $(".notification-list").hide();
});

////    Year Filter Js     /////
$(document).ready(function () {
    $('.year-filter').click(function (event) {
        event.stopPropagation();
        $(this).toggleClass("on");
        $(".year-filter-list").slideToggle("fast");
    });
    $(".year-filter-list").on("click", function (event) {
        event.stopPropagation();
    });
});

$(document).on("click", function () {
    $(".year-filter").removeClass("on");
    $(".year-filter-list").hide();
});

////    Table Filter Js     /////
$(document).ready(function () {
    $('.data-filter').click(function (event) {
        event.stopPropagation();
        $(this).toggleClass("on");
        $(".filter-list").slideToggle("fast");
    });
    $(".filter-list").on("click", function (event) {
        event.stopPropagation();
    });
});

$(document).on("click", function () {
    $(".data-filter").removeClass("on");
    $(".filter-list").hide();
});

$('select').selectpicker(
    {
        liveSearchPlaceholder: 'Search'
    }
);

$(document).on('click', '.option', function () {
    $(this).closest('li').remove();
});

//password field hide/show start
$(document).ready(function () {
    $(".toggle-password").click(function () {
        var id = $(this).data('id');
        if (id != "") {
            if (id == 1) {
                var passwordFieldCP = $("#current_password");
                if (passwordFieldCP.attr("type") === "password") {
                    passwordFieldCP.attr("type", "text");
                    $("#eye-open").removeClass('eye-close-ps');
                    $("#eye-close").addClass('eye-close-ps');
                } else {
                    passwordFieldCP.attr("type", "password");
                    $("#eye-close").removeClass('eye-close-ps');
                    $("#eye-open").addClass('eye-close-ps');
                }
            } else if (id == 2) {
                var passwordField = $("#password");

                if (passwordField.attr("type") === "password") {
                    passwordField.attr("type", "text");
                    $("#eye-open-second").removeClass('eye-close-ps');
                    $("#eye-close-second").addClass('eye-close-ps');
                } else {
                    passwordField.attr("type", "password");
                    $("#eye-close-second").removeClass('eye-close-ps');
                    $("#eye-open-second").addClass('eye-close-ps');
                }
            } else if (id == 3) {
                var passwordFieldT = $("#password_confirmation");

                if (passwordFieldT.attr("type") === "password") {
                    passwordFieldT.attr("type", "text");
                    $("#eye-open-third").removeClass('eye-close-ps');
                    $("#eye-close-third").addClass('eye-close-ps');
                } else {
                    passwordFieldT.attr("type", "password");
                    $("#eye-close-third").removeClass('eye-close-ps');
                    $("#eye-open-third").addClass('eye-close-ps');
                }
            }
        }
    });
});
//password field hide/show end
//change password start
$('#cp_popup').on('hidden.bs.modal', function (e) {
    $('.error-mgs').html('');
    resetFormAfterClose();
    resetValidationError();
})
$('#change_password_form').submit(function (e) {
    e.preventDefault();
    var formAction = $(this).attr('action');
    var button = $('#changePasswordButton');
    button.prop('disabled', true);
    button.html('Processing...');
    $('.error-mgs').html('');
    $.ajax({
        url: formAction,
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            if (response.errors) {
                button.prop('disabled', false);
                button.html('UPDATE');
                $('.error-mgs').html('');
                resetValidationError();
                if (response.errors.current_password) {
                    // $('#errorCurrentPassword').html(response.errors.current_password[0]);
                    $('.errorCurrentPasswordCls').after('<span class="error-mgs" id="errorCurrentPassword">'+response.errors.current_password[0]+'</span>');
                }
                if (response.errors.password) {
                    // $('#errorPassword').html(response.errors.password[0]);
                    $('.errorPasswordCls').after('<span class="error-mgs" id="errorPassword">'+response.errors.password[0]+'</span>');
                }
                if (response.errors.password_confirmation) {
                    // $('#errorConPassword').html(response.errors.password_confirmation[0]);
                    $('.errorConPasswordCls').after('<span class="error-mgs" id="errorConPassword">'+response.errors.password_confirmation[0]+'</span>');
                }
            }
            if (response.success) {
                button.prop('disabled', false);
                button.html('UPDATE');
                $('#errorMessages').html(response.success);
                resetValidationError();
                $('#cp_popup').modal('hide');
                $('#successfull-modal').modal('show');
            }
            if (response.old_password_as_current) {
                button.prop('disabled', false);
                button.html('UPDATE');
                $('.error-mgs').html('');
                // $('#errorPassword').html(response.old_password_as_current);
                resetValidationError();
                $('.errorPasswordCls').after('<span class="error-mgs" id="errorPassword">'+response.old_password_as_current+'</span>');
            }
            if (response.field_not_match) {
                button.prop('disabled', false);
                button.html('UPDATE');
                $('.error-mgs').html('');
                // $('#errorConPassword').html(response.field_not_match);
                resetValidationError();
                $('.errorConPasswordCls').after('<span class="error-mgs" id="errorConPassword">'+response.field_not_match+'</span>');
            }
            if (response.current_password) {
                button.prop('disabled', false);
                button.html('UPDATE');
                $('.error-mgs').html('');
                // $('#errorCurrentPassword').html(response.current_password);
                resetValidationError();
                $('.errorCurrentPasswordCls').after('<span class="error-mgs" id="errorCurrentPassword">'+response.current_password+'</span>');
            }
        },
    });
});
function resetValidationError(){
    $('#errorCurrentPassword').remove();
    $('#errorPassword').remove();
    $('#errorConPassword').remove();
}
function resetFormAfterClose() {    
    $('.field-clear-cp').val("");
    $('.field-clear-cp').attr("type", "password");
    $(".eye-cp-reset").removeClass('eye-close-ps');
    $(".eye-opn-cp-reset").addClass('eye-close-ps');
}
//change password end




$(function () {
    $(window).on("load", function () {
        $(".checkbox-main").mCustomScrollbar({
            theme: "dark-3",
            scrollButtons: { enable: false }
        });
    });
});

$(function () {
    $(window).on("load", function () {
        $(".privacy-modal .modal-body").mCustomScrollbar({
            theme: "dark-3",
            scrollButtons: { enable: false }
        });
    });
});


$(window).on("load", function () {
    // $(".left-sidebar .dropdown-menu").hide();
    $(".left-sidebar .dropdown-menu").prev().addClass("click");
    $('.click').click(function (e) {
        var $this = $(this);
        $(this).toggleClass('open');
        $(this).parent().toggleClass('menu-drop-open');
        $(this).next('.dropdown-menu').slideToggle('slow');
    });
});
$(window).on("load resize", function () {
    if($(window).width() < 992)	{
        $('body').addClass("sidebar-collepsed");
        $('.sidebar-toggle-inner').click(function (e) {
            $('body').toggleClass("open-sidebar");
        });
    } else {
        $('body').removeClass("sidebar-collepsed");
    }
});

(function ($) {

    $(".nav.nav-pills").on('scroll', function () {
        $val = $(this).scrollLeft();

        if ($(this).scrollLeft() + $(this).innerWidth() >= $(this)[0].scrollWidth) {
            $(".nav-next").addClass("disabled");
        } else {
            $(".nav-next").removeClass("disabled");
        }

        if ($val == 0) {
            $(".nav-prev").addClass("disabled");
        } else {
            $(".nav-prev").removeClass("disabled");
        }
    });
    $(".nav-next").on("click", function () {
        $(".nav.nav-pills").animate({ scrollLeft: '+=200' }, 200);

    });
    $(".nav-prev").on("click", function () {
        $(".nav.nav-pills").animate({ scrollLeft: '-=200' }, 200);
    });



})(jQuery);






