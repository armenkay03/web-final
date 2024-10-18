let products = [];

// Fetch products from the server
async function fetchProducts() {
    const response = await fetch('../php/fetch_products.php');
    products = await response.json();
    const productSelect = $('#product');

    products.forEach(product => {
        const option = new Option(`${product.name} - ${product.description}`, product.id);
        productSelect.append(option);
    });

    // Initialize select2 for product dropdown
    $('#product').select2({
        placeholder: 'Select a product',
        allowClear: true,
        width: 'resolve' 
    });
}

// Update quantity options based on the selected product
function updateQuantityOptions() {
    const selectedProductId = $('#product').val();
    const selectedProduct = products.find(product => product.id == selectedProductId);
    const quantitySelect = $('#quantity');
    quantitySelect.empty().append(new Option('Select quantity', '')); 

    if (selectedProduct && selectedProduct.quantity > 0) {
        const maxQuantity = selectedProduct.quantity;
        for (let i = 1; i <= maxQuantity; i++) {
            const option = new Option(i, i);
            quantitySelect.append(option);
        }
    }
}

// Call fetchProducts on page load
$(document).ready(() => {
    fetchProducts();
});

// Handle form submission
async function placeOrder(event) {
    event.preventDefault(); // Prevent default form submission
    const formData = new FormData(document.getElementById('order-form'));

    const response = await fetch('../php/place-order.php', {
        method: 'POST',
        body: formData
    });
    const result = await response.text();

    alert(result); 
    $('#order-form')[0].reset(); 
    updateQuantityOptions(); 
}