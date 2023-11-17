// JavaScript for login form validation and error message handling

document.addEventListener("DOMContentLoaded", function() {
    let usernameInput = document.getElementById("username");
    let loginError = document.getElementById("loginError");

    // Set focus on the username input when the page loads
    usernameInput.focus();

    // Hide all error messages except for the login error
    let errorElements = document.getElementsByClassName("error");
    for (let element of errorElements) {
        if (element.id !== "loginError") {
            element.style.display = "none";
        }
    }

    // If there's a login error message, make sure it's displayed
    if (loginError && loginError.textContent.trim()) {
        loginError.style.display = 'block';
    }

    // Attach the event listener for form submission
    document.getElementById("signInForm").addEventListener("submit", validate);
});

function validate(e) {
    // Perform form validation
    if (formHasErrors()) {
        // Prevent form submission if there are errors
        e.preventDefault();
        return false;
    }
    // If no errors, allow the form to submit
    return true;
}

function formHasErrors() {
    let errorFlag = false;
    let fields = ["username", "password"];

    // Check if any field is empty
    fields.forEach(function(fieldId) {
        let field = document.getElementById(fieldId);
        let errorElementId = fieldId + "Error";

        if (!field.value.trim()) {
            showErrorMessage(errorElementId, "This field is required");
            errorFlag = true;
        } else {
            hideErrorMessage(errorElementId);
        }
    });

    return errorFlag;
}

// Shows the specific error message
function showErrorMessage(elementId, message) {
    let errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.innerHTML = message;
        errorElement.style.display = 'block';
    }
}

// Hides the specific error message
function hideErrorMessage(elementId) {
    let errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.style.display = 'none';
    }
}

function hideErrors() {
    let errorElements = document.getElementsByClassName("error");
    for (let element of errorElements) {
        element.style.display = "none";
    }
}
