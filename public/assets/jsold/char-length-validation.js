
function charLengthValidation(input, limit) {
    var maxLength = limit;
    var inputValue = $(input).val();

    // Check if first character is a space
    if (inputValue.charAt(0) === ' ') {
        // If the first character is a space, remove it
        $(input).val(inputValue.slice(1));
        inputValue = $(input).val(); // Update the inputValue
    }

    // Check if length exceeds the maximum length
    if (inputValue.length > maxLength) {
        $(input).val(inputValue.slice(0, maxLength));
        return false; // Validation failed
    }

    return true; // Validation passed
}