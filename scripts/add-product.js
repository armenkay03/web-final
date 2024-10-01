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

var modal = document.getElementById("response-modal");
        var span = document.getElementsByClassName("close-button")[0];

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function showModal(message) {
            document.getElementById("modal-message").innerText = message;
            modal.style.display = "block";
        }

        document.getElementById("add-product-form").onsubmit = function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('../php/product-management.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                showModal(data);
            })
            .catch(error => {
                showModal("Error: " + error.message);
            });
        };

        document.getElementById("update-product-form").onsubmit = function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            // Remove empty fields from the formData (only send filled inputs)
            for (var pair of formData.entries()) {
                if (!pair[1]) { // if the value is empty, delete it
                    formData.delete(pair[0]);
                }
            }

            fetch('../php/product-management.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                showModal(data);
            })
            .catch(error => {
                showModal("Error: " + error.message);
            });
        };

        document.getElementById("delete-product-form").onsubmit = function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('../php/product-management.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                showModal(data);
            })
            .catch(error => {
                showModal("Error: " + error.message);
            });
        };