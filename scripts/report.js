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


let products = [];

// Fetch products from the server
async function fetchProducts() {
    const response = await fetch('../php/fetch_products.php');
    products = await response.json();
}

// Call fetchProducts on page load
window.onload = fetchProducts;

function generateReport(event) {
    event.preventDefault();
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;

    // Filter products based on the date range
    const filteredProducts = products.filter(product => {
        return product.date >= startDate && product.date <= endDate;
    });

    if (filteredProducts.length > 0) {
        document.getElementById('download-section').style.display = 'block';
        // Prepare data for Excel
        prepareExcelReport(filteredProducts);
    } else {
        alert('No products found in the selected date range.');
        document.getElementById('download-section').style.display = 'none';
    }
}

function prepareExcelReport(data) {
    const ws = XLSX.utils.json_to_sheet(data);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Products');
    XLSX.writeFile(wb, 'inventory_report.xlsx');
}
