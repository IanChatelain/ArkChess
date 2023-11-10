// Prevents the form submission if the form has any errors.
function validate(e){
	hideErrors();

	if (formHasErrors()){
		e.preventDefault();

		return false;
	}

	return true;
}

// Checks whether the forms have valid inputs before submitting the page.
function formHasErrors(){
    let errorFlag = false;
    let passwordValid = true;
    let requiredFields = ["username", "password", "email"];
    let regexKeys = [/^[a-zA-Z0-9_-]{3,16}$/i,
                     /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[a-zA-Z0-9!@#$%^&*()_+]{8,}$/i,
                     /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/i];

    for(let i = 0; i < requiredFields.length; i++){
        let field = document.getElementById(requiredFields[i]);
        let regex = regexKeys[i];

        // TODO: if field is "email" and if it's display = "none" do not show error.
        if(field.value == null || field.value.trim() == ""){
            if(field.id != "email" || (field.id == "email" && field.style.display == "block"))
            {
                document.getElementById(requiredFields[i] + "Required_error").style.display = "block";
                if(!errorFlag){
                    document.getElementById(field.id).focus();
                }
                errorFlag = true;
            }
        }
        else{
            if(!regex.test(field.value)){
                if(field.id == "password"){
                    ShowPasswordRequirements();
                    errorFlag = true;
                }
                else{
                    document.getElementById(field.id + "Invalid_error").style.display = "block";
                    if(!errorFlag){
                        document.getElementById(field.id).focus();
                        document.getElementById(field.id).select();
                    }
                    errorFlag = true;
                }
            }
        }
    }

    return errorFlag;
}

// Hides all errors on the page.
function hideErrors(){
	let error = document.getElementsByClassName("error");

	for(let i = 0; i < error.length; i++) {
		error[i].style.display = "none";
	}
}

function ShowPasswordRequirements(){
    let password = document.getElementById("password");
    let marker = document.getElementById("passwordErrorMarker");
    let passRegexKeys = [/(?=.*\d)/i,
                         /(?=.*[a-z])/i,
                         /(?=.*[A-Z])/i,
                         /(?=.*[!@#$%^&*()_+])/i,
                         /\d{8,}/i];
    let passReqPhrases = ["* Password requires one digit",
                          "* Password requires one lowercase letter",
                          "* Password requires one uppercase letter",
                          "* Password requires one special character",
                          "* Password must be 8 characters minimum"];

    for(let p = 0; p < passRegexKeys.length; p++){
        let passRegex = passRegexKeys[p];
        if(!passRegex.test(password.value)){
            let passPhrase = document.createElement("p");
            passPhrase.innerHTML = passReqPhrases[p];
            passPhrase.setAttribute("class", "error");
            marker.insertAdjacentElement("beforebegin", passPhrase);
        }
    }

}

// Hides any number of elements specified in the parameters.
function hideElements(){
    for(let x = 0; x < arguments.length; x++){
        arguments[x].style.display = "none";
    }
}

// Hides any number of elements specified in the parameters.
function showElements(){
    for(let x = 0; x < arguments.length; x++){
        arguments[x].style.display = "block";
    }
}

// Clears all paramaters specified values.
function clearFields(){
    for(let y = 0; y < arguments.length; y++){
        arguments[y].value = "";
    }
}

// Checks all parameter elements to see if they are empty.
function fieldIsEmpty(){
    for(let z = 0; z < arguments.length; z++){
        if(field.value == null || field.value.trim() == ""){
            return false;
        }
    }
}

function load(){
    let emailInput = document.getElementById("email");
    let passwordInput = document.getElementById("password");
    let usernameInput = document.getElementById("username");
    let emailLabel = document.getElementById("emailLabel");
    let name = document.getElementById("username");
    let h1 = document.getElementsByTagName("h1")[0];

    name.focus();

    hideElements(emailInput, emailLabel);
    hideErrors();

    document.getElementById("signinForm").addEventListener("submit", validate);

    document.getElementsByName("signIn")[0].addEventListener("click", function() {
        clearFields(emailInput, emailLabel);
        hideElements(emailInput, emailLabel);
        hideErrors();
    });

    document.getElementsByName("register")[0].addEventListener("click", function() {
        clearFields(emailInput, emailLabel);
        showElements(emailInput, emailLabel);
        hideErrors();
    });
}

document.addEventListener("DOMContentLoaded", load);