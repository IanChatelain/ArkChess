function openDropdown(event) {
    event.preventDefault();
    var dropdownContent = document.getElementById("dropdownContent");

    if (!dropdownContent.querySelector('a')) {
        var links = ['Profile', 'Admin Settings', 'Logout'];
        links.forEach(function(link) {
            var a = document.createElement('a');
            a.textContent = link;
            a.href = link.replace(/\s+/g, '').toLowerCase() + '.php';
            dropdownContent.appendChild(a);
        });
    }

    dropdownContent.classList.toggle('show');
    event.stopPropagation();
}

window.onclick = function(event) {
    // Get the dropdown content element
    var dropdownContent = document.getElementById("dropdownContent");
    
    // Check if the clicked area is not the dropdown itself and not the dropdown button
    if (!dropdownContent.contains(event.target) && !event.target.matches('.dropbtn')) {
        // If the 'show' class is present, remove it to hide the dropdown
        if (dropdownContent.classList.contains('show')) {
            dropdownContent.classList.remove('show');
        }
    }
};

window.onclick = function(event) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown && openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
        }
    }
};