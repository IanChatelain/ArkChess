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

function footerLogoSeparator(){
    let footerul = document.getElementById("footerul");
    let footerLength = footerul.children.length + 1;

    for(let n = 0; n < footerLength * 2; n++){
        if(n % 2 == 0){
            let li = document.createElement("li");
            footerul.insertBefore(li, footerul.children[n]);
        }
    }

    let lis = footerul.querySelectorAll("li");

    for(let n = 0; n < lis.length; n += 2){
        var img = document.createElement("img");

        img.setAttribute("src", "images/ArkChessLogoTransparentC9.png");
        img.setAttribute("alt", "ArkChess Logo");

        lis[n].appendChild(img);
    }
}

function load(){
    let name = document.getElementById("name");
    name.focus();

    hideErrors();
    footerLogoSeparator();

    document.getElementById("contactForm").addEventListener("submit", validate);
    document.getElementById("contactForm").addEventListener("reset", resetForm);
}

document.addEventListener("DOMContentLoaded", load);