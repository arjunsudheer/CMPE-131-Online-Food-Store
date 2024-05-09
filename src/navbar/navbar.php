<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../navbar/navbar.css">
    <!-- Load an icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Left side bar -->
    <div id="left-sidebar">
        <h1>OFS</h1>
        <p>At Downtown San Jose</p>
        <a href="../main-page/main-page.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
        <?php
        // Start the session
        // session_start();
       if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'logged_out') {
            echo '<a href="../profile/profile.php"><i class="fa fa-fw fa-dollar"></i> Profile</a>';
            //echo '<a href="../checkout/CheckOutPage.php"><i class="fa fa-fw fa-dollar"></i> Checkout</a>';
       }
        // Check if the user is an employee
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'employee') {
            echo '<a href="../inventory-page/employee-inventory-page.php"><i class="fa fa-cube" aria-hidden="true"></i> Inventory</a>';
        }
        ?>
        <?php
        // Show cart button only on the main page
        if (basename($_SERVER['PHP_SELF']) === 'main-page.php') {
            echo '<a id="cart-button" href="#"><i class="fa fa-fw fa-shopping-cart"></i> Cart</a>';
        }
        ?>
        <a href="../about-page/about-page.php"><i class="fa fa-store" aria-hidden="true"></i> About Us</a>
        <a href="../navbar/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
    </div>
    <!-- Cart menu, will hide and show whenever the cart button is pressed -->
<!-- Cart menu, will hide and show whenever the cart button is pressed -->
<div class="cart-menu">
    <h3>Shopping Cart</h3>
    <?php include_once 'cart-menu.php'; ?> <!-- Include the database connection file here -->
    <?php echo $cartContents; ?> <!-- Echo the fetched cart contents here -->
    <?php
    //echo "Total item cost " . "<span class='total-cost'>$" . $totalCost . "</span>";
    ?>
    <p><?php echo $shippingInfo; ?></p>
    <a href="../checkout-page/CheckOutPage.php"><button type="submit" id="checkout-button">Checkout</button></a>
    <!-- Your existing HTML/PHP code for the cart menu -->
</div>

        </div>
    </div>
</div>

<script>
    // Function to calculate total cost based on displayed item costs
    function calculateTotalCost(productName) {
        var totalCost = 0;
        var itemCostElements = document.querySelectorAll('.item-cost');
        itemCostElements.forEach(function(itemCostElement) {
            totalCost += parseFloat(itemCostElement.textContent.replace('$', ''));
            console.log("Total cost for", productName + ":", totalCost); // Log the new quantity
        
        });

        // Update total cost display
        var totalCostElement = document.getElementById('total-cost');
        totalCostElement.textContent = '$' + totalCost.toFixed(2);
    }

    // Function to update total cost based on quantity adjustment
    function updateTotalCost(productName, quantity) {
        // Get product price and weight
        var productPrice = parseFloat(document.querySelector('li[data-product="' + productName + '"] .product-price').textContent.replace('$', ''));
        var productWeight = parseFloat(document.querySelector('li[data-product="' + productName + '"] .product-weight').textContent);

        // Calculate item cost
        var itemCost = productPrice * quantity;
        // Update item cost display
        var itemCostElement = document.querySelector('li[data-product="' + productName + '"] .item-cost');
        itemCostElement.textContent = '$' + itemCost.toFixed(2);

    // Check if quantity is 0 and remove item from currentCart if so
    if (quantity === 0) {
            var currentCartElement = document.querySelector('li[data-product="' + productName + '"]');
            currentCartElement.parentNode.removeChild(currentCartElement); // Remove the item from the cart display
            // Call a function to update the currentCart in the database
            removeFromCart(productName);
    }

        // Recalculate total cost
        calculateTotalCost();
    }

    // Function to remove item from currentCart in the database
function removeFromCart(productName) {
    // Send an AJAX request to remove the item from the currentCart in the database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'remove-from-cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Item removed successfully
            console.log(xhr.responseText); // Log the response from the server
        } else {
            // Error occurred
            console.error('Error: ' + xhr.statusText);
        }
    };
    xhr.send('productName=' + productName);
}

    // Call the function to calculate initial total cost when the page loads
    window.onload = function() {
        calculateTotalCost(); // Call calculateTotalCost instead of recalculateTotalCost
    };

    // Get all decrement quantity buttons
    var decrementButtons = document.querySelectorAll('.decrement-quantity');
    // Add event listener for each decrement button
    decrementButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var productName = button.dataset.product;
            var quantityElement = button.nextElementSibling; // Get the quantity element
            var quantity = parseInt(quantityElement.textContent); // Get the current quantity
            if (quantity > 0) {
                quantity--; // Decrease the quantity
                quantityElement.textContent = quantity; // Update the quantity display

                // Update total cost
                updateTotalCost(productName, quantity);
            }
        });
    });

    var incrementButtons = document.querySelectorAll('.increment-quantity');
// Add event listener for each increment button
incrementButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var productName = button.dataset.product;
        console.log("Updating quantity for product:", productName); // Log the product name
        var quantityElement = button.previousElementSibling; // Get the quantity element
        var quantity = parseInt(quantityElement.textContent); // Get the current quantity
        quantity++; // Increase the quantity
        console.log("New quantity for", productName + ":", quantity); // Log the new quantity
        quantityElement.textContent = quantity; // Update the quantity display

        // Update total cost
        updateTotalCost(productName, quantity);
    });
});

// Function to calculate total weight based on displayed item weights
function calculateTotalWeight() {
    var totalWeight = 0;
    var itemWeightElements = document.querySelectorAll('.product-weight');
    itemWeightElements.forEach(function(itemWeightElement) {
        totalWeight += parseFloat(itemWeightElement.textContent);
    });

    // Update total weight display
    var totalWeightElement = document.getElementById('total-weight');
    totalWeightElement.textContent = totalWeight;
}

// Call the function to calculate initial total weight when the page loads
window.onload = function() {
    calculateTotalWeight();
};

// Function to update total weight based on quantity adjustment
function updateTotalWeight(productName, quantity) {
    // Get product weight
    var productWeight = parseFloat(document.querySelector('li[data-product="' + productName + '"] .product-weight').textContent);

    // Calculate item weight
    var itemWeight = productWeight * quantity;

    // Update item weight display
    var itemWeightElement = document.querySelector('li[data-product="' + productName + '"] .item-weight');
    itemWeightElement.textContent = itemWeight;

    // Recalculate total weight
    calculateTotalWeight();
}
</script>




</body>

<script src="../navbar/navbar.js"></script>

</html>
