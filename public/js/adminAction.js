document.addEventListener("DOMContentLoaded", function(){
    var addUserModal = document.getElementsByClassName("addUserModal")[0];
    var addUserBtn = document.getElementsByClassName("addUserBtn")[0];
    var addUserSpan = document.getElementsByClassName("addClose")[0];

    addUserBtn.onclick = function(){
        addUserModal.style.display = "block";
    }

    addUserSpan.onclick = function(){
        addUserModal.style.display = "none";
    }

    var editUserModal = document.getElementsByClassName("editUserModal")[0];
    var editUserBtns = document.getElementsByClassName("editUser");
    var editUserSpan = document.getElementsByClassName("editClose")[0];

    editUserSpan.onclick = function(){
        editUserModal.style.display = "none";
    }

    Array.from(editUserBtns).forEach(function(btn){
        btn.addEventListener('click', function(){

            var userId = this.getAttribute('data-user-id');
            var userName = this.getAttribute('data-user-name');
            var userEmail = this.getAttribute('data-user-email');
            var userRating = this.getAttribute('data-user-rating');
            var userRole = this.getAttribute('data-user-role');
    
            document.getElementById('editUserId').value = userId;
            document.getElementById('editUserName').value = userName;
            document.getElementById('editEmail').value = userEmail;
            document.getElementById('editRating').value = userRating;
            document.getElementById('editRole').value = userRole;

            editUserModal.style.display = "block";
        });
    });

    var deleteUserBtns = document.getElementsByClassName("deleteUser");
    Array.from(deleteUserBtns).forEach(function(btn) {
        btn.addEventListener("click", function(event) {
            var userId = this.getAttribute("data-user-id");
            if (confirm('Are you sure you want to delete user ' + userId + '?')){
                document.querySelector("[name='userId']").value = userId;
                document.querySelector("[name='userActionForm']").submit();
            } 
            else{
                event.preventDefault();
            }
        });
    });

    window.onclick = function(event){
        if(event.target == addUserModal) {
            addUserModal.style.display = "none";
        }
        else if(event.target == editUserModal){
            editUserModal.style.display = "none";
        }
    }
});