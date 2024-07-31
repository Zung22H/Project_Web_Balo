function searchfunction() {
    let input = document.getElementById('searchinput').value.toLowerCase();
    let results = document.getElementById('searchresults');

    
    let items = [
        'apple',
        'banana',
        'cherry',
        'date',
        'elderberry',
        'fig',
        'grape'
    ];

    // Clear previous results
    results.innerHTML = '';

    // Filter items based on search input
    let filteredItems = items.filter(item => item.includes(input));

    // Display results
    if (filteredItems.length > 0) {
        filteredItems.forEach(item => {
            let resultItem = document.createElement('div');
            resultItem.textContent = item;
            results.appendChild(resultItem);
        });
    } else {
        results.textContent = 'No results found';
    }
}

function goToAccount() {
    // Logic to go to the account page
    alert('Going to Account Page!');
    // You can replace the above line with actual navigation logic like:
    // window.location.href = 'account.html';
}

function goToCart() {
    // Logic to go to the cart page
    alert('Going to Cart Page!');
    // You can replace the above line with actual navigation logic like:
    // window.location.href = 'cart.html';
}