document.addEventListener("DOMContentLoaded", function() {
    var addUserModal = document.getElementsByClassName("addUserModal")[0];
    var addUserBtn = document.getElementsByClassName("addUserBtn")[0];
    var addUserSpan = document.getElementsByClassName("addClose")[0];

    addUserBtn.onclick = function() {
        addUserModal.style.display = "block";
    }

    addUserSpan.onclick = function() {
        addUserModal.style.display = "none";
    }

    var editUserModal = document.getElementsByClassName("editUserModal")[0];
    var editUserBtns = document.getElementsByClassName("editUser");
    var editUserSpan = document.getElementsByClassName("editClose")[0];

    for (var i = 0; i < editUserBtns.length; i++) {
        editUserBtns[i].onclick = function() {
            editUserModal.style.display = "block";
        }
    }

    editUserSpan.onclick = function() {
        editUserModal.style.display = "none";
    }

    var deleteUserBtns = document.getElementsByClassName("deleteUser");
    Array.from(deleteUserBtns).forEach(function(btn) {
        btn.addEventListener("click", function(event) {
            var userId = this.getAttribute("data-user-id");
            if (confirm("Are you sure you want to delete user " + userId + "?")) {
            }
        });
    });

    window.onclick = function(event) {
        if (event.target == addUserModal) {
            addUserModal.style.display = "none";
        } else if (event.target == editUserModal) {
            editUserModal.style.display = "none";
        }
    }
});
