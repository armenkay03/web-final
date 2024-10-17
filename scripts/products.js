let products = [];
        let sortOrder = {
            name: 'asc', 
            date: 'asc', 
            quantity: 'asc', 
            price: 'asc' 
        };

        
        fetch('../php/fetch_products.php')
            .then(response => response.json())
            .then(data => {
                products = data; 
                displayProducts(products); 
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                document.getElementById('product-table-body').innerHTML = '<tr><td colspan="6">Error loading products</td></tr>';
            });

        function displayProducts(products) {
            const tableBody = document.getElementById('product-table-body');
            tableBody.innerHTML = ''; 

            if (products.length > 0) {
                products.forEach(product => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${product.id}</td>
                        <td>${product.name}</td>
                        <td>${product.description}</td>
                        <td>$${product.price}</td>
                        <td>${product.quantity}</td>
                        <td>${product.date}</td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="6">No products found</td></tr>';
            }
        }

        function sortProducts(criteria) {
            let sortedProducts;

            switch (criteria) {
                case 'name':
                    sortedProducts = products.sort((a, b) => {
                        return sortOrder.name === 'desc' 
                            ? a.name.localeCompare(b.name) 
                            : b.name.localeCompare(a.name);
                    });
                    sortOrder.name = sortOrder.name === 'asc' ? 'desc' : 'asc'; // Toggle sort order
                    break;
                case 'date':
                    sortedProducts = products.sort((a, b) => {
                        return sortOrder.date === 'desc' 
                            ? new Date(a.date) - new Date(b.date) 
                            : new Date(b.date) - new Date(a.date);
                    });
                    sortOrder.date = sortOrder.date === 'asc' ? 'desc' : 'asc'; // Toggle sort order
                    break;
                case 'quantity':
                    sortedProducts = products.sort((a, b) => {
                        return sortOrder.quantity === 'desc' 
                            ? a.quantity - b.quantity 
                            : b.quantity - a.quantity;
                    });
                    sortOrder.quantity = sortOrder.quantity === 'asc' ? 'desc' : 'asc'; // Toggle sort order
                    break;
                case 'price': // New case for price sorting
                    sortedProducts = products.sort((a, b) => {
                        return sortOrder.price === 'desc' 
                            ? a.price - b.price 
                            : b.price - a.price;
                    });
                    sortOrder.price = sortOrder.price === 'asc' ? 'desc' : 'asc'; // Toggle sort order
                    break;
                default:
                    return;
            }

            displayProducts(sortedProducts);
        }