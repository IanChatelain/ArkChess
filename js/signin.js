// Prevents the form submission if the form has any errors.
function validate(e){
	hideErrors();

	if (formHasErrors()){
		e.preventDefault();

		return false;
	}

    thankYou();

	return true;
}

// Initiates a message box verifying whether to reset the form.
function resetForm(e){
	if (confirm('Clear form?')){
		hideErrors();

		return true;
	}

	e.preventDefault();

	return false;
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

// Changes the contact form to show confirmation of submission.
function thankYou(){
    let form = document.getElementById("contactForm");
    form.remove();
    let contactDescription = document.getElementById("contactDescription");

    contactDescription.id = "thankYou";
    contactDescription.getElementsByTagName("h1")[0].textContent = "Thank you!";
    contactDescription.getElementsByTagName("p")[0].textContent = "Thank you for contacting us! We have received your message and will respond to you as soon as possible.";
}

// Adds a logo image beside every nav element.
function footerLogoSeparator(){
    let footerul = document.getElementById("footerul");

    for(let n = 0; n < footerul.children.length + 1; n++){

        if(n % 2 == 0){
            let img = document.createElement("img");
            footerul.appendChild(img);

            img.setAttribute("src", "/images/ArkChessLogoTransparentC9.png");

            footerul.insertBefore(img, footerul.children[n]);
        }
    }
}

// Hides any number of elements specified in the parameters.
function hideElements(){
    for(let x = 0; x < arguments.length; x++){
        arguments[x].style.display = "none";
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
    let usernameInput = document.getElementById("username")
    let emailLabel = document.getElementById("emailLabel");
    let name = document.getElementById("username");
    let legend = document.getElementsByTagName("legend")[0];

    name.focus();

    hideElements(emailInput, emailLabel);
    hideErrors();
    footerLogoSeparator();

    document.getElementById("slider").addEventListener("change", function(){
        hideErrors();
        clearFields(emailInput, passwordInput, usernameInput);

        let toggleSwitch = document.getElementById("slider");
        let button = document.getElementById("submit");
        if(toggleSwitch.checked){
            legend.innerHTML = "Register";
            button.innerHTML = "Register";
            button.style.color = "#0071C5";
            emailInput.style.display = "block";
            emailLabel.style.display = "block";
        }
        else{
            legend.innerHTML = "Sign In";
            button.innerHTML = "Sign In";
            button.style.color = "#a9a9a9";
            hideElements(emailInput, emailLabel);
        }
    });

    document.getElementById("signinForm").addEventListener("submit", validate);
    document.getElementById("signinForm").addEventListener("reset", resetForm);
}

document.addEventListener("DOMContentLoaded", load);