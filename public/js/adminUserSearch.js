function showResult(str) {
    var userList = document.getElementById("userList");
    if (str.length == 0) {
        userList.innerHTML = "";
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var results = JSON.parse(this.responseText);
            userList.innerHTML = ""; // Clear current list
            results.forEach(function (user) {
                var li = document.createElement("li");
                li.textContent = user;
                userList.appendChild(li);
            });
        }
    }
    xmlhttp.open("GET", "services/UserSearch.php?q=" + encodeURIComponent(str), true);
    xmlhttp.send();
}
