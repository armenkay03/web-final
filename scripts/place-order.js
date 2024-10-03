let products = [];
    
// Fetch products from the server
async function fetchProducts() {
    const response = await fetch('../php/fetch_products.php');
    products = await response.json();
    const productSelect = document.getElementById('product');
    
    products.forEach(product => {
        const option = document.createElement('option');
        option.value = product.id; // Use product ID as value
        option.textContent = `${product.name} - ${product.description}`; // Display name and description
        productSelect.appendChild(option);
    });
}

// Update quantity options based on the selected product
function updateQuantityOptions() {
    const productSelect = document.getElementById('product');
    const quantitySelect = document.getElementById('quantity');
    quantitySelect.innerHTML = '<option value="">Select quantity</option>'; // Reset quantity dropdown

    const selectedProductId = productSelect.value;
    const selectedProduct = products.find(product => product.id == selectedProductId);
    
    if (selectedProduct && selectedProduct.quantity > 0) {
        const maxQuantity = selectedProduct.quantity; // Assuming quantity is the available stock
        for (let i = 1; i <= maxQuantity; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i; // Display quantity from 1 to maxQuantity
            quantitySelect.appendChild(option);
        }
    }
}

// Call fetchProducts on page load
window.onload = fetchProducts;

// Handle form submission
async function placeOrder(event) {
    event.preventDefault(); // Prevent default form submission
    const formData = new FormData(document.getElementById('order-form'));

    const response = await fetch('../php/place-order.php', {
        method: 'POST',
        body: formData
    });
    const result = await response.text();
    
    alert(result); // Show success message
    document.getElementById('order-form').reset(); // Reset the form
    updateQuantityOptions(); // Reset quantity dropdown on form reset
}