$(document).ready(function() {
    $.ajax({
        url: '../php/check_session.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (!response.logged_in) {
                window.location.href = '../php/index.php';
            }
            console.log("Session checked.");
        },
        error: function() {
            alert('An error occurred while checking session.');
        }
    });
});