<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "users");

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve parameters from POST request
$productName = $_POST['productName'];
$quantity = $_POST['quantity'];
$productPrice = $_POST['productPrice'];

// Update quantity in the database
// Example SQL statement, adjust according to your database schema
$sql = "UPDATE cart SET quantity = $quantity WHERE productName = '$productName'";
if (mysqli_query($connection, $sql)) {
    // Calculate total cost based on updated quantities
    // Example calculation, adjust according to your database schema
    $totalCost = calculateTotalCost($connection);

    // Return updated total cost to client
    echo json_encode(array("totalCost" => $totalCost));
} else {
    echo "Error updating record: " . mysqli_error($connection);
}

// Close connection
mysqli_close($connection);

// Function to calculate total cost based on updated quantities
function calculateTotalCost($connection) {
    // Fetch quantities and prices from the database and calculate total cost
    // Example SQL statement, adjust according to your database schema
    $sql = "SELECT SUM(quantity * productPrice) AS totalCost FROM cart";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['totalCost'];
}
?>
