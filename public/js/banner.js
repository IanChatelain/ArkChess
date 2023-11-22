function openDropdown(event) {
    event.preventDefault();
    var dropdownContent = document.getElementById("dropdownContent");

    if (!dropdownContent.querySelector('a')) {
        var links = ['Profile', 'Admin Settings', 'Logout'];
        links.forEach(function(link) {
            var a = document.createElement('a');
            a.textContent = link;
            // Adjust the href if needed to point to the correct URLs
            a.href = link.replace(/\s+/g, '').toLowerCase() + '.php';
            dropdownContent.appendChild(a);
        });
    }

    // Toggle the 'show-dropdown-content' class based on your CSS
    dropdownContent.classList.toggle('show-dropdown-content');

    event.stopPropagation();
}

window.onclick = function(event) {
    var dropdownContent = document.getElementById("dropdownContent");
    if (!dropdownContent.contains(event.target) && !event.target.matches('#dynamicDropdown')) {
        dropdownContent.classList.remove('show-dropdown-content');
    }
};
