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
    debugger;
    let errorFlag = false;
    let blogTitle = document.getElementById("postTitle");
    let titleError = document.getElementById("titleError");

    let blogContent = tinymce.activeEditor.getContent();
    let contentError = document.getElementById("contentError");

    if(blogTitle.value == null || blogTitle.value.trim() === ""){
        titleError.style.display = "block";
        errorFlag = true;
    }

    if(blogContent == null || blogContent.trim() === ""){
        contentError.style.display = "block";
        errorFlag = true;
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


function load(){
    let blogTitle = document.getElementById("postTitle");

    blogTitle.focus();

    hideErrors();

    let fileError = document.getElementById("fileError");
    let uploadError = document.getElementById("uploadError");

    if(fileError){
        fileError.style.display = "block";
        errorFlag = true;
    }
    
    if(uploadError){
        uploadError.style.display = "block";
        errorFlag = true;
    }

    document.getElementById("newBlog").addEventListener("submit", validate);
}

document.addEventListener("DOMContentLoaded", load);