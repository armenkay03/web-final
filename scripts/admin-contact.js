 // Function to fetch contact submissions
 async function fetchContactSubmissions() {
    try {
        const response = await fetch('../php/fetch_contact_submissions.php');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const submissions = await response.json();
        populateTable(submissions);
    } catch (error) {
        console.error('Error fetching contact submissions:', error);
    }
}

function populateTable(submissions) {
    const tableBody = document.querySelector('#submissionsTable tbody');
    tableBody.innerHTML = ''; 

    if (submissions.length > 0) {
        submissions.forEach(submission => {
            const cleanMessage = submission.message.replace(/\\r\\n|\\n|\\r/g, ' ');

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${submission.id}</td>
                <td>${submission.name}</td>
                <td>${submission.email}</td>
                <td>${cleanMessage}</td>
                <td>${submission.created_at}</td>
            `;
            tableBody.appendChild(row);
        });
    } else {
        const row = document.createElement('tr');
        row.innerHTML = `<td colspan="5">No submissions found.</td>`;
        tableBody.appendChild(row);
    }
}



window.onload = fetchContactSubmissions;