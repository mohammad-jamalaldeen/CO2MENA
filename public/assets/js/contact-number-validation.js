
$(document).ready(function () {
    function handleKeypress(event) {
        var inputValue = event.key;
        if (!/^[0-9]$/.test(inputValue) || $(this).val().length >= 10) {
            event.preventDefault();
        }
    }

    $('#contact_number, #company_phone, #company_phone_number, #phone_number, #editContactNumber').on('keypress', handleKeypress);
});