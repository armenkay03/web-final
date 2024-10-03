$(document).ready(function() {
    // Perform session check using AJAX to verify admin status
    $.ajax({
        url: '../php/check_admin_session.php', // The PHP script to check if admin is logged in
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (!response.admin_logged_in) {
                // If not logged in as admin, redirect to login page
                window.location.href = '../php/index.php';
            }console.log("admin success")
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('An error occurred while checking admin session: ' + errorThrown);
            console.log(jqXHR.responseText); // For debugging
        }
    });
});