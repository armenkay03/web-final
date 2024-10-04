// Fetch pending orders from the server
fetch('../php/admin-orders.php')
    .then(response => response.json())
    .then(data => {
        const ordersList = document.getElementById('orders-list');

        if (data.message) {
            // If there's a message like 'No orders to be displayed'
            const noOrdersMessage = document.createElement('h3');
            noOrdersMessage.textContent = data.message;
            ordersList.appendChild(noOrdersMessage);
        } else {
            data.forEach(order => {
                const listItem = document.createElement('li');
                listItem.classList.add('order-box', order.status === 'completed' ? 'completed-orders' : 'ongoing-orders');
                listItem.innerHTML = `
                    <div class="order-details">
                        <h3 style="display:inline;">Order ID: ${order.id}</h3>
                        <p style="display:inline; margin-left: 10px;">Customer: ${order.customer_name} (${order.customer_email})</p>
                        <p style="display:inline; margin-left: 10px;">Status: ${order.status}</p>
                        <p style="display:inline; margin-left: 10px;">Order Date: ${order.order_date}</p>
                    </div>
                    <div class="order-items">
                        <h4>Items:</h4>
                        <ul>
                            ${order.items.map(item => `<li>${item.product} (Quantity: ${item.quantity})</li>`).join('')}
                        </ul>
                    </div>
                    <div class="order-actions">
                        <button class="accept-btn" onclick="updateOrderStatus(${order.id}, 'accept')">Accept</button>
                        <button class="reject-btn" onclick="updateOrderStatus(${order.id}, 'reject')">Reject</button>
                    </div>
                `;
                ordersList.appendChild(listItem);
            });
        }
    })
    .catch(error => {
        console.error('Error fetching orders:', error);
        const errorMessage = document.createElement('li');
        errorMessage.textContent = 'Error fetching orders.';
        document.getElementById('orders-list').appendChild(errorMessage);
    });

// Function to update order status (Accept/Reject)
function updateOrderStatus(orderId, action) {
    const formData = new FormData();
    formData.append('order_id', orderId);
    formData.append('action', action);

    fetch('../php/admin-orders.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
        location.reload(); // Reload the page to reflect changes
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
