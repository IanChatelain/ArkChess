function validate(e){
    hideErrors();
    let errors = formHasErrors();

    if (errors){
        e.preventDefault();
    } else {
        e.preventDefault();
        displayThankYou();
    }
}

function resetForm(e){
    if (!confirm('Are you sure you want to clear the form?')){
        e.preventDefault();
    } 
    else{
        hideErrors();
    }
}

function formHasErrors(){
    let errorFlag = false;
    let fields = {
        "email": /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i,
        "comment": /.+/
    };

    for (let id in fields){
        let field = document.getElementById(id);
        if (field.value.trim() === ""){
            document.getElementById(id + "Required_error").style.display = "block";
            field.focus();
            errorFlag = true;
        }
    }

    if (!errorFlag){
        for (let id in fields){
            let field = document.getElementById(id);
            if (!fields[id].test(field.value)){
                document.getElementById(id + "Invalid_error").style.display = "block";
                field.focus();
                errorFlag = true;
                break;
            }
        }
    }

    return errorFlag;
}


function hideErrors(){
    var errors = document.getElementsByClassName("error");
    for (var i = 0; i < errors.length; i++){
        errors[i].style.display = "none";
    }
}

function displayThankYou(){
    let formContainer = document.getElementsByClassName("form-container")[0];
    if (formContainer){
        formContainer.innerHTML = '<h2 id="thankYouTitle">Thank You!</h2><p>Thank you for contacting us! We have received your message and will respond to you as soon as possible.</p>';
    }
}

function load(){
    let email = document.getElementById("email");
    email.focus();

    hideErrors();

    document.getElementById("contactForm").addEventListener("submit", validate);
    document.getElementById("contactForm").addEventListener("reset", resetForm);
}

document.addEventListener("DOMContentLoaded", load);