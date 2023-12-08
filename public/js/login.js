document.addEventListener("DOMContentLoaded", function(){
    let usernameInput = document.getElementById("username");
    let loginError = document.getElementById("loginError");

    usernameInput.focus();

    let errorElements = document.getElementsByClassName("error");
    for(let element of errorElements){
        if(element.id !== "loginError"){
            element.style.display = "none";
        }
    }

    if(loginError && loginError.textContent.trim()){
        loginError.style.display = 'block';
    }

    document.getElementById("signInForm").addEventListener("submit", validate);
});

function validate(e){
    if(formHasErrors()){
        e.preventDefault();
        return false;
    }
    return true;
}

function formHasErrors(){
    let errorFlag = false;
    let fields = ["username", "password"];

    fields.forEach(function(fieldId){
        let field = document.getElementById(fieldId);
        let errorElementId = fieldId + "Error";

        if (!field.value.trim()){
            showErrorMessage(errorElementId, "This field is required");
            errorFlag = true;
        } 
        else{
            hideErrorMessage(errorElementId);
        }
    });

    return errorFlag;
}

function showErrorMessage(elementId, message){
    let errorElement = document.getElementById(elementId);
    if(errorElement){
        errorElement.innerHTML = message;
        errorElement.style.display = 'block';
    }
}

function hideErrorMessage(elementId){
    let errorElement = document.getElementById(elementId);
    if(errorElement){
        errorElement.style.display = 'none';
    }
}

function hideErrors(){
    let errorElements = document.getElementsByClassName("error");
    for(let element of errorElements){
        element.style.display = "none";
    }
}
