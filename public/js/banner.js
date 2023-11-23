function openDropdown(event) {
    event.preventDefault();
    var dropdownContent = document.getElementById("dropdownContent");
    var dropdownLink = document.getElementById("dynamicDropdown");

    if (!dropdownContent.querySelector('a')) {
        var links = ['Profile', 'Logout'];
        links.forEach(function(link) {
            var a = document.createElement('a');
            a.textContent = link;
            a.href = link.replace(/\s+/g, '').toLowerCase() + '.php';
            dropdownContent.appendChild(a);
        });
    }

    dropdownContent.classList.toggle('show-dropdown-content');

    if (dropdownContent.classList.contains('show-dropdown-content')){
        dropdownLink.style.backgroundColor = "#333";
        dropdownLink.style.border = "1px solid #444";
        dropdownLink.style.padding = "2px";
    }

    event.stopPropagation();
}

window.onclick = function(event) {
    var dropdownContent = document.getElementById("dropdownContent");
    var dropdownLink = document.getElementById("dynamicDropdown");

    if (!dropdownContent.contains(event.target) && !event.target.matches('#dynamicDropdown')) {
        dropdownContent.classList.remove('show-dropdown-content');
        dropdownLink.style.backgroundColor = "transparent";
        dropdownLink.style.border = "none";
    }
};
