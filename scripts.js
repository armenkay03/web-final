function downloadZip() {
    const link = document.createElement('a');
    link.href = 'https://github.com/armenkay03/web-final/archive/refs/heads/main.zip';
    link.download = 'web.zip';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
document.addEventListener('DOMContentLoaded', function() {


    const form = document.querySelector('#add-product-form');
    if (form) {
        form.addEventListener('submit', function(event) {
            const name = document.querySelector('#product-name').value;
            const description = document.querySelector('#product-description').value;
            if (name === '' || description === '') {
                alert('All fields are required!');
                event.preventDefault();
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('generate-report-form');
    const downloadSection = document.getElementById('download-section');
    const downloadButton = document.getElementById('downloadReport');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        const notes = document.getElementById('additional-notes').value;

        if (!startDate || !endDate) {
            alert("Please enter both start and end dates.");
            return;
        }
        console.log(`Generating report from ${startDate} to ${endDate} with notes: ${notes}`);
        downloadSection.style.display = 'block';
    });

    downloadButton.addEventListener('click', function() {
        console.log("Generating and downloading report as ZIP...");
        alert("ZIP file generated and ready for download!");
    });
});

document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    fetch('connect.php', {
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


