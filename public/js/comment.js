document.addEventListener("DOMContentLoaded", function(){
    commentButton = document.getElementsByClassName('commentButton')[0];

    commentButton.addEventListener("click", function(event){
        event.preventDefault();

        commentButton = document.getElementsByClassName("commentButton")[0];
        commentButton.style.display = "none";

        blogItem = document.getElementsByClassName('blogPageContainer')[0];
        commentForm = document.createElement("form");
        commentForm.setAttribute("method", "post");
        commentForm.setAttribute("id", "commentForm");

        commentTextArea = document.createElement("textarea");
        commentTextArea.setAttribute("name", "commentTextArea");
        commentTextArea.setAttribute("class", "commentTextArea");
        commentTextArea.setAttribute("cols", "30");
        commentTextArea.setAttribute("rows", "10");

        submitButton = document.createElement("input");
        submitButton.setAttribute("type", "submit");
        submitButton.setAttribute("class", "commentSubmitButton");
        submitButton.setAttribute("name", "commentSubmitButton");
        submitButton.setAttribute("value", "Submit");

        cancelButton = document.createElement("input");
        cancelButton.setAttribute("type", "submit");
        cancelButton.setAttribute("class", "commentCancelButton");
        cancelButton.setAttribute("name", "commentCancelButton");
        cancelButton.setAttribute("value", "Cancel");

        captchaAnswer = document.createElement("input");
        captchaAnswer.setAttribute("type", "text");
        captchaAnswer.setAttribute("class", "captchaAnswer");
        captchaAnswer.setAttribute("name", "captchaAnswer");
        captchaAnswer.setAttribute("placeholder", "Captcha Answer");

        captchaImage = document.createElement('img');
        captchaImage.id = 'captchaImage';
        captchaImage.src = 'services/Captcha.php';

        commentForm.appendChild(commentTextArea);
        commentForm.appendChild(submitButton);
        commentForm.appendChild(cancelButton);
        commentForm.appendChild(captchaImage);
        commentForm.appendChild(captchaAnswer);
        
        blogItem.appendChild(commentForm);

        cancelButton.addEventListener("click", function(e){
            e.preventDefault();
            blogItem.removeChild(commentForm);
            commentButton.style.display = "block";
        });
    })
});