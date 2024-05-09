<?php
session_start(); // Start the session

// Check if data is received via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the JSON data from the request body
    $json_data = file_get_contents('php://input');

    // Decode the JSON data into a PHP associative array
    $data = json_decode($json_data, true);

    // Check if the required parameters are provided
    if (isset($data["productName"]) && isset($data["quantity"])) {
        // Retrieve user_id from session
        $user_id = $_SESSION['user_id'];
        $tableName = ($_SESSION['user_type'] == 'employee') ? 'employees' : 'customers';

        // Connect to the database
        $connection = mysqli_connect("localhost", "root", "", "users");
        if (!$connection) {
            // If connection fails, return an error response
            $response = array(
                "success" => false,
                "message" => "Error: Connection failed"
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        // Retrieve the current cart data from the database
        $sql_select_cart = "SELECT currentCart FROM $tableName WHERE id = $user_id";
        $result_select_cart = mysqli_query($connection, $sql_select_cart);
        if ($result_select_cart) {
            $row = mysqli_fetch_assoc($result_select_cart);
            $currentCart = $row['currentCart'];

            // Check if the product already exists in the cart
            $cartItems = explode(",", $currentCart);
            foreach ($cartItems as $item) {
                $itemData = explode("|", $item);
                if ($itemData[0] === $data["productName"]) {
                    // Extract the existing quantity and update it
                    $existingQuantity = $itemData[4];
                    $newQuantity = $data["quantity"];
                    // Construct the updated item string with the new quantity
                    $updatedItem = "{$itemData[0]}|{$itemData[1]}|{$itemData[2]}|{$itemData[3]}|$newQuantity";
                    // Replace the old item with the updated item in the cart string
                    $currentCart = str_replace($item, $updatedItem, $currentCart);
                    // Break out of the loop since the item has been updated
                    break;
                }
            }

            // Update the database with the new cart data
            $sql_update_cart = "UPDATE $tableName SET currentCart = '$currentCart' WHERE id = $user_id";
            $result_update_cart = mysqli_query($connection, $sql_update_cart);
            if ($result_update_cart) {
                // If the cart was successfully updated, send a success response
                $response = array(
                    "success" => true,
                    "message" => "Cart updated successfully",
                    "productName" => $data["productName"],
                    "quantity" => $data["quantity"]
                );
            } else {
                // If there was an error updating the cart, send an error response
                $response = array(
                    "success" => false,
                    "message" => "Error: Failed to update cart"
                );
            }
        } else {
            // If there was an error retrieving the cart data, send an error response
            $response = array(
                "success" => false,
                "message" => "Error: " . mysqli_error($connection)
            );
        }

        // Close the database connection
        mysqli_close($connection);

        // Send a response back to the JavaScript code
        // Respond with JSON data
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // If required parameters are not provided, return an error message
        $response = array(
            "success" => false,
            "message" => "Error: Required parameters missing"
        );

        // Send a response back to the JavaScript code
        // Respond with JSON data
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // If not a POST request, return an error message
    $response = array(
        "success" => false,
        "message" => "Error: This endpoint only accepts POST requests"
    );

    // Send a response back to the JavaScript code
    // Respond with JSON data
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
