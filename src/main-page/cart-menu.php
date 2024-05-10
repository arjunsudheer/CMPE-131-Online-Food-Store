<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "users");

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch currentCart from the database based on user ID
$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];
$tableName = ($userType == 'employee') ? 'employees' : 'customers';
$sql = "SELECT currentCart FROM $tableName WHERE id = $userId";
$resultCart = mysqli_query($connection, $sql);

$totalCost = 0; // Initialize total cost
$totalWeight = 0; // Initialize total weight

if ($resultCart && mysqli_num_rows($resultCart) > 0) {
    $row = mysqli_fetch_assoc($resultCart);
    if (isset($row['currentCart'])) {
        $currentCart = $row['currentCart'];
        // Initialize total cost
        $totalCost = 0;
        $totalWeight = 0;
        
        // Display currentCart contents
        ob_start(); // Start output buffering
        echo "<p>Current Cart:</p>";
        if (!empty($currentCart)) {
            echo "<ul>";
            // Explode the currentCart string into individual items
            $items = explode(",", $currentCart);
            foreach ($items as $item) {
                // Explode each item into product details
                $details = explode("|", $item);
                if (count($details) >= 5) {
                    $productName = $details[0];
                    $productBrand = $details[1];
                    $productPrice = floatval($details[2]); // Convert to float
                    $productWeight = floatval($details[3]); // Convert to float
                    $quantity = isset($details[4]) ? intval($details[4]) : 1; // Convert to integer

                    $itemCost = $productPrice * $quantity;
                    $itemWeight = $productWeight * $quantity;
                    $totalWeight += $itemWeight;

                    // Display the product details
                    echo "<li data-product='$productName'>";
                    echo "$productName - $productBrand - <span class='product-price'>$$productPrice</span>";
                    echo "- <span class='product-weight'>$productWeight</span>";
                    // Add quantity adjustment buttons
                    echo "<div class='quantity-adjustment'>";
                    echo "<button class='decrement-quantity' data-product='$productName'>-</button>";
                    echo "<span class='quantity'>$quantity</span>";
                    echo "<button class='increment-quantity' data-product='$productName'>+</button>";
                    echo "</div>";
                    echo "Total item cost " . "<span class='item-cost'>$" . $itemCost . "</span>"; // Display item cost using the variable
                    echo "</li>";

                    // Add item cost to total cost
                    $totalCost += $itemCost;


                    // Add item weight multiplied by quantity to total weight
                    $totalWeight += ($productWeight * $quantity);
                } else {
                    echo "<p>Error: Incorrect data format for item: $item</p>";
                }
            }
            echo "</ul>";
        } else {
            echo "<p>Cart is empty</p>";
        }
        $cartContents = ob_get_clean(); // Capture the output and clear the buffer
    } else {
        $cartContents = "<p>Cart is empty</p>";
    }
} else {
    $cartContents = "<p>Error: Unable to fetch cart data from the database</p>";
}

//echo "Total item cost " . "<span class='total-cost'>$" . $totalCost . "</span>";
// Calculate total cost including shipping

$shippingCost = 0;

// Calculate shipping cost based on total weight
if ($totalWeight > 15) {
    $shippingInfo = "Free shipping!"; // Free shipping for total weight over 15 pounds
    $shippingCost = 0;
} else {
    $shippingInfo = "Shipping: $5"; // $5 shipping cost for total weight under or equal to 15 pounds
    $shippingCost = 5;
}

$totalCostWithShipping = $totalCost + $shippingCost; // Shipping is free, so total cost remains the same
echo "<h4>Total cost with shipping: <span id='total-cost' class='total-cost'>$" . $totalCostWithShipping . "</span></h4>";
echo "<p>Total weight: <span class='total-weight'>$totalWeight</span> pounds</p>";
echo "<button class='save-cart'>Save Cart Changes</button>";

