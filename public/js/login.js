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
    let requiredFields = ["username", "password"];
    let regexKeys = [/^[a-zA-Z0-9_-]{3,16}$/i,
                     /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[a-zA-Z0-9!@#$%^&*()_+]{8,}$/i];

    for(let i = 0; i < requiredFields.length; i++){
        let field = document.getElementById(requiredFields[i]);
        let regex = regexKeys[i];

        if(field.value == null || field.value.trim() == ""){
            document.getElementById(requiredFields[i] + "Error").style.display = "block";
            if(!errorFlag){
                document.getElementById(field.id).focus();
            }
            errorFlag = true;
        }
        else{
            if(!regex.test(field.value)){
                if(field.id == "password"){
                    ShowPasswordRequirements();
                    errorFlag = true;
                }
                else if(field.id == "username"){
                    showUsernameRequirements();
                    errorFlag = true;
                }
                else{
                    document.getElementById(field.id + "error").style.display = "block";
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

function ShowPasswordRequirements(){
    let password = document.getElementById("password");
    let marker = document.getElementById("passwordError");
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

function showUsernameRequirements() {
    let username = document.getElementById("username");
    let marker = document.getElementById("usernameError");
    let usernameRegexKeys = [/^[a-zA-Z0-9]+$/,
                             /^.{3,16}$/];
    let usernameReqPhrases = ["* Username can only contain letters, numbers",
                              "* Username must be 3 to 16 characters long"];

    for (let u = 0; u < usernameRegexKeys.length; u++) {
        let usernameRegex = usernameRegexKeys[u];
        if (!usernameRegex.test(username.value)) {
            let usernamePhrase = document.createElement("p");
            usernamePhrase.innerHTML = usernameReqPhrases[u];
            usernamePhrase.setAttribute("class", "error");
            marker.insertAdjacentElement("beforebegin", usernamePhrase);
        }
    }
}


// Hides all errors on the page.
function hideErrors(){
	let error = document.getElementsByClassName("error");

	for(let i = 0; i < error.length; i++) {
		error[i].style.display = "none";
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
    let name = document.getElementById("username");

    name.focus();

    hideErrors();
    document.getElementById("signInForm").addEventListener("submit", validate);
}

document.addEventListener("DOMContentLoaded", load);