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
tableBody.innerHTML = ''; // Clear existing content

if (submissions.length > 0) {
submissions.forEach(submission => {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${submission.id}</td>
        <td>${submission.name}</td>
        <td>${submission.email}</td>
        <td>${submission.message}</td>
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


// Fetch submissions on page load
window.onload = fetchContactSubmissions;