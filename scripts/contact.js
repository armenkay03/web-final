document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    fetch('../php/connect.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        if (result.trim() === 'success') {
            document.getElementById('success-modal').classList.add('show');
            document.getElementById('contact-form').reset();
        } else {
            alert('There was an error submitting the form: ' + result);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
