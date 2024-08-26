// Initialize an empty array to store cart items
let cart = [];

// Function to add a product to the cart
function addToCart(productName, productPrice) {
    let quantity = parseInt(document.getElementById('quantity').value) || 1;
    let existingProduct = cart.find(item => item.name === productName);

    if (existingProduct) {
        existingProduct.quantity += quantity;
    } else {
        cart.push({ name: productName, price: productPrice, quantity: quantity });
    }

    updateCart();
}

// Function to update the cart display
function updateCart() {
    let totalItems = 0;
    let totalPrice = 0;

    cart.forEach(item => {
        totalItems += item.quantity;
        totalPrice += item.quantity * item.price;
    });

    // Update the total number of items and total price in the cart
    document.getElementById('cart-total-items').innerText = totalItems;
    document.getElementById('cart-total-price').innerText = totalPrice.toFixed(2);
}

// Example usage:
// Add this to the HTML where the product is listed
// <button onclick="addToCart('Product Name', 29.99)">Add to Cart</button>
