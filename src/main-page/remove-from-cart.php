<?php
session_start(); // Start the session

// Check if the request method is POST and if the product name is set
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['productName'])) {
    // Retrieve product name from POST data
    $productName = $_POST['productName'];

    // Retrieve user ID and table name from session
    $userId = $_SESSION['user_id'];
    $tableName = ($_SESSION['user_type'] == 'employee') ? 'employees' : 'customers';

    // Database connection
    $connection = mysqli_connect("localhost", "root", "", "users");
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve current cart data from the database
    $sql_select_cart = "SELECT currentCart FROM $tableName WHERE id = $userId";
    $result_select_cart = mysqli_query($connection, $sql_select_cart);

    if ($result_select_cart && mysqli_num_rows($result_select_cart) > 0) {
        $row = mysqli_fetch_assoc($result_select_cart);
        $currentCart = $row['currentCart'];

        // Remove the item from the current cart data
        $items = explode(",", $currentCart);
        $updatedCart = [];
        foreach ($items as $item) {
            $details = explode("|", $item);
            if ($details[0] !== $productName) {
                // Keep items other than the one to be removed
                $updatedCart[] = $item;
            }
        }

        // Construct the updated cart string
        $updatedCartString = implode(",", $updatedCart);

        // Update the database with the updated cart data
        $sql_update_cart = "UPDATE $tableName SET currentCart = '$updatedCartString' WHERE id = $userId";
        $result_update_cart = mysqli_query($connection, $sql_update_cart);

        if ($result_update_cart) {
            echo "Item removed from cart successfully.";
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        echo "Error: Unable to fetch cart data from the database";
    }

    mysqli_close($connection);
} else {
    // Invalid request
    echo "Error: Invalid request";
}
?>
