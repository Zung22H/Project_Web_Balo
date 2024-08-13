function searchfunction() {
    let input = document.getElementById('searchinput').value.toLowerCase();
    let results = document.getElementById('searchresults');

    
    let items = [
        'nike',
        'adidas',
        'puma',
        'simple carry',
        'túi du lịch',
        'balo đựng laptop'
        
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
    
    window.location.href = 'form_login.html';
    // You can replace the above line with actual navigation logic like:
    // window.location.href = 'account.html';
}

function goToCart() {
    // Logic to go to the cart page
    window.location.href = 'cart.html';
    // You can replace the above line with actual navigation logic like:
    // window.location.href = 'cart.html';
}