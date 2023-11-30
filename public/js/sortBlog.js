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

    window.onclick = function(event){
        if(event.target == addUserModal) {
            addUserModal.style.display = "none";
        }
    }
});