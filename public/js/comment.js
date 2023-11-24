document.addEventListener("DOMContentLoaded", function() {
    var commentButton = document.getElementsByClassName('commentButton')[0];

    commentButton.addEventListener("click", function(event) {
        event.preventDefault();
        var blogItem = document.getElementsByClassName('blog-item')[0];

        var commentForm = document.createElement("form");
        commentForm.setAttribute("method", "post");

        var commentTextArea = document.createElement("textarea");
        commentTextArea.setAttribute("name", "commentTextArea");
        commentTextArea.setAttribute("class", "commentTextArea");
        commentTextArea.setAttribute("cols", "30");
        commentTextArea.setAttribute("rows", "10");

        var submitButton = document.createElement("input");
        submitButton.setAttribute("type", "submit");
        submitButton.setAttribute("class", "commentSubmitButton");
        submitButton.setAttribute("name", "commentSubmitButton");
        submitButton.setAttribute("value", "Submit");

        var cancelButton = document.createElement("input");
        cancelButton.setAttribute("type", "submit");
        cancelButton.setAttribute("class", "commentCancelButton");
        cancelButton.setAttribute("name", "commentCancelButton");
        cancelButton.setAttribute("value", "Cancel");


        commentForm.appendChild(commentTextArea);
        commentForm.appendChild(submitButton);
        commentForm.appendChild(cancelButton);
        blogItem.appendChild(commentForm);

        cancelButton.addEventListener("click", function(event) {
            document.body.removeChild(commentForm);
        });
    })
});