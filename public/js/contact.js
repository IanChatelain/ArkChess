// TODO: log and export submissions to database?

function validate(e){
	hideErrors();

	if (formHasErrors()){
		e.preventDefault();

		return false;
	}

    thankYou();

	return true;
}

function resetForm(e){
	if (confirm('Clear form?')){
		hideErrors();

		return true;
	}

	e.preventDefault();

	return false;
}

function formHasErrors(){
    let errorFlag = false;
    let requiredFields = ["name", "phoneNumber", "email", "comment"];
    let regexKeys = [/^[a-zA-Z\s\,\''\-]*$/i,
                     /^\d{10}$/i,
					 /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/i,
                     /^[\x20-\x7E\n\r]*$/];

    for(let i = 0; i < requiredFields.length; i++){
        let field = document.getElementById(requiredFields[i]);
        let regex = regexKeys[i];

        if(field.value == null || field.value.trim() == ""){
            document.getElementById(requiredFields[i] + "Required_error").style.display = "block";
            if(!errorFlag){
                document.getElementById(field.id).focus();
            }
            errorFlag = true;
        }
        else{
            if(!regex.test(field.value)){
                document.getElementById(field.id + "Invalid_error").style.display = "block";
                if(!errorFlag){
                    document.getElementById(field.id).focus();
                    document.getElementById(field.id).select();
                }
                errorFlag = true;
            }
        }
    }

    return errorFlag;
}

function hideErrors(){
	let error = document.getElementsByClassName("error");

	for(let i = 0; i < error.length; i++) {
		error[i].style.display = "none";
	}
}

function thankYou(){
    let form = document.getElementById("contactForm");
    form.remove();
    let contactDescription = document.getElementById("contactDescription");

    contactDescription.id = "thankYou";
    contactDescription.getElementsByTagName("h1")[0].textContent = "Thank you!";
    contactDescription.getElementsByTagName("p")[0].textContent = "Thank you for contacting us! We have received your message and will respond to you as soon as possible.";
}

function load(){
    let name = document.getElementById("name");
    name.focus();

    hideErrors();

    document.getElementById("contactForm").addEventListener("submit", validate);
    document.getElementById("contactForm").addEventListener("reset", resetForm);
}

document.addEventListener("DOMContentLoaded", load);