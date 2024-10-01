document.addEventListener("DOMContentLoaded", function() {
    const navLinks = document.querySelectorAll('nav ul li a');
    const currentPath = window.location.pathname.split("/").pop(); // Get the current page file name
    
    navLinks.forEach(link => {
        const linkPath = link.getAttribute('href').split("/").pop(); // Get only the file name of the link
        
        // Compare current page filename with the link filename
        if (currentPath === linkPath) {
            link.classList.add('active');
        }
    });
});