// Function to update the quantity of an item in the user's cart
function updateCartQuantity($connection, $userId, $productName, $quantity) {
    // Determine the table name based on the user type
    $userType = $_SESSION['user_type'];
    $tableName = ($userType == 'employee') ? 'employees' : 'customers';

    // Retrieve the current cart data from the database
    $sql_select_cart = "SELECT currentCart FROM $tableName WHERE id = ?";
    $stmt_select_cart = mysqli_prepare($connection, $sql_select_cart);

    if ($stmt_select_cart) {
        mysqli_stmt_bind_param($stmt_select_cart, "i", $userId);
        if (mysqli_stmt_execute($stmt_select_cart)) {
            $result = mysqli_stmt_get_result($stmt_select_cart);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $currentCart = $row['currentCart'];

                // Parse the current cart string into individual items
                $items = explode(",", $currentCart);

                // Initialize a variable to track whether the product is found in the cart
                $productFound = false;

                // Iterate through each item to update the quantity of the specified product
                foreach ($items as &$item) {
                    // Split the item string into its components
                    $itemDetails = explode("|", $item);
                    $itemProductName = $itemDetails[0];

                    if ($itemProductName === $productName) {
                        // Update the quantity of the specified product
                        $itemDetails[3] = $quantity; // Assuming quantity is the fourth element (0-indexed)
                        $item = implode("|", $itemDetails);
                        $productFound = true;
                        break; // Exit the loop once the product is found and updated
                    }
                }

                // If the product is not found in the cart, add it with the specified quantity
                if (!$productFound) {
                    $items[] = "$productName|$quantity"; // Assuming other fields are already present
                }

                // Reconstruct the cart string with the updated quantity
                $updatedCart = implode(",", $items);

                // Update the currentCart field in the database with the modified cart string
                $sql_update_cart = "UPDATE $tableName SET currentCart = ? WHERE id = ?";
                $stmt_update_cart = mysqli_prepare($connection, $sql_update_cart);

                if ($stmt_update_cart) {
                    mysqli_stmt_bind_param($stmt_update_cart, "si", $updatedCart, $userId);
                    if (mysqli_stmt_execute($stmt_update_cart)) {
                        return "Quantity updated successfully for product: $productName";
                    } else {
                        return "Error updating quantity for product: $productName. Error: " . mysqli_error($connection);
                    }
                } else {
                    return "Error: Unable to prepare UPDATE statement: " . mysqli_error($connection);
                }
            } else {
                return "Error: No cart data found for user ID $userId";
            }
        } else {
            return "Error: Unable to execute SELECT statement: " . mysqli_error($connection);
        }
    } else {
        return "Error: Unable to prepare SELECT statement: " . mysqli_error($connection);
    }
}
?>

<script>
var userId = <?php echo $userId; ?>;

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
            updateTotalCost(productName);
            // Append the quantity to the item's current entry in currentCart
            // Call the function to update the quantity in the database
            updateCartItemQuantity(userId, productName, quantity);
        }
    });
});

var incrementButtons = document.querySelectorAll('.increment-quantity');
// Add event listener for each increment button
incrementButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var productName = button.dataset.product;
        var quantityElement = button.previousElementSibling; // Get the quantity element
        var quantity = parseInt(quantityElement.textContent); // Get the current quantity
        quantity++; // Increase the quantity
        quantityElement.textContent = quantity; // Update the quantity display

        // Update total cost
        updateTotalCost(productName);
        // Append the quantity to the item's current entry in currentCart
        // Call the function to update the quantity in the database
        updateCartItemQuantity(userId, productName, quantity);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var saveCartButton = document.querySelector('.save-cart');

    saveCartButton.addEventListener('click', function() {
        console.log("Save cart button clicked");

        var items = document.querySelectorAll('li[data-product]');
        items.forEach(function(item) {
            var productName = item.dataset.product;
            var quantityElement = item.querySelector('.quantity');
            var quantity = parseInt(quantityElement.textContent);
            console.log("Updating quantity for product: " + productName + " - " + quantity);
            
            // Create data object to be sent in the AJAX request
            var data = {
                productName: productName,
                quantity: quantity
            };
            
            // Log the data object before sending it
            console.log("Data to be sent:", data);

            // Make an AJAX request to update the quantity for each product
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../main-page/update-currentCart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText); // Log the response from the PHP script
                        // Handle the response if needed
                    } else {
                        console.error('Error:', xhr.status, xhr.statusText); // Log any errors
                    }
                }
            };

            xhr.send(JSON.stringify(data)); // Send the request with the JSON data
        });
    });
});

// Function to update the quantity of an item in the cart
function updateCartItemQuantity(userId, productName, quantity) {
    console.log("Updating cart item quantity for product: " + productName + quantity); // Log that the function is called
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update-currentCart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Success! Do something with the response
            console.log(xhr.responseText);
        } else {
            // Error
            console.error('Request failed: ' + xhr.statusText);
        }
    };
    xhr.send('userId=' + userId + '&productName=' + encodeURIComponent(productName) + '&quantity=' + quantity);
}

</script>