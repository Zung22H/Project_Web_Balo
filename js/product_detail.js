// product_detail.js

const products = {
    product1: {
        name: "Balo Adidas x Lion King",
        price: "990.000đ",
        type: "Thể thao",
        image: "product_img/Adidas/Ba_Lo_adidas_Disney_Lion_King_Xam.jpg",
        description: "A stylish backpack featuring Lion King design."
    },
    product2: {
        name: "Balo Adidas Classic",
        price: "800.000đ",
        type: "Thể thao",
        image: "product_img/Adidas/Ba_Lo_Classic.jpg",
        description: "A classic Adidas backpack."
    },
    // Add more products as needed
};

// Function to get the product ID from the URL
function getProductId() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id');
}

// Function to display product details
function displayProductDetails() {
    const productId = getProductId();
    const product = products[productId];

    if (product) {
        document.getElementById('productImage').src = product.image;
        document.getElementById('productName').innerText = product.name;
        document.getElementById('productPrice').innerText = product.price;
        document.getElementById('productType').innerText = product.type;
        document.getElementById('productDescription').innerText = product.description;
    } else {
        document.getElementById('productName').innerText = 'Product not found.';
    }
}

// Quantity control functions
document.getElementById('increaseQuantity').addEventListener('click', () => {
    const quantityInput = document.getElementById('quantity');
    quantityInput.value = parseInt(quantityInput.value) + 1;
});

document.getElementById('decreaseQuantity').addEventListener('click', () => {
    const quantityInput = document.getElementById('quantity');
    if (quantityInput.value > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
    }
});

// Add to cart functionality
document.getElementById('addToCart').addEventListener('click', () => {
    const quantity = document.getElementById('quantity').value;
    alert(`Added ${quantity} of ${products[getProductId()].name} to cart!`);
});

// Call the function to display product details
displayProductDetails();