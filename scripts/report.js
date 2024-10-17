document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('generate-report-form');
    const downloadSection = document.getElementById('download-section');
    const downloadButton = document.getElementById('downloadReport');


    downloadSection.style.display = 'none';

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        generateReport(event);
    });


    downloadButton.addEventListener('click', function () {
        alert("Excel file is being downloaded...");
    });
});

let products = [];


async function fetchProducts() {
    try {
        const response = await fetch('../php/fetch_products.php');
        products = await response.json();
    } catch (error) {
        console.error('Error fetching products:', error);
    }
}


window.onload = fetchProducts;

function generateReport(event) {
    event.preventDefault();

    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;


    if (!startDate || !endDate) {
        alert('Please select both start and end dates.');
        return;
    }


    const filteredProducts = products.filter(product => {
        const productDate = new Date(product.date);
        const start = new Date(startDate);
        const end = new Date(endDate);

        return productDate >= start && productDate <= end;
    });


    if (filteredProducts.length > 0) {
        document.getElementById('download-section').style.display = 'block';
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
