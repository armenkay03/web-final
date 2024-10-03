document.addEventListener("DOMContentLoaded", function() {
    fetchOrders();
});

function fetchOrders() {
    fetch("../php/get-orders.php")
        .then(response => {
            if (!response.ok) {
                console.error("Network response was not ok", response.statusText);
                return;
            }
            return response.json();
        })
        .then(data => {
            console.log("Fetched orders:", data);

            const acceptedOrdersTable = document.querySelector("#accepted-orders tbody");
            const rejectedOrdersTable = document.querySelector("#rejected-orders tbody");

            data.forEach(order => {
const row = document.createElement("tr");

// Format the items as product_name (product_id) - description [quantity]
const itemsFormatted = order.items.map(item => 
`ID:${item.product_id} - Name: ${item.product_name} - ${item.product_description} - Quantity: ${item.quantity}`
).join(", ");

row.innerHTML = `
<td>${order.id}</td>
<td>${order.customer_name}</td>
<td>${order.customer_email}</td>
<td>${order.order_date}</td>
<td>${itemsFormatted}</td>
`;

if (order.status === 'Accepted') {
acceptedOrdersTable.appendChild(row);
} else if (order.status === 'Rejected') {
rejectedOrdersTable.appendChild(row);
}
});
        })
        .catch(error => {
            console.error("Error fetching orders:", error);
        });
}