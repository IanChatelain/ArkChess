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
    let blogTitle = document.getElementById("postTitle");
    let titleError = document.getElementById("titleError");

    let blogContent = tinymce.activeEditor.getContent();
    let contentError = document.getElementById("contentError");

    let fileError = document.getElementById("fileError");
    let uploadError = document.getElementById("uploadError");

    debugger;
    if(blogTitle.value == null || blogTitle.value.trim() === ""){
        titleError.style.display = "block";
        errorFlag = true;
    }

    if(blogContent == null || blogContent.trim() === ""){
        contentError.style.display = "block";
        errorFlag = true;
    }

    if(fileError){
        fileError.style.display = "block";
        errorFlag = true;
    }
    else{
        let fileError = document.getElementById("fileError");

    
        if(fileError){
            fileError.remove();
        }
    }
    
    if(uploadError){
        uploadError.style.display = "block";
        errorFlag = true;
    }
    else{
        let uploadError = document.getElementById("uploadError");
                
        if(uploadError){
            uploadError.remove();
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
    let blogTitle = document.getElementById("postTitle");

    blogTitle.focus();

    hideErrors();
    document.getElementById("newBlog").addEventListener("submit", validate);
}

document.addEventListener("DOMContentLoaded", load);